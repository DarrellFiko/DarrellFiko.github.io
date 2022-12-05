<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'toko_soccer');

function alert($message)
{
    echo "<script>alert('$message');</script>";
}

function resetPaging()
{
    $_SESSION["pageSekarang"] = 1;
    $_SESSION["paging"] = [];
    $pageBaru = [
        "page" => 1
    ];
    array_push($_SESSION["paging"], $pageBaru);
    $pageBaru = [
        "page" => 2
    ];
    array_push($_SESSION["paging"], $pageBaru);
    $pageBaru = [
        "page" => 3
    ];
    array_push($_SESSION["paging"], $pageBaru);
    $pageBaru = [
        "page" => 4
    ];
    array_push($_SESSION["paging"], $pageBaru);
    $pageBaru = [
        "page" => 5
    ];
    array_push($_SESSION["paging"], $pageBaru);
}
function resetPagingAdmin()
{
    $_SESSION["pageAdminSekarang"] = 1;
    $_SESSION["pagingAdmin"] = [];
    $pageBaru = [
        "page" => 1
    ];
    array_push($_SESSION["pagingAdmin"], $pageBaru);
    $pageBaru = [
        "page" => 2
    ];
    array_push($_SESSION["pagingAdmin"], $pageBaru);
    $pageBaru = [
        "page" => 3
    ];
    array_push($_SESSION["pagingAdmin"], $pageBaru);
    $pageBaru = [
        "page" => 4
    ];
    array_push($_SESSION["pagingAdmin"], $pageBaru);
    $pageBaru = [
        "page" => 5
    ];
    array_push($_SESSION["pagingAdmin"], $pageBaru);
}
function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);

    // var_dump($result);

    // alert(mysqli_error($conn));

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($rows, $row);
    }

    return $rows;
}

// INSERT

function insert($data, $table)
{
    global $conn;

    // DATA
    $username = $data["username"];
    $name = $data["full_name"];
    $email = $data["email"];
    $alamat = $data["alamat"];
    $telp = $data["nomor_telepon"];
    $password = $data["password"];

    $query = "INSERT INTO $table (username, full_name, email, alamat, nomor_telepon, password, status_user) VALUES ('$username', '$name', '$email', '$alamat', '$telp', '$password', '1')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertBrand($data)
{
    global $conn;

    // DATA
    $id_brand = $data["id_brand"];
    $name_brand = $data["name_brand"];

    $query = "INSERT INTO brand (id_brand, name_brand) VALUES ('$id_brand', '$name_brand')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertKategori($data)
{
    global $conn;

    // DATA
    $id_kategori = $data["id_kategori"];
    $name_kategori = $data["name_kategori"];

    $query = "INSERT INTO kategori (id_kategori, name_kategori) VALUES ('$id_kategori', '$name_kategori')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertProduk($data)
{
    global $conn;

    // DATA
    foreach ($data as $key => $value) {
        $name_produk = $value["name_produk"];
        $id_brand = $value["id_brand"];
        $id_kategori = $value["id_kategori"];
        $stok_produk = $value["stok_produk"];
        $price_produk = $value["price_produk"];
        $image_produk = $value["image_produk"];
        $description_produk = $value["description_produk"];
        $status_produk = $value["status_produk"];

        $query = "INSERT INTO produk (name_produk,id_brand,id_kategori,stok_produk,price_produk,image_produk,description_produk,status_produk) VALUES ('$name_produk', '$id_brand', '$id_kategori', '$stok_produk', '$price_produk', '$image_produk','$description_produk','$status_produk')";

        mysqli_query($conn, $query);
    }

    return mysqli_affected_rows($conn);
}

function insertHtrans($data)
{
    global $conn;

    // DATA
    $nota_jual = $data["nota_jual"];
    $tanggal = $data["tanggal"];
    $id_user = $data["id_user"];
    $subtotal = $data["subtotal"];

    $query = "INSERT INTO htrans (nota_jual,tanggal,id_user,subtotal,status_transaksi) VALUES ('$nota_jual', '$tanggal', '$id_user', '$subtotal','0')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertDtrans($data)
{
    global $conn;

    // DATA
    $nota_jual = $data["nota_jual"];
    $id_produk = $data["id_produk"];
    $quantity = $data["quantity"];

    $query = "INSERT INTO dtrans (nota_jual,id_produk,quantity) VALUES ('$nota_jual', '$id_produk', '$quantity')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertCart($data)
{
    global $conn;

    // DATA
    $id_user = $data["id_user"];
    $id_produk = $data["id_produk"];
    $image_produk = $data["image_produk"];
    $name_produk = $data["name_produk"];
    $price_produk = $data["price_produk"];
    $quantity_produk = $data["quantity_produk"];

    $query = "INSERT INTO cart VALUES ('$id_user','$id_produk','$image_produk','$name_produk','$price_produk','$quantity_produk')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// UPDATE

function update($data)
{
    global $conn;

    // DATA

    $query = "UPDATE  SET () WHERE ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateUser($data)
{
    global $conn;

    $id_user = $data["id_user"];
    $full_name = $data["full_name"];
    $email = $data["email"];
    $nomor_telepon = $data["nomor_telepon"];
    $alamat = $data["alamat"];

    $query = "UPDATE user SET full_name = '$full_name', email = '$email', nomor_telepon = '$nomor_telepon', alamat = '$alamat' WHERE id_user = '$id_user'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateProduk($data)
{
    global $conn;

    // DATA
    $id_produk = $data["id_produk"];
    $name_produk = $data["name_produk"];
    $id_brand = $data["id_brand"];
    $id_kategori = $data["id_kategori"];
    $stok_produk = $data["stok_produk"];
    $price_produk = $data["price_produk"];
    $image_produk = $data["image_produk"];
    $description_produk = $data["description_produk"];
    $status_produk = $data["status_produk"];

    $query = "UPDATE produk SET name_produk = '$name_produk',id_brand = '$id_brand',id_kategori = '$id_kategori',stok_produk = '$stok_produk',price_produk = '$price_produk',image_produk = '$image_produk',description_produk = '$description_produk',status_produk = '$status_produk' WHERE id_produk = '$id_produk'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateStokProduk($data)
{
    global $conn;

    // DATA
    $id_produk = $data["id_produk"];
    $stok_produk = $data["stok_produk"];
    $status_produk = $data["status_produk"];

    $query = "UPDATE produk SET stok_produk = '$stok_produk', status_produk = '$status_produk' WHERE id_produk = '$id_produk'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateStatusHtrans($data)
{
    global $conn;

    // DATA

    $query = "UPDATE htrans SET status_transaksi = '1' WHERE nota_jual = '$data'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// DELETE

function delete($id)
{
    global $conn;

    $query = "DELETE FROM  WHERE = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function deleteProduk($id)
{
    global $conn;

    $query = "DELETE FROM produk WHERE id_produk = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function deleteCart($id)
{
    global $conn;

    $query = "DELETE FROM cart WHERE id_user = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// ALTER TABLE produk AUTO_INCREMENT = 1504
// ALTER TABLE user AUTO_INCREMENT = 1