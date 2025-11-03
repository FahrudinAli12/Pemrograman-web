<?php
session_start();
include('include/db.php');

$email = $_POST['email'];
$password = $_POST['password'];

// Ambil data user berdasarkan email
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user && $password === $user['password']) {
    $_SESSION['username'] = $user['nama']; 
    $_SESSION['email'] = $user['email']; 

    // Cek jika admin login
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        header("Location: dashboard_admin.php?page=hotel");
    } else {
        header("Location: index.php");
    }
    exit;
} else {
    echo "Login gagal! <a href='login.php'>Kembali</a>";
}
