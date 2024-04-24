<?php
session_start();
$userid = $_SESSION['user_id'];
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
  echo "<script>
        alert('Anda Belum Login!');
        window.location.href='../index.php';
        </script>";
}
// Query untuk mengambil informasi pengguna dari database
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id = '$userid'");
if (!$query) {
  // Handle kesalahan jika query gagal
  die("Gagal mengambil data pengguna: " . mysqli_error($koneksi));
}

// Ambil data pengguna dari hasil query
$row = mysqli_fetch_assoc($query);
$namalengkap = $row['nama_lengkap'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery | UKK Nisa N</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="favicon.ico" rel="shortcut icon">
</head>

<body style="background-color:#fef2f9;">
  <nav class="navbar navbar-expand-lg  shadow rounded" style="background-color:#f5d3ce;">
    <div class="container">
      <a class="navbar-brand" href="index.php"><b>All Gallery ˚˖𓍢ִ໋🖼️༘⋆</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
        <div class="navbar-nav me-auto">
          <a href="home.php" class="nav-link">Home 🏠</a>
          <a href="album.php" class="nav-link">Album 🏞️</a>
          <a href="foto.php" class="nav-link">Foto 📸</a>
          <p class="nav-link"><?php echo ucwords($row['nama_lengkap']); ?> 👨🏻‍💼</p>

        </div>
        <a href="../config/aksi_logout.php" class="btn m-1 shadow rounded" style="background-color:#ec9488;">Logout <i class="bi bi-box-arrow-right"></i></a>
      </div>
    </div>
  </nav>

  
  <h3><p class="text-center mt-3">Selamat datang di Galeri Foto, <b><?php echo $row['nama_lengkap']; ?>!!</b></p></h3> 



  <div class="container ">
    <div class="row">
      <?php
      $query = mysqli_query($koneksi, "SELECT * FROM foto INNER JOIN user ON foto.user_id=user.user_id INNER JOIN album ON foto.album_id=album.album_id");
      while ($data = mysqli_fetch_array($query)) {
        ?>
        <div class="col-md-3 ">
          <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>">
          <div class="card mb-2 shadow p-2 rounded">
            <img style="height:12rem;" src="../assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top"
              title="<?php echo $data['judul_foto'] ?>">
            <div class="card-footer text-center">
              <?php
              $fotoid = $data['foto_id'];
              $ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$fotoid' AND user_id='$userid'");
              if (mysqli_num_rows($ceksuka) == 1) { ?>
                <a style="text-decoration:none" href="../config/proses_like.php?foto_id=<?php echo $data['foto_id'] ?>"
                  type="submit" name="batal_suka"><i class="bi bi-heart-fill"></i></a>
              <?php } else { ?>
                <a style="text-decoration:none" href="../config/proses_like.php?foto_id=<?php echo $data['foto_id'] ?>"
                  type="submit" name="suka"><i class="bi bi-heart"></i></a>
              <?php }
              $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$fotoid'");
              echo mysqli_num_rows($like) . ' Suka';
              ?>

               <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id'] ?>"><i
                  class="bi bi-chat"></i> </a>
                  <?php
                  $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id='$fotoid'");
                  echo mysqli_num_rows($jmlkomen).' Komentar';
                  ?>
            </div>
          </div>
          </a>
          
                <!-- Modal -->
            <div class="modal fade" id="komentar<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-body">
                   <div class="row">
                    <div class="col-md-8">
                    <img src="../assets/img/<?php echo $data['lokasi_file'] ?>" class="card-img-top"
                    title="<?php echo $data['judul_foto'] ?>">
                    </div>

                    <div class="col-md-4">
                      <div class="m-2">
                        <div class="overflow-auto">
                          <div class="sticky-top">
                           <strong><?php echo $data['judul_foto'] ?></strong> <br>
                           <span class="badge bg-secondary"><?php echo $data['nama_lengkap'] ?></span>
                           <span class="badge bg-secondary"><?php echo $data['tanggal_unggah'] ?></span>
                           <span class="badge bg-primary"><?php echo $data['nama_album'] ?></span>
                          </div>
                          <hr>
                          <p align="left">
                            <?php echo $data['deskripsi_foto'] ?>
                          </p>
                          <hr>
                          <?php
                          $fotoid = $data['foto_id'];
                          $komentar = mysqli_query($koneksi, "SELECT * FROM komentar_foto INNER JOIN user ON komentar_foto.user_id=user.user_id WHERE komentar_foto.foto_id='$fotoid'");
                          while($row = mysqli_fetch_array($komentar)){ ?>
                          <p align="left">
                            <strong><?php echo $row['nama_lengkap'] ?></strong>
                            <?php echo $row['isi_komentar'] ?>
                          </p>
                          <?php }?>
                          <hr>
                          <div class="sticky-bottom">
                            <form action="../config/proses_komentar.php " method="post">
                              <div class="input-group">
                                <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
                                <input type="text" name="isi_komentar" class="form-control" placeholder="Tambah Komentar">
                                <div class="input-group-prepend">
                                  <button type="submit" name="kirim_komentar" class="btn btn-outline-primary">Kirim</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    </div>
                   </div>
                  </div>

                </div>
              </div>
            </div>


        </div>
      <?php } ?>
    </div>
  </div>

  <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
  <p class="mt-2">&copy; UKK | Nisa 12 RPL 3</p>
  </footer>

  <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>