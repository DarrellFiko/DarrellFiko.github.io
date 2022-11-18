<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"
</head>
<body>
<!-- Modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreenMd">Full screen below md</button>
    <!-- Full screen modal -->
    <div class="modal fade" id="exampleModalFullscreenMd" tabindex="-1" aria-labelledby="exampleModalFullscreenMdLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Input your data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="usernamePembelian" class="form-control form-control-lg" placeholder="Username" />
                </div>
                <div class="modal-body">
                    <input type="text" name="namePembelian" class="form-control form-control-lg" placeholder="Full Name" />
                </div>
                <div class="modal-body">
                    <input type="email" name="emailPembelian" class="form-control form-control-lg" placeholder="Email" />
                </div>
                <div class="modal-body">
                    <input type="text" name="alamatPembelian" class="form-control form-control-lg" placeholder="Alamat" />
                </div>
                <div class="modal-body">
                    <input type="text" name="noTelpPembelian" class="form-control form-control-lg" placeholder="Nomor Telepon" />
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Buy</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>