<?php
session_start();
include 'koneksi.php';

$fotoid = $_POST['foto_id'];
$userid = $_SESSION['user_id'];
$isikomentar = $_POST['isi_komentar'];
$tanggalkomentar = date('Y-m-d');

$query = mysqli_query($koneksi, "INSERT INTO komentar_foto VALUES('','$fotoid','$userid','$isikomentar','$tanggalkomentar')");

echo "<script>
window.location.href='../admin/index.php';
</script>"
?>