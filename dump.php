<!-- MAILER -->
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

<script>
    function submit() {
        nama = document.getElementsByName("name")[0].value;
        email = document.getElementsByName("email")[0].value;
        teks = document.getElementsByName("textarea")[0].value;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementsByName("name")[0].value = "";
            document.getElementsByName("email")[0].value = "";
            document.getElementsByName("textarea")[0].value = "";
        }
        xhttp.open("GET", "Mailer/Mailer/emailku.php?nama=" + nama + "&email=" + email + "&teks=" + teks);
        xhttp.send();
    }
</script>