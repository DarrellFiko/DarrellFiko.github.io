<?php
    require("functions.php");

    $idUser = $_SESSION['idUser'];
    $stmt = $conn->query("SELECT * FROM user WHERE id_user='$idUser'");
    $user = $stmt->fetch_assoc();
    
    $carts = $_SESSION["keranjang"];
    
    // insert to database
    $nota_jual = $_SESSION["nomorNota"];
    $tanggal = date('Y-m-d');
    $subtotal = 0;
    foreach ($_SESSION["keranjang"] as $i => $key) {
        $price = $key["price_produk"];
        $quantity = $key["quantity_produk"];
        $totalHarga = $price * $quantity;
        $subtotal += $totalHarga;
    }
    
    $data = [
        "nota_jual" => $nota_jual,
        "tanggal" => $tanggal,
        "id_user" => $idUser,
        "subtotal" => $subtotal
    ];

?>

<html>
    <head></head>
    <body>
    <div style="background-color: rgb(255, 255, 255);
            width: 100%;
            /* margin-left: 2vw; */
            height: auto;
            border-radius: 1vw;
            box-shadow: inset 0 -3em 3em rgba(125, 125, 125, 0.1), 0 0 0 2px rgb(221, 221, 221), 0.3em 0.3em 1em rgba(128, 128, 128, 0.3);
            margin-top: 0.5vw;    
            display: flex;
            ">
            <div class="isinya" style="width: 100%;margin-top: 1.5vw">
                <div class="" style="flex: 100%; padding: 2vw;">
                    <div class="" style="display: flex;">
                        <div class="kiri" style="flex: 50%;justify-content: start; text-align: start; margin-left: 0.5vw;">
                            <img src=\'cid:logo_p2t\' style="width: 8vw;height: 8vw;" alt="" srcset="">
                        </div>
                        <div class="kanan" style="flex: 50%; text-align: end; justify-content: end; margin-right: 1vw;">
                            <span style="font-size: 2.5vw;">Soccer Champ</span><br>
                            <span style="font-size: 1.3vw;color:#495057;">soccerchamp.com</span><br>
                            <span style="font-size: 1.3vw;color:#495057;">(888) 8888888</span><br>
                            <span style="font-size: 1.3vw;color:#495057;">soccerchampstore@gmail.com</span><br>
                        </div>
                    </div>
                    <hr>
                    <div class="" style="display: flex;">
                        <div class="kiri" style="flex: 50%;justify-content: start; text-align: start; margin-top: 2vw; margin-left: 1vw;">
                            <span style="font-size: 1.2vw;color:#495057;">INVOICE TO : </span><br>
                            <span style="font-size: 2vw;color:black;">nama</span><br>
                            <span style="font-size: 1.2vw;color:#495057;">kota</span><br>
                            <span style="font-size: 1.2vw;color:#495057;">email</span><br>
                        </div>
                        <div class="kanan" style="flex: 50%; text-align: end; justify-content: end; margin-right: 1vw; margin-top: 2vw;">
                            <span style="font-size: 1.2vw;color:#495057; font-weight: bold;">INVOICE</span><br>
                            <span style="font-size: 1.2vw;color:#495057; font-weight: bold;">nota</span><br>
                            <span style="font-size: 1.2vw;color:#495057;">Date of Invoice : </span><br>
                        </div>
                    </div>
                    <div class="" style="display: flex; margin-top: 1.5vw;margin-bottom: 1.5vw; margin-left: 1vw;">
                        <div class="" style="width: 100%">
                            <table style="width: 100%">
                                <tr style="font-size: 1.5vw;">
                                    <th style="text-align: start;">No</th>
                                    <th style="text-align: start;">Product</th>
                                    <th style="text-align: start;">Price</th>
                                    <th style="text-align: start;">Quantity</th>
                                    <th style="text-align: start;">Total</th>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="" style="display: flex;">
                        <div class="kiri" style="flex: 40%;justify-content: start; text-align: start; margin-top: 2vw; margin-left: 1vw;">
                            
                        </div>
                        <div class="kanan" style="flex: 60%; text-align: end; justify-content: end; margin-right: 1vw; margin-top: 2vw;">
                            <div class="" style="display: flex; ">
                                <div class="" style="flex: 30%">
                                    <span style="font-size: 1.5vw;">Shipping Fee </span><br>
                                </div>
                                <div class="" style="flex: 70%">
                                    <span style="font-size: 1.5vw;">$5</span><br>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="" style="display: flex;">
                        <div class="kiri" style="flex: 40%;justify-content: start; text-align: start; margin-left: 1vw;">
                            
                        </div>
                        <div class="kanan" style="flex: 60%; text-align: end; justify-content: end; margin-right: 1vw; margin-top: 2vw;">
                            <div class="" style="display: flex; ">
                                <div class="" style="flex: 35%">
                                    <span style="font-size: 1.7vw;">Subtotal</span><br>
                                </div>
                                <div class="" style="flex: 65%">
                                    <span style="font-size: 1.7vw;">$ 0</span><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="" style="display: flex; justify-content: start; margin-top: 1vw; margin-left: 1vw; margin-bottom: 6vw;">
                        <span style="font-size: 2vw;">Appreciation To You!</span><br>
                    </div>
                    <div class="" style="display: flex; justify-content: start; margin-top: 1vw; margin-bottom: 6vw;">
                        <div class="" style="flex: 100%; justify-content: center; text-align:center;">
                            <hr>
                            <span style="font-size: 1vw; color: #495057;">Invoice was created on a computer and is valid without the signature and seal.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
