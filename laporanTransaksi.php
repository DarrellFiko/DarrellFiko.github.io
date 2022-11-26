<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=TransactionReport_SoccerSportStation.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'functions.php';

$output = "";

$output .= "
		<table border='1'>
			<thead>
				<tr>
					<th>Nota</th>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Produk</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
				</tr>
			<tbody>
	";

$htrans = query("SELECT * FROM htrans");

foreach ($htrans as $key => $valueHtrans) {
    $nota = $valueHtrans["nota_jual"];
    $tempTanggal = $valueHtrans["tanggal"];
    $time = strtotime($tempTanggal);
    $tanggal = date('d-m-Y', $time);
    $idUser = $valueHtrans["id_user"];
    $subtotal = $valueHtrans["subtotal"];

    $user = query("SELECT * FROM user WHERE id_user = '$idUser'");
    foreach ($user as $key => $valueUser) {
        $nameUser = $valueUser["full_name"];
    }

    $dtrans = query("SELECT * FROM dtrans WHERE nota_jual = '$nota'");

    foreach ($dtrans as $key => $valueDtrans) {
        $idProduk = $valueDtrans["id_produk"];
        $quantity = $valueDtrans["quantity"];

        $produk = query("SELECT * FROM produk WHERE id_produk = '$idProduk'");
        foreach ($produk as $key => $valueProduk) {
            $nameProduk = $valueProduk["name_produk"];
            $priceProduk = $valueProduk["price_produk"];
        }

        $total = $quantity * $priceProduk;
        $total = ceil($total);

        $output .= "
                    <tr>
                        <td>" . $nota . "</td>
                        <td>" . $tanggal . "</td>
                        <td>" . $nameUser . "</td>
                        <td>" . $nameProduk . "</td>
                        <td>" . $quantity . " pcs</td>
                        <td>$ " . $total . "</td>
                    </tr>
        ";
    }

    $output .= "
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Subtotal</td>
                        <td>$ " . $subtotal . "</td>
                    </tr>
        ";
}

$output .= "
			</tbody>
 
		</table>
	";

echo $output;

echo "<script>document.location.href = 'admin.php'</script>";
