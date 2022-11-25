<?php
require("functions.php");

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $users = query("SELECT * FROM user");

    $exist = false;
    //buat admin
    if ($username == "" || $password == "") {
        $safe = false;
        alert("Semua Field Harus Terisi!");
        //buat user
    // }else if($username == "admin" && $password == "admin123"){
    //     $_SESSION["dataAdmin"] = [];
    //     $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
    //     header("Location: admin.php");
    } else {
        foreach ($users as $user) {
            if ($username == $user["username"] || $username == $user["email"]) {
                $exist = true;
                if ($password == $user["password"]) {
                    $_SESSION["login"] = true;
                    $_SESSION["idUser"] = $user["id_user"];
                    header("Location: index.php");
                } else {
                    alert("Wrong Password!");
                }
            }
        }
    }

    if ($exist == false && $username != "" && $password != "") {
        alert("User Tidak Terdaftar!");
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
    <title>Login</title>

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
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your username and password!</p>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username/Email" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                                </div>
                                <div class="row">
                                    <div class="col-5 col-xl-4 mb-3 d-flex justify-content-start"><button class="btn btn-outline-light btn-lg px-4" type="submit" name="login">Login</button></div>
                                    <div class="col-5 mb-3 d-flex justify-content-start"><button class="btn btn-outline-light btn-lg px-4" type="submit" name="back">Back</button></div>
                                </div>
                            </form>

                            <div>
                                <p class="mb-0">Don't have an account? <a href="register.php" class="fw-bold">Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</html>