<?php
session_start();
include 'include/db.php';

$page = $_GET['page'] ?? 'hotel';
$search = $_GET['search'] ?? '';
$pageNumber = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($pageNumber - 1) * $limit;
$filter = "";

if ($page === 'hotel' && $search !== '') {
  $safeSearch = mysqli_real_escape_string($conn, $search);
  $filter = "WHERE h.nama LIKE '%$safeSearch%' OR h.lokasi LIKE '%$safeSearch%'";
}

if ($page === 'hotel') {
  $totalQuery = "SELECT COUNT(*) AS total FROM hotels h $filter";
  $totalResult = mysqli_query($conn, $totalQuery);
  $totalRow = mysqli_fetch_assoc($totalResult);
  $totalPages = ceil($totalRow['total'] / $limit);

  $query = "SELECT h.*, h.gambar AS gambar_utama FROM hotels h $filter LIMIT $limit OFFSET $offset";
  $result = mysqli_query($conn, $query);
}

if ($page === 'pelanggan') {
  $result_pelanggan = mysqli_query($conn, "SELECT * FROM users");
}

if (isset($_POST['tambah'])) {
  // Tambah hotel
  $nama = $_POST['nama'];
  $lokasi = $_POST['lokasi'];
  $harga = $_POST['harga'];
  $rating = $_POST['rating'];
  $ulasan = $_POST['ulasan'];
  $jumlah_kamar = $_POST['jumlah_kamar'];
  $jumlah_tamu = $_POST['jumlah_tamu'];
  $gambar = $_POST['gambar'];

  mysqli_query($conn, "INSERT INTO hotels (nama, lokasi, harga, rating, ulasan, jumlah_kamar, jumlah_tamu, gambar)
    VALUES ('$nama', '$lokasi', '$harga', '$rating', '$ulasan', '$jumlah_kamar', '$jumlah_tamu', '$gambar')");
  $hotel_id = mysqli_insert_id($conn);

  foreach ($_POST['gambar_tambahan'] as $url) {
    if (trim($url) != '') {
      mysqli_query($conn, "INSERT INTO hotel_gambar (hotel_id, url) VALUES ('$hotel_id', '$url')");
    }
  }

  $cek = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM hotel_gambar WHERE hotel_id='$hotel_id'");
  $cekJml = mysqli_fetch_assoc($cek);
  if ($cekJml['jml'] == 0 && !empty($gambar)) {
    mysqli_query($conn, "INSERT INTO hotel_gambar (hotel_id, url) VALUES ('$hotel_id', '$gambar')");
  }

  header("Location: dashboard_admin.php?page=hotel");
  exit;
}

if (isset($_POST['update'])) {
  // Update hotel
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $lokasi = $_POST['lokasi'];
  $harga = $_POST['harga'];
  $rating = $_POST['rating'];
  $ulasan = $_POST['ulasan'];
  $jumlah_kamar = $_POST['jumlah_kamar'];
  $jumlah_tamu = $_POST['jumlah_tamu'];
  $gambar = $_POST['gambar'];

  mysqli_query($conn, "UPDATE hotels SET nama='$nama', lokasi='$lokasi', harga='$harga', rating='$rating',
    ulasan='$ulasan', jumlah_kamar='$jumlah_kamar', jumlah_tamu='$jumlah_tamu', gambar='$gambar' WHERE id='$id'");

  mysqli_query($conn, "DELETE FROM hotel_gambar WHERE hotel_id='$id'");
  foreach ($_POST['gambar_tambahan'] as $url) {
    if (trim($url) != '') {
      mysqli_query($conn, "INSERT INTO hotel_gambar (hotel_id, url) VALUES ('$id', '$url')");
    }
  }

  $cek = mysqli_query($conn, "SELECT COUNT(*) AS jml FROM hotel_gambar WHERE hotel_id='$id'");
  $cekJml = mysqli_fetch_assoc($cek);
  if ($cekJml['jml'] == 0 && !empty($gambar)) {
    mysqli_query($conn, "INSERT INTO hotel_gambar (hotel_id, url) VALUES ('$id', '$gambar')");
  }

  header("Location: dashboard_admin.php?page=hotel");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f5f5f5; }
    .sidebar { background: #d32f2f; min-height: 100vh; color: #fff; }
    .sidebar a { display: block; padding: 12px 20px; color: #fff; text-decoration: none; }
    .sidebar a:hover { background: #b71c1c; }
    .navbar { background: #fff; }
    .table-img { width: 100px; border-radius: 6px; }
    .btn-red { background: #d32f2f; color: #fff; }
    .btn-red:hover { background: #b71c1c; }
    .table thead { background: #ffe6e6; }
    .btn-group-sm .btn { margin-right: 4px; }
  </style>
</head>
<body>
<div class="d-flex">
  <div class="sidebar p-3">
    <h4 class="text-center fw-bold mb-4">Admin RedDoorz</h4>
    <a href="?page=hotel">Kelola Hotel</a>
    <a href="?page=pelanggan">Data Pelanggan</a>
    <a href="?page=keuangan">Laporan Transaksi</a>
  </div>

  <div class="flex-grow-1">
    <nav class="navbar shadow-sm px-4 py-2 d-flex justify-content-between align-items-center">
      <div class="fw-bold text-danger fs-5">
        <?php echo ($page == 'hotel') ? 'Manajemen Hotel' : (($page == 'pelanggan') ? 'Data Pelanggan' : 'Laporan Transaksi'); ?>
      </div>
      <?php if ($page == 'hotel'): ?>
      <form class="d-flex" method="GET" id="searchForm">
        <input type="hidden" name="page" value="hotel">
        <input class="form-control me-2" type="text" name="search" id="searchInput" placeholder="Cari hotel..." value="<?php echo htmlspecialchars($search); ?>">
        <button class="btn btn-outline-danger" type="submit">Cari</button>
      </form>
      <?php endif; ?>
    </nav>

    <div class="container py-4" id="hotelContainer">
      <?php
        if ($page === 'hotel') {
          include 'hotel_table.php';
        } elseif ($page === 'pelanggan') {
          echo "<h5 class='mb-3'>Daftar Pelanggan</h5>";
          echo "<table class='table table-bordered'>";
          echo "<thead><tr><th>No</th><th>Nama</th><th>Email</th></tr></thead><tbody>";

          $no = 1;
          while ($p = mysqli_fetch_assoc($result_pelanggan)) {
              echo "<tr><td>" . $no++ . "</td><td>" . $p['nama'] . "</td><td>" . $p['email'] . "</td></tr>";
          }

          echo "</tbody></table>";
        } elseif ($page === 'keuangan') {
          $result_keuangan = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY waktu_transaksi DESC");
          echo "<h5 class='mb-3'>Laporan Transaksi</h5>";
          echo "<div class='table-responsive'>";
          echo "<table class='table table-bordered'>";
          echo "<thead class='table-light'><tr>
              <th>No</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Nama Hotel</th><th>Lokasi</th><th>Check-in</th><th>Check-out</th><th>Jumlah Kamar</th><th>Jumlah Tamu</th><th>Harga/Malam</th><th>Total Malam</th><th>Promo</th><th>Potongan</th><th>Total Bayar</th><th>Metode Pembayaran</th><th>Waktu Transaksi</th>
          </tr></thead><tbody>";

          $no = 1;
          while ($k = mysqli_fetch_assoc($result_keuangan)) {
              $nama = $k['nama_depan'] . ' ' . $k['nama_belakang'];
              $total_bayar = number_format($k['total_bayar'], 0, ',', '.');
              $harga_malam = number_format($k['harga_per_malam'], 0, ',', '.');
              $promo_value = number_format($k['promo_value'], 0, ',', '.');

              echo "<tr>
                  <td>$no</td><td>$nama</td><td>{$k['email']}</td><td>{$k['no_telp']}</td><td>{$k['nama_hotel']}</td><td>{$k['lokasi']}</td><td>{$k['checkin']}</td><td>{$k['checkout']}</td><td>{$k['jumlah_kamar']}</td><td>{$k['jumlah_tamu']}</td><td>Rp$harga_malam</td><td>{$k['total_malam']}</td><td>{$k['promo']}</td><td>Rp$promo_value</td><td>Rp$total_bayar</td><td>{$k['metode_pembayaran']}</td><td>{$k['waktu_transaksi']}</td>
              </tr>";
              $no++;
          }

          echo "</tbody></table></div>";
        }
      ?>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
