<?php
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])){
    $judulfoto = $_POST['judul_foto'];
    $deskripsifoto = $_POST['deskripsi_foto'];
    $tanggalunggah = date('Y-m-d');
    $albumid = $_POST['album_id'];
    $userid = $_SESSION['user_id'];
    $foto = $_FILES['lokasi_file']['name'];
    $tmp = $_FILES['lokasi_file']['tmp_name'];
    $lokasi = '../assets/img/';
    $namafoto = rand().'-'.$foto;

    move_uploaded_file($tmp, $lokasi.$namafoto);

    $sql = mysqli_query($koneksi, "INSERT INTO foto VALUES ('','$judulfoto','$deskripsifoto','$tanggalunggah','$namafoto','$albumid','$userid')");

    echo "<script>
    alert('Data Berhasil Disimpan!');
    window.location.href='../admin/foto.php';
    </script>";

}

if (isset($_POST['edit'])){
    $fotoid = $_POST['foto_id'];
    $judulfoto = $_POST['judul_foto'];
    $deskripsifoto = $_POST['deskripsi_foto'];
    $tanggalunggah = date('Y-m-d');
    $albumid = $_POST['album_id'];
    $userid = $_SESSION['user_id'];
    $foto = $_FILES['lokasi_file']['name'];
    $tmp = $_FILES['lokasi_file']['tmp_name'];
    $lokasi = '../assets/img/';
    $namafoto = rand().'-'.$foto;

    if ($foto == null){
        $sql = mysqli_query($koneksi, "UPDATE foto SET judul_foto='$judulfoto',deskripsi_foto='$deskripsifoto', tanggal_unggah='$tanggalunggah',album_id='$albumid' WHERE foto_id='$fotoid'");
    }else{
        $query=mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id='$fotoid'");
        $data=mysqli_fetch_array($query);
        if (is_file('../assets/img/'.$data['lokasi_file'])){
            unlink('../assets/img/'.$data['lokasi_file']);
        }
        move_uploaded_file($tmp, $lokasi.$namafoto);
        $sql = mysqli_query($koneksi, "UPDATE foto SET judul_foto='$judulfoto',deskripsi_foto='$deskripsifoto', tanggal_unggah='$tanggalunggah',lokasi_file='$namafoto',album_id='$albumid' WHERE foto_id='$fotoid'");
    }
    echo "<script>
    alert('Data Berhasil Diperbarui!');
    window.location.href='../admin/foto.php';
    </script>";


}

if (isset($_POST['hapus'])){
    $fotoid = $_POST['foto_id'];
    $query=mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id='$fotoid'");
    $data=mysqli_fetch_array($query);
    if (is_file('../assets/img/'.$data['lokasi_file'])){
        unlink('../assets/img/'.$data['lokasi_file']);
    }
    $sql = mysqli_query($koneksi, "DELETE FROM  foto WHERE foto_id='$fotoid'");
    echo "<script>
    alert('Data Berhasil Dihapus!');
    window.location.href='../admin/foto.php';
    </script>";

}








