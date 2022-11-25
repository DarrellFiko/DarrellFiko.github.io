<?php
require("functions.php");

if (!isset($_SESSION["authAdmin"])) {
    $_SESSION["authAdmin"] = false;
}

if (isset($_POST["login"])) {

    $password = $_POST["password"];
    //buat admin
    if ($password == "admin123") {
        $_SESSION["authAdmin"] = true;
        header("Location: admin.php");
    } else {
        alert("Wrong password!");
    }
}

if (isset($_POST["back"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="min-vh-100 bgGradient pt-5">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form action="" method="post" class="mb-3 mt-3 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Admin</h2>
                                <p class="text-white-50 mb-5">Please enter your password!</p>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                                </div>
                                <div class="row">
                                    <div class="col-5 col-xl-4 mb-3 d-flex justify-content-start"><button class="btn btn-outline-light btn-lg px-4" type="submit" name="login">Login</button></div>
                                    <div class="col-5 mb-3 d-flex justify-content-start"><button class="btn btn-outline-light btn-lg px-4" type="submit" name="back">Back</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>