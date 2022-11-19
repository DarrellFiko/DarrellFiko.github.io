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

    $query = "INSERT INTO $table (username, full_name, email, alamat, nomor_telepon, password) VALUES ('$username', '$name', '$email', '$alamat', '$telp', '$password')";
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
// UPDATE

function update($data)
{
    global $conn;

    // DATA

    $query = "UPDATE  SET () WHERE ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// DELETE

function delete($id)
{
    global $conn;

    $query = "DELETE FROM  WHERE = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
