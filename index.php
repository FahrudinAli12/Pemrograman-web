<?php
session_start();
include 'include/db.php';

$lokasi = $_GET['lokasi'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
$jumlah = $_GET['jumlah'] ?? '';

// Pecah jumlah menjadi kamar dan tamu
list($jumlah_kamar, $jumlah_tamu) = [null, null];
if (preg_match('/(\d+)\s*Kamar.*?(\d+)\s*Tamu/', $jumlah, $match)) {
  $jumlah_kamar = (int)$match[1];
  $jumlah_tamu = (int)$match[2];
}

$query = "SELECT * FROM hotels WHERE 1";
$params = [];
if (!empty($lokasi)) {
  $query .= " AND lokasi LIKE ?";
  $params[] = "%$lokasi%";
}
if (!empty($jumlah_kamar)) {
  $query .= " AND jumlah_kamar >= ?";
  $params[] = $jumlah_kamar;
}
if (!empty($jumlah_tamu)) {
  $query .= " AND jumlah_tamu >= ?";
  $params[] = $jumlah_tamu;
}
$stmt = $conn->prepare($query);

// Siapkan binding parameter
if (!empty($params)) {
    // Buat string tipe data, misal semua "s" (string)
    $types = str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$hotels = $result->fetch_all(MYSQLI_ASSOC);


$kategoriHarga = [
  '0-120K' => 0,
  '120K-150K' => 0,
  '150K-180K' => 0,
  '180K+' => 0
];

foreach ($hotels as $hotel) {
  $harga = $hotel['harga'];
  if ($harga <= 120000) {
    $kategoriHarga['0-120K']++;
  } elseif ($harga <= 150000) {
    $kategoriHarga['120K-150K']++;
  } elseif ($harga <= 180000) {
    $kategoriHarga['150K-180K']++;
  } else {
    $kategoriHarga['180K+']++;
  }
}
// Tambahkan pengecekan admin login redirect
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Khusus akun admin
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        $_SESSION['username'] = 'admin';
        header("Location: dashboard_admin.php?page=hotel");
        exit;
    }

    // Pencocokan dengan database untuk user biasa
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password); // Tidak pakai md5 sesuai permintaan
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $email;
        header("Location: search_result.php");
        exit;
    } else {
        echo "<script>alert('Login gagal. Email atau password salah!'); window.location.href='index.php';</script>";
    }
}
?>
<!-- HTML & tampilan tetap seperti semula -->


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hotel Rimaaaa</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .navbar-custom {
      background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0));
      position: absolute;
      width: 100%;
      z-index: 1000;
      padding: 15px 30px;
    }

    .navbar-brand img {
      height: 40px;
    }
 #logoHotel {
      height: 80px;
    }

    .btn-lang, .btn-auth {
      border-radius: 25px;
      font-size: 14px;
      padding: 6px 16px;
    }

    .btn-lang {
      background-color: white;
      color: black;
      margin-right: 10px;
    }

    .btn-auth {
      background-color: white;
      color: black;
    }

    .redclub {
      color: white;
      font-size: 14px;
      margin-right: 20px;
    }

    .hero {
      background-image: url('https://picsum.photos/id/1015/1600/600');
      background-size: cover;
      background-position: center;
      height: 600px;
      position: relative;
    }

    .hero-overlay {
      background: rgba(0, 0, 0, 0.3);
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .search-box {
      position: absolute;
      top: 55%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(30px);
      padding: 25px;
      border-radius: 25px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.4);
      display: flex;
      gap: 15px;
      align-items: center;
      flex-wrap: wrap;
      width: 90%;
      max-width: 950px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .search-box input,
    .search-box select {
      border: none;
      border-radius: 8px;
      padding: 10px 14px;
      width: 180px;
      background-color: rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    .search-box input::placeholder {
      color: #fff;
      opacity: 1;
    }

    .search-box .btn-cari {
      background-color: #ff0055;
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 25px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    @media (max-width: 768px) {
      .search-box {
        flex-direction: column;
        gap: 10px;
        padding: 20px;
      }

      .search-box input,
      .search-box select {
        width: 100%;
      }

      .search-box .btn-cari {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img id="logoHotel" src="https://github.com/FahrudinAli12/Tugas-UTS-GUI-Semester-3/blob/master/ChatGPT_Image_Jul_12__2025__11_46_41_PM-removebg-preview.png?raw=true" alt="RedDoorz Logo (Mockup)" style="border-radius: 15px;">
    </a>

    <div class="ms-auto d-flex align-items-center">
      <span class="redclub">
        <strong style="background-color: #fff; color: red; padding: 2px 5px; border-radius: 4px;">Rima Club</strong><br>
        <small>Dapatkan keuntungan menarik</small>
      </span>
  <button class="btn btn-sm btn-lang d-flex align-items-center" id="btn-bendera">
  <img src="https://flagcdn.com/w40/id.png" alt="Bendera Indonesia" width="20" class="me-2" style="border: 1px solid black; border-radius: 3px;">
  ID
</button>

  <?php if (isset($_SESSION['username'])): ?>
  <div class="dropdown">
    <button class="btn btn-sm btn-auth dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <?= htmlspecialchars($_SESSION['username']) ?>
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="#">Profil Saya</a></li>
      <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
    </ul>
  </div>
<?php else: ?>
  <button class="btn btn-sm btn-auth" data-bs-toggle="modal" data-bs-target="#loginModal">
    Gabung | Daftar
  </button>
<?php endif; ?>

    </div>
  </div>
</nav>

<!-- Hero Banner -->
<div class="hero">
  <div class="hero-overlay"></div>

  <!-- Search Box -->
  <form action="search_result.php" method="GET" class="search-box">
    <input type="text" name="lokasi" placeholder="Cari Tempat" required>
    <input type="date" name="checkin" required>
    <input type="date" name="checkout" required>
    <select name="jumlah">
      <option>1 Kamar, 2 Tamu</option>
      <option>2 Kamar, 4 Tamu</option>
      <option>3 Kamar, 6 Tamu</option>
    </select>
    <button type="submit" class="btn btn-cari">
      <i class="bi bi-search"></i> Cari
    </button>
  </form>
</div>



<!-- Tujuan Populer -->
<div class="container mt-5 mb-5">
  <h3 class="fw-bold mb-4">Tujuan Populer</h3>
  <div class="d-flex flex-wrap gap-4 justify-content-start ps-3">

    <!-- Malang -->
    <div onclick="window.location.href='search_result.php?lokasi=Malang'" class="text-center" style="width: 90px; cursor: pointer;">
      <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: 0 auto;">
        <img src="https://ongistravel.com/wp-content/uploads/2017/07/monumen-Tugu-Malang.jpg" alt="Malang" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <p class="mt-2 mb-0" style="font-size: 14px;">Malang</p>
    </div>

    <!-- Blitar -->
    <div onclick="window.location.href='search_result.php?lokasi=Blitar'" class="text-center" style="width: 90px; cursor: pointer;">
      <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: 0 auto;">
        <img src="https://www.kotablitar.com/wp-content/uploads/2021/12/patung-bk.png.webp" alt="Blitar" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <p class="mt-2 mb-0" style="font-size: 14px;">Blitar</p>
    </div>

    <!-- Kediri -->
    <div onclick="window.location.href='search_result.php?lokasi=Kediri'" class="text-center" style="width: 90px; cursor: pointer;">
      <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: 0 auto;">
        <img src="https://media-cdn.tripadvisor.com/media/photo-s/0c/7f/d2/9f/monumen-simpanglima-gumul.jpg" alt="Kediri" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <p class="mt-2 mb-0" style="font-size: 14px;">Kediri</p>
    </div>

    <!-- Tulungagung -->
    <div onclick="window.location.href='search_result.php?lokasi=Tulungagung'" class="text-center" style="width: 90px; cursor: pointer;">
      <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: 0 auto;">
        <img src="https://assets.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/76/2023/08/15/4D0A4817-48D0-453E-AB85-F6FDAC084B70-2755694230.png" alt="Tulungagung" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <p class="mt-2 mb-0" style="font-size: 14px;">Tulungagung</p>
    </div>

    <!-- Surabaya -->
    <div onclick="window.location.href='search_result.php?lokasi=Surabaya'" class="text-center" style="width: 90px; cursor: pointer;">
      <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: 0 auto;">
        <img src="https://media-cdn.tripadvisor.com/media/photo-s/1c/9e/62/d8/icon-of-surabaya-east.jpg" alt="Surabaya" style="width: 100%; height: 100%; object-fit: cover;">
      </div>
      <p class="mt-2 mb-0" style="font-size: 14px;">Surabaya</p>
    </div>

  </div>
</div>


<!-- Rekomendasi Terbaik -->
<div class="container mt-5 mb-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Rekomendasi Terbaik</h3>
    <a href="#" class="btn btn-outline-dark btn-sm rounded-pill">Lihat semua <i class="bi bi-chevron-right"></i></a>
  </div>

  <div class="position-relative">
    <div class="d-flex overflow-auto gap-3 pb-2" style="scroll-behavior: smooth;" id="rekomendasi-scroll">
      <!-- Item 1 -->
      <div class="flex-shrink-0" style="width: 300px;">
        <div class="card border-0 shadow-sm">
          <img src="https://github.com/FahrudinAli12/TUGASsmt3/blob/main/malang.jpg?raw=true" class="card-img-top" alt="Promo 1">
          <div class="card-body">
            <h6 class="fw-bold mb-1">Staycation Murah di Malang</h6>
            <p class="text-muted small">Diskon hingga 30% khusus pengguna baru</p>
          </div>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="flex-shrink-0" style="width: 300px;">
        <div class="card border-0 shadow-sm">
          <img src="https://github.com/FahrudinAli12/TUGASsmt3/blob/main/surabaya.jpg?raw=true" class="card-img-top" alt="Promo 2">
          <div class="card-body">
            <h6 class="fw-bold mb-1">Promo Akhir Pekan Surabaya</h6>
            <p class="text-muted small">Nikmati liburan hemat bareng keluarga</p>
          </div>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="flex-shrink-0" style="width: 300px;">
        <div class="card border-0 shadow-sm">
          <img src="https://github.com/FahrudinAli12/TUGASsmt3/blob/main/kediri.jpg?raw=true" class="card-img-top" alt="Promo 3">
          <div class="card-body">
            <h6 class="fw-bold mb-1">Diskon Hotel di Kediri</h6>
            <p class="text-muted small">Tersedia berbagai pilihan hotel strategis</p>
          </div>
        </div>
      </div>

      <!-- Item 4 -->
      <div class="flex-shrink-0" style="width: 300px;">
        <div class="card border-0 shadow-sm">
          <img src="https://github.com/FahrudinAli12/TUGASsmt3/blob/main/Blitar.jpg?raw=true" class="card-img-top" alt="Promo 4">
          <div class="card-body">
            <h6 class="fw-bold mb-1">Blitar Pilihan Keluarga</h6>
            <p class="text-muted small">Mulai dari 99 ribuan per malam</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Tombol Scroll -->
    <button class="btn btn-light position-absolute top-50 start-0 translate-middle-y shadow" onclick="scrollRekom(-1)" style="z-index: 2;"><i class="bi bi-chevron-left"></i></button>
    <button class="btn btn-light position-absolute top-50 end-0 translate-middle-y shadow" onclick="scrollRekom(1)" style="z-index: 2;"><i class="bi bi-chevron-right"></i></button>
  </div>
</div>

<!-- Script Scroll -->
<script>
  function scrollRekom(dir) {
    const el = document.getElementById('rekomendasi-scroll');
    el.scrollBy({ left: dir * 320, behavior: 'smooth' });
  }
</script>
<!-- Deskripsi dalam Box -->
<div class="container mb-5">
  <div class="p-4 rounded" style="background-color: #f4fafc;">
    <h5 class="fw-bold">Booking Hotel Murah di Rima Hotel dan Nikmati Pengalaman Menginap yang Tak Terlupakan di Indonesia</h5>
    <p class="mb-3">
      Cari penginapan murah di Indonesia? Jangan lewatkan kesempatan untuk mendapatkan penawaran terbaik untuk pesan hotel termurah di Rima Hotel.
      Terdapat ribuan hotel dan penginapan terjangkau di seluruh kota besar dan destinasi wisata populer di Indonesia.
      Rima Hotel memberikan pelayanan dan kemudahan booking hotel termurah untuk kebutuhan liburan kamu. 
      Jelajahi Indonesia dengan kenyamanan maksimal dan fasilitas lengkap.
      Dari destinasi wisata terbaru hingga kota-kota budaya, Rima Hotel menjamin perjalanan Anda di Indonesia menjadi lebih istimewa dengan pengalaman menginap yang tak terlupakan. 
      Pesan sekarang dan dapatkan diskon spesial untuk liburan yang menyenangkan!
    </p>

    <p class="mb-2">
      Rekomendasi beberapa kota liburan untuk Anda adalah 
      <a href="#">Bandung</a>, <a href="#">Jakarta</a>, <a href="#">Lampung</a>, <a href="#">Malang</a>, <a href="#">Medan</a>, <a href="#">Palembang</a>, 
      <a href="#">Surabaya</a>, <a href="#">Yogyakarta</a>, <a href="#">Balikpapan</a>, <a href="#">Semarang</a>, <a href="#">Bogor</a>, <a href="#">Tangerang Selatan</a>, 
      <a href="#">Tangerang</a>, <a href="#">Depok</a>, <a href="#">Puncak</a>, <a href="#">Batam</a>, <a href="#">Solo</a>, <a href="#">Makassar</a>, 
      <a href="#">Tegal</a>, <a href="#">Cirebon</a>, <a href="#">Bali</a>, <a href="#">Bekasi</a>, <a href="#">Banjarmasin</a>, <a href="#">Jambi</a>, 
      <a href="#">Padang</a>, <a href="#">Pekanbaru</a>, <a href="#">Manado</a>, <a href="#">Pematang Siantar</a>, <a href="#">Pontianak</a>, <a href="#">Banyuwangi</a>, 
      <a href="#">Garut</a>, <a href="#">Bengkulu</a>, <a href="#">Aceh</a>, <a href="#">Serang</a>, <a href="#">Kendari</a>, <a href="#">Kuningan</a>, 
      dan <a href="#">Palangkaraya</a>.
    </p>

  </div>
</div>

<!-- Footer -->
<footer class="bg-light py-5 mt-5" style="background-color: #f4fafc !important;">
  <div class="container">
    <div class="row text-start">
      <!-- Rima Hotel -->
      <div class="col-md-4 mb-4">
        <h6 class="fw-bold">Rima Hotel</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-dark text-decoration-none">Tentang Kami</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Blogs</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Jumpa pers</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Karir</a></li>
        </ul>
      </div>

      <!-- Partner -->
      <div class="col-md-4 mb-4">
        <h6 class="fw-bold">Jadi Partner Kami</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-dark text-decoration-none">Daftarkan properti Anda</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Rima Hotel untuk Bisnis</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Rima Hotel untuk Reseller</a></li>
        </ul>
      </div>

      <!-- Bantuan -->
      <div class="col-md-4 mb-4">
        <h6 class="fw-bold">Bantuan</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-dark text-decoration-none">Hubungi Kami</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Terms and Conditions</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Ketentuan Privasi</a></li>
          <li><a href="#" class="text-dark text-decoration-none">FAQ</a></li>
        </ul>
      </div>
    </div>

    <hr>

    <!-- Sosial Media & Copyright -->
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <div class="d-flex gap-3 mb-2 mb-md-0">
        <a href="#" class="text-dark fs-5"><i class="bi bi-instagram"></i></a>
        <a href="#" class="text-dark fs-5"><i class="bi bi-twitter"></i></a>
        <a href="#" class="text-dark fs-5"><i class="bi bi-facebook"></i></a>
      </div>
      <div class="text-muted small">© 2025 Rima Hotel.com</div>
    </div>
  </div>
</footer>

<!-- Modal Login/Register/Reset Password -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 16px;">

      <!-- Judul Modal -->
      <h5 class="fw-bold mb-3 text-center" id="loginModalLabel">Selamat datang!</h5>

      <!-- Logo -->
      <div class="icon-online mb-3 text-center">
        <img src="https://github.com/FahrudinAli12/Tugas-UTS-GUI-Semester-3/blob/master/ChatGPT_Image_Jul_12__2025__11_46_41_PM-removebg-preview.png?raw=true" alt="Logo" width="120" height="120">
      </div>

      <!-- Form Login -->
      <form action="login.php" method="POST" id="form-login">
        <input type="email" name="email" class="form-control mb-2" placeholder="Alamat Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <div class="form-check mb-2">
          <input type="checkbox" class="form-check-input" id="ingatSaya" name="ingat">
          <label class="form-check-label" for="ingatSaya">Ingat saya</label>
        </div>
        <div class="text-end mb-3">
          <a href="#" onclick="showForgotForm()">Lupa Password?</a>
        </div>
        <button type="submit" class="btn btn-danger w-100">Masuk</button>
        <div class="text-center mt-3">
          Belum punya akun? <a href="#" onclick="showRegisterForm()">Daftar di sini</a>
        </div>
      </form>

      <!-- Form Register -->
      <form action="register.php" method="POST" style="display: none;" id="form-register">
        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Lengkap" required>
        <input type="email" name="email" class="form-control mb-2" placeholder="Alamat Email" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <input type="password" name="konfirmasi" class="form-control mb-3" placeholder="Konfirmasi Password" required>
        <button type="submit" class="btn btn-success w-100">Daftar</button>
        <div class="text-center mt-3">
          Sudah punya akun? <a href="#" onclick="showLoginForm()">Masuk di sini</a>
        </div>
      </form>

     <!-- Form Lupa Password -->
<form action="lupa_password.php" method="POST" style="display:none;" id="form-forgot">
  <div id="resetNotif" class="alert alert-success text-center" style="display:none;"></div>

  <input type="email" name="email" class="form-control mb-3" placeholder="Masukkan email Anda" required>
  <button type="submit" class="btn btn-warning w-100">Kirim Link Reset</button>
  <div class="text-center mt-3">
    Sudah ingat password? <a href="#" onclick="showLoginForm()">Masuk di sini</a>
  </div>
</form>


<script>
  function showRegisterForm() {
    document.getElementById('form-login').style.display = 'none';
    document.getElementById('form-register').style.display = 'block';
    document.getElementById('form-forgot').style.display = 'none';
    document.getElementById('loginModalLabel').textContent = 'Buat Akun';
  }

  function showLoginForm() {
    document.getElementById('form-login').style.display = 'block';
    document.getElementById('form-register').style.display = 'none';
    document.getElementById('form-forgot').style.display = 'none';
    document.getElementById('loginModalLabel').textContent = 'Selamat datang!';
  }

  function showForgotForm() {
    document.getElementById('form-login').style.display = 'none';
    document.getElementById('form-register').style.display = 'none';
    document.getElementById('form-forgot').style.display = 'block';
    document.getElementById('loginModalLabel').textContent = 'Lupa Password';
  }

  // Tampilkan notifikasi jika berhasil dari lupa_password.php
  window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    if (params.get('reset') === 'success') {
      const resetNotif = document.getElementById('resetNotif');
      if (resetNotif) {
        resetNotif.style.display = 'block';
        resetNotif.textContent = 'Link reset telah dikirim ke email Anda.';
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
        showForgotForm();
      }
    } else if (params.get('reset') === 'failed') {
      const resetNotif = document.getElementById('resetNotif');
      if (resetNotif) {
        resetNotif.style.display = 'block';
        resetNotif.classList.remove('alert-success');
        resetNotif.classList.add('alert-danger');
        resetNotif.textContent = 'Email tidak ditemukan.';
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
        showForgotForm();
      }
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
