<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=ProductReport_SoccerSportStation.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'functions.php';

$output = "";

$output .= "
		<table border='1'>
			<thead>
				<tr>
					<th>ID Produk</th>
                    <th>Name Produk</th>
                    <th>Brand</th>
                    <th>Kategori</th>
                    <th>Stok Produk</th>
                    <th>Price Produk</th>
                    <th>Image Produk</th>
                    <th>Status Produk</th>
				</tr>
			<tbody>
	";

$data = query("SELECT * FROM produk");
foreach ($data as $key => $value) {
    $idBrand = $value["id_brand"];
    $idKategori = $value["id_kategori"];
    $tempStatus = $value["status_produk"];
    if ($tempStatus == 1) {
        $status = "Active";
    } else if ($tempStatus == 0) {
        $status = "Inactive";
    }

    $brand = query("SELECT * FROM brand WHERE id_brand = '$idBrand'");
    foreach ($brand as $key => $valueBrand) {
        $nameBrand = $valueBrand["name_brand"];
    }

    $kategori = query("SELECT * FROM kategori WHERE id_kategori = '$idKategori'");
    foreach ($kategori as $key => $valueKategori) {
        $nameKategori = $valueKategori["name_kategori"];
    }
    $output .= "
				<tr>
					<td>" . $value["id_produk"] . "</td>
                    <td>" . $value["name_produk"] . "</td>
                    <td>" . $nameBrand . "</td>
                    <td>" . $nameKategori . "</td>
                    <td>" . $value["stok_produk"] . " pcs</td>
                    <td>$ " . number_format($value["price_produk"], 2, ',', '.') . "</td>
                    <td>" . $value["image_produk"] . "</td>
                    <td>" . $status . "</td>
				</tr>
	";
}

$output .= "
			</tbody>
 
		</table>
	";

echo $output;

echo "<script>document.location.href = 'admin.php'</script>";
