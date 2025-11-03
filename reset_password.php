<?php
date_default_timezone_set('Asia/Jakarta');
include 'include/db.php';

$pesan = '';
if (isset($_GET['status']) && $_GET['status'] === 'berhasil') {
    $pesan = 'Password berhasil direset. Silakan login kembali.';
}

if (!isset($_GET['token'])) {
    die("Token tidak ditemukan.");
}

$token = $_GET['token'];

$query = "SELECT * FROM users WHERE reset_token = '$token' AND token_expired > NOW()";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    die("Token tidak valid atau sudah kadaluarsa.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Atur Ulang Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .card {
      max-width: 400px;
      padding: 30px;
    }
    .logo {
      width: 100px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="card shadow-sm">
  <div class="text-center">
    <img class="logo" src="https://github.com/FahrudinAli12/Tugas-UTS-GUI-Semester-3/blob/master/ChatGPT_Image_Jul_12__2025__11_46_41_PM-removebg-preview.png?raw=true" alt="Logo Hotel">
    <h5 class="mb-3">Atur Ulang Password</h5>
  </div>

  <?php if ($pesan): ?>
    <div class="alert alert-success"><?= $pesan ?></div>
  <?php endif; ?>

  <form action="proses_password_baru.php" method="POST">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <div class="mb-3">
      <label class="form-label">Password Baru</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Konfirmasi Password</label>
      <input type="password" class="form-control" name="konfirmasi" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
  </form>
</div>

</body>
</html>
