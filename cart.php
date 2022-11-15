<?php
    require("functions.php");

    if (!isset($_SESSION["keranjang"])){
        $_SESSION["keranjang"] = []; 
    }

    if (isset($_SESSION["buy"])){
        $_SESSION["tempKeranjang"] = $_SESSION["keranjang"]; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<nav class="bg-dark text-white fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 col-lg-2 d-flex align-items-center">
                    <a class="navbar-brand text-white" href="index.php">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="row mt-5 d-flex justify-content-center bg-dark text-light">
        <?php
        for ($i=0; $i < count($_SESSION["keranjang"]); $i++) { 
            ?>
            <div class="col-4 d-flex justify-content-center">
                <?php
                $image = $_SESSION["keranjang"][$i]["image_produk"];
                $image = base64_decode($image);
                echo '<img src = "data:assets/jpg;base64,' . base64_encode($image) . '"style="width:200px; height: auto;" class="card-img-top border-0 img-size" alt="..."/>';
                ?>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <h5><?=$_SESSION["keranjang"][$i]["name_produk"]?></h5>
            </div>
            <div class="col-2 d-flex justify-content-center">
                <h5><?=$_SESSION["keranjang"][$i]["price_produk"]?></h5>
            </div>
            <div class="col-2 d-flex justify-content-center">
                <h5><?=$_SESSION["keranjang"][$i]["quantity_produk"]?></h5>
            </div>
            <?php
        }
        ?>
        <button name="buy">BUY</button>
    </div>
</body>
</html>