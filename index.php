<?php
// Midtrans
namespace Midtrans;

require_once dirname(__FILE__) . '/Midtrans.php';
require("functions.php");

// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-FY5-JgqWOTwkKCWZke7dWNeK';
Config::$clientKey = 'SB-Mid-client-ZbOMHp7KRkClWyAG';

// non-relevant function only used for demo/example purpose
// printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;

// Enable sanitization
Config::$isSanitized = true;

// Enable 3D-Secure
Config::$is3ds = true;

// Uncomment for append and override notification URL
// Config::$appendNotifUrl = "https://example.com";
// Config::$overrideNotifUrl = "https://example.com";

if (!isset($_SESSION["keranjang"])) {
    $_SESSION["keranjang"] = [];
}

if (!isset($_SESSION["history"])) {
    $_SESSION["history"] = false;
}
if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = false;
    $_SESSION["history"] = false;
}
if (isset($_POST["logout"])) {
    $_SESSION["login"] = false;
    $_SESSION["history"] = false;
}

$htrans = query("SELECT * FROM htrans");
$ctr = 0;
foreach ($htrans as $key) {
    $nota = $key["nota_jual"];
    $ctr++;
}

if ($ctr == 0) {
    $nota = "NOTA0000000000000000000000000000000000000000000001";
} else {
    $number = substr($nota, 4);
    $number = intval($number) + 1;
    $nota = "NOTA" . str_pad($number, 46, '0', STR_PAD_LEFT);
}

$_SESSION["nomorNota"] = $nota;

// Optional
$item_details = [];

$subtotal = 0;
foreach ($_SESSION["keranjang"] as $key) {
    $id = $key["id_produk"];
    $price = doubleval($key["price_produk"]);
    $price = ceil($price * 15606.50);
    $price = intval($price);
    $quantity = intval($key["quantity_produk"]);
    $name = $key["name_produk"];

    $checkOutPrice = $price * $quantity;

    $item_detail = array(
        'id' => $id,
        'price' => $price,
        'quantity' => $quantity,
        'name' => $name
    );

    $subtotal += $price;
    array_push($item_details, $item_detail);
}

// Required
$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => ceil($subtotal), // no decimal allowed for creditcard
);

// Optional, remove this to display all available payment methods
// $enable_payments = array('credit_card', 'cimb_clicks', 'mandiri_clickpay');

// Fill transaction details
// Optional
// $shipping_address = array(
//     'first_name'    => "",
//     'last_name'     => "",
//     'address'       => $alamat,
//     'city'          => "",
//     'postal_code'   => "",
//     'phone'         => $nomor_telepon,
//     'country_code'  => ''
// );

// // Optional
// $customer_details = array(
//     'first_name'    => $full_name,
//     'last_name'     => "",
//     'email'         => $email,
//     'phone'         => $nomor_telepon,
//     // 'billing_address'  => $billing_address,
//     'shipping_address' => $shipping_address
// );

$transaction = array(
    // 'enabled_payments' => $enable_payments,
    'transaction_details' => $transaction_details,
    // 'customer_details' => $customer_details,
    'item_details' => $item_details,
);

$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
} catch (\Exception $e) {
}

echo "<script>console.log('snapToken = $snap_token')</script>";

function printExampleWarningMessage()
{
    if (strpos(Config::$serverKey, 'your ') != false) {
        // echo "<code>";
        // echo "<h4>Please set your server key from sandbox</h4>";
        // echo "In file: " . __FILE__;
        // echo "<br>";
        // echo "<br>";
        // echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
        die();
    }
}

// 

if (!isset($_SESSION["masukDetail"])) {
    $_SESSION["masukDetail"] = false;
}
if (!isset($_SESSION["tempIdDetail"])) {
    $_SESSION["tempIdDetail"] = -1;
}

if (isset($_POST["cart"])) {
    $_SESSION["masukCart"] = true;
    $_SESSION["masukDetail"] = false;
    $_SESSION["history"] = false;
}
if (!isset($_SESSION["masukCart"])) {
    $_SESSION["masukCart"] = false;
}

if ($_SESSION["masukCart"] == true) {
    if ($_SESSION["login"] == true) {
        $cartIdUser = $_SESSION["idUser"];
        if ($cartIdUser != "") {
            $tempCart = query("SELECT * FROM cart WHERE id_user = '$cartIdUser'");

            $_SESSION["keranjang"] = [];
            foreach ($tempCart as $key => $value) {
                $id_produk = $value["id_produk"];
                $image_produk = $value["image_produk"];
                $name_produk = $value["name_produk"];
                $price_produk = $value["price_produk"];
                $quantity_produk = $value["quantity_produk"];

                $tempKeranjang = [
                    "id_produk" => $id_produk,
                    "image_produk" => $image_produk,
                    "name_produk" => $name_produk,
                    "price_produk" => $price_produk,
                    "quantity_produk" => $quantity_produk
                ];

                array_push($_SESSION["keranjang"], $tempKeranjang);
            }
        }
    } else {
        $_SESSION["keranjang"] = [];
    }
}

if (isset($_POST["btnSaveDataUser"])) {
    $tempIdUser = $_SESSION['idUser'];
    $fullName = $_POST["nameUser"];
    $email = $_POST["emailUser"];
    $nomor_telepon = $_POST["phoneUser"];
    $alamat = $_POST["addressUser"];

    $data = [
        "id_user" => $tempIdUser,
        "full_name" => $fullName,
        "email" => $email,
        "nomor_telepon" => $nomor_telepon,
        "alamat" => $alamat
    ];

    updateUser($data);
}


// ARRAY UNTUK CHECKBOX BRAND DAN CATEGORY
if (!isset($_SESSION["cbBrand"])) {
    $_SESSION["cbBrand"] = [];

    $brands = query("SELECT * FROM brand ORDER BY name_brand");
    foreach ($brands as $brand) {
        $pageBaru = [
            "brand" => $brand["name_brand"]
        ];
        array_push($_SESSION["cbBrand"], $pageBaru);
    }
} else {
    $_SESSION["cbBrand"] = [];

    $brands = query("SELECT * FROM brand ORDER BY name_brand");
    foreach ($brands as $brand) {
        $pageBaru = [
            "brand" => $brand["name_brand"]
        ];
        array_push($_SESSION["cbBrand"], $pageBaru);
    }
}

