<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="vh-100 bgContactGradient pt-5">
        <div class=" conatiner">
            <div class="text-center">
                <h3 class="text-primary">Ouch.. You've Got a Problem</h3>
                <p class="lead">Feel free to ask some help</p>
            </div>
            <div id="mailer" class="container bgContactGradient rounded-5 pt-3" style="margin-top: 5vh">
                <div class="row my-5 d-flex justify-content-center">
                    <div class="col-10 px-5 pt-2 pb-3 d-flex bg-transparent justify-content-start rounded-top">
                        <h1 class="text-light">Contact Us</h1>
                    </div>
                    <div class="col-10 px-5 d-flex bg-transparent justify-content-start">
                        <div class="form-floating mb-3 w-100">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Name" name="name">
                            <label for="floatingInput">Name</label>
                        </div>
                    </div>
                    <div class="col-10 px-5 d-flex bg-transparent justify-content-start">
                        <div class="form-floating mb-3 w-100">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
                            <label for="floatingInput">Email address</label>
                        </div>
                    </div>
                    <div class="col-10 px-5 d-flex bg-transparent justify-content-start">
                        <div class="form-floating mb-3 w-100">
                            <textarea class="form-control" id="floatingInput" placeholder="Message" style="height: 20vh" aria-label="With textarea" name="textarea"></textarea>
                            <label for="floatingInput">Message</label>
                        </div>
                    </div>
                    <div class="col-10 pt-3 pb-5 px-5 bg-transparent d-flex justify-content-start rounded-bottom">
                        <button type="submit" class="btn btn-outline-light me-3" name="submit" onclick="submit();">Submit</button>
                        <button type="submit" class="btn btn-outline-light" name="clear" onclick="clearForm();">Clear</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="jquery-3.6.1.min.js"></script>

</html>