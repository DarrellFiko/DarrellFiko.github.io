<?php
require("functions.php");

if (isset($_SESSION["authAdmin"])) {
    if ($_SESSION["authAdmin"] == false) {
        header("Location: loginAdmin.php");
    }
}else{
    header("Location: loginAdmin.php");
}

if (isset($_POST["logout"])) {
    $_SESSION["data"] = "produk";
    $_SESSION["jumlahInput"] = 1;
    resetPagingAdmin();

    $_SESSION["listProduk"] = query("SELECT * FROM produk WHERE status_produk = '1'");
    $_SESSION["productCount"] = count($_SESSION["listProduk"]);

    $_SESSION["authAdmin"] = false;
    header("Location: index.php");
}

if (!isset($_SESSION["data"])) {
    $_SESSION["data"] = "produk";
}
if (!isset($_SESSION["jumlahInput"])) {
    $_SESSION["jumlahInput"] = 1;
}

if (!isset($_SESSION["dataAdmin"])) {
    $_SESSION["dataAdmin"] = [];
    if ($_SESSION["data"] == "produk") {
        $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
    } else if ($_SESSION["data"] == "htrans") {
        $_SESSION["dataAdmin"] = query("SELECT * FROM htrans");
    } else {
        $_SESSION["dataAdmin"] = query("SELECT * FROM dtrans");
    }
}

if (!isset($_SESSION["pagingAdmin"])) {
    resetPagingAdmin();
}

if (isset($_POST["choose"])) {
    $data = $_POST["pilihData"];
    if ($data == "produk") {
        $_SESSION["data"] = "produk";
        $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
    } else if ($data == "htrans") {
        $_SESSION["data"] = "htrans";
        $_SESSION["dataAdmin"] = query("SELECT * FROM htrans");
    } else if ($data == "dtrans") {
        $_SESSION["data"] = "dtrans";
        $_SESSION["dataAdmin"] = query("SELECT * FROM dtrans");
    } else {
        $_SESSION["data"] = "user";
        $_SESSION["dataAdmin"] = query("SELECT * FROM user");
    }
    resetPagingAdmin();
    header("Location: #collections");
}
if (isset($_POST["report"])) {
    $data = $_POST["pilihData"];
    if ($data == "produk") {
        header("Location: laporanProduk.php");
    } else if ($data == "htrans") {
        header("Location: laporanTransaksi.php");
    } else if ($data == "dtrans") {
        header("Location: laporanTransaksi.php");
    } else {
        header("Location: laporanUser.php");
    }
    resetPagingAdmin();
    // header("Location: #collections");
}
//SEARCH
if (isset($_POST["btnSearchAdmin"])) {
    $_SESSION["adminSearch"] = $_POST["inputSearchAdmin"];
    $tempKey = $_SESSION["adminSearch"];

    if ($_SESSION["data"] == "produk") {
        if ($tempKey == "") {
            $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
        } else {
            $_SESSION["dataAdmin"] = query("SELECT * FROM produk,brand,kategori WHERE produk.id_brand = brand.id_brand AND produk.id_kategori = kategori.id_kategori AND (produk.name_produk LIKE '%$tempKey%' OR produk.id_brand LIKE '%$tempKey%' OR produk.id_kategori LIKE '%$tempKey%' OR kategori.name_kategori LIKE '%$tempKey%') ORDER BY produk.id_produk");
        }
    } else if ($_SESSION["data"] == "htrans") {
        if ($tempKey == "") {
            $_SESSION["dataAdmin"] = query("SELECT * FROM htrans");
        } else {
            $_SESSION["dataAdmin"] = query("SELECT * FROM htrans,user WHERE htrans.id_user = user.id_user AND (htrans.nota_jual LIKE '%$tempKey%' OR htrans.tanggal LIKE '%$tempKey%' OR htrans.id_user LIKE '%$tempKey%' OR user.full_name LIKE '%$tempKey%') ORDER BY htrans.nota_jual");
        }
    } else {
        if ($tempKey == "") {
            $_SESSION["dataAdmin"] = query("SELECT * FROM dtrans");
        } else {
            $_SESSION["dataAdmin"] = query("SELECT * FROM dtrans,produk WHERE dtrans.id_produk = produk.id_produk AND (dtrans.nota_jual LIKE '%$tempKey%' OR dtrans.id_produk LIKE '%$tempKey%' OR produk.name_produk LIKE '%$tempKey%') ORDER BY dtrans.nota_jual");
        }
    }
    resetPagingAdmin();
    header("Location: #collections");
}

if (isset($_POST["submitBrand"])) {
    $tempNameBrand = $_POST["addBrand"];
    if ($tempNameBrand == "") {
        alert("Add Brand Failed!");
    } else {
        $bikinId = "BRN";
        $tempBrand = query("SELECT * FROM brand");
        $idBrandAkhir = $tempBrand[count($tempBrand) - 1]["id_brand"];

        $urutanIdBrand = (int)substr($idBrandAkhir, 3);
        $urutanIdBrand++;

        if ($urutanIdBrand < 10) {
            $bikinId = $bikinId . ("00" . $urutanIdBrand);
        } else if ($urutanIdBrand < 100) {
            $bikinId = $bikinId . ("0" . $urutanIdBrand);
        } else {
            $bikinId = $bikinId . $urutanIdBrand;
        }
        $brandBaru = [
            "id_brand" => $bikinId,
            "name_brand" => $tempNameBrand
        ];
        insertBrand($brandBaru);
        alert("Add Brand Success!");
    }
    $_SESSION["data"] = "produk";
    echo "<script> document.location.href = 'admin.php'; </script>";
}
if (isset($_POST["submitKategori"])) {
    $tempNameKategori = $_POST["addKategori"];
    if ($tempNameKategori == "") {
        alert("Add Categories Failed!");
    } else {
        $bikinId = "KTG";
        $tempKategori = query("SELECT * FROM kategori");
        $idKategoriAkhir = $tempKategori[count($tempKategori) - 1]["id_kategori"];

        $urutanIdKategori = (int)substr($idKategoriAkhir, 3);
        $urutanIdKategori++;

        if ($urutanIdKategori < 10) {
            $bikinId = $bikinId . ("00" . $urutanIdKategori);
        } else if ($urutanIdKategori < 100) {
            $bikinId = $bikinId . ("0" . $urutanIdKategori);
        } else {
            $bikinId = $bikinId . $urutanIdKategori;
        }
        $KategoriBaru = [
            "id_kategori" => $bikinId,
            "name_kategori" => $tempNameKategori
        ];
        insertKategori($KategoriBaru);
        alert("Add Categories Success!");
    }
    $_SESSION["data"] = "produk";
    echo "<script> document.location.href = 'admin.php'; </script>";
}

