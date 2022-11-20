<?php
require("functions.php");

$edit = false;
$delete = false;

if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
    $quantity = $_REQUEST["quantity"];
    $quantity = intval($quantity);
    if ($quantity < 1) {
        $delete = true;
    } else {
        $edit = true;
    }
}

if ($edit) {
    $_SESSION["keranjang"][$id]["quantity_produk"] = $quantity;
}

if ($delete) {
    unset($_SESSION["keranjang"][$id]);
}

$loginValue = $_SESSION["login"];

if (count($_SESSION["keranjang"]) > 0) {
    $ongkosKirim = 5;
} else {
    $ongkosKirim = 0;
}

$subtotalCart = 0;
foreach ($_SESSION["keranjang"] as $i => $key) {
    $image = $key["image_produk"];
    $name = $key["name_produk"];
    $price = $key["price_produk"];
    $quantity = $key["quantity_produk"];
    $totalHarga = $price * $quantity;
    $subtotalCart += $totalHarga;

    echo "<div class='col-8 pb-3'>";
    echo "<div class='card mb-3'>";
    echo "<div class='row'>";
    echo "<div class='col-2 d-flex align-items-center justify-content-center'>";
    echo "<img src ='$image' style='width: 70%;' height: auto;' class='img-fluid rounded-start' alt='...'/>";
    echo "</div>";
    echo "<div class='col-9 text-start d-flex align-items-center'>";
    echo "<div class='card-body shoppingCart'>";
    echo "<h4 class='card-title pb-3'>" . $name . "</h4>";
    echo "<div class='row d-flex align-items-center justify-content-start'>";
    echo "<div id='hargaProdukCart" . $i . "' class='col-2 d-flex align-items-center'>";
    echo "Price : $ " . $price;
    echo "</div>";
    echo "<div class='col-6 text-start d-flex justify-content-center'>";
    echo "<input type='number' onchange='updateCart(" . $i . ")' class='mx-3' style='width: 60px' name='quantity' id='quantity" . $i . "' min='0' value='$quantity'>";
    echo "</div>";
    echo "<div id='totalHargaCart" . $i . "' class='col-4 d-flex align-items-center fw-bold'>";
    echo "Total Price : $ " . $totalHarga;
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<button type='submit' class='col-1 btn d-flex align-items-center justify-content-center bg-dark' name='delete' id='delete" . $i . "' onclick='deleteItemCart(" . $i . ")'><i class='fs-5 fa-solid fa-trash-can text-light'></i></button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

$subtotalCart += $ongkosKirim;

echo "<div class='mt-2 fs-4 d-flex justify-content-end align-items-center mb-4'>";
echo "<span class='me-3'>";
echo "Shipping Fee : $ <span id='ongkosKirim'>" . $ongkosKirim . "</span>";
echo "</span>";
echo "</div>";
echo "<div class='mt-2 fs-4 d-flex justify-content-end align-items-center mb-4'>";
echo "<span class='me-3 fw-bold'>";
echo "Subtotal: $ <span id='subtotalCart'>" . $subtotalCart . "</span>";
echo "</span>";
echo "<form action='' method='post' class='my-auto'>";
echo "<input type='hidden' name='loginValue' id='loginValue' value='$loginValue'>";
echo "<button type='button' name='checkOutBtn' id='checkOutBtn' class='btn btn-outline-dark fs-4' onclick='transaksi()'>Check Out</button>";
echo "</form>";
echo "</div>";

?>
<style>
    img {
        width: fit-content;
    }
</style>