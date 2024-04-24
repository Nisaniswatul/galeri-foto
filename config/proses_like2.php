<?php
include 'koneksi.php';

// Tentukan user ID secara default
$userid = 20;

// Periksa apakah parameter foto_id tersedia
if(isset($_GET['foto_id'])) {
    $fotoid = $_GET['foto_id'];

    // Validasi parameter
    if(!is_numeric($fotoid)) {
        die("Parameter foto_id tidak valid.");
    }

    // Periksa apakah pengguna sudah menyukai foto ini sebelumnya
    $ceksuka = mysqli_prepare($koneksi, "SELECT like_id FROM like_foto WHERE foto_id=? AND user_id=?");
    mysqli_stmt_bind_param($ceksuka, "ii", $fotoid, $userid);
    mysqli_stmt_execute($ceksuka);
    mysqli_stmt_store_result($ceksuka);

    if (mysqli_stmt_num_rows($ceksuka) == 1) {
        // Jika sudah menyukai, hapus suka
        mysqli_stmt_bind_result($ceksuka, $likeid);
        mysqli_stmt_fetch($ceksuka);
        mysqli_stmt_close($ceksuka);

        $hapusSuka = mysqli_prepare($koneksi, "DELETE FROM like_foto WHERE like_id=?");
        mysqli_stmt_bind_param($hapusSuka, "i", $likeid);
        $result = mysqli_stmt_execute($hapusSuka);
        mysqli_stmt_close($hapusSuka);

        if($result) {
            // Jika berhasil, redirect ke index.php
            header("Location: ../index.php");
            exit(); // menghentikan eksekusi setelah redirect
        } else {
            // Jika gagal, keluarkan pesan kesalahan
            die("Gagal menghapus suka.");
        }
    } else {
        // Jika belum menyukai, tambahkan suka
        $tanggallike = date('Y-m-d');
    
        $tambahSuka = mysqli_prepare($koneksi, "INSERT INTO like_foto (foto_id, user_id, tanggal_like) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($tambahSuka, "iis", $fotoid, $userid, $tanggallike);
        $result = mysqli_stmt_execute($tambahSuka);
        mysqli_stmt_close($tambahSuka);

        if($result) {
            // Jika berhasil, redirect ke index.php
            header("Location: ../index.php");
            exit();
        } else {
            // Jika gagal, keluarkan alert
            die("Gagal menambah suka.");
        }
    }
} else {
    // Mengecek Parameter, Jika tidak ada alert gagal
    die("Parameter foto_id tidak tersedia.");
}
?>