if (isset($_POST["edit"])) {
    $id = $_POST["idData"];
    $stmt = $conn->query("SELECT * FROM produk WHERE id_produk='$id'");
    $_SESSION["editData"] = $stmt->fetch_assoc();
    header("Location: editData.php");
}

if (isset($_POST["activate"])) {
    $id = $_POST["idData"];

    // $tempProduk = query("SELECT * FROM produk WHERE id_produk = '$id'");
    // foreach ($tempProduk as $key => $value) {
    //     $dir = $value["image_produk"];
    // }

    // if (file_exists($dir)) {
    //     unlink($dir);
    // }

    // deleteProduk($id);
    if ($_SESSION["data"] == "produk") {
        $query = "UPDATE produk SET status_produk = '1' WHERE id_produk = '$id'";
        mysqli_query($conn, $query);
        $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
        alert("Activate Product Success!");
    } else if ($_SESSION["data"] == "user") {
        $query = "UPDATE user SET status_user = '1' WHERE id_user = '$id'";
        mysqli_query($conn, $query);
        $_SESSION["dataAdmin"] = query("SELECT * FROM user");
        alert("Activate User Success!");
    }

    echo "<script> document.location.href = 'admin.php#collections'; </script>";
}
if (isset($_POST["deactivate"])) {
    $id = $_POST["idData"];

    // $tempProduk = query("SELECT * FROM produk WHERE id_produk = '$id'");
    // foreach ($tempProduk as $key => $value) {
    //     $dir = $value["image_produk"];
    // }

    // if (file_exists($dir)) {
    //     unlink($dir);
    // }

    // deleteProduk($id);
    if ($_SESSION["data"] == "produk") {
        $query = "UPDATE produk SET status_produk = '0' WHERE id_produk = '$id'";
        mysqli_query($conn, $query);
        $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
        alert("Deactivate Product Success!");
    } else if ($_SESSION["data"] == "user") {
        $query = "UPDATE user SET status_user = '0' WHERE id_user = '$id'";
        mysqli_query($conn, $query);
        $_SESSION["dataAdmin"] = query("SELECT * FROM user");
        alert("Activate User Success!");
    }


    echo "<script> document.location.href = 'admin.php#collections'; </script>";
}
if (isset($_POST["submitProduk"])) {
    $safe = true;

    $insertData = [];
    for ($i = 0; $i < $_SESSION["jumlahInput"]; $i++) {
        $nameProduk = $_POST["addName" . $i];
        $brandProduk = $_POST["addProdukBrand" . $i];
        $categoryProduk = $_POST["addProdukKategori" . $i];
        $stockProduk = $_POST["addStock" . $i];
        $priceProduk = $_POST["addPrice" . $i];
        $descriptionProduk = $_POST["addDescription" . $i];

        if ($nameProduk == "" || $brandProduk == "" || $categoryProduk == "" || $stockProduk == "" || $priceProduk == "" || $descriptionProduk == "") {
            $safe = false;
        } else {
            $target_dir = "asset/product/";
            $target_file = $target_dir . basename($_FILES["addImage" . $i]["name"]);
            $uploadOk = true;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["addImage" . $i]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = true;
            } else {
                $uploadOk = false;
                alert("File is not an image.");
            }

            // Check if file already exists
            if (file_exists($target_file) && $uploadOk == true) {
                $uploadOk = false;
                alert("Sorry, file already exists.");
            }

            // Check file size
            if ($_FILES["addImage" . $i]["size"] > 10000000 && $uploadOk == true) {
                $uploadOk = false;
                alert("Sorry, your file is too large.");
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $uploadOk == true) {
                $uploadOk = false;
                alert("Sorry, only JPG files are allowed.");
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == false) {
                $safe = false;
            } else {
                if (move_uploaded_file($_FILES["addImage" . $i]["tmp_name"], $target_file)) {
                    $safe = true;
                } else {
                    alert("Sorry, there was an error uploading your file.");
                    $safe = false;
                }
            }
        }

        if ($safe) {
            $path = $target_dir . htmlspecialchars(basename($_FILES["addImage" . $i]["name"]));

            $brands = query("SELECT * FROM brand");
            foreach ($brands as $key => $value) {
                if ($brandProduk == $value["name_brand"]) {
                    $idBrand = $value["id_brand"];
                }
            }

            $categories = query("SELECT * FROM kategori");
            foreach ($categories as $key => $value) {
                if ($categoryProduk == $value["name_kategori"]) {
                    $idCategory = $value["id_kategori"];
                }
            }

            $data = [
                "name_produk" => $nameProduk,
                "id_brand" => $idBrand,
                "id_kategori" => $idCategory,
                "stok_produk" => $stockProduk,
                "price_produk" => $priceProduk,
                "image_produk" => $path,
                "description_produk" => $descriptionProduk,
                "status_produk" => 1
            ];

            array_push($insertData, $data);
        }
    }

    if ($safe) {
        insertProduk($insertData);

        alert("Add Product Success!");
    } else {
        alert("Add Product Failed!");
        unlink($path);
    }
    $_SESSION["data"] = "produk";
    $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
    echo "<script> document.location.href = 'admin.php'; </script>";
}

