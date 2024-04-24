<?php
include 'koneksi.php';

// Mengambil foto_id, user_id, dan isi_komentar dari POST data
$fotoid = $_POST['foto_id'];
$userid = 20; // Menggunakan nilai 20 untuk user_id
$isikomentar = $_POST['isi_komentar'];
$tanggalkomentar = date('Y-m-d');

// Memasukkan data komentar ke dalam tabel komentar_foto
$query = mysqli_query($koneksi, "INSERT INTO komentar_foto (foto_id, user_id, isi_komentar, tanggal_komentar) VALUES ('$fotoid','$userid','$isikomentar','$tanggalkomentar')");

// Redirect ke halaman admin setelah selesai memasukkan komentar
echo "<script>
window.location.href='../admin/index.php';
</script>"
?>
