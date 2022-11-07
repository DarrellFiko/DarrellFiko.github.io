<?php
    session_start();
    // $host = 'localhost';
    // $user = 'root';
    // $password = '';
    // $database = 't6_6947';
    // $port = '3306';
    // $conn = new mysqli($host, $user, $password, $database);
    // if ($conn->connect_errno) {
    //   die("gagal connect : " . $conn->connect_error);
    // }

    function alert($message) {
        echo "<script>alert('$message');</script>";
    }
?>
