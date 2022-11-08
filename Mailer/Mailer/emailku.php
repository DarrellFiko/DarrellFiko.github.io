<?php
    require_once("../../connection.php");
    
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
    
    // Set Recipent
    $mail -> SetFrom($_SESSION["email"], $_SESSION["name"]);
    $mail -> addAddress('soccersportstation@gmail.com','Store');
    

    $mail -> Subject = 'Spam';
    $mail -> Body = $_SESSION["message"];
    $mail -> WordWrap = 50;

    if ($mail -> send()) {
        echo "Email Terkirim!";
    } else {
        echo "Email Tidak Terkirim!";
    }
    header("Location: ../../index.php");
?>