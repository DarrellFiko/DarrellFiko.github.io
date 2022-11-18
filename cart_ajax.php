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
    $ongkosKirim = rand(2, 5);
} else {
    $ongkosKirim = 0;
}

$subtotalCart = 0;
foreach ($_SESSION["keranjang"] as $i => $key) {
    $image = $key["image_produk"];
    $image = base64_decode($image);
    $name = $key["name_produk"];
    $price = $key["price_produk"];
    $quantity = $key["quantity_produk"];
    $totalHarga = $price * $quantity;
    $subtotalCart += $totalHarga;

    echo "<div class='col-10 pb-3'>";
    echo "<div class='card mb-3'>";
    echo "<div class='row'>";
    echo "<div class='col-4'>";
    echo '<img src = "data:assets/jpg;base64,' . base64_encode($image) . '"style="width:200px; height: auto;" class="img-fluid rounded-start my-2" alt="..."/>';
    echo "</div>";
    echo "<div class='col-7 text-start d-flex align-items-center'>";
    echo "<div class='card-body shoppingCart'>";
    echo "<h4 class='card-title pb-3'>" . $name . "</h4>";
    echo "<div class='row d-flex align-items-center'>";
    echo "<div id='hargaProdukCart" . $i . "' class='col-4 d-flex align-items-center'>";
    echo "Price : $ " . $price;
    echo "</div>";
    echo "<div class='col-3 text-start'>";
    echo "<input type='number' onchange='updateCart(" . $i . ")' class='mx-3' style='width: 60px' name='quantity' id='quantity" . $i . "' min='0' value='$quantity'>";
    echo "</div>";
    echo "<div id='totalHargaCart" . $i . "' class='col-12 mt-3 d-flex align-items-center'>";
    echo "Total Price : $ " . $totalHarga;
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class='col-1 d-flex align-items-center'>";
    echo "<button type='submit' class='btn-close d-flex align-items-center' name='delete' aria-label='Close'></button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

$subtotalCart += $ongkosKirim;

echo "<div class='mt-2 fs-4 d-flex justify-content-end align-items-center mb-4'>";
echo "<span class='me-3'>";
echo "Ongkos Kirim: $ <span id='ongkosKirim'>" . $ongkosKirim . "</span>";
echo "</span>";
echo "</div>";
echo "<div class='mt-2 fs-4 d-flex justify-content-end align-items-center mb-4'>";
echo "<span class='me-3'>";
echo "Subtotal: $ <span id='subtotalCart'>" . $subtotalCart . "</span>";
echo "</span>";
echo "<form action='' method='post' class='my-auto'>";
echo "<input type='hidden' name='loginValue' id='loginValue' value='$loginValue'>";
echo "<button type='button' name='checkOutBtn' id='checkOutBtn' class='btn btn-outline-dark fs-4' onclick='transaksi()'>Check Out</button>";
echo "</form>";
echo "</div>";
