<?php
require("functions.php");

if (isset($_POST["register"])) {
    $safe = true;

    $username = $_POST["username"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if ($username == "" || $name == "" || $email == "" || $password == "" || $confirmPassword == "") {
        $safe = false;
        alert("Semua Field Harus Terisi!");
    } else if ($username == 'admin') {
        $safe = false;
        alert("Admin Can\'t be Used!");
    } else if ($password != $confirmPassword) {
        $safe = false;
        alert("Password Not Match!");
    }

    $users = query("SELECT * FROM users");

    foreach ($users as $user) {
        if ($username == $user["username"]) {
            $safe = false;
            alert("Username Sudah Terdaftar!");
        }
        if ($email == $user["email"]) {
            $safe = false;
            alert("Email Sudah Terdaftar!");
        }
    }

    if ($safe) {
        if (insertUser($_POST) > 0) {
            alert("Berhasil Register!");
            echo "<script> document.location.href = 'login.php'; </script>";
        } else {
            alert("Gagal Register!");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="registerStyle.css">
</head>

<body>
    <div class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <form action="" method="post" class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                                <p class="text-white-50 mb-5">Please enter your data!</p>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Name" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="confirmPassword" class="form-control form-control-lg" placeholder="Confirm Password" />
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit" name="register">Register</button>
                            </form>

                            <div>
                                <p class="mb-0">Already have an account? <a href="login.php" class="text-white-50 fw-bold">Login</a>
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