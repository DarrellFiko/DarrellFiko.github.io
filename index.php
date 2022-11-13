<?php
require_once("connection.php");
require("functions.php");

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
}

if (!isset($_SESSION["productCount"])) {
    $_SESSION["productCount"] = 0;
}
if (!isset($_SESSION["listProduk"])) {
    $_SESSION["listProduk"] = [];
    $_SESSION["listProduk"] = query("SELECT * FROM produk");
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

// AMBIL MERK ATAU BRAND
if (isset($_POST["allBrands"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["brand"] = "";
    if ($_SESSION["category"] != "") {
        $tempCategory = $_SESSION["category"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE category = '$tempCategory'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["Nike"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["brand"] = "nike";
    if ($_SESSION["category"] != "") {
        $tempCategory = $_SESSION["category"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = 'nike' AND category = '$tempCategory'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = 'nike'");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["Adidas"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["brand"] = "adidas";
    if ($_SESSION["category"] != "") {
        $tempCategory = $_SESSION["category"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = 'adidas' AND category = '$tempCategory'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = 'adidas'");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["Puma"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["brand"] = "puma";
    if ($_SESSION["category"] != "") {
        $tempCategory = $_SESSION["category"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = 'puma' AND category = '$tempCategory'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = 'puma'");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}

// AMBIL KATEGORI
if (isset($_POST["allCategories"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["category"] = "";
    if ($_SESSION["brand"] != "") {
        $tempBrand = $_SESSION["brand"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = '$tempBrand'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["Shoes"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["category"] = "shoes";
    if ($_SESSION["brand"] != "") {
        $tempBrand = $_SESSION["brand"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = '$tempBrand' AND category = 'shoes'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE category = 'shoes'");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["Balls"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["category"] = "balls";
    if ($_SESSION["brand"] != "") {
        $tempBrand = $_SESSION["brand"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = '$tempBrand' AND category = 'balls'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE category = 'balls'");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["Jersey"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["category"] = "jerseys";
    if ($_SESSION["brand"] != "") {
        $tempBrand = $_SESSION["brand"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = '$tempBrand' AND category = 'jerseys'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE category = 'jerseys'");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["Gloves"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["category"] = "gloves";
    if ($_SESSION["brand"] != "") {
        $tempBrand = $_SESSION["brand"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = '$tempBrand' AND category = 'gloves'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE category = 'gloves'");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}
if (isset($_POST["Guards"])) {
    time_nanosleep(0, 350000000);
    $_SESSION["category"] = "shinGuards";
    if ($_SESSION["brand"] != "") {
        $tempBrand = $_SESSION["brand"];
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE brand = '$tempBrand' AND category = 'shinGuards'");
    } else {
        $_SESSION["listProduk"] = query("SELECT * FROM product WHERE category = 'shinGuards'");
    }
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
}


//SEARCH
if (isset($_POST["search"])) {
    $_SESSION["input"] = $_POST["input"];
    alert($_SESSION["input"]);
    $_SESSION["listProduk"] = query("SELECT * FROM produk,brand,kategori WHERE produk.id_brand = brand.id_brand AND produk.id_kategori = kategori.id_kategori AND produk.name_produk LiKE '%" . $_SESSION["input"] . "%'");
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);
    resetPaging();
    header("Location: #collections");
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

if (isset($_POST["detail"])) {
    alert("test");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sport Station</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<script>
    function submit() {
        nama = document.getElementsByName("name")[0].value;
        email = document.getElementsByName("email")[0].value;
        teks = document.getElementsByName("textarea")[0].value;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementsByName("name")[0].value = "";
            document.getElementsByName("email")[0].value = "";
            document.getElementsByName("textarea")[0].value = "";
        }
        xhttp.open("GET", "Mailer/Mailer/emailku.php?nama=" + nama + "&email=" + email + "&teks=" + teks);
        xhttp.send();
    }

    function clearForm() {
        document.getElementsByName("name")[0].value = "";
        document.getElementsByName("email")[0].value = "";
        document.getElementsByName("textarea")[0].value = "";
    }
</script>

<body>
    <!-- NAVBAR -->
    <nav class="bg-dark text-white fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 col-lg-2 d-flex align-items-center">
                    <a class="navbar-brand" href="#">
                        <img src="asset/logo_toko.png" alt="Logo" width="50" height="50" class="d-inline-block">
                    </a>
                    <div class="navbar-brand d-xl-inline d-none fs-5">
                        Sport Station
                    </div>
                </div>
                <div class="col-7 col-lg-8 py-3">
                    <form class="d-flex" role="search" method="POST">
                        <input class="form-control me-2" type="Search" placeholder="Search" aria-label="Search" name="input">
                        <button class="btn btn-outline-light" type="submit" name="search">Search</button>
                    </form>
                </div>
                <div class="col-3 col-lg-2 d-flex justify-content-end py-3">
                    <a class="navbar-brand mx-2" href="#">
                        <img src="asset/keranjang.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                    </a>
                    <a class="navbar-brand mx-2" href="login.php">
                        <img src="asset/login.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- SCROLL -->
    <div style="margin-top:70px">
        <!-- Div kiri buat scroll -->
        <div class="d-flex align-items-center justify-content-center">
            <button class="buttonCategories d-flex align-items-center justify-content-center text-white ps-2" onclick="openNav()">
                <h2><img src="asset/arrow_kanan.png" alt="" width="25" height="25"></h2>
            </button>
        </div>

        <!-- kategori -->
        <form action="" method="post">
            <div id="mySidenav" class="sidenav">

                <button type="button" class="closebtn bg-transparent text-white border border-0" onclick="closeNav()" class="btn btn-link">&times;</button>

                <h2 class="text-white">
                    Brand
                </h2>
                <table class="text-light ms-5">
                    <?php
                    // GANTI ARRAY BRAND
                    foreach ($_SESSION["cbBrand"] as $key => $value) {
                    ?>
                        <tr class="text-light">
                            <td class="text-light py-2"><input type="checkbox" style="width: 17px; height: 17px;" name="" id=""> <?= $value["brand"] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>

                <h2 class="text-white mt-5">
                    Categories
                </h2>
                <table class="text-light ms-5 mb-5">
                    <?php
                    // GANTI ARRAY BRAND
                    foreach ($_SESSION["cbCategories"] as $key => $value) {
                    ?>
                        <tr class="text-light">
                            <td class="text-light py-2"><input type="checkbox" style="width: 17px; height: 17px;" name="" id=""> <?= $value["categories"] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-light text-light">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container-fluid bgGradient">
        <div class="" style="margin-left: 60px;">
            <!-- carousel -->
            <div class="d-flex justify-content-center">
                <div class="col-1"></div>
                <div class="col-10 my-5 ">
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
                <!-- tutup carousel -->
            </div>
        </div>

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
                            if (($_SESSION["pageSekarang"]) * 30 < $_SESSION["productCount"]) {
                            ?>
                                <h5>Result <?= ($_SESSION["pageSekarang"] - 1) * 30 + 1 ?> - <?= ($_SESSION["pageSekarang"]) * 30 ?> of <?= $_SESSION["productCount"] ?></h5>
                            <?php
                            } else {
                            ?>
                                <h5>Result <?= ($_SESSION["pageSekarang"] - 1) * 30 + 1 ?> - <?= $_SESSION["productCount"] ?> of <?= $_SESSION["productCount"] ?></h5>

                            <?php
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
                            $name = $product["name_produk"];
                            $price = $product["price_produk"];
                            $image = $product["image_produk"];
                            $image = base64_decode($image);

                            $temp++;
                            if (($temp / 30) > $_SESSION["pageSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageSekarang"]) {
                        ?>
                                <div class="col-5 col-md-4 col-lg-3 col-xl-2 mx-3 my-3 d-flex justify-content-center ">
                                    <form action="" method="post">
                                        <button class="bg-transparent border border-0" name="detail">
                                            <div class="img-fluid">
                                                <div class="card btn btn-outline-dark shadow border-0" style="width: 13rem; height: 21rem;">
                                                    <?php
                                                    echo '<img src = "data:assets/jpg;base64,' . base64_encode($image) . '" class="card-img-top border-0 img-size" alt="..."/>';
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
                                            if ($_SESSION["pageSekarang"] > 3 && $_SESSION["paging"][0]["page"] != 1) {
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
                                            ?>
                                                <div class="col-5 col-xl-2 d-flex justify-content-center">
                                                    <li class="page-item text-light"><span class="text-light"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-light border border-0"><?= (int)$maks ?></button></li>
                                                </div>
                                            <?php
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


                    <!-- MAILER -->
                    <div id="mailer" class="container bgContactGradient rounded-5 pt-3" style="margin-top: 5vh">
                        <div class="row my-5 d-flex justify-content-center">
                            <div class="col-10 px-5 pt-2 pb-3 d-flex bg-transparent justify-content-start rounded-top">
                                <h1 class="text-light">Contact Us</h1>
                            </div>
                            <div class="col-10 px-5 d-flex bg-transparent justify-content-start">
                                <div class="form-floating mb-3 w-100">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Name" name="name">
                                    <label for="floatingInput">Name</label>
                                </div>
                            </div>
                            <div class="col-10 px-5 d-flex bg-transparent justify-content-start">
                                <div class="form-floating mb-3 w-100">
                                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
                                    <label for="floatingInput">Email address</label>
                                </div>
                            </div>
                            <div class="col-10 px-5 d-flex bg-transparent justify-content-start">
                                <div class="form-floating mb-3 w-100">
                                    <textarea class="form-control" id="floatingInput" placeholder="Message" style="height: 20vh" aria-label="With textarea" name="textarea"></textarea>
                                    <label for="floatingInput">Message</label>
                                </div>
                            </div>
                            <div class="col-10 pt-3 pb-5 px-5 bg-transparent d-flex justify-content-start rounded-bottom">
                                <button type="submit" class="btn btn-outline-light me-3" name="submit" onclick="submit();">Submit</button>
                                <button type="submit" class="btn btn-outline-light" name="clear" onclick="clearForm();">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- test -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

        <!-- script buat open scroll yang dikiri -->
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
        </script>
</body>

</html>