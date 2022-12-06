<?php
    require("../../functions.php");

    // $idUser = $_SESSION['idUser'];
    $idUser = $_SESSION['idUser'];
    $notaJual = $_SESSION["nomorNota"];
    $stmt = $conn->query("SELECT * FROM user WHERE id_user='$idUser'");
    $user = $stmt->fetch_assoc();

    $carts = $_SESSION["keranjang"];

    $htrans = query("SELECT * FROM htrans WHERE nota_jual = '$notaJual'");
    foreach ($htrans as $key => $value) {
        $tempTanggal = $value["tanggal"];
        $time = strtotime($tempTanggal);
        $tanggal = date('d/m/Y', $time);
        $subtotal = $value["subtotal"] + 5;
    }

    $dtrans = query("SELECT * FROM dtrans WHERE nota_jual = '$notaJual'");
    
    require("OAuthTokenProvider.php");
    require("Exception.php");
    // require("get_oauth_token.php");
    require("OAuth.php");
    require("PHPMailer.php");
    require("POP3.php");
    require("SMTP.php");

    // Namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $nama = "soccerchampstore@gmail.com";
    $email = "darrellfikoalexander@gmail.com";
    // Create Object
    $mail = new PHPMailer();
    $mail -> isSMTP();
    $mail -> Host = 'smtp.gmail.com';
    $mail -> Port = 587;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    ); 
    
    $mail -> SMTPSecure =PHPMailer::ENCRYPTION_STARTTLS;
    $mail -> SMTPSecure = 'tls';
    $mail -> SMTPAuth = true;
    $mail -> Username = 'soccersportstation@gmail.com';
    $mail -> Password = 'vgdokaiunloxjlaf';
    $mail->isHTML(true);
    // Set Recipent
    $mail -> SetFrom($email, $nama);
    $mail -> addAddress('soccerchampstore@gmail.com','Store');
    $mail->Subject = "Invoice";
    $mail->addEmbeddedImage('../../asset/logo_toko.png', 'logo');
    $tes ="";
