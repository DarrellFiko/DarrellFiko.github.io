<?php
// session_start();

$conn = mysqli_connect('localhost', 'root', '', 'toko_soccer');

// function alert($message)
// {
//     echo "<script>alert('$message');</script>";
// }

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

function insert($data)
{
    global $conn;

    // DATA

    $query = "INSERT INTO  VALUES ()";

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
