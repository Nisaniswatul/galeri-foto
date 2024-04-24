<?php
session_start();
include 'koneksi.php';
$fotoid = $_GET['foto_id'];
$userid = $_SESSION['user_id'];

$ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE foto_id='$fotoid' AND user_id='$userid'");

if (mysqli_num_rows($ceksuka) == 1){
    while ($row = mysqli_fetch_array($ceksuka)){
        $likeid = $row ['like_id'];
        $query = mysqli_query($koneksi, "DELETE FROM like_foto WHERE like_id='$likeid'");
        echo "<script>
        window.location.href='../admin/index.php'; 
        </script>";
    }
    }else {
        $tanggallike = date('Y-m-d');
$query = mysqli_query($koneksi, "INSERT INTO like_foto VALUES('','$fotoid','$userid','$tanggallike')");

echo "<script>
window.location.href='../admin/index.php'; 
</script>";
    }

?>