$tes.= '<html>

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
                    <div class="" style="width: 100%; padding: 2vw;">
                        <div class="" style="display: flex;">
                            <div class="kiri" style="width: 45%;justify-content: start; text-align: start; margin-left: 0.5vw;">
                                <img src=\'cid:logo\' style="width: 8vw;height: 8vw;" alt="" srcset="">
                            </div>
                            <div class="kanan" style="width: 45%; text-align: end; justify-content: end; margin-right: 1vw;">
                                <span style="font-size: 2.5vw;">Soccer Champ</span><br>
                                <span style="font-size: 1.3vw;color:#495057;">soccerchamp.com</span><br>
                                <span style="font-size: 1.3vw;color:#495057;">(888) 8888888</span><br>
                                <span style="font-size: 1.3vw;color:#495057;">soccerchampstore@gmail.com</span><br>
                            </div>
                        </div>
                        <hr>
                        <div class="" style="display: flex;">
                            <div class="kiri" style="width: 45%;justify-content: start; text-align: start; margin-top: 2vw; margin-left: 1vw;">
                                <span style="font-size: 1.2vw;color:#495057;">INVOICE TO : </span><br>
                                <span style="font-size: 2vw;color:black;">'.$user["full_name"].'</span><br>
                                <span style="font-size: 1.2vw;color:#495057;">'.$user["alamat"].'</span><br>
                                <span style="font-size: 1.2vw;color:#495057;">'.$user["email"] .'</span><br>
                            </div>
                            <div class="kanan" style="width: 45%; text-align: end; justify-content: end; margin-right: 1vw; margin-top: 2vw;">
                                <span style="font-size: 1.2vw;color:#495057; font-weight: bold;">INVOICE</span><br>
                                <span style="font-size: 1.2vw;color:#495057; font-weight: bold;">'.$notaJual.'</span><br>
                                <span style="font-size: 1.2vw;color:#495057;">Date of Invoice : '.$tanggal.'</span><br>
                            </div>
                        </div>
                        <div class="" style="display: flex; margin-top: 1.5vw;margin-bottom: 1.5vw; margin-left: 1vw;">
                            <div class="" style="width: 90%">
                                <table style="width: 100%">
                                    <tr style="font-size: 1.5vw;">
                                        <th style="text-align: start;">No</th>
                                        <th style="text-align: start;">Product</th>
                                        <th style="text-align: start;">Price</th>
                                        <th style="text-align: start;">Quantity</th>
                                        <th style="text-align: start;">Total</th>
                                    </tr>';
                                    $subtotal = 0;
                                    $no = 0;
                                    foreach ($dtrans as $i => $valueDtrans) {
                                        if ($valueDtrans["quantity"] > 0) {
                                            $no += 1;
                                        }
                                        $idProduk = $valueDtrans["id_produk"];
                                        $tempQuery = "SELECT * FROM produk WHERE id_produk = $idProduk";
                                        $produk = query($tempQuery);
                                        foreach ($produk as $key => $value) {
                                            $name = $value["name_produk"];
                                            $price = $value["price_produk"];
                                        }
                                        $quantity = $valueDtrans["quantity"];
                                        $totalHarga = $price * $quantity;
                                        $subtotal += $totalHarga;
                                        $tes .='
                                        <tr>
                                            <td class="no">'.$no.'</td>
                                            <td class="text-left">'.$name.'</td>
                                            <td class="unit">$ '. $price.'</td>
                                            <td class="qty">'.$quantity.'</td>
                                            <td class="total">$ '.$totalHarga.'</td>
                                        </tr>';
                                    }
                                    $tes.='
                                </table>
                            </div>
                        </div>
                        <div class="" style="display: flex;">
                            <div class="kiri" style="width: 40%;justify-content: start; text-align: start; margin-top: 2vw; margin-left: 1vw;">

                            </div>
                            <div class="kanan" style="width: 50%; text-align: end; justify-content: end; margin-right: 1vw; margin-top: 2vw;">
                                <div class="" style="display: flex; ">
                                    <div class="" style="width: 30%">
                                        <span style="font-size: 1.5vw;">Shipping Fee </span><br>
                                    </div>
                                    <div class="" style="width: 70%">
                                        <span style="font-size: 1.5vw;">$5</span><br>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="" style="display: flex;">
                            <div class="kiri" style="width: 30%;justify-content: start; text-align: start; margin-left: 1vw;">

                            </div>
                            <div class="kanan" style="width: 60%; text-align: end; justify-content: end; margin-right: 1vw; margin-top: 2vw;">
                                <div class="" style="display: flex; ">
                                    <div class="" style="width: 35%">
                                        <span style="font-size: 1.7vw;">Subtotal</span><br>
                                    </div>
                                    <div class="" style="width: 65%">
                                        <span style="font-size: 1.7vw;">$ '.$subtotal.'</span><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="" style="display: flex; justify-content: start; margin-top: 1vw; margin-left: 1vw; margin-bottom: 6vw;">
                            <span style="font-size: 2vw;">Appreciation To You!</span><br>
                        </div>
                        <div class="" style="display: flex; justify-content: start; margin-top: 1vw; margin-bottom: 6vw;">
                            <div class="" style="width: 80%; justify-content: center; text-align:center;">
                                <hr>
                                <span style="font-size: 1vw; color: #495057;">Invoice was created on a computer and is valid without the signature and seal.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>

        </html>';

    $mail -> Subject = 'Spam';
    $mail->Body = $tes;
    $mail->send();

    // $mail -> WordWrap = 50;

    // if ($mail -> send()) {
    //     echo "Email Terkirim!";
    // } else {
    //     echo "Email Tidak Terkirim!";
    // }
    deleteCart($idUser);
    $_SESSION["keranjang"] = [];
    echo "<script>document.location.href = '../../index.php'</script>";