if (!isset($_SESSION["cbCategories"])) {
    $_SESSION["cbCategories"] = [];

    $categories = query("SELECT * FROM kategori ORDER BY name_kategori");
    foreach ($categories as $kategori) {
        $pageBaru = [
            "categories" => $kategori["name_kategori"]
        ];
        array_push($_SESSION["cbCategories"], $pageBaru);
    }
} else {
    $_SESSION["cbCategories"] = [];

    $categories = query("SELECT * FROM kategori ORDER BY name_kategori");
    foreach ($categories as $kategori) {
        $pageBaru = [
            "categories" => $kategori["name_kategori"]
        ];
        array_push($_SESSION["cbCategories"], $pageBaru);
    }
}

if (!isset($_SESSION["productCount"])) {
    $_SESSION["productCount"] = 0;
}
if (!isset($_SESSION["listProduk"])) {
    $_SESSION["listProduk"] = [];
    $_SESSION["listProduk"] = query("SELECT * FROM produk WHERE status_produk = '1'");
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
}

// alert($tempCount);

if (!isset($_SESSION["brand"])) {
    $_SESSION["brand"] = "";
}
if (!isset($_SESSION["category"])) {
    $_SESSION["category"] = "";
}
if (!isset($_SESSION["input"])) {
    $_SESSION["input"] = "";
}
if (!isset($_SESSION["paging"])) {
    resetPaging();
}

//SEARCH
if (isset($_POST["search"])) {
    //Munculkan semua
    $_SESSION["masukDetail"] = false;
    $_SESSION["history"] = false;
    $_SESSION["input"] = $_POST["input"];

    $_SESSION["listProduk"] = query("SELECT * FROM produk,brand,kategori WHERE produk.id_brand = brand.id_brand AND produk.id_kategori = kategori.id_kategori AND produk.status_produk = '1' AND produk.name_produk LiKE '%" . $_SESSION["input"] . "%' ORDER BY produk.id_produk");
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
    $_SESSION["masukCart"] = false;
}

//PAGING
//GANTI MAKS PAGE ARRAY
$maks = ($_SESSION["productCount"] / 30) + 1;
if (isset($_POST["page0"])) {
    $_SESSION["pageSekarang"] = $_SESSION["paging"][0]["page"];
    if ($_SESSION["paging"][0]["page"] > 2) {
        $_SESSION["paging"][0]["page"] -= 2;
        $_SESSION["paging"][1]["page"] -= 2;
        $_SESSION["paging"][2]["page"] -= 2;
        $_SESSION["paging"][3]["page"] -= 2;
        $_SESSION["paging"][4]["page"] -= 2;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["page1"])) {
    $_SESSION["pageSekarang"] = $_SESSION["paging"][1]["page"];
    if ($_SESSION["paging"][0]["page"] > 1) {
        $_SESSION["paging"][0]["page"]--;
        $_SESSION["paging"][1]["page"]--;
        $_SESSION["paging"][2]["page"]--;
        $_SESSION["paging"][3]["page"]--;
        $_SESSION["paging"][4]["page"]--;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["page2"])) {
    $_SESSION["pageSekarang"] = $_SESSION["paging"][2]["page"];
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["page3"])) {
    $_SESSION["pageSekarang"] = $_SESSION["paging"][3]["page"];
    if ($_SESSION["paging"][4]["page"] < $maks - 1) {
        $_SESSION["paging"][0]["page"]++;
        $_SESSION["paging"][1]["page"]++;
        $_SESSION["paging"][2]["page"]++;
        $_SESSION["paging"][3]["page"]++;
        $_SESSION["paging"][4]["page"]++;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["page4"])) {
    $_SESSION["pageSekarang"] = $_SESSION["paging"][4]["page"];
    if ($_SESSION["paging"][4]["page"] < $maks - 2) {
        $_SESSION["paging"][0]["page"] += 2;
        $_SESSION["paging"][1]["page"] += 2;
        $_SESSION["paging"][2]["page"] += 2;
        $_SESSION["paging"][3]["page"] += 2;
        $_SESSION["paging"][4]["page"] += 2;
    } else if ($_SESSION["paging"][4]["page"] < $maks - 1) {
        $_SESSION["paging"][0]["page"] += 1;
        $_SESSION["paging"][1]["page"] += 1;
        $_SESSION["paging"][2]["page"] += 1;
        $_SESSION["paging"][3]["page"] += 1;
        $_SESSION["paging"][4]["page"] += 1;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["pageSekarangMin1"])) {
    if ($_SESSION["paging"][0]["page"] > 1 && $_SESSION["pageSekarang"] != 1) {
        $_SESSION["pageSekarang"]--;
        $_SESSION["paging"][0]["page"]--;
        $_SESSION["paging"][1]["page"]--;
        $_SESSION["paging"][2]["page"]--;
        $_SESSION["paging"][3]["page"]--;
        $_SESSION["paging"][4]["page"]--;
    } else if ($_SESSION["pageSekarang"] > 1) {
        $_SESSION["pageSekarang"]--;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["pageSekarangPlus1"])) {
    if ($maks <= 4) {
        if ($_SESSION["paging"][$maks - 2]["page"] <= $maks && $_SESSION["pageSekarang"] < $maks - 1) {
            $_SESSION["pageSekarang"]++;
        }
    } else {
        if ($_SESSION["paging"][4]["page"] < $maks - 1 && $_SESSION["pageSekarang"] != $maks) {
            $_SESSION["pageSekarang"]++;
            $_SESSION["paging"][0]["page"]++;
            $_SESSION["paging"][1]["page"]++;
            $_SESSION["paging"][2]["page"]++;
            $_SESSION["paging"][3]["page"]++;
            $_SESSION["paging"][4]["page"]++;
        } else if ($_SESSION["pageSekarang"] < $maks - 1) {
            $_SESSION["pageSekarang"]++;
        }
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["pagePertama"])) {
    $_SESSION["pageSekarang"] = 1;
    $_SESSION["paging"][0]["page"] = 1;
    $_SESSION["paging"][1]["page"] = 2;
    $_SESSION["paging"][2]["page"] = 3;
    $_SESSION["paging"][3]["page"] = 4;
    $_SESSION["paging"][4]["page"] = 5;
}
if (isset($_POST["pageTerakhir"])) {
    $maks = (int)$maks;
    $_SESSION["pageSekarang"] = $maks;
    $_SESSION["paging"][0]["page"] = $maks - 4;
    $_SESSION["paging"][1]["page"] = $maks - 3;
    $_SESSION["paging"][2]["page"] = $maks - 2;
    $_SESSION["paging"][3]["page"] = $maks - 1;
    $_SESSION["paging"][4]["page"] = $maks;
}