// PAGINATION
$maks = (count($_SESSION["dataAdmin"]) / 30) + 1;
if (isset($_POST["page0"])) {
    $_SESSION["pageAdminSekarang"] = $_SESSION["pagingAdmin"][0]["page"];
    if ($_SESSION["pagingAdmin"][0]["page"] > 2) {
        $_SESSION["pagingAdmin"][0]["page"] -= 2;
        $_SESSION["pagingAdmin"][1]["page"] -= 2;
        $_SESSION["pagingAdmin"][2]["page"] -= 2;
        $_SESSION["pagingAdmin"][3]["page"] -= 2;
        $_SESSION["pagingAdmin"][4]["page"] -= 2;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["page1"])) {
    $_SESSION["pageAdminSekarang"] = $_SESSION["pagingAdmin"][1]["page"];
    if ($_SESSION["pagingAdmin"][0]["page"] > 1) {
        $_SESSION["pagingAdmin"][0]["page"]--;
        $_SESSION["pagingAdmin"][1]["page"]--;
        $_SESSION["pagingAdmin"][2]["page"]--;
        $_SESSION["pagingAdmin"][3]["page"]--;
        $_SESSION["pagingAdmin"][4]["page"]--;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["page2"])) {
    $_SESSION["pageAdminSekarang"] = $_SESSION["pagingAdmin"][2]["page"];
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["page3"])) {
    $_SESSION["pageAdminSekarang"] = $_SESSION["pagingAdmin"][3]["page"];
    if ($_SESSION["pagingAdmin"][4]["page"] < $maks - 1) {
        $_SESSION["pagingAdmin"][0]["page"]++;
        $_SESSION["pagingAdmin"][1]["page"]++;
        $_SESSION["pagingAdmin"][2]["page"]++;
        $_SESSION["pagingAdmin"][3]["page"]++;
        $_SESSION["pagingAdmin"][4]["page"]++;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["page4"])) {
    $_SESSION["pageAdminSekarang"] = $_SESSION["pagingAdmin"][4]["page"];
    if ($_SESSION["pagingAdmin"][4]["page"] < $maks - 2) {
        $_SESSION["pagingAdmin"][0]["page"] += 2;
        $_SESSION["pagingAdmin"][1]["page"] += 2;
        $_SESSION["pagingAdmin"][2]["page"] += 2;
        $_SESSION["pagingAdmin"][3]["page"] += 2;
        $_SESSION["pagingAdmin"][4]["page"] += 2;
    } else if ($_SESSION["pagingAdmin"][4]["page"] < $maks - 1) {
        $_SESSION["pagingAdmin"][0]["page"] += 1;
        $_SESSION["pagingAdmin"][1]["page"] += 1;
        $_SESSION["pagingAdmin"][2]["page"] += 1;
        $_SESSION["pagingAdmin"][3]["page"] += 1;
        $_SESSION["pagingAdmin"][4]["page"] += 1;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["pageSekarangMin1"])) {
    if ($_SESSION["pagingAdmin"][0]["page"] > 1 && $_SESSION["pageAdminSekarang"] != 1) {
        $_SESSION["pageAdminSekarang"]--;
        $_SESSION["pagingAdmin"][0]["page"]--;
        $_SESSION["pagingAdmin"][1]["page"]--;
        $_SESSION["pagingAdmin"][2]["page"]--;
        $_SESSION["pagingAdmin"][3]["page"]--;
        $_SESSION["pagingAdmin"][4]["page"]--;
    } else if ($_SESSION["pageAdminSekarang"] > 1) {
        $_SESSION["pageAdminSekarang"]--;
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["pageSekarangPlus1"])) {
    if ($maks <= 4) {
        if ($_SESSION["pagingAdmin"][$maks - 2]["page"] <= $maks && $_SESSION["pageAdminSekarang"] < $maks - 1) {
            $_SESSION["pageAdminSekarang"]++;
        }
    } else {
        if ($_SESSION["pagingAdmin"][4]["page"] < $maks - 1 && $_SESSION["pageAdminSekarang"] != $maks) {
            $_SESSION["pageAdminSekarang"]++;
            $_SESSION["pagingAdmin"][0]["page"]++;
            $_SESSION["pagingAdmin"][1]["page"]++;
            $_SESSION["pagingAdmin"][2]["page"]++;
            $_SESSION["pagingAdmin"][3]["page"]++;
            $_SESSION["pagingAdmin"][4]["page"]++;
        } else if ($_SESSION["pageAdminSekarang"] < $maks - 1) {
            $_SESSION["pageAdminSekarang"]++;
        }
    }
    // alert($_SESSION["pageSekarang"]);
    header("Location: #collections");
}
if (isset($_POST["pagePertama"])) {
    $_SESSION["pageAdminSekarang"] = 1;
    $_SESSION["pagingAdmin"][0]["page"] = 1;
    $_SESSION["pagingAdmin"][1]["page"] = 2;
    $_SESSION["pagingAdmin"][2]["page"] = 3;
    $_SESSION["pagingAdmin"][3]["page"] = 4;
    $_SESSION["pagingAdmin"][4]["page"] = 5;
    header("Location: #collections");
}
if (isset($_POST["pageTerakhir"])) {
    $maks = (int)$maks;
    $_SESSION["pageAdminSekarang"] = $maks;
    $_SESSION["pagingAdmin"][0]["page"] = $maks - 4;
    $_SESSION["pagingAdmin"][1]["page"] = $maks - 3;
    $_SESSION["pagingAdmin"][2]["page"] = $maks - 2;
    $_SESSION["pagingAdmin"][3]["page"] = $maks - 1;
    $_SESSION["pagingAdmin"][4]["page"] = $maks;
    header("Location: #collections");
}

