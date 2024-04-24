<?php
    session_start();
    $userid = $_SESSION['user_id'];
    include '../config/koneksi.php';
    if ($_SESSION['status']!= 'login'){
        echo "<script>
        alert('Anda Belum Login!');
        window.location.href='../index.php';
        </script>";
    }

    $userid = $_SESSION['user_id'];
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
    <title>CRUD Foto | UKK Nisa N</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link href="favicon.ico" rel="shortcut icon">
</head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<body style="background-color:#fef2f9;">
<nav class="navbar navbar-expand-lg  shadow rounded" style="background-color:#f5d3ce;">
  <div class="container">
    <a class="navbar-brand" href="index.php"><b>All Gallery ˚˖𓍢ִ໋🖼️༘⋆</b><a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2 " id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a href="album.php" class="nav-link">Home 🏠</a>
        <a href="album.php" class="nav-link">Album 🏞️</a>
        <a href="foto.php" class="nav-link">Foto 📸</a>
        <p class="nav-link"><?php echo ucwords($row['nama_lengkap']); ?> 👨🏻‍💼</p>
        
      </div>
      <a href="../config/aksi_logout.php" class="btn m-1  shadow rounded"style="background-color:#ec9488;">Logout <i class="bi bi-box-arrow-right"></i></a>
    </div>
  </div>
</nav>

<!-- TAMBAH ALBUM -->

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mt-5  shadow rounded">
                <div class="card-header">Tambah Foto</div>
                <div class="card-body">
                    <form action="../config/aksi_foto.php" method="post" enctype="multipart/form-data">
                        <label class="form-label">Judul Foto</label>
                        <input type="text" name="judul_foto" class="form-control" required>
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi_foto" required></textarea>
                        <label class="form-label">Album</label>
                        <select class="form-control" name="album_id" required>
                            <?php
                            $sql_album = mysqli_query($koneksi, "SELECT * FROM album WHERE user_id='$userid' ");
                            while($data_album = mysqli_fetch_array($sql_album)){?>
                            <option value="<?php echo $data_album['album_id']; ?>"><?php echo $data_album['nama_album']; ?></option>
                            <?php 
                            }
                            ?>
                        </select>
                        <label class="form-label">File</label>
                        <input type="file" class="form-control" name="lokasi_file" required>
                        <button type="submit" class="btn btn-primary mt-2  shadow rounded" name="tambah"><i class="bi bi-person-plus"></i> Tambah Data</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mt-5  shadow rounded">
                <div class="card-header">Data Galeri Foto</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Judul Foto</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $userid = $_SESSION['user_id'];
                            $sql = mysqli_query($koneksi, "SELECT * FROM foto WHERE user_id='$userid'");
                            while($data = mysqli_fetch_array($sql)){
                            ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><img src="../assets/img/<?php echo $data['lokasi_file'] ?>" width="100"></td>
                                <td><?php echo $data['judul_foto']?></td>
                                <td><?php echo $data['deskripsi_foto']?></td>
                                <td><?php echo $data['tanggal_unggah']?></td>
                                <td>

                                    <!-- EDIT DATA -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['foto_id'] ?>">
<i class="bi bi-pencil-square"></i></button>

<!-- Modal -->
<div class="modal fade" id="edit<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../config/aksi_foto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
        <label class="form-label">Judul Foto</label>
        <input type="text" name="judul_foto" value="<?php echo $data['judul_foto'] ?>" class="form-control" required>
        <label class="form-label">Deskripsi</label>
        <textarea class="form-control" name="deskripsi_foto" required><?php echo $data['deskripsi_foto']; ?></textarea>
        <label class="form-label">Album</label>
        <select class="form-control" name="album_id">
             <?php
             $userid=$_SESSION['user_id'];
            $sql_album = mysqli_query($koneksi, "SELECT * FROM album WHERE user_id='$userid'");
            while($data_album=mysqli_fetch_array($sql_album)){?>
            <option <?php if($data_album['album_id'] == $data['album_id']){ ?> selected='selected'<?php } ?> value="<?php echo $data_album['album_id'] ?>"><?php echo $data_album['nama_album'] ?></option>
            <?php 
            }
            ?>
        </select>
        <label class="form-label">Foto</label>
        <div class="row">
            <div class="col-md-4">
            <img src="../assets/img/<?php echo $data['lokasi_file'] ?>" width="100">
            </div>
            <div class="col-md-8">
            <label class="form-label">Ganti File</label>
             <input type="file" class="form-control" name="lokasi_file">
            </div>
        </div>
        

      </div>
      <div class="modal-footer">
        <button type="submit" name="edit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit Data</button>
        </form>
     </div>
        </div>
            </div>
                 </div>

                 <!-- HAPUS DATA -->

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['foto_id'] ?>"><i class="bi bi-trash3-fill"></i></button>
<div class="modal fade" id="hapus<?php echo $data['foto_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../config/aksi_foto.php" method="post">
        <input type="hidden" name="foto_id" value="<?php echo $data['foto_id'] ?>">
        Apakah anda yakin akan menghapus data <strong> <?php echo $data['judul_foto'] ?> ? </strong>
      </div>
      <div class="modal-footer">
        <button type="submit" name="hapus" class="btn btn-primary"><i class="bi bi-trash3-fill"></i> Hapus Data?</button>
        </form>
                                </div>
                                </div>
                            </div>
                            </div>

                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
<p class="mt-2">&copy; UKK | Nisa 12 RPL 3</p>
</footer>
    
<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>