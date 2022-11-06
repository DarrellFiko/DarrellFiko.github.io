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
                <a class="navbar-brand mx-2" href="#">
                    <img src="asset/login.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top">
                </a>
            </div>
        </div>
    </div>
    </nav>
    <div style="margin-top:70px">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Categories</span>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

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