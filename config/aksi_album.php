<?php
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])){
    $namaalbum = $_POST['nama_album'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date('Y-m-d');
    $userid = $_SESSION['user_id'];

    $sql = mysqli_query($koneksi, "INSERT INTO album VALUES ('','$namaalbum','$deskripsi','$tanggal','$userid')");

    echo "<script>
    alert('Data Berhasil Disimpan!');
    window.location.href='../admin/album.php';
    </script>";

}


if (isset($_POST['edit'])){
    $albumid = $_POST['album_id'];
    $namaalbum = $_POST['nama_album'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date('Y-m-d');
    $userid = $_SESSION['user_id'];

    $sql = mysqli_query($koneksi, "UPDATE album SET nama_album='$namaalbum',deskripsi='$deskripsi',tanggal_dibuat='$tanggal' WHERE album_id='$albumid'");

    echo "<script>
    alert('Data Berhasil Diperbarui!');
    window.location.href='../admin/album.php';
    </script>";

}

if (isset($_POST['hapus'])){
    $albumid = $_POST['album_id'];

    $sql = mysqli_query($koneksi, "DELETE FROM album WHERE album_id='$albumid'");

    echo "<script>
    alert('Data Berhasil Dihapus!');
    window.location.href='../admin/album.php';
    </script>"; 
}

?>