<?php
require("functions.php");

if (!isset($_SESSION["dataAdmin"])) {
    $_SESSION["dataAdmin"] = [];
    $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
} else {
    $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
}

if (isset($_POST["back"])) {
    header("Location: admin.php");
}

if (isset($_POST["submitProduk"])) {
    $safe = true;

    $idProduk = $_SESSION["editData"]["id_produk"];
    $nameProduk = $_POST["addName"];
    $brandProduk = $_POST["addProdukBrand"];
    $categoryProduk = $_POST["addProdukKategori"];
    $stockProduk = $_POST["addStock"];
    $priceProduk = $_POST["addPrice"];
    $descriptionProduk = $_POST["addDescription"];

    if ($nameProduk == "" || $brandProduk == "" || $categoryProduk == "" || $stockProduk == "" || $priceProduk == "" || $descriptionProduk == "") {
        $safe = false;
        alert("kosong");
    } else {
        $target_dir = "asset/product/";
        $target_file = $target_dir . basename($_FILES["addImage"]["name"]);
        $uploadOk = false;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if ($_FILES["addImage"]["error"] === 4) {
            $imageProduk = $_SESSION["editData"]["image_produk"];
        } else {
            $check = getimagesize($_FILES["addImage"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = true;
            } else {
                $uploadOk = false;
                alert("File is not an image.");
            }
        }

        // Check if file already exists
        if (file_exists($target_file) && $uploadOk == true) {
            $uploadOk = false;
            alert("Sorry, file already exists.");
        }

        // Check file size
        if ($_FILES["addImage"]["size"] > 10000000 && $uploadOk == true) {
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
            if ($_FILES["addImage"]["error"] === 4) {
                $safe = true;
            } else {
                $safe = false;
            }
        } else {
            if (move_uploaded_file($_FILES["addImage"]["tmp_name"], $target_file)) {
                $safe = true;
            } else {
                alert("Sorry, there was an error uploading your file.");
                $safe = false;
            }
        }
    }



    if ($safe) {
        if ($_FILES["addImage"]["error"] === 0) {
            unlink($_SESSION["editData"]["image_produk"]);
            $imageProduk = $target_dir . htmlspecialchars(basename($_FILES["addImage"]["name"]));
        }

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
            "id_produk" => $idProduk,
            "name_produk" => $nameProduk,
            "id_brand" => $idBrand,
            "id_kategori" => $idCategory,
            "stok_produk" => $stockProduk,
            "price_produk" => $priceProduk,
            "image_produk" => $imageProduk,
            "description_produk" => $descriptionProduk,
            "status_produk" => 1
        ];

        updateProduk($data);

        alert("Update Product Success!");
    } else {
        alert("Update Product Failed!");
    }
    echo "<script> document.location.href = 'admin.php'; </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="d-flex justify-content-center">
            <div class="container text-center p-5 my-5 glass">
                <div class="row d-flex justify-content-start mb-5">
                    <div class="col-2">
                        <h1 class="text-danger">Admin</h1>
                    </div>
                    <div class="col-8 d-flex justify-content-start">
                        <button type="submit" class="btn btn-outline-danger px-5" style="font-size: 25px;" name="back">Back</button>
                    </div>
                </div>
                <!-- Add Product -->
                <div class="col-12 border border-2 p-5 mb-5">
                    <div class="col-12 text-success">
                        <h1>Edit Product</h1>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="form-floating mb-3 w-100">
                            <input type="text" class="form-control" placeholder="Name Product" name="addName" id="addName" value="<?= $_SESSION["editData"]["name_produk"] ?>">
                            <label for="addName">Name Product</label>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="row">
                            <div class="col-6 col-xl-3 d-flex justify-content-start align-items-center" style="font-size: 20px;">
                                Brand : <select name="addProdukBrand" class="ms-3" id="addProdukBrand" style="width: 7vw; height: 5vh;">
                                    <?php
                                    $tempBrand = query("SELECT * FROM brand");
                                    foreach ($tempBrand as $key => $value) {
                                        if ($_SESSION["editData"]["id_brand"] === $value["id_brand"]) {
                                    ?>
                                            <option selected="selected" value="<?= $value["name_brand"] ?>" style="width: 7vw; height: 5vh;"><?= $value["name_brand"] ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $value["name_brand"] ?>" style="width: 7vw; height: 5vh;"><?= $value["name_brand"] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-xl-3 d-flex justify-content-start align-items-center" style="font-size: 20px;">
                                Categories : <select name="addProdukKategori" class="ms-3" id="addProdukKategori" style="width: 7vw; height: 5vh;">
                                    <?php
                                    $tempBrand = query("SELECT * FROM kategori");
                                    foreach ($tempBrand as $key => $value) {
                                        if ($_SESSION["editData"]["id_kategori"] === $value["id_kategori"]) {
                                    ?>
                                            <option selected="selected" value="<?= $value["name_kategori"] ?>" style="width: 8vw; height: 5vh;"> <?= $value["name_kategori"] ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $value["name_kategori"] ?>" style="width: 8vw; height: 5vh;"> <?= $value["name_kategori"] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-xl-3 text-start d-flex justify-content-center align-items-center" style="font-size: 20px;">
                                Stock : <input type="number" onclick="" class="mx-3" style="width: 7vw; height: 5vh;" name="addStock" id="addStock" min="1" value="<?= $_SESSION["editData"]["stok_produk"] ?>">
                            </div>
                            <div class="col-6 col-xl-3 d-flex justify-content-end align-items-center" style="font-size: 20px;">
                                Price : $ <input type="number" step="0.01" class="mx-3" style="width: 8vw; height: 5vh;" name="addPrice" id="addPrice" value="<?= $_SESSION["editData"]["price_produk"] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-start pt-4" style="font-size: 20px;">
                        <div>
                            Image :
                        </div>
                        <div class="ms-3">
                            <img src='<?= $_SESSION["editData"]["image_produk"] ?>' class='card-img-top border-0 img-size mb-3' alt='...' />
                            <br>
                            <input type="file" name="addImage" id="addImage" class="ms-3">
                        </div>
                    </div>
                    <div class="col-12 pt-4 d-flex justify-content-start">
                        <div class="form-floating mb-3 w-100">
                            <textarea class="form-control" placeholder="Description Product" style="height: 20vh" aria-label="With textarea" name="addDescription" id="addDescription"><?= $_SESSION["editData"]["description_produk"] ?></textarea>
                            <label for="addDescription">Description Product</label>
                        </div>
                    </div>
                    <div class="col-12 pt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-success py-2 px-5 me-3" name="submitProduk" onclick="">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>