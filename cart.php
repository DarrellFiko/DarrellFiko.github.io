<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for snap popup:
// https://docs.midtrans.com/en/snap/integration-guide?id=integration-steps-overview
namespace Midtrans;

require_once dirname(__FILE__) . '/Midtrans.php';
require("functions.php");

// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-FY5-JgqWOTwkKCWZke7dWNeK';
Config::$clientKey = 'SB-Mid-client-ZbOMHp7KRkClWyAG';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;

// Enable sanitization
Config::$isSanitized = true;

// Enable 3D-Secure
Config::$is3ds = true;

// Uncomment for append and override notification URL
// Config::$appendNotifUrl = "https://example.com";
// Config::$overrideNotifUrl = "https://example.com";

$htrans = query("SELECT * FROM htrans");
$ctr = 0;
foreach ($htrans as $key) {
    $nota = $key["nota_jual"];
    $ctr++;
}

if ($ctr == 0) {
    $nota = "NOTA0000000000000000000000000000000000000000000001";
} else {
    $number = substr($nota, 4);
    $number = intval($number) + 1;
    $nota = "NOTA" . str_pad($number, 46, '0', STR_PAD_LEFT);
}

// // Optional
// $item1_details = array(
//     'id' => 'a1',
//     'price' => 50000,
//     'quantity' => 3,
//     'name' => "Apple"
// );

// // Optional
// $item2_details = array(
//     'id' => 'a2',
//     'price' => 50000,
//     'quantity' => 2,
//     'name' => "Orange"
// );

// Optional
$item_details = [];

$subtotal = 0;
foreach ($_SESSION["keranjang"] as $key) {
    $id = $key["id_produk"];
    $price = doubleval($key["price_produk"]);
    $price = ceil($price * 15606.50);
    $price = intval($price);
    $quantity = intval($key["quantity_produk"]);
    $name = $key["name_produk"];

    $checkOutPrice = $price * $quantity;

    $item_detail = array(
        'id' => $id,
        'price' => $price,
        'quantity' => $quantity,
        'name' => $name
    );

    $subtotal += $price;
    array_push($item_details, $item_detail);
}

// Required
$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => ceil($subtotal), // no decimal allowed for creditcard
);

// Optional
$billing_address = array(
    'first_name'    => "Andri",
    'last_name'     => "Litani",
    'address'       => "Mangga 20",
    'city'          => "Jakarta",
    'postal_code'   => "16602",
    'phone'         => "081122334455",
    'country_code'  => 'IDN'
);

// Optional
$shipping_address = array(
    'first_name'    => "Obet",
    'last_name'     => "Supriadi",
    'address'       => "Manggis 90",
    'city'          => "Jakarta",
    'postal_code'   => "16601",
    'phone'         => "08113366345",
    'country_code'  => 'IDN'
);

// Optional
$customer_details = array(
    'first_name'    => "Andri",
    'last_name'     => "Litani",
    'email'         => "andri@litani.com",
    'phone'         => "081122334455",
    'billing_address'  => $billing_address,
    'shipping_address' => $shipping_address
);

// Optional, remove this to display all available payment methods
// $enable_payments = array('credit_card', 'cimb_clicks', 'mandiri_clickpay');

// Fill transaction details
$transaction = array(
    // 'enabled_payments' => $enable_payments,
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
} catch (\Exception $e) {
    echo $e->getMessage();
}

echo "snapToken = " . $snap_token;

function printExampleWarningMessage()
{
    if (strpos(Config::$serverKey, 'your ') != false) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
        die();
    }
}



if (!isset($_SESSION["keranjang"])) {
    $_SESSION["keranjang"] = [];
}

if (isset($_SESSION["buy"])) {
    $_SESSION["tempKeranjang"] = $_SESSION["keranjang"];
}

$subtotal = 350000;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <nav class="bg-dark text-white fixed-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 col-lg-2 d-flex align-items-center">
                    <a class="navbar-brand text-white" href="index.php">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="row mt-5 d-flex justify-content-center bg-dark text-light">
        <?php
        for ($i = 0; $i < count($_SESSION["keranjang"]); $i++) {
        ?>
            <div class="col-4 d-flex justify-content-center">
                <?php
                $image = $_SESSION["keranjang"][$i]["image_produk"];
                $image = base64_decode($image);
                echo '<img src = "data:assets/jpg;base64,' . base64_encode($image) . '"style="width:200px; height: auto;" class="card-img-top border-0 img-size" alt="..."/>';
                ?>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <h5><?= $_SESSION["keranjang"][$i]["name_produk"] ?></h5>
            </div>
            <div class="col-2 d-flex justify-content-center">
                <h5><?= $_SESSION["keranjang"][$i]["price_produk"] ?></h5>
            </div>
            <div class="col-2 d-flex justify-content-center">
                <h5><?= $_SESSION["keranjang"][$i]["quantity_produk"] ?></h5>
            </div>
        <?php
        }
        ?>
        <input type="hidden" name="amount" value="100000" />
        <input type="submit" id="btnPay" name="btnPay" value="Pay"></input>
    </div>
</body>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey; ?>"></script>
<script>
    document.getElementById('btnPay').onclick = function() {
        // SnapToken acquired from previous step
        snap.pay('<?php echo $snap_token ?>', {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    };
</script>

</html>