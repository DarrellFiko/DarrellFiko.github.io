<?php
require("functions.php");

$showModal = "";

if (isset($_POST["register"])) {
    $safe = true;

    $username = $_POST["username"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $alamat = $_POST["alamat"];
    $telp = $_POST["noTelp"];
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST["confirmPassword"]);

    if ($username == "" || $name == "" || $email == "" || $alamat == "" || $telp == "" || $password == "" || $confirmPassword == "") {
        $safe = false;
        $showModal = "empty";
        // alert("All fields must be filled!");
    } else if ($username == 'admin') {
        $safe = false;
        $showModal = "admin";
        // alert("Admin Can\'t be Used!");
    } else if ($password != $confirmPassword) {
        $safe = false;
        $showModal = "notMatch";
        // alert("Password Not Match!");
    }

    $users = query("SELECT * FROM user");

    foreach ($users as $user) {
        if ($username == $user["username"]) {
            $safe = false;
            $showModal = "userAlreadyRegistered";
            // alert("Username Already Registered!");
        }
        if ($email == $user["email"]) {
            $safe = false;
            $showModal = "emailAlreadyRegistered";
            // alert("Email Already Registered!");
        }
    }

    if ($safe) {
        $showModal = "sukses";

        $username = strtolower(stripslashes($username));
        $password = password_hash($password, PASSWORD_DEFAULT);

        $tempUser = [
            "username" => $username,
            "full_name" => $name,
            "email" => $email,
            "alamat" => $alamat,
            "nomor_telepon" => $telp,
            "password" => $password
        ];
        insert($tempUser, 'user');
        // $stmt = $conn->prepare("INSERT INTO user(username, full_name, email, alamat, nomor_telepon, password) VALUES(?,?,?,?,?,?)");
        // $stmt->bind_param("ssssss", $username, $name, $email, $alamat, $telp, $password);
        // $stmt->execute();
        echo "<script> document.location.href = 'login.php'; </script>";
    }
}
if (isset($_POST["back"])) {
    // header("Location: index.php");
    echo "<script>document.location.href = 'index.php'</script>";
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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="" method="post">
        <div class="min-vh-100 bgGradient">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card glass bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <form action="" method="post" class="mb-md-5 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                                    <p class="text-white-50 mb-5">Please enter your data!</p>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="name" class="form-control form-control-lg" placeholder="Full Name" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="alamat" class="form-control form-control-lg" placeholder="Address" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="noTelp" class="form-control form-control-lg" placeholder="Phone Number" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="confirmPassword" class="form-control form-control-lg" placeholder="Confirm Password" />
                                    </div>
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-6">
                                            <button class="btn btn-outline-light btn-lg w-100" type="submit" name="register">Register</button>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-outline-light btn-lg w-100" type="submit" name="back">Back</button>
                                        </div>
                                    </div>
                                </form>

                                <div>
                                    <p class="mb-0 mt-5">Already have an account? <a href="login.php" class="fw-bold">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
    <!-- Modal Admin -->
    <div class="modal fade" id="modalAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">Username Admin Can't be Used!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal NotMatch -->
    <div class="modal fade" id="modalNotMatch" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">Password Not Match!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal userAlreadyRegistered -->
    <div class="modal fade" id="modalUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">Username Already Registered!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal emailAlreadyRegistered -->
    <div class="modal fade" id="modalEmail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">Email Already Registered!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Sukses -->
    <div class="modal fade" id="modalSukses" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tengah p-4">
                        <h4 class="text-center">Register Successfull!</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-none border-0 w-100 fw-bold fs-5" data-bs-dismiss="modal">OK</button>

                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
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
if ($showModal == "admin") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalAdmin").modal("show");
    	});
    </script>';
}
if ($showModal == "notMatch") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalNotMatch").modal("show");
    	});
    </script>';
}
if ($showModal == "userAlreadyRegistered") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalUser").modal("show");
    	});
    </script>';
}
if ($showModal == "emailAlreadyRegistered") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalEmail").modal("show");
    	});
    </script>';
}
if ($showModal == "sukses") {
    echo
    '<script type="text/javascript">
        $(document).ready(function(){
    		$("#modalSukses").modal("show");
    	});
    </script>';
}
?>

</html>