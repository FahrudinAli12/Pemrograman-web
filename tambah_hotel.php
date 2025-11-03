// tambah_hotel.php
<?php
include 'include/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $lokasi = $_POST['lokasi'];
    $harga = $_POST['harga'];
    $rating = $_POST['rating'];
    $ulasan = $_POST['ulasan'];
    $jumlah_kamar = $_POST['jumlah_kamar'];
    $jumlah_tamu = $_POST['jumlah_tamu'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$gambar);

    $query = "INSERT INTO hotels (nama, lokasi, harga, rating, ulasan, jumlah_kamar, jumlah_tamu, gambar) 
              VALUES ('$nama', '$lokasi', $harga, $rating, $ulasan, $jumlah_kamar, $jumlah_tamu, '$gambar')";
    mysqli_query($conn, $query);
    header("Location: dashboard_admin.php");
}
?>

<!-- Form Tambah Hotel -->
<form method="POST" enctype="multipart/form-data">
  <input type="text" name="nama" placeholder="Nama Hotel" required><br>
  <input type="text" name="lokasi" placeholder="Lokasi" required><br>
  <input type="number" name="harga" placeholder="Harga" required><br>
  <input type="text" name="rating" placeholder="Rating"><br>
  <input type="number" name="ulasan" placeholder="Ulasan"><br>
  <input type="number" name="jumlah_kamar" placeholder="Jumlah Kamar"><br>
  <input type="number" name="jumlah_tamu" placeholder="Jumlah Tamu"><br>
  <input type="file" name="gambar" required><br>
  <button type="submit">Tambah Hotel</button>
</form>