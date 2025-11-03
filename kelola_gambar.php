<?php
include 'include/db.php';

// Cek hotel_id
if (!isset($_GET['hotel_id'])) {
    die("ID hotel tidak ditemukan.");
}

$hotel_id = (int)$_GET['hotel_id'];

// Ambil nama hotel
$data_hotel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM hotels WHERE id = $hotel_id"));
$nama_hotel = $data_hotel ? $data_hotel['nama'] : 'Hotel';

// === Upload Gambar ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gambar'])) {
    $gambar = $_FILES['gambar'];
    if ($gambar['error'] === 0) {
        $namaFile = basename($gambar['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . time() . "_" . $namaFile;

        if (move_uploaded_file($gambar['tmp_name'], $targetFile)) {
            mysqli_query($conn, "INSERT INTO hotel_gambar (hotel_id, url) VALUES ($hotel_id, '$targetFile')");
        }
    }
    header("Location: kelola_gambar.php?hotel_id=$hotel_id");
    exit;
}

// === Hapus Gambar ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id'])) {
    $id = (int)$_POST['hapus_id'];
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT url FROM hotel_gambar WHERE id = $id"));
    if ($data) {
        if (file_exists($data['url'])) {
            unlink($data['url']);
        }
        mysqli_query($conn, "DELETE FROM hotel_gambar WHERE id = $id");
    }
    header("Location: kelola_gambar.php?hotel_id=$hotel_id");
    exit;
}

// Ambil gambar-gambar hotel
$result = mysqli_query($conn, "SELECT * FROM hotel_gambar WHERE hotel_id = $hotel_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Gambar - <?= htmlspecialchars($nama_hotel) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .gambar-preview { width: 150px; height: auto; }
  </style>
</head>
<body class="bg-light">
  <div class="container py-4">
    <h3 class="mb-4">Kelola Gambar - <?= htmlspecialchars($nama_hotel) ?></h3>

    <!-- Form Upload -->
    <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
      <div class="mb-3">
        <label for="gambar" class="form-label">Upload Gambar Baru</label>
        <input type="file" name="gambar" id="gambar" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Upload</button>
      <a href="dashboard_admin.php" class="btn btn-secondary">Kembali</a>
    </form>

    <!-- List Gambar -->
    <div class="row">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-3 mb-4">
          <div class="card">
            <img src="<?= htmlspecialchars($row['url']) ?>" class="card-img-top gambar-preview" alt="Gambar Hotel">
            <div class="card-body text-center">
              <form method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar ini?')">
                <input type="hidden" name="hapus_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
