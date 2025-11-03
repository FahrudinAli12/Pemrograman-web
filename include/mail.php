<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
 // Sesuaikan path-nya jika kamu pakai composer

function sendResetEmail($emailTujuan, $token) {
    $mail = new PHPMailer(true);
    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mfahrudinali7@gmail.com';     // Ganti dengan emailmu
        $mail->Password = 'udgvjjcpxhinrsai';       // Ganti dengan App Password Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('emailkamu@gmail.com', 'Rima Hotel');
        $mail->addAddress($emailTujuan);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Anda';
        $mail->Body    = "Klik link berikut untuk reset password Anda:<br><a href='http://localhost/hotel/form_password_baru.php?token=$token'>Reset Password</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
