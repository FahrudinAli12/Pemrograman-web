<?php
session_start();
include 'include/db.php';
$lokasi = $_GET['lokasi'] ?? '';
$jumlah = $_GET['jumlah'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
$sort = $_GET['sort'] ?? '';

$jumlah_kamar = 0;
$jumlah_tamu = 0;
if (preg_match('/(\d+) Kamar, (\d+) Tamu/', $jumlah, $matches)) {
    $jumlah_kamar = (int)$matches[1];
    $jumlah_tamu = (int)$matches[2];
}

$query = "SELECT * FROM hotels WHERE 1=1";
$params = [];
$types = '';

if (!empty($lokasi)) {
    $query .= " AND lokasi LIKE ?";
    $params[] = "%$lokasi%";
    $types .= 's';
}
if ($jumlah_kamar > 0) {
    $query .= " AND jumlah_kamar = ?";
    $params[] = $jumlah_kamar;
    $types .= 'i';
}
if ($jumlah_tamu > 0) {
    $query .= " AND jumlah_tamu = ?";
    $params[] = $jumlah_tamu;
    $types .= 'i';
}

switch ($sort) {
    case 'popularitas':
        $query .= " ORDER BY ulasan DESC"; break;
    case 'harga_asc':
        $query .= " ORDER BY harga ASC"; break;
    case 'harga_desc':
        $query .= " ORDER BY harga DESC"; break;
    case 'rating_desc':
        $query .= " ORDER BY rating DESC"; break;
    default:
        $query .= " ORDER BY nama ASC"; break;
}

$stmt = $conn->prepare($query);
if ($params) {
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
    $harga = (int)$hotel['harga'];
    if ($harga <= 120000) $kategoriHarga['0-120K']++;
    elseif ($harga <= 150000) $kategoriHarga['120K-150K']++;
    elseif ($harga <= 180000) $kategoriHarga['150K-180K']++;
    else $kategoriHarga['180K+']++;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { background: #f2f2f2; margin: 0; padding: 30px; font-family: Arial, sans-serif; }
    .navbar-custom {
  background: #fff;
  border-radius: 40px;
  padding: 12px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 3px 15px rgba(0,0,0,0.05);
  position: sticky;
  top: 0;
  z-index: 1030; /* memastikan berada di atas konten lain */
}

    .logo img { width: 100px; height: auto; }
    .search-form { flex: 1; margin: 0 30px; display: flex; gap: 12px; align-items: center; }
    .search-form input, .search-form select { border: 1px solid #ddd; border-radius: 20px; padding: 10px 16px; font-size: 14px; flex: 1; background: #fff; outline: none; }
    .btn-cari { display: flex; align-items: center; gap: 6px; background-color: #d8232a; border: none; color: white; padding: 10px 20px; border-radius: 25px; font-weight: 600; font-size: 14px; box-shadow: 0 3px 8px rgba(0,0,0,0.1); }
    .btn-cari:hover { background-color: #bd1f25; transform: scale(1.02); cursor: pointer; }
    .flag-btn, .auth-btn { border: 1px solid #ccc; background: #fff; padding: 6px 14px; border-radius: 20px; font-size: 14px; }
    .flag-btn img { width: 20px; margin-right: 6px; }
    .right-section { display: flex; gap: 12px; align-items: center; }
    .hotel-list img { width: 100%; border-radius: 12px; }
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

<div class="container mt-4">
  <div class="row">
    <div class="col-md-3">
      <h6 class="fw-bold">Harga per Malam (in Rp)</h6>
      <canvas id="hargaChart" height="200"></canvas>
      <div class="mt-4">
        <h6 class="fw-bold">Peringkat Pengguna</h6>
        <div class="form-check"><input class="form-check-input" type="radio" name="rating" value="4.7" id="rating47"><label class="form-check-label" for="rating47">4.7+ (Luar Biasa)</label></div>
        <div class="form-check"><input class="form-check-input" type="radio" name="rating" value="4.3" id="rating43"><label class="form-check-label" for="rating43">4.3+ (Bagus)</label></div>
        <div class="form-check"><input class="form-check-input" type="radio" name="rating" value="4.0" id="rating40"><label class="form-check-label" for="rating40">4.0+ (Cukup Baik)</label></div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="d-flex justify-content-end align-items-center mb-3">
        <form method="GET" class="d-flex align-items-center" style="gap: 8px;">
          <input type="hidden" name="lokasi" value="<?= htmlspecialchars($lokasi) ?>">
          <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin) ?>">
          <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout) ?>">
          <input type="hidden" name="jumlah" value="<?= htmlspecialchars($jumlah) ?>">
          <label for="sort" class="me-2 fw-semibold">Urutkan:</label>
          <select name="sort" id="sort" class="form-select" onchange="this.form.submit()" style="width: 200px;">
            <option value="">-- Pilih --</option>
            <option value="popularitas" <?= $sort == 'popularitas' ? 'selected' : '' ?>>Popularitas</option>
            <option value="harga_asc" <?= $sort == 'harga_asc' ? 'selected' : '' ?>>Harga: Rendah ke Tinggi</option>
            <option value="harga_desc" <?= $sort == 'harga_desc' ? 'selected' : '' ?>>Harga: Tinggi ke Rendah</option>
            <option value="rating_desc" <?= $sort == 'rating_desc' ? 'selected' : '' ?>>Peringkat: Tinggi ke Rendah</option>
          </select>
        </form>
      </div>

      <div class="hotel-list">
        <?php foreach ($hotels as $hotel): ?>
          <div class="card mb-3 shadow-sm">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="<?= htmlspecialchars($hotel['gambar']) ?>" class="img-fluid rounded-start" alt="Hotel">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title mb-1">
  <a href="pemesanan.php?id=<?= $hotel['id'] ?>&lokasi=<?= urlencode($lokasi) ?>&checkin=<?= urlencode($checkin) ?>&checkout=<?= urlencode($checkout) ?>&jumlah=<?= urlencode($jumlah) ?>&harga=<?= $hotel['harga'] ?>" 
     style="color: inherit; text-decoration: none;">
    <?= $hotel['nama'] ?>
  </a>
</h5>
                  <p class="mb-1"><small class="text-muted"><?= $hotel['lokasi'] ?></small></p>
                  <p class="mb-1"><span class="badge text-bg-primary"><?= $hotel['rating'] ?></span> &bull; <?= $hotel['ulasan'] ?> Rating</p>
                  <p class="mb-1">Resepsionis &nbsp; Wifi Gratis &nbsp; Alat Mandi Gratis</p>
                  <h5 class="text-danger mt-2">Rp <?= number_format($hotel['harga'], 0, ',', '.') ?></h5>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<script>
const ctx = document.getElementById('hargaChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['0-120K', '120K-150K', '150K-180K', '180K+'],
    datasets: [{
      label: 'Jumlah Hotel',
      data: [
        <?= $kategoriHarga['0-120K'] ?>,
        <?= $kategoriHarga['120K-150K'] ?>,
        <?= $kategoriHarga['150K-180K'] ?>,
        <?= $kategoriHarga['180K+'] ?>
      ],
      backgroundColor: '#d8232a',
      borderRadius: 8,
    }]
  },
  options: {
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, ticks: { stepSize: 1 } }
    }
  }
});
</script>

</body>
</html>