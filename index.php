<?php
require_once("connection.php");
require("functions.php");

//
if (!isset($_SESSION["productCount"])) {
    $_SESSION["productCount"] = 0;
}
if (!isset($_SESSION["listProduk"])) {
    $_SESSION["listProduk"] = [];
    $_SESSION["listProduk"] = query("SELECT * FROM product");
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
    $_SESSION["listProduk"] = query("SELECT * FROM product WHERE name LiKE '%" . $_SESSION["input"] . "%' OR brand LiKE '%" . $_SESSION["input"] . "%' OR category LiKE '%" . $_SESSION["input"] . "%'");
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
    if ($_SESSION["paging"][4]["page"] < $maks) {
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
    if ($_SESSION["paging"][4]["page"] < $maks - 1) {
        $_SESSION["paging"][0]["page"] += 2;
        $_SESSION["paging"][1]["page"] += 2;
        $_SESSION["paging"][2]["page"] += 2;
        $_SESSION["paging"][3]["page"] += 2;
        $_SESSION["paging"][4]["page"] += 2;
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
        }
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}

// if (isset($_POST["submit"])) {
//     $_SESSION["message"] = $_POST["textarea"];
//     $_SESSION["email"] = $_POST["email"];
//     $_SESSION["name"] = $_POST["name"];
//     header("Location: Mailer/Mailer/emailku.php");
// }

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
                <ul class="text-light">
                    <input type="hidden" name="sent" value="<?= $_SESSION["brand"] ?>">
                    <li><button type="submit" name="allBrands" onclick="closeNav()" class="btn btn-link">All</button></li>
                    <li><button type="submit" onclick="closeNav()" class="btn btn-link" name="Nike">Nike</button></li>
                    <li><button type="submit" name="Adidas" onclick="closeNav()" class="btn btn-link">Adidas</button></li>
                    <li><button type="submit" name="Puma" onclick="closeNav()" class="btn btn-link">Puma</button></li>
                </ul>

                <h2 class="text-white">
                    Categories
                </h2>
                <ul class="text-light">
                    <input type="hidden" name="sent" value="<?= $_SESSION["category"] ?>">
                    <li><button type="submit" name="allCategories" onclick="closeNav()" class="btn btn-link">All</button></li>
                    <li><button type="submit" name="Shoes" onclick="closeNav()" class="btn btn-link">Shoes</button></li>
                    <li><button type="submit" name="Balls" onclick="closeNav()" class="btn btn-link">Balls</button></li>
                    <li><button type="submit" name="Jersey" onclick="closeNav()" class="btn btn-link">Jersey</button></li>
                    <li><button type="submit" name="Gloves" onclick="closeNav()" class="btn btn-link">Gloves</button></li>
                    <li><button type="submit" name="Guards" onclick="closeNav()" class="btn btn-link">Shin Guards</button></li>
                </ul>
            </div>
        </form>
    </div>

    <div class="container-fluid bgGradient">
        <div class="" style="margin-left: 60px;">
            <div class="d-flex justify-content-center">
                <!-- carousel -->
                <div class="col-1"></div>
                <div class="col-10 my-5">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner shadow">
                            <div class="carousel-item active">
                                <img src="asset/sepatu1.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/sepatu2.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/sepatu3.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/ball1.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/gloves1.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/gloves2.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/gloves3.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/jersey1.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/brand1.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/brand2.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/brand3.jpg" class="d-block w-100 rounded-4" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
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
                <!-- CARD -->
                <div class="container text-center mt-4 pb-5">
                    <div class="row d-flex justify-content-center glass pt-4">
                        <div class="col-12">
                            <h1>New Collections</h1>
                        </div>
                        <div class="col-12 text-dark">
                            <hr style="font-weight: bold; color: black;">
                        </div>
                        <?php
                        $temp = 0;
                        // GANTI MAKS ARRAY
                        foreach ($_SESSION["listProduk"] as $product) {
                            $id = $product["id"];
                            $name = $product["name"];
                            $brand = $product["brand"];
                            $category = $product["category"];
                            $stock = $product["stock"];
                            $price = $product["price"];
                            $image = $product["image"];
                            $status = $product["status"];
                            $linkDetail = $product["link_detail"];

                            $temp++;
                            if (($temp / 30) > $_SESSION["pageSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageSekarang"]) {
                        ?>
                                <div class="col-5 col-md-4 col-lg-3 col-xl-2 mx-3 my-3 d-flex justify-content-center ">
                                    <form action="" method="post">
                                        <button class="bg-transparent border border-0" name="detail">
                                            <div class="img-fluid">
                                                <div class="card btn btn-outline-dark shadow border-0" style="width: 13rem; height: 21rem;">
                                                    <img src="<?= $image ?>" class="card-img-top border-0 img-size" alt="...">
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
                        <div class="row py-4">
                            <form action="" method="post">
                                <div class="col-12 d-flex justify-content-center">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <button type="submit" class="btn btn-outline-light" name="pageSekarangMin1" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </button>
                                        </li>
                                        <li class="page-item"><button type="submit" name="page0" class="btn btn-outline-light"><?= $_SESSION["paging"][0]["page"] ?></button></li>
                                        <?php
                                        if (($_SESSION["productCount"] / 30) > 1) {
                                        ?>
                                            <li class="page-item"><button type="submit" name="page1" class="btn btn-outline-light"><?= $_SESSION["paging"][1]["page"] ?></button></li>
                                        <?php
                                        }
                                        if (($_SESSION["productCount"] / 30) > 2) {
                                        ?>
                                            <li class="page-item"><button type="submit" name="page2" class="btn btn-outline-light"><?= $_SESSION["paging"][2]["page"] ?></button></li>
                                        <?php
                                        }
                                        if (($_SESSION["productCount"] / 30) > 3) {
                                        ?>
                                            <li class="page-item"><button type="submit" name="page3" class="btn btn-outline-light"><?= $_SESSION["paging"][3]["page"] ?></button></li>
                                        <?php
                                        }
                                        if (($_SESSION["productCount"] / 30) > 4) {
                                        ?>
                                            <li class="page-item"><button type="submit" name="page4" class="btn btn-outline-light"><?= $_SESSION["paging"][4]["page"] ?></button></li>
                                        <?php
                                        }
                                        ?>
                                        <button type="submit" class="btn btn-outline-light" name="pageSekarangPlus1" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </button>
                                        </li>
                                    </ul>
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