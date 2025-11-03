<?php
session_start();
include 'include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];

    if ($password !== $konfirmasi) {
        die("Password dan konfirmasi tidak cocok.");
    }

    $user = mysqli_query($conn, "SELECT * FROM users WHERE reset_token='$token'");
    $data = mysqli_fetch_assoc($user);

    if ($data) {
        // Update password baru dan hapus token
        $query = "UPDATE users SET password='$password', reset_token=NULL, token_expired=NULL WHERE reset_token='$token'";
        mysqli_query($conn, $query);
        echo "Password berhasil diperbarui. <a href='index.php'>Login di sini</a>";
    } else {
        echo "Token tidak valid.";
    }
} else {
    echo "Akses ditolak!";
}
?>
