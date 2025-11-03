<?php
session_start();
include 'include/db.php';

$lokasi = $_GET['lokasi'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
$jumlah = $_GET['jumlah'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pesan'])) {
    $hotel_id = $_POST['hotel_id'];
    $nama_hotel = $_POST['nama_hotel'];
    $harga = $_POST['harga'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $jumlah_kamar = $_POST['jumlah_kamar'];
    $jumlah_tamu = $_POST['jumlah_tamu'];
    $total_harga = $harga * $jumlah_kamar;

    $stmt = $conn->prepare("INSERT INTO pemesanan (hotel_id, nama_hotel, harga, checkin, checkout, jumlah_kamar, jumlah_tamu, total_harga) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isissiii", $hotel_id, $nama_hotel, $harga, $checkin, $checkout, $jumlah_kamar, $jumlah_tamu, $total_harga);

    if ($stmt->execute()) {
        echo "<script>alert('Pemesanan berhasil!'); window.location='search_result.php';</script>";
    } else {
        echo "<script>alert('Gagal memesan.');</script>";
    }
}

$hotel_id = $_GET['id'] ?? 0;

$hotelQuery = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
$hotelQuery->bind_param("i", $hotel_id);
$hotelQuery->execute();
$hotelData = $hotelQuery->get_result()->fetch_assoc();

$gambarTambahan = [];
$stmtGambar = $conn->prepare("SELECT url FROM hotel_gambar WHERE hotel_id = ?");
$stmtGambar->bind_param("i", $hotel_id);
$stmtGambar->execute();
$resultGambar = $stmtGambar->get_result();
while ($row = $resultGambar->fetch_assoc()) {
    $gambarTambahan[] = $row['url'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pemesanan Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f9f9f9;
      font-family: Arial, sans-serif;
      padding: 30px;
    }
    .navbar-custom {
      background: #fff;
      border-radius: 40px;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
    }
    .logo img {
      width: 100px;
      height: auto;
    }
    .search-form {
      flex: 1;
      margin: 0 30px;
      display: flex;
      gap: 12px;
      align-items: center;
    }
    .search-form input,
    .search-form select {
      border: 1px solid #ddd;
      border-radius: 20px;
      padding: 10px 16px;
      font-size: 14px;
      flex: 1;
      background: #fff;
      outline: none;
    }
    .btn-cari {
      display: flex;
      align-items: center;
      gap: 6px;
      background-color: #d8232a;
      border: none;
      color: white;
      padding: 10px 20px;
      border-radius: 25px;
      font-weight: 600;
      font-size: 14px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .btn-cari:hover {
      background-color: #bd1f25;
      transform: scale(1.02);
      cursor: pointer;
    }
    .flag-btn,
    .auth-btn {
      border: 1px solid #ccc;
      background: #fff;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 14px;
    }
    .flag-btn img {
      width: 20px;
      margin-right: 6px;
    }
    .right-section {
      display: flex;
      gap: 12px;
      align-items: center;
    }
  </style>
</head>
<body>

<div class="navbar-custom">
  <div class="logo">
    <img src="https://github.com/FahrudinAli12/TUGASsmt3/blob/main/ChatGPT_Image_13_Jul_2025__13.25.02-removebg-preview.png?raw=true" alt="Hotel Rima">
  </div>
 <form class="search-form" action="search_result.php" method="GET">
  <input type="text" name="lokasi" placeholder="Cari Lokasi" value="<?= htmlspecialchars($lokasi) ?>">
  <input type="date" name="checkin" value="<?= htmlspecialchars($checkin) ?>">
  <input type="date" name="checkout" value="<?= htmlspecialchars($checkout) ?>">
  <select name="jumlah">
    <option <?= $jumlah == '1 Kamar, 2 Tamu' ? 'selected' : '' ?>>1 Kamar, 2 Tamu</option>
    <option <?= $jumlah == '2 Kamar, 4 Tamu' ? 'selected' : '' ?>>2 Kamar, 4 Tamu</option>
    <option <?= $jumlah == '3 Kamar, 6 Tamu' ? 'selected' : '' ?>>3 Kamar, 6 Tamu</option>
  </select>
  <button type="submit" class="btn-cari">Cari</button>
</form>

  <div class="right-section">
    <button class="flag-btn"><img src="https://flagcdn.com/w40/id.png" alt="ID"> ID</button>
    <?php if (isset($_SESSION['username'])): ?>
      <div class="auth-btn"><?= htmlspecialchars($_SESSION['username']) ?></div>
    <?php else: ?>
      <a href="login.php" class="auth-btn text-decoration-none text-dark">Gabung | Daftar</a>
    <?php endif; ?>
  </div>
</div>

<?php if ($hotelData): ?>
<div class="container mt-4">
  <div class="row">
    <div class="col-md-7">
      <h4><?= htmlspecialchars($hotelData['nama']) ?></h4>
      <p><?= htmlspecialchars($hotelData['lokasi']) ?></p>
      <div class="mb-3">
        <img src="<?= htmlspecialchars($hotelData['gambar']) ?>" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
      </div>

      <?php if (!empty($gambarTambahan)): ?>
        <div class="row mb-4">
          <?php foreach ($gambarTambahan as $url): ?>
            <div class="col-md-4 mb-3">
              <img src="<?= htmlspecialchars($url) ?>" class="img-fluid rounded shadow-sm" alt="Gambar Tambahan">
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="mt-3">
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-primary fs-6"><?= number_format($hotelData['rating'], 1) ?>/5</span>
          <strong>
            <?php
              $rating = $hotelData['rating'];
              if ($rating >= 4.5) echo "Sangat Baik";
              elseif ($rating >= 4.0) echo "Baik";
              elseif ($rating >= 3.5) echo "Cukup";
              else echo "Kurang";
            ?>
          </strong>
          <span class="text-muted">Dari <?= $hotelData['ulasan'] ?> ulasan</span>
        </div>
      </div>

    </div>

    <div class="col-md-5">
      <div class="card p-4 shadow-sm">
        <form method="POST">
          <input type="hidden" name="hotel_id" value="<?= $hotelData['id'] ?>">
          <input type="hidden" name="nama_hotel" value="<?= htmlspecialchars($hotelData['nama']) ?>">
          <input type="hidden" name="harga" value="<?= $hotelData['harga'] ?>">

          <h5 class="text-danger mb-3">Rp <?= number_format($hotelData['harga'], 0, ',', '.') ?> / malam</h5>

          <div class="mb-2">
            <label for="checkin">Check-in</label>
            <input type="date" name="checkin" class="form-control" required value="<?= htmlspecialchars($checkin) ?>">
          </div>
          <div class="mb-2">
            <label for="checkout">Check-out</label>
            <input type="date" name="checkout" class="form-control" required value="<?= htmlspecialchars($checkout) ?>">
          </div>
         <div class="mb-3">
  <label for="jumlah">Jumlah Kamar & Tamu</label>
  <select name="jumlah" id="jumlah" class="form-select" onchange="updateJumlahHidden()" required>
    <option <?= $jumlah == '1 Kamar, 2 Tamu' ? 'selected' : '' ?>>1 Kamar, 2 Tamu</option>
    <option <?= $jumlah == '2 Kamar, 4 Tamu' ? 'selected' : '' ?>>2 Kamar, 4 Tamu</option>
    <option <?= $jumlah == '3 Kamar, 6 Tamu' ? 'selected' : '' ?>>3 Kamar, 6 Tamu</option>
  </select>
</div>

<input type="hidden" name="jumlah_kamar" id="jumlah_kamar" value="">
<input type="hidden" name="jumlah_tamu" id="jumlah_tamu" value="">



<a href="pembayaran.php?
  nama=<?= urlencode($hotelData['nama']) ?>&
  gambar=<?= urlencode($hotelData['gambar']) ?>&
  lokasi=<?= urlencode($hotelData['lokasi']) ?>&
  checkin=<?= urlencode($checkin) ?>&
  checkout=<?= urlencode($checkout) ?>&
  jumlah=<?= urlencode($jumlah) ?>&
  harga=<?= $hotelData['harga'] ?>"
  class="btn btn-danger w-100">
  Pesan Sekarang
</a>

        </form>
      </div>
    </div>
  </div>
</div>
<?php else: ?>
  <div class="alert alert-danger mt-4 text-center">Hotel tidak ditemukan.</div>
<?php endif; ?>

<script>
  function updateJumlahHidden() {
    const select = document.getElementById('jumlah').value;
    const kamar = select.match(/(\d+) Kamar/);
    const tamu = select.match(/(\d+) Tamu/);
    if (kamar && tamu) {
      document.getElementById('jumlah_kamar').value = kamar[1];
      document.getElementById('jumlah_tamu').value = tamu[1];
    }
  }
  document.addEventListener('DOMContentLoaded', updateJumlahHidden);
</script>


</body>
</html>
