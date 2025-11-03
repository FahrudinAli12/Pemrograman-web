?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= $row['nama'] ?></td>
  <td><?= $row['lokasi'] ?></td>
  <td>Rp<?= number_format($row['harga']) ?></td>
  <td><?= $row['rating'] ?></td>
  <td><?= $row['ulasan'] ?></td>
  <td><?= $row['jumlah_kamar'] ?></td>
  <td><?= $row['jumlah_tamu'] ?></td>
  <td><img src="<?= $row['gambar_utama'] ?>?v=<?= time() ?>" class="table-img"></td>
  <td>
    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="collapse" data-bs-target="#edit<?= $row['id'] ?>">Edit</button>
    <a href="hapus_hotel.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
  </td>
</tr>
<tr class="collapse" id="edit<?= $row['id'] ?>">
  <td colspan="10">
    <!-- copy isi form edit dari kode sebelumnya di sini -->
  </td>
</tr>
<?php
