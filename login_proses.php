<?php
session_start();
include('include/db.php');

$email = $_POST['email'];
$password = $_POST['password'];

// Kondisi untuk admin langsung tanpa cek database
if ($email === 'admin@gmail.com' && $password === 'admin123') {
    $_SESSION['username'] = 'admin';
    header("Location: dashboard_admin.php?page=hotel");
    exit;
}

// Login user biasa dari database
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Jika data user ditemukan dan password cocok
if ($user && $password === $user['password']) {
    $_SESSION['username'] = $user['nama']; // atau $user['email']
    header("Location: index.php");
    exit;
} else {
    echo "<script>alert('Login gagal! Email atau password salah.'); window.location.href='index.php';</script>";
}
?>

