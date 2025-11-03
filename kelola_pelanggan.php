// kelola_pelanggan.php
<?php
include 'include/db.php';
$pelanggan = mysqli_query($conn, "SELECT * FROM users WHERE role='pelanggan'");
?>
<table border="1">
  <tr><th>Nama</th><th>Email</th></tr>
  <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
    <tr><td><?= $p['nama'] ?></td><td><?= $p['email'] ?></td></tr>
  <?php } ?>
</table>