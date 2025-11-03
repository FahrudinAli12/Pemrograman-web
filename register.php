<?php
session_start();
include('include/db.php'); // pastikan file ini ada dan koneksi $conn berhasil

// Ambil data dari form
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$konfirmasi = mysqli_real_escape_string($conn, $_POST['konfirmasi']);

// Cek apakah password dan konfirmasi cocok
if ($password !== $konfirmasi) {
    echo "Password dan konfirmasi tidak cocok!";
    exit;
}

// Cek apakah email sudah terdaftar
$cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "Email sudah terdaftar!";
    exit;
}

// Simpan ke database (password tanpa hash → untuk testing saja)
$query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')";
if (mysqli_query($conn, $query)) {
    $_SESSION['username'] = $nama; // login otomatis
    header("Location: index.php");
    exit;
} else {
    echo "Registrasi gagal: " . mysqli_error($conn);
}
?>
