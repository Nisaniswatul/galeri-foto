<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | UKK Nisa N</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="favicon.ico" rel="shortcut icon">
</head>
<body style="background-color:#fef2f9;">
<nav class="navbar navbar-expand-lg shadow p-3 mb-5 rounded" style="background-color:#fcdef0;">
  <div class="container">
    <a class="navbar-brand" href="index.php">Register 👥</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        
      </div>
      <a href="register.php" class="btn btn-primary m-1">Daftar</a>
      <a href="login.php" class="btn btn-success m-1">Login</a>
      <a href="index.php" class="btn btn-danger m-1">Kembali</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4 ">
            <div class="card shadow rounded">
                <div class="card-body bg-light">
                <div class="text-center">
                    <h5>Register</h5>
                </div>
                <form action="config/aksi_register.php" method="post">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <label class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" required>
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                    <div class="d-grid mt-2">
                        <button class="btn btn-primary" type="submit" name="kirim">Daftar</button>
                    </div>
                </form>
                <hr>
                <p>Sudah Punya Akun? <a href="login.php">Login Disini!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
<p class="mt-2">&copy; UKK | Nisa 12 RPL 3</p>
</footer>
    
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>