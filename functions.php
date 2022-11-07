<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 't6_6958');

function alert($message)
{
    echo "<script>alert('$message');</script>";
}

function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($rows, $row);
    }

    return $rows;
}

// INSERT

function insert($data)
{
    global $conn;

    // DATA

    $query = "INSERT INTO  VALUES ()";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertUser($data)
{
    global $conn;

    $username = $data["username"];
    $name = $data["nama"];
    $email = $data["email"];
    $password = $data["password"];

    $query = "INSERT INTO users(username,nama,email,password) VALUES ('$username','$name','$email','$password')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertRoom($data)
{
    global $conn;

    $nomorRuangan = $data["nomor_ruangan"];
    $namaRuangan = $data["nama_ruangan"];
    $console = $data["console"];

    $query = "INSERT INTO room VALUES ('$nomorRuangan','$namaRuangan','$console')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function insertRent($data)
{
    global $conn;

    $idRent = $data["id_rent"];
    $nomorRuangan = $data["nomor_ruangan"];
    $jumlah = $data["jumlah_customer"];

    $query = "INSERT INTO rents VALUES ('$idRent','$nomorRuangan','$jumlah')";

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

    $username = $data["username"];
    $nama = $data["nama"];
    $email = $data["email"];
    $password = $data["password"];
    $idRent = $data["id_rents"];

    if ($idRent == "") {
        $query = "UPDATE users SET username = '$username', nama = '$nama', email = '$email', password = '$password' WHERE username = '$username'";
    } else {
        $query = "UPDATE users SET username = '$username', nama = '$nama', email = '$email', password = '$password', id_rents = '$idRent' WHERE username = '$username'";
    }

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateRent($data)
{
    global $conn;

    $idRent = $data["id_rent"];
    $nomorRuangan = $data["nomor_ruangan"];
    $jumlah = $data["jumlah_customer"];

    $query = "UPDATE rents SET id_rent = '$idRent', nomor_ruangan = '$nomorRuangan', jumlah_customer = '$jumlah' WHERE id_rent = '$idRent' ";

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

function deleteUser($id)
{
    global $conn;

    $query = "DELETE FROM users WHERE username = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function deleteRent($id)
{
    global $conn;

    $query = "DELETE FROM rents WHERE id_rent = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function deleteRoom($id)
{
    global $conn;

    $query = "DELETE FROM room WHERE nomor_ruangan = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
