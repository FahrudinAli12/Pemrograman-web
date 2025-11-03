<?php
include 'include/db.php';

if (!isset($result)) {
  // Jika tidak dipanggil dari dashboard_admin.php, jalankan ulang query
  $search = $_GET['search'] ?? '';
  $pageNumber = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
  $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
  $offset = ($pageNumber - 1) * $limit;
  $filter = '';

  if ($search !== '') {
    $safeSearch = mysqli_real_escape_string($conn, $search);
    $filter = "WHERE h.nama LIKE '%$safeSearch%' OR h.lokasi LIKE '%$safeSearch%'";
  }

  $totalQuery = "SELECT COUNT(*) AS total FROM hotels h $filter";
  $totalResult = mysqli_query($conn, $totalQuery);
  $totalRow = mysqli_fetch_assoc($totalResult);
  $totalPages = ceil($totalRow['total'] / $limit);

  $query = "SELECT h.*, h.gambar AS gambar_utama FROM hotels h $filter LIMIT $limit OFFSET $offset";
  $result = mysqli_query($conn, $query);
} else {
  $pageNumber = $pageNumber ?? 1;
  $limit = $limit ?? 10;
  $offset = ($pageNumber - 1) * $limit;
  $totalPages = $totalPages ?? 1;
}

echo '<div class="mb-3">
  <button class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#formTambahHotel">+ Tambah Hotel</button>
</div>';

echo '<div class="collapse mb-4" id="formTambahHotel">
  <form method="POST" action="dashboard_admin.php?page=hotel">
    <input type="hidden" name="tambah" value="1">
    <div class="row g-2">
      <div class="col-md-6"><input class="form-control" name="nama" placeholder="Nama Hotel" required></div>
      <div class="col-md-6"><input class="form-control" name="lokasi" placeholder="Lokasi" required></div>
      <div class="col-md-4"><input class="form-control" name="harga" type="number" placeholder="Harga" required></div>
      <div class="col-md-4"><input class="form-control" name="rating" step="0.1" placeholder="Rating" required></div>
      <div class="col-md-4"><input class="form-control" name="ulasan" placeholder="Ulasan" required></div>
      <div class="col-md-4"><input class="form-control" name="jumlah_kamar" type="number" placeholder="Jumlah Kamar" required></div>
      <div class="col-md-4"><input class="form-control" name="jumlah_tamu" type="number" placeholder="Jumlah Tamu" required></div>
      <div class="col-md-12"><input class="form-control" name="gambar" placeholder="URL Gambar Utama" required></div>
      <div class="col-md-12">
        <label>Gambar Tambahan</label>
        <input class="form-control mb-2" name="gambar_tambahan[]" placeholder="URL Gambar 1">
        <input class="form-control mb-2" name="gambar_tambahan[]" placeholder="URL Gambar 2">
        <input class="form-control mb-2" name="gambar_tambahan[]" placeholder="URL Gambar 3">
      </div>
    </div>
    <div class="mt-3"><button class="btn btn-success">Simpan</button></div>
  </form>
</div>';

echo '<table class="table table-bordered table-hover align-middle">
  <thead>
    <tr>
      <th>#</th><th>Nama</th><th>Lokasi</th><th>Harga</th><th>Rating</th><th>Ulasan</th>
      <th>Kamar</th><th>Tamu</th><th>Gambar</th><th>Aksi</th>
    </tr>
  </thead>
  <tbody>';

$no = $offset + 1;
mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_assoc($result)) {
  echo '<tr>
    <td>' . $no++ . '</td>
    <td>' . htmlspecialchars($row['nama']) . '</td>
    <td>' . htmlspecialchars($row['lokasi']) . '</td>
    <td>Rp' . number_format($row['harga']) . '</td>
    <td>' . $row['rating'] . '</td>
    <td>' . htmlspecialchars($row['ulasan']) . '</td>
    <td>' . $row['jumlah_kamar'] . '</td>
    <td>' . $row['jumlah_tamu'] . '</td>
    <td><img src="' . $row['gambar_utama'] . '" class="table-img"></td>
    <td>
      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="collapse" data-bs-target="#edit' . $row['id'] . '">Edit</button>
      <a href="hapus_hotel.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</a>
    </td>
  </tr>';

  // Ambil gambar tambahan
  $gambar_tambahan = [];
  $gbr = mysqli_query($conn, "SELECT url FROM hotel_gambar WHERE hotel_id = {$row['id']}");
  while ($g = mysqli_fetch_assoc($gbr)) {
    $gambar_tambahan[] = $g['url'];
  }

  echo '<tr class="collapse" id="edit' . $row['id'] . '">
    <td colspan="10">
      <form method="POST" action="dashboard_admin.php?page=hotel">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" value="' . $row['id'] . '">
        <div class="row g-2">
          <div class="col-md-6"><input class="form-control" name="nama" value="' . htmlspecialchars($row['nama']) . '"></div>
          <div class="col-md-6"><input class="form-control" name="lokasi" value="' . htmlspecialchars($row['lokasi']) . '"></div>
          <div class="col-md-4"><input class="form-control" name="harga" type="number" value="' . $row['harga'] . '"></div>
          <div class="col-md-4"><input class="form-control" name="rating" value="' . $row['rating'] . '"></div>
          <div class="col-md-4"><input class="form-control" name="ulasan" value="' . htmlspecialchars($row['ulasan']) . '"></div>
          <div class="col-md-4"><input class="form-control" name="jumlah_kamar" value="' . $row['jumlah_kamar'] . '"></div>
          <div class="col-md-4"><input class="form-control" name="jumlah_tamu" value="' . $row['jumlah_tamu'] . '"></div>
          <div class="col-md-12"><input class="form-control" name="gambar" value="' . htmlspecialchars($row['gambar_utama']) . '"></div>
          <div class="col-md-12">
            <label>Gambar Tambahan</label>';
            for ($i = 0; $i < 3; $i++) {
              $value = isset($gambar_tambahan[$i]) ? htmlspecialchars($gambar_tambahan[$i]) : '';
              echo '<input class="form-control mb-2" name="gambar_tambahan[]" value="' . $value . '" placeholder="URL Gambar ' . ($i+1) . '">';
            }
  echo    '</div>
        </div>
        <div class="mt-3"><button class="btn btn-success btn-sm">Simpan Perubahan</button></div>
      </form>
    </td>
  </tr>';
}
echo '</tbody></table>';

echo '<div class="d-flex justify-content-between align-items-center">
  <div>
    <label>Tampilkan </label>
    <select id="perPage" class="form-select d-inline-block w-auto ms-2">
      <option value="5"' . ($limit == 5 ? ' selected' : '') . '>5</option>
      <option value="10"' . ($limit == 10 ? ' selected' : '') . '>10</option>
      <option value="25"' . ($limit == 25 ? ' selected' : '') . '>25</option>
    </select>
    <label>data</label>
  </div>
  <nav><ul class="pagination">';
for ($i = 1; $i <= $totalPages; $i++) {
  $active = ($i == $pageNumber) ? 'active' : '';
  echo '<li class="page-item ' . $active . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
}
echo '</ul></nav></div>';
?>
