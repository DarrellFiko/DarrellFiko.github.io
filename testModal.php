<?php
require("functions.php");

$showModal = "";

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $users = query("SELECT * FROM user");

    $exist = false;
    //buat admin
    if ($username == "" || $password == "") {
        $safe = false;

        $showModal = "empty";
        // alert("All Fields Must Be Filled!");
        //buat user
        // }else if($username == "admin" && $password == "admin123"){
        //     $_SESSION["dataAdmin"] = [];
        //     $_SESSION["dataAdmin"] = query("SELECT * FROM produk");
        //     header("Location: admin.php");
    } else {
        foreach ($users as $user) {
            if ($username == $user["username"] || $username == $user["email"]) {
                $exist = true;
                if (password_verify($password, $user["password"]) && $user["status_user"] == "1") {
                    $_SESSION["login"] = true;
                    $_SESSION["idUser"] = $user["id_user"];
                    header("Location: index.php");
                } else {
                    if (password_verify($password, $user["password"]) == false) {
                        $showModal = "wrong";
                        // alert("Wrong Password!");
                    } else if ($user["status_user"] == 0) {
                        $showModal = "banned";
                        // alert("Your Account Was Permanently Banned!");
                    }
                }
            }
        }
    }

    if ($exist == false && $username != "" && $password != "") {
        $showModal = "unregistered";
        // alert("Unregistered User!");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
                                <div class="row d-flex justify-content-between">
                                    <div class="col-6">
                                        <button class="btn btn-outline-light btn-lg w-100" type="submit" name="login">Login</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-light btn-lg w-100" type="submit" name="back">Back</button>
                                    </div>
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

    <!-- Modal Empty -->
    <div class="modal fade" id="modalEmpty" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">All Fields Must Be Filled!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Wrong -->
    <div class="modal fade" id="modalWrong" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">Wrong Password!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Banned -->
    <div class="modal fade" id="modalBanned" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">Your account was permanently banned due to multiple violations of our Community Guidelines.</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Unregistered -->
    <div class="modal fade" id="modalUnregistered" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">Unregistered User!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>

</body>
<script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="jquery-3.6.1.min.js"></script>
<script>
    // $('#btnTest').click(function() {
    //     $('#testingModal').modal('show');
    // });
</script>
<?php
if ($showModal == "empty") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalEmpty").modal("show");
    	});
    </script>';
}
if ($showModal == "wrong") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalWrong").modal("show");
    	});
    </script>';
}
if ($showModal == "banned") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalBanned").modal("show");
    	});
    </script>';
}
if ($showModal == "unregistered") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalUnregistered").modal("show");
    	});
    </script>';
}
?>

</html>