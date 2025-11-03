// edit_hotel.php
<?php
include 'include/db.php';
$id = $_GET['id'];
$hotel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hotels WHERE id = $id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $lokasi = $_POST['lokasi'];
    $harga = $_POST['harga'];
    $rating = $_POST['rating'];
    $ulasan = $_POST['ulasan'];
    $jumlah_kamar = $_POST['jumlah_kamar'];
    $jumlah_tamu = $_POST['jumlah_tamu'];

    $query = "UPDATE hotels SET nama='$nama', lokasi='$lokasi', harga=$harga, rating=$rating, ulasan=$ulasan, jumlah_kamar=$jumlah_kamar, jumlah_tamu=$jumlah_tamu WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: dashboard_admin.php");
}
?>

<!-- Form Edit Hotel -->
<form method="POST">
  <input type="text" name="nama" value="<?= $hotel['nama'] ?>" required><br>
  <input type="text" name="lokasi" value="<?= $hotel['lokasi'] ?>" required><br>
  <input type="number" name="harga" value="<?= $hotel['harga'] ?>" required><br>
  <input type="text" name="rating" value="<?= $hotel['rating'] ?>"><br>
  <input type="number" name="ulasan" value="<?= $hotel['ulasan'] ?>"><br>
  <input type="number" name="jumlah_kamar" value="<?= $hotel['jumlah_kamar'] ?>"><br>
  <input type="number" name="jumlah_tamu" value="<?= $hotel['jumlah_tamu'] ?>"><br>
  <button type="submit">Update Hotel</button>
</form>