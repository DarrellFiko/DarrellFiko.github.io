<?php
require("functions.php");

$key = $_GET["search"];

if ($key == "") {
    // Semua
    $products = query("SELECT * FROM produk");
} else {
    // Filter
    $products = query("SELECT * FROM produk WHERE name_produk LIKE '%" . $key . "%'");
}

echo "<tr>";
echo "<!-- <th>Image Produk</th> -->";
echo "<th scope='col'>ID Produk</th>";
echo "<th scope='col'>Name Produk</th>";
echo "<th scope='col'>Brand Produk</th>";
echo "<th scope='col'>Category Produk</th>";
echo "<th scope='col'>Stok Produk</th>";
echo "<th scope='col'>Price Produk</th>";
echo "<th scope='col'>Action</th>";
echo "<!-- <th>Deskription Produk</th> -->";
echo "</tr>";
$temp = 0;
foreach ($products as $product) {
    $id = $product["id_produk"];
    $name = $product["name_produk"];
    $id_brand = $product["id_brand"];
    $id_category = $product["id_kategori"];
    $stok = $product["stok_produk"];
    $price = $product["price_produk"];
    $description = $product["description_produk"];
    $image = $product["image_produk"];
    $temp++;
    if (($temp / 30) > $_SESSION["pageAdminSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageAdminSekarang"]) {
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='idData' value='$id'>";
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$name</td>";
        $stmt = $conn->query("SELECT * FROM brand WHERE id_brand='$id_brand'");
        $brand = $stmt->fetch_assoc();
        echo '<td>' . $brand["name_brand"] . '</td>';
        $stmt = $conn->query("SELECT * FROM kategori WHERE id_kategori='$id_category'");
        $kategori = $stmt->fetch_assoc();
        echo '<td>'.$kategori["name_kategori"].'</td>';
        echo "<td>$stok</td>";
        echo "<td>$ $price</td>";
        echo "<td><button type='submit' class='btn btn-outline-warning ms-3' name='edit'>Edit</button><button type='submit' class='btn btn-outline-danger mx-3' name='delete'>Delete</button></td>";
        echo "<!-- <td>$description</td> -->";
        echo "</tr>";
        echo "</form>";
    }
}