if (isset($_POST["back"])) {
    $_SESSION["masukDetail"] = false;
    $_SESSION["masukCart"] = false;
    header("Location: #collections");
}
if (isset($_POST["resetAwal"])) {
    $_SESSION["history"] = false;
    $_SESSION["masukDetail"] = false;
    $_SESSION["masukCart"] = false;
    $_SESSION["listProduk"] = [];
    $_SESSION["listProduk"] = query("SELECT * FROM produk WHERE status_produk = '1'");
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    header("Location: #collections");
}
if (isset($_POST["c1"])) {
    $_SESSION["masukDetail"] = true;
    $id = 145;
    $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$id'");
}
if (isset($_POST["c2"])) {
    $_SESSION["masukDetail"] = true;
    $id = 281;
    $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$id'");
}
if (isset($_POST["c3"])) {
    $_SESSION["masukDetail"] = true;
    $id = 1125;
    $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$id'");
}
if (isset($_POST["c4"])) {
    $_SESSION["masukDetail"] = true;
    $id = 160;
    $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$id'");
}
if (isset($_POST["c5"])) {
    $_SESSION["masukDetail"] = true;
    $id = 280;
    $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$id'");
}
if (isset($_POST["c6"])) {
    $alRihla = "al rihla pack";
    $_SESSION["listProduk"] = query("SELECT * FROM produk WHERE name_produk LiKE '%" . $alRihla . "%'");
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["detail"])) {
    //GANTIII
    if (isset($_POST["idDetail"])) {
        $_SESSION["masukDetail"] = true;
        $_SESSION["history"] = false;
        $id = $_POST["idDetail"];
        $curID = $id;
        $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$id'");
    }

    // if ($_SESSION["tempIdDetail"] != -1) {
    //     //Munculkan detail
    //     $_SESSION["masukDetail"] = true;
    //     $tempIdQuery = $_SESSION["tempIdDetail"];
    //     alert($_SESSION["tempIdDetail"]);

    //     $produkDetail = query("SELECT * FROM produk WHERE id_produk = '$tempIdQuery'");
    //     // alert($produkDetail[0]["id_produk"]);
    // }
}

if (isset($_POST["btnFilter"])) {

    // alert("filter");

    $brandFilter = [];
    if (!empty($_POST["filterBrand"])) {
        foreach ($_POST["filterBrand"] as $value) {
            // alert("brand : " . $value);
            $brands = query("SELECT * FROM brand WHERE name_brand = '$value'");
            array_push($brandFilter, $brands[0]["id_brand"]);
        }
    }

    // var_dump($brandFilter);

    $kategoriFilter = [];
    if (!empty($_POST["filterKategori"])) {

        foreach ($_POST["filterKategori"] as $value) {
            // alert("kategori : " . $value);
            $kategories = query("SELECT * FROM kategori WHERE name_kategori = '$value'");
            array_push($kategoriFilter, $kategories[0]["id_kategori"]);
        }
    }

    // var_dump($kategoriFilter);

    if (count($brandFilter) > 0 || count($kategoriFilter) > 0) {

        $query = "SELECT * FROM produk WHERE status_produk = '1' AND";

        for ($i = 0; $i < count($brandFilter); $i++) {
            $filter = $brandFilter[$i];
            if ($i == 0) {
                $temp = ' (id_brand LIKE "%' . $filter . '%"';
            } else {
                $temp = ' OR id_brand LIKE "%' . $filter . '%"';
            }
            $query .= $temp;
        }
        if (count($brandFilter) > 0) {
            $query .= ')';
        }

        for ($i = 0; $i < count($kategoriFilter); $i++) {
            $filter = $kategoriFilter[$i];
            if ($i == 0 && count($brandFilter) > 0) {
                $temp = ' AND (id_kategori LIKE "%' . $filter . '%"';
            } else if ($i == 0) {
                $temp = ' (id_kategori LIKE "%' . $filter . '%"';
            } else {
                $temp = ' OR id_kategori LIKE "%' . $filter . '%"';
            }
            $query .= $temp;
        }
        if (count($kategoriFilter) > 0) {
            $query .= ')';
        }

        // echo "<script>console.log('$query')</script>";

        $_SESSION["listProduk"] = query($query);
        $_SESSION["productCount"] = count($_SESSION["listProduk"]);
        resetPaging();
        header("Location: #collections");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM produk WHERE status_produk = '1'");
        $_SESSION["productCount"] = count($_SESSION["listProduk"]);
        resetPaging();
        header("Location: #collections");
    }
    $_SESSION["masukCart"] = false;
    $_SESSION["history"] = false;
}

if (isset($_POST["addToCart"])) {
    $_SESSION["masukDetail"] = false;
    $tempId = $_POST["cartPassID"];
    $tempQuantity = $_POST["quantity"];
    // alert("Berhasil menambahkan ke keranjang!");

    if ($tempQuantity > 0) {
        $tempProduk = query("SELECT * FROM produk WHERE id_produk = '$tempId'");

        $tempKeranjang = [
            "id_produk" => $tempProduk[0]["id_produk"],
            "image_produk" => $tempProduk[0]["image_produk"],
            "name_produk" => $tempProduk[0]["name_produk"],
            "price_produk" => $tempProduk[0]["price_produk"],
            "quantity_produk" => $tempQuantity
        ];

        $tempIdCart = -1;
        foreach ($_SESSION["keranjang"] as $i => $key) {
            if ($key["id_produk"] == $tempProduk[0]["id_produk"] && $tempIdCart == -1) {
                $tempIdCart = $i;
            }
        }

        if ($tempIdCart == -1) {
            if (isset($_SESSION["keranjang"])) {
                array_push($_SESSION["keranjang"], $tempKeranjang);
            } else {
                $_SESSION["keranjang"] = [];
                array_push($_SESSION["keranjang"], $tempKeranjang);
            }
        } else {
            $_SESSION["keranjang"][$tempIdCart]["quantity_produk"] = $tempQuantity;
        }
    } else {
        $_SESSION["keranjang"] = [];
    }
}

