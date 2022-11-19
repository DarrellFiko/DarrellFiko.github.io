<?php
    require("functions.php");

    if(!isset($_SESSION["dataAdmin"])){
        $_SESSION["dataAdmin"] = [];
        $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
    }

    if(isset($_POST["back"])){
        header("Location: admin.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="post">
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
                            <input type="text" class="form-control" id="floatingInput" placeholder="Name Product" name="addName" id="addName" value="<?=$_SESSION["editData"]["name_produk"]?>">
                            <label for="floatingInput">Name Product</label>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="row">
                            <div class="col-6 col-xl-3 d-flex justify-content-start align-items-center" style="font-size: 20px;">
                                Brand : <select name="addProdukBrand" class="ms-3" id="addProdukBrand" style="width: 7vw; height: 5vh;">
                                    <?php
                                    $tempBrand = query("SELECT * FROM brand");
                                    foreach ($tempBrand as $key => $value) {
                                        ?>
                                        <option value="<?=$value["name_brand"]?>" style="width: 7vw; height: 5vh;"><?=$value["name_brand"]?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-xl-3 d-flex justify-content-start align-items-center" style="font-size: 20px;">
                                Categories : <select name="addProdukKategori" class="ms-3" id="addProdukKategori" style="width: 8vw; height: 5vh;">
                                    <?php
                                    $tempBrand = query("SELECT * FROM kategori");
                                    foreach ($tempBrand as $key => $value) {
                                        ?>
                                        <option value="<?=$value["name_kategori"]?>" style="width: 8vw; height: 5vh;"> <?=$value["name_kategori"]?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-xl-3 text-start d-flex justify-content-center align-items-center" style="font-size: 20px;">
                                Stock : <input type="number" onclick="" class="mx-3" style="width: 7vw; height: 5vh;" name="addStock" id="addStock" min="1" value="<?=$_SESSION["editData"]["stok_produk"]?>">
                            </div>
                            <div class="col-6 col-xl-3 d-flex justify-content-end align-items-center" style="font-size: 20px;">
                                Price : $ <input type="text" class="mx-3" style="width: 8vw; height: 5vh;" name="addPrice" id="addPrice" value="<?=$_SESSION["editData"]["price_produk"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-start pt-4" style="font-size: 20px;">
                        Image : <input type="file" name="" id="" class="ms-3">
                    </div>
                    <div class="col-12 pt-4 d-flex justify-content-start">
                        <div class="form-floating mb-3 w-100">
                            <textarea class="form-control" id="floatingInput" placeholder="Description Product" style="height: 20vh" aria-label="With textarea" name="addDescription" id="addDescription"><?=$_SESSION["editData"]["description_produk"]?></textarea>
                            <label for="floatingInput">Description Product</label>
                        </div>
                    </div>
                    <div class="col-12 pt-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-outline-success py-2 px-5 me-3" name="submitProduk" onclick="">Add Product</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>