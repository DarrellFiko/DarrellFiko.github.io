<?php
    require_once("connection.php");
    if(!isset($_SESSION["brand"])){
        $_SESSION["brand"] = "";
    }
    if(!isset($_SESSION["categories"])){
        $_SESSION["categories"] = "";
    }
    if(!isset($_SESSION["input"])){
        $_SESSION["input"] = "";
    }

    // AMBIL MERK ATAU BRAND
    if(isset($_POST["allBrands"])){
        $_SESSION["brand"] = "";
    }
    if(isset($_POST["Nike"])){
        $_SESSION["brand"] = "Nike";
        //echo "<script>alert('$brand')</script>";
    }
    if(isset($_POST["Adidas"])){
        $_SESSION["brand"] = "Adidas";
    }
    if(isset($_POST["Puma"])){
        $_SESSION["brand"] = "Puma";
    }

    // AMBIL KATEGORI
    if(isset($_POST["allCategories"])){
        $_SESSION["categories"] = "";
    }
    if(isset($_POST["Shoes"])){
        $_SESSION["categories"] = "Shoes";
    }
    if(isset($_POST["Balls"])){
        $_SESSION["categories"] = "Balls";
    }
    if(isset($_POST["Bags"])){
        $_SESSION["categories"] = "Bags";
    }
    if(isset($_POST["Gloves"])){
        $_SESSION["categories"] = "Gloves";
    }

    if(isset($_POST["search"])){
        $_SESSION["input"] = $_POST["input"];
        // alert($_SESSION["input"]);
        // alert($_SESSION["brand"]);
        // alert($_SESSION["categories"]);
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

<body>
    <!-- NAVBAR -->
    <nav class="bg-dark text-white fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 col-lg-2 d-flex align-items-center">
                    <a class="navbar-brand" href="#">
                        <img src="asset/logo_toko.png" alt="Logo" width="50" height="50" class="d-inline-block">
                    </a>
                    <div class="navbar-brand d-lg-inline d-none fs-5">
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
                    <input type="hidden" name="sent" value="<?=$_SESSION["brand"]?>">
                    <li><button type="submit" name="allBrands" onclick="closeNav()" class="btn btn-link">All</button></li>
                    <li><button type="submit" onclick="closeNav()" class="btn btn-link" name="Nike">Nike</button></li>
                    <li><button type="submit" name="Adidas" onclick="closeNav()" class="btn btn-link">Adidas</button></li>
                    <li><button type="submit" name="Puma" onclick="closeNav()" class="btn btn-link">Puma</button></li>
                </ul>

                <h2 class="text-white">
                    Categories
                </h2>
                <ul class="text-light">
                    <input type="hidden" name="sent" value="<?=$_SESSION["categories"]?>">
                    <li><button type="submit" name="allCategories" onclick="closeNav()" class="btn btn-link">All</button></li>
                    <li><button type="submit" name="Shoes" onclick="closeNav()" class="btn btn-link">Shoes</button></li>
                    <li><button type="submit" name="Balls" onclick="closeNav()" class="btn btn-link">Balls</button></li>
                    <li><button type="submit" name="Bags" onclick="closeNav()" class="btn btn-link">Bags</button></li>
                    <li><button type="submit" name="Gloves" onclick="closeNav()" class="btn btn-link">Gloves</button></li>
                </ul>
            </div>
        </form>
    </div>

    <!-- CARD -->
    <div class="container text-center bg-warning">
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <!-- carousel -->

            </div>
            <?php
            for ($i = 0; $i < 30; $i++) {
            ?>
                <div class="col-5 col-md-4 col-lg-3 mx-3 my-3">
                    <div class="img-fluid">
                    <div class="card" style="width: 15rem;">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <!-- script buat open scroll yang dikiri -->
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "200px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            $(document).ready(function () {
                createCookie("kategori", "Shoes");
            });
        }

        function createCookie(name, value) {
            document.cookie = escape(name) + "=" + escape(value)+"; path=/";
        }
    </script>
    
</body>

</html>