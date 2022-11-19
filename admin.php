<?php
    require("functions.php");

    if(!isset($_SESSION["dataAdmin"])){
        $_SESSION["dataAdmin"] = [];
        $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
    }
    if (!isset($_SESSION["pagingAdmin"])) {
        resetPagingAdmin();
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
    }
    if (isset($_POST["page2"])) {
        $_SESSION["pageAdminSekarang"] = $_SESSION["pagingAdmin"][2]["page"];
        // alert($_SESSION["pageSekarang"]);
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
        if ($_SESSION["pagingAdmin"][0]["page"] > 1 && $_SESSION["pageSekarang"] != 1) {
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
            if ($_SESSION["pagingAdmin"][$maks - 2]["page"] <= $maks && $_SESSION["pageSekarang"] < $maks - 1) {
                $_SESSION["pageAdminSekarang"]++;
            }
        } else {
            if ($_SESSION["pagingAdmin"][4]["page"] < $maks - 1 && $_SESSION["pageSekarang"] != $maks) {
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
    }
    if (isset($_POST["pageTerakhir"])) {
        $maks = (int)$maks;
        $_SESSION["pageAdminSekarang"] = $maks;
        $_SESSION["pagingAdmin"][0]["page"] = $maks - 4;
        $_SESSION["pagingAdmin"][1]["page"] = $maks - 3;
        $_SESSION["pagingAdmin"][2]["page"] = $maks - 2;
        $_SESSION["pagingAdmin"][3]["page"] = $maks - 1;
        $_SESSION["pagingAdmin"][4]["page"] = $maks;
    }

    if(isset($_POST["logout"])){
        header("Location: index.php");
    }

    if(isset($_POST["submitBrand"])){
        $tempNameBrand = $_POST["addBrand"];
        if($tempNameBrand==""){
            alert("Add Brand Failed!");
        }else{
            $bikinId = "BRN";
            $tempBrand = query("SELECT * FROM brand");
            $idBrandAkhir = $tempBrand[count($tempBrand)-1]["id_brand"];
    
            $urutanIdBrand = (int)substr($idBrandAkhir,3);
            $urutanIdBrand++;
    
            if($urutanIdBrand<10){
                $bikinId = $bikinId.("00".$urutanIdBrand);
            }else if($urutanIdBrand<100){
                $bikinId = $bikinId.("0".$urutanIdBrand);
            }else{
                $bikinId = $bikinId.$urutanIdBrand;
            }
            $brandBaru = [
                "id_brand" => $bikinId,
                "name_brand" => $tempNameBrand
            ];
            insertBrand($brandBaru);
            alert("Add Brand Success!");
        }
    }
    if(isset($_POST["submitKategori"])){
        $tempNameKategori = $_POST["addKategori"];
        if($tempNameKategori==""){
            alert("Add Categories Failed!");
        }else{
            $bikinId = "KTG";
            $tempKategori = query("SELECT * FROM kategori");
            $idKategoriAkhir = $tempKategori[count($tempKategori)-1]["id_kategori"];
    
            $urutanIdKategori = (int)substr($idKategoriAkhir,3);
            $urutanIdKategori++;
    
            if($urutanIdKategori<10){
                $bikinId = $bikinId.("00".$urutanIdKategori);
            }else if($urutanIdKategori<100){
                $bikinId = $bikinId.("0".$urutanIdKategori);
            }else{
                $bikinId = $bikinId.$urutanIdKategori;
            }
            $KategoriBaru = [
                "id_kategori" => $bikinId,
                "name_kategori" => $tempNameKategori
            ];
            insertKategori($KategoriBaru);
            alert("Add Categories Success!");
        }
    }

    if(isset($_POST["edit"])){
        $id = $_POST["idData"];
        $stmt = $conn->query("SELECT * FROM produk WHERE id_produk='$id'");
        $_SESSION["editData"] = $stmt->fetch_assoc();
        header("Location: editData.php");
    }

    if(isset($_POST["delete"])){
        $id = $_POST["idData"];
        
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
        <!-- Input -->
        <div class="d-flex justify-content-center">
            <div class="container text-center p-5 my-5 glass">
                <div class="row d-flex justify-content-start mb-5">
                    <div class="col-2">
                        <h1 class="text-danger">Admin</h1>
                    </div>
                    <div class="col-8 d-flex justify-content-start">
                        <button type="submit" class="btn btn-outline-danger px-5" style="font-size: 25px;" name="logout">Logout</button>
                    </div>
                </div>
                <!-- Add Product -->
                <div class="col-12 border border-2 p-5 mb-5">
                    <div class="col-12 text-success">
                        <h1>Add Product</h1>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="form-floating mb-3 w-100">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Name Product" name="addName" id="addName">
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
                                Stock : <input type="number" onclick="" class="mx-3" style="width: 7vw; height: 5vh;" name="addStock" id="addStock" min="1">
                            </div>
                            <div class="col-6 col-xl-3 d-flex justify-content-end align-items-center" style="font-size: 20px;">
                                Price : $ <input type="number" onclick="" class="mx-3" style="width: 8vw; height: 5vh;" name="addPrice" id="addPrice" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-start pt-4" style="font-size: 20px;">
                        Image : <input type="file" name="" id="" class="ms-3">
                    </div>
                    <div class="col-12 pt-4 d-flex justify-content-start">
                        <div class="form-floating mb-3 w-100">
                            <textarea class="form-control" id="floatingInput" placeholder="Description Product" style="height: 20vh" aria-label="With textarea" name="addDescription" id="addDescription"></textarea>
                            <label for="floatingInput">Description Product</label>
                        </div>
                    </div>
                    <div class="col-12 pt-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-outline-success py-2 px-5 me-3" name="submitProduk" onclick="">Add Product</button>
                        <button type="submit" class="btn btn-outline-success py-2 px-5" name="clear" onclick="clearForm();">Clear</button>
                    </div>
                </div>

                <div class="col-12 border border-2 p-5">
                    <div class="row">
                        <!-- Add Brand -->
                        <div class="col-6 border-end border-3">
                            <div class="row d-flex justify-content-center">
                                <div class="col-12 mb-3 text-success">
                                    <h1>Add Brand</h1>
                                </div>
                                <div class="col-8">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control " id="floatingInput" placeholder="Name Brand" name="addBrand" id="addBrand">
                                        <label for="floatingInput">Name Brand</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-outline-success py-3" name="submitBrand" onclick="">Add Brand</button>
                                </div>
                            </div>
                        </div>
                        <!-- Add Categories -->
                        <div class="col-6 ps-5">
                            <div class="row d-flex justify-content-center">
                                <div class="col-12 mb-3 text-success">
                                    <h1>Add Categories</h1>
                                </div>
                                <div class="col-8">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="Name Categories" name="addKategori" id="addKategori">
                                        <label for="floatingInput">Name Categories</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-outline-success py-3" name="submitKategori" onclick="">Add Categories</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Data produk -->
        <div class="d-flex justify-content-center">
            <div class="container text-center p-5 my-5 glass">
                <div class="row d-flex justify-content-center">
                    <div class="col-12">
                        <h1>Product Data</h1>
                    </div>
                    <div class="col-12">
                        <?php
                        if (($_SESSION["pageAdminSekarang"]) * 30 < $_SESSION["productCount"]) {
                        ?>
                            <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= ($_SESSION["pageAdminSekarang"]) * 30 ?> of <?= $_SESSION["productCount"] ?></h5>
                        <?php
                        } else {
                        ?>
                            <h5>Result <?= ($_SESSION["pageAdminSekarang"] - 1) * 30 + 1 ?> - <?= $_SESSION["productCount"] ?> of <?= $_SESSION["productCount"] ?></h5>

                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-12">
                    <form class="d-flex" role="search" method="POST">
                        <div class="row">
                            <div class="col-11">
                                <input class="form-control me-2" type="Search" placeholder="Search" aria-label="Search" name="input">
                            </div>
                            <div class="col-1">
                                <button class="btn btn-outline-success" type="submit" name="search">Search</button>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="col-12 text-dark">
                        <hr style="font-weight: bold; color: black;">
                    </div>
                    <table class="table">
                        <tr>
                            <!-- <th>Image Produk</th> -->
                            <th scope="col">ID Produk</th>
                            <th scope="col">Name Produk</th>
                            <th scope="col">Brand Produk</th>
                            <th scope="col">Category Produk</th>
                            <th scope="col">Stok Produk</th>
                            <th scope="col">Price Produk</th>
                            <th scope="col">Action</th>
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
                        $temp++;
                        if (($temp / 30) > $_SESSION["pageAdminSekarang"] - 1 && ($temp / 30) <= $_SESSION["pageAdminSekarang"]) {
                            ?>
                            <form action="" method="post">
                                <input type="hidden" name="idData" value="<?= $id ?>">
                                <tr>
                                    <td><?=$id?></td>
                                    <td><?=$name?></td>
                                    <?php
                                    $stmt = $conn->query("SELECT * FROM brand WHERE id_brand='$id_brand'");
                                    $brand = $stmt->fetch_assoc();
                                    ?>
                                    <td><?=$brand["name_brand"]?></td>
                                    <?php
                                    $stmt = $conn->query("SELECT * FROM kategori WHERE id_kategori='$id_category'");
                                    $kategori = $stmt->fetch_assoc();
                                    ?>
                                    <td><?=$kategori["name_kategori"]?></td>
                                    <td><?=$stok?></td>
                                    <td>$ <?=$price?></td>
                                    <td><button type="submit" class="btn btn-outline-warning ms-3" name="edit">Edit</button><button type="submit" class="btn btn-outline-danger mx-3" name="delete">Delete</button></td>
                                    <!-- <td><?=$description?></td> -->
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
                                        if (($_SESSION["productCount"] / 30) > 1) {
                                        ?>
                                            <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                <li class="page-item"><button type="submit" name="page1" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][1]["page"] ?></button></li>
                                            </div>
                                        <?php
                                        }
                                        if (($_SESSION["productCount"] / 30) > 2) {
                                        ?>
                                            <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                <li class="page-item"><button type="submit" name="page2" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][2]["page"] ?></button></li>
                                            </div>
                                        <?php
                                        }
                                        if (($_SESSION["productCount"] / 30) > 3) {
                                        ?>
                                            <div class="col-1 col-xl-1 d-flex justify-content-center me-2">
                                                <li class="page-item"><button type="submit" name="page3" class="btn text-dark border border-0"><?= $_SESSION["pagingAdmin"][3]["page"] ?></button></li>
                                            </div>
                                        <?php
                                        }
                                        if (($_SESSION["productCount"] / 30) > 4) {
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