<?php
require("functions.php");

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $users = query("SELECT * FROM users");

    $exist = false;
    if ($username == "admin" && $password == "nimda") {
        $safe = false;
        header("Location: adminHome.php");
    } else if ($username == "" || $password == "") {
        $safe = false;
        alert("Semua Field Harus Terisi!");
    } else {
        foreach ($users as $user) {
            if ($username == $user["username"] || $username == $user["email"]) {
                $exist = true;
                if ($password == $user["password"]) {
                    if ($username == $user["email"]) {
                        $username = $user["username"];
                    }
                    header("Location: user.php?username=$username");
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="loginStyle.css">
</head>

<body>
    <div class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form action="" method="post" class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Username/Email" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Login</button>
                            </form>

                            <div>
                                <p class="mb-0">Don't have an account? <a href="register.php" class="text-white-50 fw-bold">Sign Up</a>
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