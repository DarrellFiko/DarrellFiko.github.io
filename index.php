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
    if(!isset($_SESSION["paging"])){
        $_SESSION["pageSekarang"] = 1;
        $_SESSION["paging"] = [];
        $pageBaru = [
            "page" => 1
        ];
        array_push($_SESSION["paging"],$pageBaru);
        $pageBaru = [
            "page" => 2
        ];
        array_push($_SESSION["paging"],$pageBaru);
        $pageBaru = [
            "page" => 3
        ];
        array_push($_SESSION["paging"],$pageBaru);
        $pageBaru = [
            "page" => 4
        ];
        array_push($_SESSION["paging"],$pageBaru);
        $pageBaru = [
            "page" => 5
        ];
        array_push($_SESSION["paging"],$pageBaru);
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
    if(isset($_POST["Jersey"])){
        $_SESSION["categories"] = "Jersey";
    }
    if(isset($_POST["Gloves"])){
        $_SESSION["categories"] = "Gloves";
    }
    if(isset($_POST["Guards"])){
        $_SESSION["categories"] = "Guards";
    }

    //SEARCH
    if(isset($_POST["search"])){
        $_SESSION["input"] = $_POST["input"];
    }

    
    //PAGING
    $maks = 1000000;
    if(isset($_POST["page0"])){
        $_SESSION["pageSekarang"] = $_SESSION["paging"][0]["page"];
        if($_SESSION["paging"][0]["page"]>2){
            $_SESSION["paging"][0]["page"]-=2;
            $_SESSION["paging"][1]["page"]-=2;
            $_SESSION["paging"][2]["page"]-=2;
            $_SESSION["paging"][3]["page"]-=2;
            $_SESSION["paging"][4]["page"]-=2;
        }
        alert($_SESSION["pageSekarang"]);
    }
    if(isset($_POST["page1"])){
        $_SESSION["pageSekarang"] = $_SESSION["paging"][1]["page"];
        if($_SESSION["paging"][0]["page"]>1){
            $_SESSION["paging"][0]["page"]--;
            $_SESSION["paging"][1]["page"]--;
            $_SESSION["paging"][2]["page"]--;
            $_SESSION["paging"][3]["page"]--;
            $_SESSION["paging"][4]["page"]--;
        }
        alert($_SESSION["pageSekarang"]);
    }
    if(isset($_POST["page2"])){
        $_SESSION["pageSekarang"] = $_SESSION["paging"][2]["page"];
        alert($_SESSION["pageSekarang"]);
    }
    if(isset($_POST["page3"])){
        $_SESSION["pageSekarang"] = $_SESSION["paging"][3]["page"];
        if($_SESSION["paging"][4]["page"]<$maks){
            $_SESSION["paging"][0]["page"]++;
            $_SESSION["paging"][1]["page"]++;
            $_SESSION["paging"][2]["page"]++;
            $_SESSION["paging"][3]["page"]++;
            $_SESSION["paging"][4]["page"]++;
        }
        alert($_SESSION["pageSekarang"]);
    }
    if(isset($_POST["page4"])){
        $_SESSION["pageSekarang"] = $_SESSION["paging"][4]["page"];
        if($_SESSION["paging"][4]["page"]<$maks+1){
            $_SESSION["paging"][0]["page"]+=2;
            $_SESSION["paging"][1]["page"]+=2;
            $_SESSION["paging"][2]["page"]+=2;
            $_SESSION["paging"][3]["page"]+=2;
            $_SESSION["paging"][4]["page"]+=2;
        }
        alert($_SESSION["pageSekarang"]);
    }
    if(isset($_POST["pageSekarangMin1"])){
        if($_SESSION["paging"][0]["page"]>1 && $_SESSION["pageSekarang"]!=1){
            $_SESSION["pageSekarang"]--;
            $_SESSION["paging"][0]["page"]--;
            $_SESSION["paging"][1]["page"]--;
            $_SESSION["paging"][2]["page"]--;
            $_SESSION["paging"][3]["page"]--;
            $_SESSION["paging"][4]["page"]--;
        }
        alert($_SESSION["pageSekarang"]);
    }
    if(isset($_POST["pageSekarangPlus1"])){
        if($_SESSION["paging"][0]["page"]<$maks && $_SESSION["pageSekarang"]!=$maks){
            $_SESSION["pageSekarang"]++;
            $_SESSION["paging"][0]["page"]++;
            $_SESSION["paging"][1]["page"]++;
            $_SESSION["paging"][2]["page"]++;
            $_SESSION["paging"][3]["page"]++;
            $_SESSION["paging"][4]["page"]++;
        }
        alert($_SESSION["pageSekarang"]);
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
                    <li><button type="submit" name="Jersey" onclick="closeNav()" class="btn btn-link">Jersey</button></li>
                    <li><button type="submit" name="Gloves" onclick="closeNav()" class="btn btn-link">Gloves</button></li>
                    <li><button type="submit" name="Guards" onclick="closeNav()" class="btn btn-link">Shin Guards</button></li>
                </ul>
            </div>
        </form>
    </div>


    <!-- CARD -->
    <div class="container text-center mt-4">
        <div class="row d-flex justify-content-center">
            <!-- carousel -->
            <div class="col-1"></div>
            <div class="col-10">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="asset/temp.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="asset/temp.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="asset/temp.jpg" class="d-block w-100" alt="...">
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
            <?php
            for ($i = 0; $i < 30; $i++) {
            ?>
                <div class="col-5 col-md-4 col-lg-3 mx-3 my-3 d-flex justify-content-center">
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
        
        <!-- PAGING -->
        <div class="row">
            <form action="" method="post">
            <div class="col-12 d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item">
                <button type="submit" class="btn btn-outline-dark" name="pageSekarangMin1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </button>
                </li>
                <li class="page-item"><button type="submit" name="page0" class="btn btn-outline-dark"><?=$_SESSION["paging"][0]["page"]?></button></li>
                <li class="page-item"><button type="submit" name="page1" class="btn btn-outline-dark"><?=$_SESSION["paging"][1]["page"]?></button></li>
                <li class="page-item"><button type="submit" name="page2" class="btn btn-outline-dark"><?=$_SESSION["paging"][2]["page"]?></button></li>
                <li class="page-item"><button type="submit" name="page3" class="btn btn-outline-dark"><?=$_SESSION["paging"][3]["page"]?></button></li>
                <li class="page-item"><button type="submit" name="page4" class="btn btn-outline-dark"><?=$_SESSION["paging"][4]["page"]?></button></li>
                <button type="submit" class="btn btn-outline-dark" name="pageSekarangPlus1" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </button>
                </li>
            </ul>
            </div>
            </form>
        </div>
    </div>

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