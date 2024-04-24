<?php
include 'config/koneksi.php';

// Tentukan user ID secara default
$userid = 20;

$foto = mysqli_query($koneksi, "SELECT * FROM foto ORDER BY foto_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="favicon.ico" rel="shortcut icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | UKK Nisa N</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="favicon.ico" rel="shortcut icon">
</head>
<body style="background-color:#fef2f9;">
<nav class="navbar navbar-expand-lg shadow rounded mb-2" style="background-color:#fcdef0;">
  <div class="container">
    <a class="navbar-brand" href="index.php"><b>Gallery ˙✧˖°📷 ༘ ⋆｡°</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        
      </div>
      <a href="register.php" class="btn btn-primary m-1">Daftar</a>
      <a href="login.php" class="btn btn-success m-1">Login</a>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row">
        <?php while ($data = mysqli_fetch_array($foto)) { ?>
            <div class="col-md-3 mt-5" >
                <div class="card mb-2 shadow p-3 mb-5 rounded">
                    <img style="height:12rem;" src="assets/img/<?php echo $data['lokasi_file']; ?>" class="card-img-top" title="<?php echo $data['judul_foto']; ?>">
                    <div class="card-footer text-center">
                        <?php
                        $fotoid = $data['foto_id'];
                        $ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$fotoid' AND user_id='$userid'");
                        if (mysqli_num_rows($ceksuka) == 1) { ?>
                            <a style="text-decoration:none" href="config/proses_like2.php?foto_id=<?php echo $data['foto_id']; ?>" type="submit" name="batal_suka"><i class="bi bi-heart-fill"></i></a>
                        <?php } else { ?>
                            <a style="text-decoration:none" href="config/proses_like2.php?foto_id=<?php echo $data['foto_id']; ?>" type="submit" name="suka"><i class="bi bi-heart"></i></a>
                        <?php }
                        $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$fotoid'");
                        echo mysqli_num_rows($like) . ' Suka';
                        ?>
                        <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['foto_id']; ?>"><i class="bi bi-chat"></i></a>
                        <?php
                        $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id='$fotoid'");
                        echo mysqli_num_rows($jmlkomen).' Komentar';
                        ?>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="komentar<?php echo $data['foto_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="assets/img/<?php echo $data['lokasi_file']; ?>" class="card-img-top" title="<?php echo $data['judul_foto']; ?>">
                        </div>
                        <div class="col-md-4">
                            <div class="m-2">
                                <div class="overflow-auto">
                                    <div class="sticky-top">
                                        <strong><?php echo $data['judul_foto']; ?></strong> <br>
                                        
                                        <span class="badge bg-secondary"><?php echo $data['tanggal_unggah']; ?></span>
                                        
                                    </div>
                                    <hr>
                                    <p align="left">
                                        <?php echo $data['deskripsi_foto']; ?>
                                    </p>
                                    <hr>
                                    <?php
                                    $fotoid = $data['foto_id'];
                                    $komentar = mysqli_query($koneksi, "SELECT * FROM komentar_foto INNER JOIN user ON komentar_foto.user_id=user.user_id WHERE komentar_foto.foto_id='$fotoid'");
                                    while($row = mysqli_fetch_array($komentar)){ ?>
                                        <p align="left">
                                            <strong><?php echo $row['nama_lengkap']; ?></strong>
                                            <?php echo $row['isi_komentar']; ?>
                                        </p>
                                    <?php }?>
                                    <hr>
                                    <div class="sticky-bottom">
                                        <form action="config/proses_komentar2.php" method="post">
                                            <div class="input-group">
                                                <input type="hidden" name="foto_id" value="<?php echo $data['foto_id']; ?>">
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
        <?php } ?>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
<p class="mt-2">&copy; UKK | Nisa 12 RPL 3</p>
</footer>
    
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