if (isset($_POST["history"])) {
    $_SESSION["history"] = true;
}

if (isset($_POST["btnInvoice"])) {
    $nota = $_POST["sentNota"];
    $_SESSION["invoiceNota"] = $nota;
    
    header("Location: invoice.php");
}

// var_dump($_SESSION["keranjang"]);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sport Station</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- jQuery -->
    <script src="jquery-3.6.1.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey; ?>"></script>
<script>
    function clearForm() {
        document.getElementsByName("name")[0].value = "";
        document.getElementsByName("email")[0].value = "";
        document.getElementsByName("textarea")[0].value = "";
    }

    function transaksi() {
        loginValue = document.getElementById("loginValue").value;
        if (loginValue) {
            // SnapToken acquired from previous step
            snap.pay("<?php echo $snap_token ?>", {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    document.location.href = "thankyou_v2.php";
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    document.location.href = "error.php";
                }
            });
        } else {
            document.location.href = "login.php";
        }


    };
</script>

<body>
    <!-- NAVBAR -->
    <nav class="bg-dark text-white fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 col-lg-2 d-flex align-items-center py-3">
                    <form class="m-0" action="" method="post">
                        <button class="navbar-brand bg-transparent border border-0" name="resetAwal" href="#">
                            <img src="asset/logo_toko.png" alt="Logo" width="50" height="50" class="d-inline-block">
                        </button>
                    </form>
                    <div class="navbar-brand d-xl-inline d-none fs-5">
                        Sport Station
                    </div>
                </div>
                <div class="col-7 col-lg-8 d-flex align-items-center justify-content-center">
                    <form class="d-flex m-0" role="search" method="POST" style="width: 100%;">
                        <input class="form-control me-2" type="Search" placeholder="Search" aria-label="Search" name="input">
                        <button class="btn btn-outline-light" type="submit" name="search">Search</button>
                    </form>
                </div>
                <div class="col-3 col-lg-2 d-flex justify-content-end align-items-center">
                    <?php
                    if ($_SESSION["login"] == true) {
                    ?>
                        <form class=" m-0" action="" method="post">
                            <button class="navbar-brand mx-2 bg-transparent border border-0" name="history">
                                <i class=" fa-solid fa-clock-rotate-left fs-3 text-center pt-1" style="width: 35px; height: 35px;"></i>
                            </button>
                        </form>
                    <?php
                    }
                    ?>
                    <form class=" m-0" action="" method="post">
                        <button class="navbar-brand mx-2 bg-transparent border border-0" name="cart" onclick="loadCart()">
                            <img src="asset/keranjang.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                        </button>
                    </form>
                    <?php
                    if ($_SESSION["login"] == false) {
                    ?>
                        <a class="navbar-brand mx-2" href="login.php">
                            <img src="asset/login.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                        </a>
                    <?php
                    } else {
                    ?>
                        <form class="m-0" action="" method="post">
                            <button class="navbar-brand mx-2 bg-transparent border border-0" name="logout">
                                <img src="asset/logout.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                            </button>
                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- SCROLL -->
    <div style="margin-top:78px">
        <!-- Div kiri buat scroll -->
        <div class="d-flex align-items-center justify-content-center">
            <button class="buttonCategories d-flex align-items-center justify-content-center text-white ps-2 border-0" onclick="openNav()">
                <h2><img src="asset/arrow_kanan.png" alt="" width="25" height="25"></h2>
            </button>
        </div>

        <!-- kategori -->
        <div id="mySidenav" class="sidenav">
            <form action="" method="post">

                <button type="button" class="closebtn bg-transparent text-white border border-0" onclick="closeNav()" class="btn btn-link">&times;</button>

                <div class="d-flex justify-content-between align-items-center klikBrand">
                    <span class="fs-3 text-white ms-4">
                        Brand
                    </span>
                    <div id="iconBrand" name="collapse">
                        <i class="fa-sharp fa-solid fa-arrow-up text-light me-4"></i>
                    </div>
                </div>
                <div class="toogleBrand">
                    <table class="text-light ms-5">
                        <?php
                        // GANTI ARRAY BRAND
                        foreach ($_SESSION["cbBrand"] as $key => $value) {
                        ?>
                            <tr class="text-light">
                                <td class="text-light py-2"><input type="checkbox" style="width: 17px; height: 17px;" name="filterBrand[]" id="" value='<?= $value["brand"] ?>'> <?= $value["brand"] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>

                <div class="mt-2 d-flex justify-content-between align-items-center klikCategories">
                    <span class="fs-3 text-white ms-4">
                        Categories
                    </span>
                    <div id="iconCategory" name="collapse">
                        <i class="fa-sharp fa-solid fa-arrow-up text-light me-4"></i>
                    </div>
                </div>
                <div class="toogleCategories">
                    <table class="text-light ms-5">
                        <?php
                        // GANTI ARRAY BRAND
                        foreach ($_SESSION["cbCategories"] as $key => $value) {
                        ?>
                            <tr class="text-light">
                                <td class="text-light py-2"><input type="checkbox" style="width: 17px; height: 17px;" name="filterKategori[]" id="" value='<?= $value["categories"] ?>'> <?= $value["categories"] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-outline-light text-light" name="btnFilter">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SESSION["history"] == false) {
        if ($_SESSION["masukCart"] == false) {
            # code...
            if ($_SESSION["masukDetail"] == false) {
    ?>
                <div class="container-fluid bgGradient">
                    <div class="d-flex justify-content-center" style="padding-top: 4vh;">
                        <!-- carousel -->
                        <!-- <div class="d-flex justify-content-center">
                            <div class="col-1"></div>
                            <div class="col-9 my-5 ">
                                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner shadow ">
                                        <div class="carousel-item active" data-bs-interval="2000">
                                            <img src="asset/sepatu1.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/sepatu2.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/sepatu3.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/ball1.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/gloves1.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/gloves2.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/gloves3.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/jersey1.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/brand1.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/brand2.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="asset/brand3.jpg" class="d-block w-100 rounded-4" alt="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div> -->
                        <div class="containerr carousel slide">

                            <!-- Full-width images with number text -->
                            <div class=" mySlides">
                                <div class="numbertext m-3 rounded">1 / 6</div>
                                <form action="" method="post">
                                    <button type="submit" class="border border-0 bg-transparent" name="c1"><img src="asset/c1.jpg" class="" style="width:72vw; height: 85vh; border-radius: 1vw;"></button>
                                </form>
                            </div>

                            <div class="mySlides">
                                <div class="numbertext m-3 rounded">2 / 6</div>
                                <form action="" method="post">
                                    <button type="submit" class="border border-0 bg-transparent" name="c2"><img src="asset/c2.webp" class="" style="width:72vw; height: 85vh; border-radius: 1vw;"></button>
                                </form>
                            </div>

                            <div class="mySlides">
                                <div class="numbertext m-3 rounded">3 / 6</div>
                                <form action="" method="post">
                                    <button type="submit" class="border border-0 bg-transparent" name="c3"><img src="asset/c3.jpg" class="" style="width:72vw; height: 85vh; border-radius: 1vw;"></button>
                                </form>
                            </div>

                            <div class="mySlides">
                                <div class="numbertext m-3 rounded">4 / 6</div>
                                <form action="" method="post">
                                    <button type="submit" class="border border-0 bg-transparent" name="c4"><img src="asset/c4.jpg" class="" style="width:72vw; height: 85vh; border-radius: 1vw;"></button>
                                </form>
                            </div>

                            <div class="mySlides">
                                <div class="numbertext m-3 rounded">5 / 6</div>
                                <form action="" method="post">
                                    <button type="submit" class="border border-0 bg-transparent" name="c5"><img src="asset/c5.png" class="" style="width:72vw; height: 85vh; border-radius: 1vw;"></button>
                                </form>
                            </div>

                            <div class="mySlides">
                                <div class="numbertext m-3 rounded"> 6 / 6 </div>
                                <form action="" method="post">
                                    <button type="submit" class="border border-0 bg-transparent" name="c6"><img src="asset/c6.jpg" class="" style="width:72vw; height: 85vh; border-radius: 1vw;"></button>
                                </form>
                            </div>

                            <!-- Next and previous buttons -->
                            <a class="prev text-info text-decoration-none glass rounded" style="margin-left: 3vw;background-color: rgba(0, 0, 0, 0.8);" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next text-info text-decoration-none glass rounded" style="background-color: rgba(0, 0, 0, 0.8);" onclick="plusSlides(1)">&#10095;</a>
                        </div>
                    </div>
                    <!-- tutup carousel -->

                    <!-- untuk paging -->
                    <div id="collections" class="pt-5"></div>

                    <div class="" style="margin-left: 60px;">
                        <div class="d-flex justify-content-center">
                            <div class="container text-center mt-4 pb-5">
                                <!-- CARD -->
                                <div class="row d-flex justify-content-center glass pt-4">
                                    <div class="col-12">
                                        <h1>New Collections</h1>
                                    </div>
                                    <div class="col-12">
                                        <?php
                                        if (count($_SESSION["listProduk"]) == 0) {
                                        ?>
                                            <h5>Result 0 - 0 of 0</h5>
                                            <?php
                                        } else {
                                            if (($_SESSION["pageSekarang"]) * 30 < $_SESSION["productCount"]) {
                                            ?>
                                                <h5>Result <?= ($_SESSION["pageSekarang"] - 1) * 30 + 1 ?> - <?= ($_SESSION["pageSekarang"]) * 30 ?> of <?= $_SESSION["productCount"] ?></h5>
                                            <?php
                                            } else {
                                            ?>
                                                <h5>Result <?= ($_SESSION["pageSekarang"] - 1) * 30 + 1 ?> - <?= $_SESSION["productCount"] ?> of <?= $_SESSION["productCount"] ?></h5>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-12 text-dark">
                                        <hr style="font-weight: bold; color: black;">
                                    </div>
                                    <?php
                                    $temp = 0;
                                    // GANTI MAKS ARRAY
                                    foreach ($_SESSION["listProduk"] as $product) {
                                        $id = $product["id_produk"];
                                        $name = $product["name_produk"];
                                        $price = $product["price_produk"];
                                        $image = $product["image_produk"];
                                        //PASSINGG
                                        $temp++;
                                        if (($temp / 30) > $_SESSION["pageSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageSekarang"]) {
                                    ?>
                                            <div class="col-5 col-md-4 col-lg-3 col-xl-2 mx-3 my-3 d-flex justify-content-center ">
                                                <form action="" method="post">
                                                    <button class="bg-transparent border border-0" name="detail">
                                                        <input type="hidden" name="idDetail" value="<?= $id ?>">
                                                        <div class="img-fluid">
                                                            <div class="card btn btn-outline-dark shadow border-0" style="width: 13rem; height: 21rem;">
                                                                <?php
                                                                echo "<img src ='$image' class='card-img-top border-0 img-size' alt='...'/>";
                                                                ?>
                                                                <div class="card-body ">
                                                                    <h6 class="card-title mb-2"><?= $name ?></h6>
                                                                    <p class="card-text">$ <?= $price ?></p>
                                                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <!-- PAGING -->
                                    <div class="row py-3">
                                        <form action="" method="post">
                                            <div class="col-12 d-flex justify-content-center">
                                                <ul class="pagination d-flex align-items-center justify-content-center img-fluid">
                                                    <div class="row d-flex justify-content-center rounded-pill bg-dark px-2">
                                                        <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                            <li class="page-item">
                                                                <button type="submit" class="btn text-light border border-0" name="pageSekarangMin1" aria-label="Previous">
                                                                    <span aria-hidden="true">&laquo;</span>
                                                                </button>
                                                            </li>
                                                        </div>
                                                        <?php
                                                        $adaSatu = false;
                                                        if ($_SESSION["pageSekarang"] > 3 && $_SESSION["paging"][0]["page"] != 1) {
                                                            $adaSatu = true;
                                                        ?>
                                                            <div class="col-5 col-xl-2 d-flex justify-content-center">
                                                                <li class="page-item text-light"><button type="submit" name="pagePertama" class="btn text-light border border-0">1</button><span class="text-light"> . . . </span></li>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                            <li class="page-item"><button type="submit" name="page0" class="btn text-light border border-0"><?= $_SESSION["paging"][0]["page"] ?></button></li>
                                                        </div>
                                                        <?php
                                                        if (($_SESSION["productCount"] / 30) > 1) {
                                                        ?>
                                                            <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                                <li class="page-item"><button type="submit" name="page1" class="btn text-light border border-0"><?= $_SESSION["paging"][1]["page"] ?></button></li>
                                                            </div>
                                                        <?php
                                                        }
                                                        if (($_SESSION["productCount"] / 30) > 2) {
                                                        ?>
                                                            <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                                <li class="page-item"><button type="submit" name="page2" class="btn text-light border border-0"><?= $_SESSION["paging"][2]["page"] ?></button></li>
                                                            </div>
                                                        <?php
                                                        }
                                                        if (($_SESSION["productCount"] / 30) > 3) {
                                                        ?>
                                                            <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                                <li class="page-item"><button type="submit" name="page3" class="btn text-light border border-0"><?= $_SESSION["paging"][3]["page"] ?></button></li>
                                                            </div>
                                                        <?php
                                                        }
                                                        if (($_SESSION["productCount"] / 30) > 4) {
                                                        ?>
                                                            <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                                <li class="page-item"><button type="submit" name="page4" class="btn text-light border border-0"><?= $_SESSION["paging"][4]["page"] ?></button></li>
                                                            </div>
                                                            <?php
                                                        }
                                                        if ($_SESSION["pageSekarang"] < $maks - 3 && $_SESSION["paging"][4]["page"] != (int)$maks) {
                                                            if ($adaSatu) {
                                                            ?>
                                                                <div class="col-5 col-xl-2">
                                                                    <li class="page-item text-light"><span class="text-light"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-light border border-0"><?= (int)$maks ?></button></li>
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="col-5 col-xl-3">
                                                                    <li class="page-item text-light"><span class="text-light"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-light border border-0"><?= (int)$maks ?></button></li>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                            <button type="submit" class="btn text-light border border-0" name="pageSekarangPlus1" aria-label="Next">
                                                                <span aria-hidden="true">&raquo;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                            <div class="col-12 d-flex justify-content-center">
                                                <h5 class="text-dark">Page <?= $_SESSION["pageSekarang"] ?> of <?= (int)$maks ?></h5>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                $_SESSION["masukDetail"] = false;
            ?>
                <form action="" method="post" class="mb-0">
                    <input type="hidden" name="cartPassID" value="<?= $curID ?>">
                    <div class="container-fluid bgGradient">
                        <div class="" style="margin-left: 60px;">
                            <div class="d-flex justify-content-center">
                                <div class="container text-center mt-4 py-5">
                                    <div class="row d-flex justify-content-center glass p-5" style="background-color: white;">
                                        <div class="col-12 text-center">
                                            <h1>Details</h1>
                                        </div>
                                        <div class="col-12 col-xl-6 d-flex justify-content-start align-items-center">
                                            <?php
                                            $image = $produkDetail[0]["image_produk"];
                                            echo "<img src='$image' style='height: auto;' class='card-img-top border-0 img-size' alt='...'/>";
                                            ?>
                                        </div>
                                        <div class="col-12 col-xl-6 px-5 py-5 d-flex align-items-center">
                                            <div class="row">
                                                <div class="col-12 text-dark text-start">
                                                    <h1><?= $produkDetail[0]["name_produk"] ?></h1>
                                                </div>
                                                <div class=" py-3 col-12 pb-4 text-danger text-start">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <h3>$</h3>
                                                        </div>
                                                        <div class="col-9">
                                                            <h3 id="hargaProduk"><?= $produkDetail[0]["price_produk"] ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 pb-4 text-start">
                                                    <hr>
                                                </div>
                                                <div class="col-12 pb-4">
                                                    <div class="row">
                                                        <div class="col-5 col-xl-1">
                                                            <h5>Quantity:</h5>
                                                        </div>
                                                        <div class="col-5 col-xl-9">
                                                            <?php
                                                            $cekJumlah = 0;
                                                            foreach ($_SESSION["keranjang"] as $i => $key) {
                                                                if ($key["id_produk"] == $produkDetail[0]["id_produk"]) {
                                                                    $cekJumlah = $_SESSION["keranjang"][$i]["quantity_produk"];
                                                                }
                                                            }
                                                            $stok = $produkDetail[0]["stok_produk"];
                                                            ?>
                                                            <input type="number" onclick="updateTotalHarga();" class="mx-3" style="width: 60px" name="quantity" id="quantity" min="0" max="<?= $stok ?>" value=<?= $cekJumlah ?>>
                                                            <?= $stok ?> Remaining.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 pb-4 text-start">
                                                    <div class="row">
                                                        <div class="col-7 col-xl-3">
                                                            <h3>Total: $</h3>
                                                        </div>
                                                        <div class="col-4 col-xl-7 text-danger">
                                                            <h3 id="totalHarga"><?= $produkDetail[0]["price_produk"] * $cekJumlah ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 pb-4 text-start">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button type="submit" class="btn btn-success d-flex justify-content-center align-items-center" name="addToCart">ADD TO CART <img src="asset/keranjang.png" style="width: 30px; height:auto; margin-left:15px;" alt=""></button>
                                                        </div>
                                                        <div class="col-6">
                                                            <form action="" method="post">
                                                                <button type="submit" class="btn btn-danger d-flex justify-content-center align-items-center" name="back">BACK</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 py-5 text-start d-flex align-items-center">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3>Description : </h3>
                                                    <hr>
                                                </div>
                                                <div class="col-12">
                                                    <p style="font-size: 18px"><?= $produkDetail[0]["description_produk"] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php
            }
        } else {
            ?>
            <!-- Cart -->
            <div class="bgGradient min-vh-100" style="margin-left: 30px;">
                <div class="row pt-5 d-flex justify-content-evenly mx-3">
                    <div class="col-12 col-xl-7 text-center mt-4 pb-5 d-flex me-3">
                        <div class="row d-flex justify-content-center glass pt-4">
                            <div class="col-12 my-3">
                                <h1 class="text-success">Cart</h1>
                            </div>
                            <div class="col-12">
                                <div class="row d-flex justify-content-center" id="listCart" onload="loadCart()">

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($_SESSION["login"]) {
                        $idUser = $_SESSION['idUser'];
                        $stmt = $conn->query("SELECT * FROM user WHERE id_user='$idUser'");
                        $user = $stmt->fetch_assoc();
                    ?>
                        <div class="col-8 col-xl-4 text-center mt-4 pb-5">
                            <div class="row d-flex justify-content-center glass py-4 w-100 px-2">
                                <div class="col-12 my-4">
                                    <h2 class="text-success">Shipping Detail</h2>
                                </div>
                                <div class="col-12">
                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-floating mb-3 w-100">
                                                    <input type="text" class="form-control" placeholder="Name" name="nameUser" id="nameUser" value="<?= $user['full_name'] ?>">
                                                    <label for="nameUser">Name</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3 w-100">
                                                    <input type="email" class="form-control" placeholder="Email" name="emailUser" id="emailUser" value="<?= $user['email'] ?>">
                                                    <label for="emailUser">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3 w-100">
                                                    <input type="text" class="form-control" placeholder="Phone Number" name="phoneUser" id="phoneUser" value="<?= $user['nomor_telepon'] ?>">
                                                    <label for="phoneUser">Phone Number</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating mb-3 w-100">
                                                    <input type="text" class="form-control" placeholder="Address" name="addressUser" id="addressUser" value="<?= $user['alamat'] ?>">
                                                    <label for="addressUser">Address</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row me-3">
                                            <div class="saveDataUser d-flex justify-content-end">
                                                <button name="btnSaveDataUser" class="btn btn-outline-dark">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-8 col-xl-4 text-center mt-4">
                            <div class="row glass d-flex justify-content-center w-100" style="background-image: url('asset/shipping.jpg'); background-repeat: no-repeat;background-size: cover;">
                                <div class="glass2 d-flex align-items-center justify-content-center text-dark" style="height: 66vh;">
                                    <div class="row">
                                        <div class="col-12">
                                            <h1>Login First To</h1>
                                        </div>
                                        <div class="col-12">
                                            <h1>Confirm Your Data</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
    } else {
        ?>
        <!-- history -->
        <div class="bgGradient d-flex justify-content-center" style="margin-left: 30px; min-height: 65vh;">
            <div class="container glass my-3 pt-3">
                <?php
                $idUser = $_SESSION["idUser"];
                $htrans = query("SELECT * FROM htrans WHERE id_user = '$idUser'");
                foreach ($htrans as $key => $value) {
                    $nota = $value["nota_jual"];
                    $tempTanggal = $value["tanggal"];
                    $time = strtotime($tempTanggal);
                    $tanggal = date('d-m-Y', $time);
                    $idUser = $value["id_user"];
                    $subtotal = number_format($value["subtotal"] + 5, 2, ',', '.');

                    $dtrans = query("SELECT * FROM dtrans WHERE nota_jual = '$nota'");

                ?>
                    <div class="card">
                        <div class="card-header">
                            <span class="text-success fs-3 mt-3">Success</span>
                            <div class="headerHistory d-flex align-item-center justify-content-between">
                                <div class="headerKiri d-flex align-items-center">
                                    <h5 class="me-3"><?= $tanggal ?>,</h5>
                                    <h6 class="me-3"><?= $nota ?></h6>
                                </div>
                                <div class="headerKanan d-flex align-items-center">
                                    <h5 class="fw-bold">$ <?= $subtotal ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php

                            foreach ($dtrans as $key => $value) {
                                $idProduk = $value["id_produk"];
                                $quantity = $value["quantity"];

                                $produk = query("SELECT * FROM produk WHERE id_produk = '$idProduk'");
                                foreach ($produk as $key => $value) {
                                    $nameProduk = $value["name_produk"];
                                    $nameProduk = ucfirst($nameProduk);
                                    $idBrand = $value["id_brand"];
                                    $brand = query("SELECT * FROM brand WHERE id_brand = '$idBrand'");
                                    foreach ($brand as $key => $valueBrand) {
                                        $nameBrand = $valueBrand["name_brand"];
                                    }
                                    $idKategori = $value["id_kategori"];
                                    $kategori = query("SELECT * FROM kategori WHERE id_kategori = '$idKategori'");
                                    foreach ($kategori as $key => $valueKategori) {
                                        $nameKategori = $valueKategori["name_kategori"];
                                    }
                                    $priceProduk = $value["price_produk"];
                                    $imageProduk = $value["image_produk"];
                                    $total = $quantity * $priceProduk;

                            ?>
                                    <div class="card mb-3" style="max-width: 100%;">
                                        <div class="row">
                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                <img src="<?= $imageProduk ?>" class="img-fluid rounded-start" style="width: 50%;" alt="...">
                                            </div>
                                            <div class="col-md-10">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $nameProduk ?></h5>
                                                    <span class="card-text mt-1">Kategori: <?= $nameKategori ?> - </span>
                                                    <span class="card-text">Brand: <?= $nameBrand ?></span> <br>
                                                    <span class="card-text">Price: $ <?= $priceProduk ?> - </span>
                                                    <span class="card-text">Quantity: <?= $quantity ?></span> <br>
                                                    <div class="totalHarga d-flex align-items-center justify-content-end">
                                                        <span class="card-text fw-bold">Total: $ <?= $total ?></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php
                                }
                            }
                            ?>
                            <div class="footerCart d-flex justify-content-between">
                                <div class="footerKiri align-self-end ms-1">
                                    <form class="m-0" action="" method="post">
                                        <input type="hidden" name="sentNota" value="<?= $nota ?>">
                                        <button class="btn btn-outline-dark" name="btnInvoice" id="btnInvoice">Invoice</button>
                                    </form>
                                </div>
                                <div class="footerKanan">
                                    <div class="subTotal d-flex align-items-center justify-content-end">
                                        <span class="fs-5">Shipping Fee: $5</span>
                                    </div>
                                    <div class="subTotal d-flex align-items-center justify-content-end">
                                        <span class="fs-4 fw-bold">Subtotal: $ <?= $subtotal ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    }
    ?>

    <!-- Footer -->
    <section class="container-fluid d-flex bg-dark justify-content-center isifot text-light" style="width:100%;" id="footer">
        <div class="row ftr p-3" style="width: 100%; ">
            <div class="over d-flex justify-content-center" style="margin-left: 1vw; margin-right:5vw">
                <div class="col-6 col-lg-3" style="margin: 0.1vw;">
                    <a class="nav-link text-white" href="#" style="display: flex;">
                        <img src="asset/logo_toko.png" class="gambar" style="width: 3vw; height:3vw; margin-right: 10px" alt="" srcset="">
                        <h2 style="margin: 0.3vw;">
                            Sport Station
                        </h2>
                    </a>
                    <div class="des ms-5">
                        <p style="font-size: 1vw;margin-left: 10px">Jl. Ahmad Yani No.233<br>
                            Surabaya, Indonesia</p>
                        <p style="font-size: 0.7vw; margin-left: 10px">Payment By Midtrans</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" style="margin: 0.5vw;font-size: 1.3vw; color:dark;">
                    <p>Our Contacts</p>
                    <div class="des">
                        <p style="font-size: 1vw;">Email : soccersportstation@gmail.com</p>
                        <p style="font-size: 1vw;">Phone : (888) 8888888</p>
                        <p style="font-size: 1vw;">Mobile : 8888888888</p>
                    </div>
                </div>
                <div class="col-6 col-lg-2 ms-4" style="margin: 0.5vw; font-size: 1.3vw; color:dark;">
                    <p>Company</p>
                    <div class="des">
                        <p style="font-size: 1vw;">About Us</p>
                        <p style="font-size: 1vw;">Blog</p>
                        <p style="font-size: 1vw;">Careers</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3" style="margin: 0.5vw;font-size: 1.3vw; color:dark;">
                    <p>Subscribe our Sport Station</p>
                    <div class="des">
                        <div class="row">
                            <div class="col-1 text-start me-2">
                                <i class="fa-brands fa-facebook"></i>
                            </div>
                            <div class="col-1 text-start me-2">
                                <i class="fa-brands fa-instagram"></i>
                            </div>
                            <div class="col-1 text-start me-2">
                                <i class="fa-brands fa-linkedin"></i>
                            </div>
                            <div class="col-1 text-start me-2">
                                <i class="fa-brands fa-twitter"></i>
                            </div>
                            <div class="col-1 text-start me-2">
                                <i class="fa-brands fa-youtube"></i>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12">
                                <p style="font-size: 1vw;">Copyright © 2022 SoccerPro. All Rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <!-- script buat open scroll yang dikiri -->
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }


        $('.klikBrand').click(function() {
            $('.toogleBrand').slideToggle();
            if ($('#iconBrand').attr('name') == "expand") {
                $('#iconBrand').html("<i class='fa-sharp fa-solid fa-arrow-up text-light me-4'></i>");
                $('#iconBrand').attr('name', 'collapse');
            } else if ($('#iconBrand').attr('name') == "collapse") {
                $('#iconBrand').html("<i class='fa-sharp fa-solid fa-arrow-down text-light me-4'></i>");
                $('#iconBrand').attr('name', 'expand');
            }
        });
        $('.klikCategories').click(function() {
            $('.toogleCategories').slideToggle();
            if ($('#iconCategory').attr('name') == "expand") {
                $('#iconCategory').html("<i class='fa-sharp fa-solid fa-arrow-up text-light me-4'></i>");
                $('#iconCategory').attr('name', 'collapse');
            } else if ($('#iconCategory').attr('name') == "collapse") {
                $('#iconCategory').html("<i class='fa-sharp fa-solid fa-arrow-down text-light me-4'></i>");
                $('#iconCategory').attr('name', 'expand');
            }
        });

        function updateTotalHarga() {
            tempJumlah = document.getElementById("quantity").value;
            jumlah = parseFloat(tempJumlah);
            tempHarga = document.getElementById("hargaProduk").innerText;
            harga = parseFloat(tempHarga);
            document.getElementById("totalHarga").innerText = tempJumlah * harga;
        }

        function updateCart(id) {
            idx = parseInt(id);
            quantity = document.getElementById("quantity" + idx).value;
            max = document.getElementById("quantity" + idx).max;
            quantity = parseInt(quantity);
            max = parseInt(max);

            if (quantity > max) {
                quantity = max;
            }

            r = new XMLHttpRequest();
            // 2. Callback Function apa yang akan dikerjakan
            // NB: Jangan menggunakan Arrow Function () => {} di sini
            //     karena akan return undefined dan null
            r.onreadystatechange = function() {
                // Kalau dapat data dan status selesai > Lakukan sesuatu
                if ((this.readyState == 4) && (this.status == 200)) {
                    console.log("ajax ok!");
                    document.getElementById("listCart").innerHTML = this.responseText;
                }
            }
            // 3. Memanggil dan mengeksekusi AJAX
            r.open('GET', 'cart_ajax.php?id=' + id + '&quantity=' + quantity);
            r.send();

            document.location.href = 'index.php';

        }

        function deleteItemCart(id) {
            idx = parseInt(id);
            quantity = 0;

            r = new XMLHttpRequest();
            // 2. Callback Function apa yang akan dikerjakan
            // NB: Jangan menggunakan Arrow Function () => {} di sini
            //     karena akan return undefined dan null
            r.onreadystatechange = function() {
                // Kalau dapat data dan status selesai > Lakukan sesuatu
                if ((this.readyState == 4) && (this.status == 200)) {
                    console.log("ajax ok!");
                    document.getElementById("listCart").innerHTML = this.responseText;
                }
            }
            // 3. Memanggil dan mengeksekusi AJAX
            r.open('GET', 'cart_ajax.php?id=' + id + '&quantity=' + quantity);
            r.send();

            document.location.href = 'index.php';

        }

        loadCart();

        function loadCart() {
            r = new XMLHttpRequest();
            // 2. Callback Function apa yang akan dikerjakan
            // NB: Jangan menggunakan Arrow Function () => {} di sini
            //     karena akan return undefined dan null
            r.onreadystatechange = function() {
                // Kalau dapat data dan status selesai > Lakukan sesuatu
                if ((this.readyState == 4) && (this.status == 200)) {
                    console.log("ajax ok!");
                    document.getElementById("listCart").innerHTML = this.responseText;
                }
            }
            // 3. Memanggil dan mengeksekusi AJAX
            r.open('GET', 'cart_ajax.php?');
            r.send();

            // document.location.href = 'index.php';

        }

        let slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("demo");
            let captionText = document.getElementById("caption");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>
</body>

</html>