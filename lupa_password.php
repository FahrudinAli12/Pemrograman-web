<?php
date_default_timezone_set('Asia/Jakarta');
include 'include/db.php';
include 'include/mail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(16));
    $expired = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE users SET reset_token='$token', token_expired='$expired' WHERE email='$email'");
        sendResetEmail($email, $token);

        // Redirect kembali ke index dengan status notifikasi
        header("Location: index.php?reset=success");
    } else {
        header("Location: index.php?reset=failed");
    }
    exit;
}
?>
