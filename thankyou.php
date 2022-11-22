<?php
require("functions.php");

$idUser = $_SESSION['idUser'];
$stmt = $conn->query("SELECT * FROM user WHERE id_user='$idUser'");
$user = $stmt->fetch_assoc();

$carts = $_SESSION["keranjang"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThankYou!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="bgGradient min-vh-100">
        <div class="row d-flex justify-content-center py-5">
            <div class="col-12 col-xl-8 glass" style="background-color: white">
                <div class="row d-flex justify-content-center">
                    <div class="col-10 d-flex align-items-center my-3" style="font-size: 20px;">
                        <img src="asset/logo_toko.png" class="me-3" style="width: 50px; height: 50px;" alt=""> Sport Station
                    </div>
                    <div class="col-10 text-center">
                        <h3>Appreciation To You</h3>
                    </div>
                    <div class="col-10 d-flex justify-content-center mt-4">
                        <img src="asset/centang_ijo.png" alt="" style="width: 60px; height: 60px;">
                    </div>
                    <div class="col-7 mt-4 text-center">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsum corporis ab, et necessitatibus deleniti eligendi hic ex!
                    </div>
                    <div class="col-10 mt-4">
                        <hr>
                    </div>
                    <div class="col-10 mt-4">
                        Invoice Number :
                    </div>
                    <div class="col-10 mt-4">
                        Customer Name :
                    </div>
                    <div class="col-10 mt-4">
                        Product :
                    </div>
                    <div class="col-10">
                        <?php
                        $isiKeranjang = query("SELECT * FROM produk where id_produk<3");
                        for ($i = 0; $i < 2; $i++) {
                        ?>
                            <div class="row my-3 d-flex align-items-center">
                                <div class="col-2"><img src="<?= $isiKeranjang[$i]["image_produk"] ?>" style="width: 60%; height: auto;" alt=""></div>
                                <div class="col-4"><?= $isiKeranjang[$i]["name_produk"] ?></div>
                                <div class="col-2 text-center">$<?= $isiKeranjang[$i]["price_produk"] ?></div>
                                <div class="col-2 text-center">Quantity</div>
                                <div class="col-2 text-end">Total</div>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-10 col-md-4 mt-5" style="font-weight: bold; font-size: 18px;">
                        Total Price :
                    </div>
                    <div class="col-10 mt-4">
                        <hr>
                    </div>
                    <div class="col-10 d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-outline-dark py-2 px-3">Close</button>
                    </div>
                    <div class="col-10 mt-2 mb-4 text-center">
                        Thankyou!
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>