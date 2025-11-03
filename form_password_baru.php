<?php
date_default_timezone_set('Asia/Jakarta');
include 'include/db.php';

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
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right,rgb(255, 253, 254),rgb(255, 255, 255));
    }
    .card-custom {
      background-color:rgb(146, 145, 155); /* Warna pink muda */
      border: none;
      border-radius: 15px;
      box-shadow: 0 20px 50px rgba(179, 167, 167, 0.2);
    }
    .btn-danger {
      background-color:rgb(224, 35, 44);
      border: none;
    }
    .btn-danger:hover {
      background-color:rgb(168, 165, 183);
    }
  </style>
</head>
<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card card-custom p-4">
      <div class="text-center mb-3">
        <img src="https://github.com/FahrudinAli12/Tugas-UTS-GUI-Semester-3/blob/master/ChatGPT_Image_Jul_12__2025__11_46_41_PM-removebg-preview.png?raw=true"
             alt="Logo Rima Hotel" width="100">
        <h4 class="mt-2 fw-bold">Atur Ulang Password</h4>
        <p class="text-muted small">Silakan masukkan password baru Anda.</p>
      </div>

      <form action="proses_password_baru.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

        <div class="mb-3">
          <label for="password" class="form-label">Password Baru</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Password baru" required>
        </div>

        <div class="mb-3">
          <label for="konfirmasi" class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control" name="konfirmasi" id="konfirmasi" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Reset Password</button>
      </form>
    </div>
  </div>

</body>
</html>