if (isset($_POST["go"])) {
    $_SESSION["jumlahInput"] = $_POST["jumlahInput"];
    header("Location: #addProduk");
    // alert($_SESSION["jumlahInput"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Input -->
    <div class="bgGradient min-vh-100">
        <div class="d-flex justify-content-center">
            <div class="container bg-light text-center p-5 my-5 glass">
                <div class="row d-flex justify-content-start mb-5">
                    <div class="col-2">
                        <h1 class="text-danger">Admin</h1>
                    </div>
                    <div class="col-8 d-flex justify-content-start">
                        <form action="" method="post">
                            <button type="submit" class="btn btn-outline-danger px-5" style="font-size: 25px;" name="logout">Logout</button>
                        </form>
                    </div>
                </div>
                <!-- Add Product -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-12 border border-2 p-5 mb-5" id="addProduk">
                        <div class="col-12 text-success">
                            <h1>Add Product</h1>
                        </div>
                        <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                            <form action="" method="post">
                                <input type="number" name="jumlahInput" id="" style="width: 6vw; height: 5vh;" min="1" value="<?= $_SESSION["jumlahInput"] ?>"><button type="submit" class="btn btn-outline-dark fs-5 d-flex align-items-center justify-content-center ms-3" style="width: 4vw; height: 5vh;" name="go">Go</button>
                            </form>
                        </div>
                        <?php
                        for ($i = 0; $i < $_SESSION["jumlahInput"]; $i++) {
                        ?>
                            <div class="col-12 mt-4">
                                <div class="form-floating mb-3 w-100">
                                    <input type="text" class="form-control" placeholder="Product Name" name="addName<?= $i ?>" id="addName<?= $i ?>">
                                    <label for="addName">Product Name</label>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col-6 col-xl-3 d-flex justify-content-start align-items-center" style="font-size: 20px;">
                                        Brand : <select name="addProdukBrand<?= $i ?>" class="ms-3" id="addProdukBrand<?= $i ?>" style="width: 7vw; height: 5vh;">
                                            <?php
                                            $tempBrand = query("SELECT * FROM brand");
                                            foreach ($tempBrand as $key => $value) {
                                            ?>
                                                <option value="<?= $value["name_brand"] ?>" style="width: 7vw; height: 5vh;"><?= $value["name_brand"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-6 col-xl-3 d-flex justify-content-start align-items-center" style="font-size: 20px;">
                                        Categories : <select name="addProdukKategori<?= $i ?>" class="ms-3" id="addProdukKategori<?= $i ?>" style="width: 7vw; height: 5vh;">
                                            <?php
                                            $tempBrand = query("SELECT * FROM kategori");
                                            foreach ($tempBrand as $key => $value) {
                                            ?>
                                                <option value="<?= $value["name_kategori"] ?>" style="width: 8vw; height: 5vh;"> <?= $value["name_kategori"] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-6 col-xl-3 text-start d-flex justify-content-center align-items-center" style="font-size: 20px;">
                                        Stock : <input type="number" onclick="" class="mx-3" style="width: 7vw; height: 5vh;" name="addStock<?= $i ?>" id="addStock" min="1">
                                    </div>
                                    <div class="col-6 col-xl-3 d-flex justify-content-end align-items-center" style="font-size: 20px;">
                                        Price : $ <input type="number" step="0.01" onclick="" class="mx-3" style="width: 8vw; height: 5vh;" name="addPrice<?= $i ?>" id="addPrice" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-start pt-4" style="font-size: 20px;">
                                Image (.jpg): <input type="file" name="addImage<?= $i ?>" id="" class="ms-3">
                            </div>
                            <div class="col-12 pt-4 d-flex justify-content-start">
                                <div class="form-floating mb-3 w-100">
                                    <textarea class="form-control" placeholder="Description Product" style="height: 20vh" aria-label="With textarea" name="addDescription<?= $i ?>" id="addDescription" <?= $i ?>></textarea>
                                    <label for="addDescription">Description Product</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="col-12 pt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-success py-2 px-5 me-3" name="submitProduk" onclick="">Add Product</button>
                            <button type="submit" class="btn btn-outline-success py-2 px-5" name="clear" onclick="clearForm();">Clear</button>
                        </div>
                    </div>
                </form>

                <div class="col-12 border border-2 p-5">
                    <div class="row">
                        <!-- Add Brand -->
                        <div class="col-6 border-end border-3">
                            <form action="" method="post">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-12 mb-3 text-success">
                                        <h1>Add Brand</h1>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-floating mb-3 w-100">
                                            <input type="text" class="form-control " placeholder="Brand Name" name="addBrand" id="addBrand">
                                            <label for="addBrand">Brand Name</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-outline-success py-3" name="submitBrand" onclick="">Add Brand</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Add Categories -->
                        <div class="col-6 ps-5">
                            <form action="" method="post">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-12 mb-3 text-success">
                                        <h1>Add Category</h1>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-floating mb-3 w-100">
                                            <input type="text" class="form-control" placeholder="Category Name" name="addKategori" id="addKategori">
                                            <label for="addKategori">Category Name</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-outline-success py-3" name="submitKategori" onclick="">Add Category</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combo Box -->
        <form action="" method="post">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <select name="pilihData" class="me-3" id="pilihData" style="width: 12vw; height: 5vh;" value="<?= $_SESSION["data"] ?>">
                            <option value="produk" style="width: 12vw; height: 5vh;">Product</option>
                            <option value="htrans" style="width: 12vw; height: 5vh;">Header Transaction</option>
                            <option value="dtrans" style="width: 12vw; height: 5vh;">Detail Transaction</option>
                            <option value="user" style="width: 12vw; height: 5vh;">User</option>
                        </select>
                        <button type="submit" class="btn btn-outline-dark fs-5 d-flex align-items-center me-3 text-center" style="width: 6vw; height: 5vh;" name="choose">Choose</button>
                        <button type="submit" class="btn btn-outline-danger fs-5 d-flex align-items-center justify-content-center" style="width: 6vw; height: 5vh;" name="report">Report</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Data produk -->
        <?php
        if ($_SESSION["data"] == "produk") {
        ?>
            <form action="" method="post" class="mb-0">
                <div class="d-flex justify-content-center" id="collections">
                    <div class="container bg-light text-center p-5 mb-5 mt-1 glass">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12">
                                <h1>Products Data</h1>
                            </div>
                            <div class="col-12">
                                <?php
                                if (count($_SESSION["dataAdmin"]) == 0) {
                                ?>
                                    <h5>Result 0 - 0 of 0</h5>
                                    <?php
                                } else {
                                    if (($_SESSION["pageAdminSekarang"]) * 30 < count($_SESSION["dataAdmin"])) {
                                    ?>
                                        <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= ($_SESSION["pageAdminSekarang"]) * 30 ?> of <?= count($_SESSION["dataAdmin"]) ?></h5>
                                    <?php
                                    } else {
                                    ?>
                                        <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= count($_SESSION["dataAdmin"]) ?> of <?= count($_SESSION["dataAdmin"]) ?></h5>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <div class="col-11">
                                            <input class="form-control me-2" type="text" placeholder="Search" name="inputSearchAdmin" id="inputSearchAdmin">
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-outline-success" type="submit" name="btnSearchAdmin">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-dark">
                                <hr style="font-weight: bold; color: black;">
                            </div>
                            <table class="table">
                                <tr>
                                    <!-- <th>Image Produk</th> -->
                                    <th scope='col'>ID Produk</th>
                                    <th scope='col'>Name Produk</th>
                                    <th scope='col'>Brand Produk</th>
                                    <th scope='col'>Category Produk</th>
                                    <th scope='col'>Stok Produk</th>
                                    <th scope='col'>Price Produk</th>
                                    <th scope='col'>Status</th>
                                    <th scope='col'>Action</th>
                                    <!-- <th>Deskription Produk</th> -->
                                </tr>
                                <?php
                                $temp = 0;
                                foreach ($_SESSION["dataAdmin"] as $product) {
                                    $id = $product["id_produk"];
                                    $name = $product["name_produk"];
                                    $id_brand = $product["id_brand"];
                                    $id_category = $product["id_kategori"];
                                    $stok = $product["stok_produk"];
                                    $price = $product["price_produk"];
                                    $description = $product["description_produk"];
                                    $image = $product["image_produk"];
                                    $status = $product["status_produk"];
                                    $temp++;
                                    if (($temp / 30) > $_SESSION["pageAdminSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageAdminSekarang"]) {
                                ?>
                                        <form action="" method="post" class="mb-0">
                                            <input type='hidden' name='idData' value='<?= $id ?>'>
                                            <tr>
                                                <td><?= $id ?></td>
                                                <td><?= $name ?></td>
                                                <?php
                                                $stmt = $conn->query("SELECT * FROM brand WHERE id_brand='$id_brand'");
                                                $brand = $stmt->fetch_assoc();
                                                ?>
                                                <td><?= $brand["name_brand"] ?></td>
                                                <?php
                                                $stmt = $conn->query("SELECT * FROM kategori WHERE id_kategori='$id_category'");
                                                $kategori = $stmt->fetch_assoc();
                                                ?>
                                                <td><?= $kategori["name_kategori"] ?></td>
                                                <td><?= $stok ?></td>
                                                <td>$ <?= $price ?></td>
                                                <?php
                                                if ($status == 1) {
                                                ?>
                                                    <td><i class="fa-sharp fa-solid fa-circle-check text-success"></i></td>
                                                <?php
                                                } else if ($status == 0) {
                                                ?>
                                                    <td><i class="fa-sharp fa-solid fa-circle-xmark text-danger"></i></td>
                                                <?php
                                                }
                                                ?>

                                                <td>
                                                    <button type='submit' class='btn btn-outline-warning p-1' name='edit'>Edit</button>
                                                    <?php
                                                    if ($status == 0) {
                                                    ?>
                                                        <button type='submit' class='btn btn-outline-success p-1' name='activate'>Activate</button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button type='submit' class='btn btn-outline-danger p-1' name='deactivate'>Deactivate</button>
                                                    <?php
                                                    }
                                                    ?>
                                                    <!-- <button type='submit' class='btn btn-outline-danger mx-3' name='delete'>Delete</button> -->
                                                </td>
                                                <!-- <td>$description</td> -->
                                            </tr>
                                        </form>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                            <!-- PAGING -->
                            <div class="row py-3">
                                <form action="" method="post">
                                    <div class="col-12 d-flex justify-content-center">
                                        <ul class="pagination d-flex align-items-center justify-content-center img-fluid">
                                            <div class="row d-flex justify-content-center rounded-pill border border-2 text-dark px-2">
                                                <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                    <li class="page-item">
                                                        <button type="submit" class="btn text-dark border border-0" name="pageSekarangMin1" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </button>
                                                    </li>
                                                </div>
                                                <?php
                                                $adaSatu = false;
                                                if ($_SESSION["pageAdminSekarang"] > 3 && $_SESSION["pagingAdmin"][0]["page"] != 1) {
                                                    $adaSatu = true;
                                                ?>
                                                    <div class="col-5 col-xl-2 d-flex justify-content-center">
                                                        <li class="page-item text-dark"><button type="submit" name="pagePertama" class="btn text-dark border border-0">1</button><span class="text-dark"> . . . </span></li>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                    <li class="page-item"><button type="submit" name="page0" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][0]["page"] ?></button></li>
                                                </div>
                                                <?php
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 1) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page1" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][1]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 2) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page2" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][2]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 3) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page3" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][3]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 4) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                        <li class="page-item"><button type="submit" name="page4" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][4]["page"] ?></button></li>
                                                    </div>
                                                    <?php
                                                }
                                                if ($_SESSION["pageAdminSekarang"] < $maks - 3 && $_SESSION["pagingAdmin"][4]["page"] != (int)$maks) {
                                                    if ($adaSatu) {
                                                    ?>
                                                        <div class="col-5 col-xl-2">
                                                            <li class="page-item text-dark"><span class="text-dark"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-dark border border-0"><?= (int)$maks ?></button></li>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-5 col-xl-3">
                                                            <li class="page-item text-dark"><span class="text-dark"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-dark border border-0"><?= (int)$maks ?></button></li>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                    <button type="submit" class="btn text-dark border border-0" name="pageSekarangPlus1" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <h5 class="text-dark">Page <?= $_SESSION["pageAdminSekarang"] ?> of <?= (int)$maks ?></h5>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php
        } else if ($_SESSION["data"] == "htrans") {
        ?>
            <form action="" method="post">
                <div class="d-flex justify-content-center" id="collections">
                    <div class="container bg-light text-center p-5 mb-5 mt-1 glass">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12">
                                <h1>Header Transaction</h1>
                            </div>
                            <div class="col-12">
                                <?php
                                if (($_SESSION["pageAdminSekarang"]) * 30 < count($_SESSION["dataAdmin"])) {
                                ?>
                                    <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= ($_SESSION["pageAdminSekarang"]) * 30 ?> of <?= count($_SESSION["dataAdmin"]) ?></h5>
                                <?php
                                } else {
                                ?>
                                    <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= count($_SESSION["dataAdmin"]) ?> of <?= count($_SESSION["dataAdmin"]) ?></h5>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <div class="col-11">
                                            <input class="form-control me-2" type="text" placeholder="Search" name="inputSearchAdmin" id="inputSearchAdmin">
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-outline-success" type="submit" name="btnSearchAdmin">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-dark">
                                <hr style="font-weight: bold; color: black;">
                            </div>
                            <table class="table" id="produkInfo">
                                <tr>
                                    <!-- <th>Image Produk</th> -->
                                    <th scope='col' class="text-start">Invoice Number</th>
                                    <th scope='col' class="text-start">Date</th>
                                    <th scope='col' class="text-start">ID User</th>
                                    <th scope='col' class="text-start">Subtotal</th>
                                </tr>
                                <?php
                                $temp = 0;
                                foreach ($_SESSION["dataAdmin"] as $htrans) {
                                    $nota = $htrans["nota_jual"];
                                    $tanggal = $htrans["tanggal"];
                                    $id_user = $htrans["id_user"];
                                    $subtotal = $htrans["subtotal"];
                                    $temp++;
                                    if (($temp / 30) > $_SESSION["pageAdminSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageAdminSekarang"]) {
                                ?>
                                        <tr>
                                            <td class="text-start"><?= $nota ?></td>
                                            <td class="text-start"><?= $tanggal ?></td>
                                            <td class="text-start"><?= $id_user ?></td>
                                            <td class="text-start">$ <?= $subtotal ?></td>
                                            <!-- <td>$description</td> -->
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                            <!-- PAGING -->
                            <div class="row py-3">
                                <form action="" method="post">
                                    <div class="col-12 d-flex justify-content-center">
                                        <ul class="pagination d-flex align-items-center justify-content-center img-fluid">
                                            <div class="row d-flex justify-content-center rounded-pill border border-2 text-dark px-2">
                                                <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                    <li class="page-item">
                                                        <button type="submit" class="btn text-dark border border-0" name="pageSekarangMin1" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </button>
                                                    </li>
                                                </div>
                                                <?php
                                                $adaSatu = false;
                                                if ($_SESSION["pageAdminSekarang"] > 3 && $_SESSION["pagingAdmin"][0]["page"] != 1) {
                                                    $adaSatu = true;
                                                ?>
                                                    <div class="col-5 col-xl-2 d-flex justify-content-center">
                                                        <li class="page-item text-dark"><button type="submit" name="pagePertama" class="btn text-dark border border-0">1</button><span class="text-dark"> . . . </span></li>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                    <li class="page-item"><button type="submit" name="page0" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][0]["page"] ?></button></li>
                                                </div>
                                                <?php
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 1) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page1" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][1]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 2) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page2" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][2]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 3) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page3" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][3]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 4) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                        <li class="page-item"><button type="submit" name="page4" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][4]["page"] ?></button></li>
                                                    </div>
                                                    <?php
                                                }
                                                if ($_SESSION["pageAdminSekarang"] < $maks - 3 && $_SESSION["pagingAdmin"][4]["page"] != (int)$maks) {
                                                    if ($adaSatu) {
                                                    ?>
                                                        <div class="col-5 col-xl-2">
                                                            <li class="page-item text-dark"><span class="text-dark"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-dark border border-0"><?= (int)$maks ?></button></li>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-5 col-xl-3">
                                                            <li class="page-item text-dark"><span class="text-dark"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-dark border border-0"><?= (int)$maks ?></button></li>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                    <button type="submit" class="btn text-dark border border-0" name="pageSekarangPlus1" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <h5 class="text-dark">Page <?= $_SESSION["pageAdminSekarang"] ?> of <?= (int)$maks ?></h5>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php
        } else if ($_SESSION["data"] == "dtrans") {
        ?>
            <form action="" method="post">
                <div class="d-flex justify-content-center" id="collections">
                    <div class="container bg-light text-center p-5 mb-5 mt-1 glass">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12">
                                <h1>Detail Transaction</h1>
                            </div>
                            <div class="col-12">
                                <?php
                                if (($_SESSION["pageAdminSekarang"]) * 30 < count($_SESSION["dataAdmin"])) {
                                ?>
                                    <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= ($_SESSION["pageAdminSekarang"]) * 30 ?> of <?= count($_SESSION["dataAdmin"]) ?></h5>
                                <?php
                                } else {
                                ?>
                                    <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= count($_SESSION["dataAdmin"]) ?> of <?= count($_SESSION["dataAdmin"]) ?></h5>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <div class="col-11">
                                            <input class="form-control me-2" type="text" placeholder="Search" name="inputSearchAdmin" id="inputSearchAdmin">
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-outline-success" type="submit" name="btnSearchAdmin">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-dark">
                                <hr style="font-weight: bold; color: black;">
                            </div>
                            <table class="table" id="produkInfo">
                                <tr>
                                    <!-- <th>Image Produk</th> -->
                                    <th scope='col' class="text-start">Invoice Number</th>
                                    <th scope='col' class="text-start">ID Product</th>
                                    <th scope='col' class="text-start">Quantity</th>
                                </tr>
                                <?php
                                $temp = 0;
                                foreach ($_SESSION["dataAdmin"] as $dtrans) {
                                    $nota = $dtrans["nota_jual"];
                                    $id_produk = $dtrans["id_produk"];
                                    $quantity = $dtrans["quantity"];
                                    $temp++;
                                    if (($temp / 30) > $_SESSION["pageAdminSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageAdminSekarang"]) {
                                ?>
                                        <tr>
                                            <td class="text-start"><?= $nota ?></td>
                                            <td class="text-start"><?= $id_produk ?></td>
                                            <td class="text-start"><?= $quantity ?></td>
                                            <!-- <td>$description</td> -->
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                            <!-- PAGING -->
                            <div class="row py-3">
                                <form action="" method="post">
                                    <div class="col-12 d-flex justify-content-center">
                                        <ul class="pagination d-flex align-items-center justify-content-center img-fluid">
                                            <div class="row d-flex justify-content-center rounded-pill border border-2 text-dark px-2">
                                                <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                    <li class="page-item">
                                                        <button type="submit" class="btn text-dark border border-0" name="pageSekarangMin1" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </button>
                                                    </li>
                                                </div>
                                                <?php
                                                $adaSatu = false;
                                                if ($_SESSION["pageAdminSekarang"] > 3 && $_SESSION["pagingAdmin"][0]["page"] != 1) {
                                                    $adaSatu = true;
                                                ?>
                                                    <div class="col-5 col-xl-2 d-flex justify-content-center">
                                                        <li class="page-item text-dark"><button type="submit" name="pagePertama" class="btn text-dark border border-0">1</button><span class="text-dark"> . . . </span></li>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                    <li class="page-item"><button type="submit" name="page0" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][0]["page"] ?></button></li>
                                                </div>
                                                <?php
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 1) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page1" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][1]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 2) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page2" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][2]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 3) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page3" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][3]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 4) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                        <li class="page-item"><button type="submit" name="page4" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][4]["page"] ?></button></li>
                                                    </div>
                                                    <?php
                                                }
                                                if ($_SESSION["pageAdminSekarang"] < $maks - 3 && $_SESSION["pagingAdmin"][4]["page"] != (int)$maks) {
                                                    if ($adaSatu) {
                                                    ?>
                                                        <div class="col-5 col-xl-2">
                                                            <li class="page-item text-dark"><span class="text-dark"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-dark border border-0"><?= (int)$maks ?></button></li>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-5 col-xl-3">
                                                            <li class="page-item text-dark"><span class="text-dark"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-dark border border-0"><?= (int)$maks ?></button></li>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                    <button type="submit" class="btn text-dark border border-0" name="pageSekarangPlus1" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <h5 class="text-dark">Page <?= $_SESSION["pageAdminSekarang"] ?> of <?= (int)$maks ?></h5>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php
        } else {
        ?>
            <form action="" method="post" class="mb-0">
                <div class="d-flex justify-content-center" id="collections">
                    <div class="container bg-light text-center p-5 mb-5 mt-1 glass">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12">
                                <h1>Users Data</h1>
                            </div>
                            <div class="col-12">
                                <?php
                                if (($_SESSION["pageAdminSekarang"]) * 30 < count($_SESSION["dataAdmin"])) {
                                ?>
                                    <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= ($_SESSION["pageAdminSekarang"]) * 30 ?> of <?= count($_SESSION["dataAdmin"]) ?></h5>
                                <?php
                                } else {
                                ?>
                                    <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= count($_SESSION["dataAdmin"]) ?> of <?= count($_SESSION["dataAdmin"]) ?></h5>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <div class="col-11">
                                            <input class="form-control me-2" type="text" placeholder="Search" name="inputSearchAdmin" id="inputSearchAdmin">
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-outline-success" type="submit" name="btnSearchAdmin">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-dark">
                                <hr style="font-weight: bold; color: black;">
                            </div>
                            <table class="table" id="produkInfo">
                                <tr>
                                    <!-- <th>Image Produk</th> -->
                                    <th scope='col' class="text-start">ID User</th>
                                    <th scope='col' class="text-start">Username </th>
                                    <th scope='col' class="text-start">Full Name</th>
                                    <th scope='col' class="text-start">Email</th>
                                    <th scope='col' class="text-start">Address</th>
                                    <th scope='col' class="text-start">Phone Number</th>
                                    <th scope='col' class="text-start">Password</th>
                                    <th scope='col' class="text-start">Status</th>
                                    <th scope='col' class="text-start">Action</th>
                                </tr>
                                <?php
                                $temp = 0;
                                foreach ($_SESSION["dataAdmin"] as $users) {
                                    $id = $users["id_user"];
                                    $username = $users["username"];
                                    $fullname = $users["full_name"];
                                    $email = $users["email"];
                                    $address = $users["alamat"];
                                    $telp = $users["nomor_telepon"];
                                    $password = $users["password"];
                                    $status = $users["status_user"];
                                    $temp++;
                                    if (($temp / 30) > $_SESSION["pageAdminSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageAdminSekarang"]) {
                                ?>
                                        <form action="" method="post" class="mb-0">
                                            <input type='hidden' name='idData' value='<?= $id ?>'>
                                            <tr>
                                                <td class="text-start"><?= $id ?></td>
                                                <td class="text-start"><?= $username ?></td>
                                                <td class="text-start"><?= $fullname ?></td>
                                                <td class="text-start"><?= $email ?></td>
                                                <td class="text-start"><?= $address ?></td>
                                                <td class="text-start"><?= $telp ?></td>
                                                <td class="text-start"><?= $password ?></td>
                                                <?php
                                                if ($status == 1) {
                                                ?>
                                                    <td><i class="fa-sharp fa-solid fa-circle-check text-success"></i></td>
                                                <?php
                                                } else if ($status == 0) {
                                                ?>
                                                    <td><i class="fa-sharp fa-solid fa-circle-xmark text-danger"></i></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if ($status == 0) {
                                                ?>
                                                    <td><button type='submit' class='btn btn-outline-success p-1' name='activate'>Activate</button></td>
                                                <?php
                                                } else {
                                                ?>
                                                    <td><button type='submit' class='btn btn-outline-danger p-1' name='deactivate'>Deactivate</button></td>
                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        </form>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                            <!-- PAGING -->
                            <div class="row py-3">
                                <form action="" method="post">
                                    <div class="col-12 d-flex justify-content-center">
                                        <ul class="pagination d-flex align-items-center justify-content-center img-fluid">
                                            <div class="row d-flex justify-content-center rounded-pill border border-2 text-dark px-2">
                                                <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                    <li class="page-item">
                                                        <button type="submit" class="btn text-dark border border-0" name="pageSekarangMin1" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </button>
                                                    </li>
                                                </div>
                                                <?php
                                                $adaSatu = false;
                                                if ($_SESSION["pageAdminSekarang"] > 3 && $_SESSION["pagingAdmin"][0]["page"] != 1) {
                                                    $adaSatu = true;
                                                ?>
                                                    <div class="col-5 col-xl-2 d-flex justify-content-center">
                                                        <li class="page-item text-dark"><button type="submit" name="pagePertama" class="btn text-dark border border-0">1</button><span class="text-dark"> . . . </span></li>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                    <li class="page-item"><button type="submit" name="page0" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][0]["page"] ?></button></li>
                                                </div>
                                                <?php
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 1) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page1" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][1]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 2) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page2" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][2]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 3) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                        <li class="page-item"><button type="submit" name="page3" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][3]["page"] ?></button></li>
                                                    </div>
                                                <?php
                                                }
                                                if ((count($_SESSION["dataAdmin"]) / 30) > 4) {
                                                ?>
                                                    <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                        <li class="page-item"><button type="submit" name="page4" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][4]["page"] ?></button></li>
                                                    </div>
                                                    <?php
                                                }
                                                if ($_SESSION["pageAdminSekarang"] < $maks - 3 && $_SESSION["pagingAdmin"][4]["page"] != (int)$maks) {
                                                    if ($adaSatu) {
                                                    ?>
                                                        <div class="col-5 col-xl-2">
                                                            <li class="page-item text-dark"><span class="text-dark"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-dark border border-0"><?= (int)$maks ?></button></li>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-5 col-xl-3">
                                                            <li class="page-item text-dark"><span class="text-dark"> . . . </span><button type="submit" name="pageTerakhir" class="btn text-dark border border-0"><?= (int)$maks ?></button></li>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <div class="col-1 col-xl-1 d-flex justify-content-center">
                                                    <button type="submit" class="btn text-dark border border-0" name="pageSekarangPlus1" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <h5 class="text-dark">Page <?= $_SESSION["pageAdminSekarang"] ?> of <?= (int)$maks ?></h5>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php
        }
        ?>
    </div>

    <script>
        function clearForm() {
            document.getElementsById("addName").value = "";
            document.getElementsById("addStock").value = 0;
            document.getElementsById("addPrice").value = 0;
            document.getElementsById("addDescription").value = "";
        }
    </script>
</body>

</html>

<!-- p -->
<!-- p2 -->