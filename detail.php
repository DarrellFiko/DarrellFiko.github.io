<?php
    require("functions.php");

    $id = $_REQUEST["id"];
	$produkDetail = query("SELECT * FROM produk WHERE id_produk = '$id'");

    print_r($produkDetail);
?>