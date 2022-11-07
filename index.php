<?php

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
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
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
        <div class="scrollKiri d-flex align-items-center justify-content-center">
            <button class="buttonCategories d-flex align-items-center justify-content-center text-white ps-2" onclick="openNav()"><h2><img src="asset/arrow_kanan.png" alt="" width="30" height="30"></h2></button>
        </div>

        <!-- kategori -->
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <h2 class="text-white">
                Brand
            </h2>
            <a href="#" onclick="closeNav()">Nike</a>
            <a href="#" onclick="closeNav()">Adidas</a>
            <a href="#" class="mb-5" onclick="closeNav()">Puma</a>

            <h2 class="text-white">
                Categories
            </h2>
            <a href="#" onclick="closeNav()">Shoes</a>
            <a href="#" onclick="closeNav()">Balls</a>
            <a href="#" onclick="closeNav()">Bags</a>
            <a href="#" onclick="closeNav()">Gloves</a>
        </div>
    </div>

    <!-- carousel
    <div class="container mx-5 mx-5 d-flex justify-content-center">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
        <img src="asset/test_background.jpg" class="d-block w-300" alt="...">
        </div>
        <div class="carousel-item">
        <img src="..." class="d-block w-300" alt="...">
        </div>
        <div class="carousel-item">
        <img src="..." class="d-block w-300" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev bg-warning" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next bg-warning" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    </div>
    </div> -->

    <!-- CARD -->
    <div class="text-center">
        <div class="row">
            <div class="col-2 bg-info"></div>
            <div class="col-9 bg-danger">
                <div class="row d-flex justify-content-end"></div>
                <?php
                for ($i=0; $i < 30; $i++) { 
                    ?>
                    <div class="col-5 col-md-4 col-xl-3">
                        <div class="card" style="width: 15rem;">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div></div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
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
        }
    </script>
  </body>
</html>