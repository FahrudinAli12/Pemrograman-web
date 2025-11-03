// laporan_keuangan.php
<?php
include 'include/db.php';
$laporan = mysqli_query($conn, "SELECT * FROM pembayaran ORDER BY tanggal DESC");
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM pembayaran"));
?>
<h3>Laporan Keuangan</h3>
<table border="1">
  <tr><th>Tanggal</th><th>Jumlah</th><th>Keterangan</th></tr>
  <?php while ($row = mysqli_fetch_assoc($laporan)) { ?>
    <tr><td><?= $row['tanggal'] ?></td><td>Rp<?= number_format($row['jumlah']) ?></td><td><?= $row['keterangan'] ?></td></tr>
  <?php } ?>
</table>
<p><strong>Total: Rp<?= number_format($total['total']) ?></strong></p>
