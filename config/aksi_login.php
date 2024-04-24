<?php
session_start();
include 'koneksi.php';

// Periksa apakah variabel POST yang dibutuhkan sudah tersedia
if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");

    $cek = mysqli_num_rows($sql);

    if ($cek > 0){
        $data = mysqli_fetch_array($sql);
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['user_id'];
         $_SESSION['status'] = 'login';
        echo "<script>
        alert('Login Berhasil');
        window.location.href='../admin/index.php'; // perbaikan location.href
        </script>";
    }else{
        echo "<script>
        alert('Username atau Password salah!');
        window.location.href='../login.php'; // perbaikan location.href
        </script>";
    }
} else {
    echo "Username atau Password tidak ditemukan"; // Pesan kesalahan jika tidak ada username atau password yang diterima
}
?>