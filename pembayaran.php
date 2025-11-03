<?php
session_start();
include 'include/db.php';
$gambar  = $_GET['gambar'] ?? '';
$nama    = $_GET['nama'] ?? '';
$lokasi  = $_GET['lokasi'] ?? '';
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
$jumlah  = $_GET['jumlah'] ?? '';
$harga   = $_GET['harga'] ?? '0';

$jumlah_kamar = 1;
$jumlah_tamu  = 1;
if (preg_match('/(\d+)\s+Kamar,\s+(\d+)\s+Tamu/', $jumlah, $match)) {
  $jumlah_kamar = $match[1];
  $jumlah_tamu  = $match[2];
}

$total_malam = 1;
if (!empty($checkin) && !empty($checkout)) {
  $d1 = new DateTime($checkin);
  $d2 = new DateTime($checkout);
  $interval = $d1->diff($d2);
  $total_malam = max(1, $interval->days);
}

$harga_per_malam = (int) $harga;
$promo_value = 0;
$harga_total = $harga_per_malam * $total_malam;

$promo_list = [
  '50k' => ['label' => 'Diskon 50K - Spesial Juli', 'value' => 50000],
  '20k' => ['label' => 'Diskon 20K - Pelajar', 'value' => 20000],
  '10k' => ['label' => 'Diskon 10K', 'value' => 10000],
  'none' => ['label' => 'Tanpa Promo', 'value' => 0]
];

$selected_promo = $_POST['promo'] ?? $_GET['promo'] ?? 'none';
if (isset($promo_list[$selected_promo])) {
  $promo_value = $promo_list[$selected_promo]['value'];
}

$total_bayar = $harga_total - $promo_value;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email         = $_POST['email'];
  $title         = $_POST['title'];
  $nama_depan    = $_POST['nama_depan'];
  $nama_belakang = $_POST['nama_belakang'];
  $no_telp       = $_POST['no_telp'];
  $metode        = $_POST['metode_pembayaran'] ?? 'Belum dipilih';

  $sql = "INSERT INTO transaksi (
      promo, promo_nominal, email, title, nama_depan, nama_belakang, no_telp,
      gambar, nama_hotel, lokasi, checkin, checkout,
      jumlah_kamar, jumlah_tamu, harga_per_malam, total_malam,
      promo_value, total_bayar, metode_pembayaran
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sisssssssssiiiiiiis",
    $selected_promo,
    $promo_value,
    $email,
    $title,
    $nama_depan,
    $nama_belakang,
    $no_telp,
    $gambar,
    $nama,
    $lokasi,
    $checkin,
    $checkout,
    $jumlah_kamar,
    $jumlah_tamu,
    $harga_per_malam,
    $total_malam,
    $promo_value,
    $total_bayar,
    $metode
  );
  $stmt->execute();
$stmt->close();

// Kirim data ke cetak_pdf.php
$nama_lengkap = $nama_depan . ' ' . $nama_belakang;

$_SESSION['pdf_ready'] = [
  'metode' => $metode,
  'nama'   => $nama_lengkap,
  'total'  => $total_bayar
];

// Redirect kembali ke checkout (agar tidak langsung ke PDF)
header("Location: pembayaran.php?sukses=1");
exit;


}
?>

<script>
  const bayarBtn = document.querySelector('button[type="submit"]');
  bayarBtn.type = 'button';
  bayarBtn.name = 'triggerPembayaran';
  bayarBtn.addEventListener('click', function () {
    new bootstrap.Modal(document.getElementById('pembayaranModal')).show();
  });

  document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const metode = document.querySelector('input[name="metode"]:checked');
    if (metode) {
      document.getElementById('inputMetode').value = metode.value;
      document.getElementById('metodePembayaran').innerText = metode.value;
      document.getElementById('buktiPembayaran').classList.remove('d-none');
      bootstrap.Modal.getInstance(document.getElementById('pembayaranModal')).hide();

      // ✅ Submit form utama setelah metode dipilih
      document.querySelector('form[method="POST"]').submit();
    } else {
      alert('Silakan pilih metode pembayaran!');
    }
  });
</script>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Hotel Rima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
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
      z-index: 1030;
    }
    .logo img { width: 100px; height: auto; }
    .right-section { display: flex; gap: 12px; align-items: center; }
    .flag-btn, .auth-btn {
      border: 1px solid #ccc;
      background: #fff;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 14px;
    }
    .flag-btn img { width: 20px; margin-right: 6px; }
  </style>
</head>
<body>
  <div class="navbar-custom">
    <div class="logo">
      <img src="https://github.com/FahrudinAli12/TUGASsmt3/blob/main/ChatGPT_Image_13_Jul_2025__13.25.02-removebg-preview.png?raw=true" alt="Hotel Rima">
    </div>
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
    <h3 class="fw-bold">Ringkasan Pemesanan</h3>
    <hr>
    <form method="POST">
      <div class="row">
        <div class="col-md-8">
          <div class="bg-white p-4 rounded shadow-sm">
            <div class="d-flex align-items-center mb-3 border rounded p-3">
              <img src="https://github.com/FahrudinAli12/TUGASsmt3/blob/main/ChatGPT_Image_13_Jul_2025__13.25.02-removebg-preview.png?raw=true" alt="RedClub" width="50" class="me-3">
              <div class="flex-grow-1">
                <div class="fw-bold">2 Bulan RedClub</div>
                <div class="text-muted small">Diskon ekstra hingga 12%</div>
              </div>
              <div class="text-danger fw-semibold">Rp 12.000</div>
            </div>

            <div class="mb-3">
              <label class="fw-bold">Pilih Promo</label>
              <?php if ($selected_promo != 'none' && isset($promo_list[$selected_promo])): ?>
                <div class="border rounded p-3 bg-light d-flex align-items-center mb-2">
                  <img src="https://github.com/FahrudinAli12/TUGASsmt3/blob/main/ChatGPT_Image_13_Jul_2025__13.25.02-removebg-preview.png?raw=true" width="40" class="me-3">
                  <div>
                    <div class="fw-bold">Promo: <?= $promo_list[$selected_promo]['label'] ?></div>
                    <div class="text-danger">- Rp <?= number_format($promo_list[$selected_promo]['value'], 0, ',', '.') ?></div>
                  </div>
                </div>
              <?php endif; ?>
              <select class="form-select" name="promo" onchange="promoChange(this.value)">
                <script>
function promoChange(promoValue) {
  const urlParams = new URLSearchParams(window.location.search);
  urlParams.set('promo', promoValue);
  window.location.href = window.location.pathname + '?' + urlParams.toString();
}
</script>

                <?php foreach ($promo_list as $key => $promo): ?>
                  <option value="<?= $key ?>" <?= $selected_promo == $key ? 'selected' : '' ?>><?= $promo['label'] ?> (- Rp <?= number_format($promo['value'], 0, ',', '.') ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>

            <input type="email" name="email" class="form-control mb-3" placeholder="contoh@email.com" required>

            <div class="row mb-3">
              <div class="col-md-3">
                <select name="title" class="form-select" required>
                  <option value="Mr">Mr</option>
                  <option value="Mrs">Mrs</option>
                  <option value="Ms">Ms</option>
                </select>
              </div>
              <div class="col-md-4">
                <input type="text" name="nama_depan" class="form-control" placeholder="Nama Depan" required>
              </div>
              <div class="col-md-5">
                <input type="text" name="nama_belakang" class="form-control" placeholder="Nama Belakang" required>
              </div>
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text">+62</span>
              <input type="tel" name="no_telp" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="bg-white p-3 rounded shadow-sm sticky-top" style="top: 100px;">
            <div class="d-flex">
              <img src="<?= htmlspecialchars($gambar) ?>" class="rounded me-3" width="70" height="70">
              <div>
                <div class="fw-bold"><?= htmlspecialchars($nama) ?></div>
                <small class="text-muted"><?= htmlspecialchars($lokasi) ?></small>
              </div>
            </div>

            <hr>
            <div class="row text-center">
              <div class="col">
                <div class="text-muted">Check In</div>
                <div class="fw-bold"><?= htmlspecialchars($checkin) ?></div>
              </div>
              <div class="col">
                <div class="text-muted">Check Out</div>
                <div class="fw-bold"><?= htmlspecialchars($checkout) ?></div>
              </div>
            </div>

            <div class="row text-center mt-3">
              <div class="col">
                <div class="text-muted">Kamar</div>
                <div class="fw-bold"><?= $jumlah_kamar ?></div>
              </div>
              <div class="col">
                <div class="text-muted">Tamu</div>
                <div class="fw-bold"><?= $jumlah_tamu ?></div>
              </div>
            </div>

            <div class="mt-3 border rounded p-2 text-center">
              <div class="text-muted">Tipe Kamar</div>
              <div class="fw-semibold">RedDoorz Sale</div>
            </div>

            <hr>
            <div>
              <div class="d-flex justify-content-between small text-muted">
                <span>RimaHotel Web Price</span>
                <span>Rp <?= number_format($harga_per_malam, 0, ',', '.') ?></span>
              </div>
              <div class="d-flex justify-content-between small text-muted">
                <span>Total Malam</span>
                <span><?= $total_malam ?> malam</span>
              </div>
              <div class="d-flex justify-content-between small text-muted">
                <span>Promo</span>
                <span>- Rp <?= number_format($promo_value, 0, ',', '.') ?></span>
              </div>
              <hr>
              <div class="fw-bold text-danger fs-5 text-end">Rp <?= number_format($total_bayar, 0, ',', '.') ?></div>
            </div>
<input type="hidden" name="metode_pembayaran" id="inputMetode">
            <button type="button" id="btnBayarSekarang" class="btn btn-danger w-100 mt-3">Bayar Sekarang</button>

          </div>
        </div>
      </div>
    </form>
  </div>

<!-- Modal Metode Pembayaran -->
<div class="modal fade" id="pembayaranModal" tabindex="-1" aria-labelledby="pembayaranModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="paymentForm">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Metode Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <label class="fw-bold mb-2">Cash / Tunai</label>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="metode" value="Cash" id="cash">
            <label class="form-check-label" for="cash">Bayar di tempat (Cash)</label>
          </div>

          <label class="fw-bold mb-2">Virtual Account</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="metode_pembayaran" value="BRI" id="bri">
            <label class="form-check-label" for="bri">
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRUA2kqUQIf_RTz3evvjkgAjnKC_piTxR0RUg&s" width="40" class="me-2">BRI
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="metode_pembayaran" value="BNI" id="bni">
            <label class="form-check-label" for="bni">
              <img src="https://images.seeklogo.com/logo-png/35/1/bank-bni-logo-png_seeklogo-355606.png" width="40" class="me-2">BNI
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="metode_pembayaran" value="BCA" id="bca">
            <label class="form-check-label" for="bca">
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDgmigEAVm7iI09ls7yIoo0DGJMHzafSfNPt539x06PEUWhb6B42vg2e-RL4oi8kVkHCE&usqp=CAU" width="40" class="me-2">BCA
            </label>
          </div>

          <label class="fw-bold mb-2">E-Wallet</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="metode_pembayaran" value="DANA" id="dana">
            <label class="form-check-label" for="dana">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png" width="40" class="me-2">DANA
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="metode_pembayaran" value="OVO" id="ovo">
            <label class="form-check-label" for="ovo">
              <img src="https://i.pinimg.com/736x/60/42/c3/6042c3148add711c946833bbc2b90f6d.jpg" width="40" class="me-2">OVO
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="metode_pembayaran" value="GoPay" id="gopay">
            <label class="form-check-label" for="gopay">
              <img src="https://logos-world.net/wp-content/uploads/2023/03/GoPay-Logo.jpg" width="40" class="me-2">GoPay
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Bayar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Cetak Bukti -->
<div class="container mt-4 d-none" id="buktiPembayaran">
 <div class="alert alert-success text-center">
  Pembayaran berhasil via <span id="metodePembayaran"></span>!<br>
  <a class="btn btn-outline-primary mt-2"
     id="btnCetakPDF"
     href="#"
     target="_blank">
     Cetak Bukti Pembayaran (PDF)
  </a>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Saat tombol Bayar Sekarang diklik, munculkan modal
  document.getElementById('btnBayarSekarang').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('pembayaranModal'));
    modal.show();
  });

  // Ketika form pembayaran (modal) dikirim
  document.getElementById('paymentForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const metode = document.querySelector('input[name="metode_pembayaran"]:checked');
  if (!metode) {
    alert('Silakan pilih metode pembayaran!');
    return;
  }

  document.getElementById('inputMetode').value = metode.value;

  // Ambil nama & total dari PHP ke JS (pakai PHP echo ke JS variable)
  const namaPemesan = "<?= $nama_depan ?? 'Tamu' ?> <?= $nama_belakang ?? '' ?>";
  const totalBayar = <?= $total_bayar ?>;

  // Submit form transaksi
  document.querySelector('form[method="POST"]').submit();

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
if (isset($_GET['sukses']) && isset($_SESSION['pdf_ready'])) {
  $data = $_SESSION['pdf_ready'];
  unset($_SESSION['pdf_ready']);
?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Tampilkan notifikasi berhasil
    Swal.fire({
      title: "Pembayaran Berhasil!",
      text: "Bukti pembayaran akan diunduh.",
      icon: "success",
      showConfirmButton: false,
      timer: 3000
    });

    // Setelah popup selesai, baru download PDF & redirect
    setTimeout(() => {
      // Buka PDF di tab baru (biar langsung ke download jika diatur begitu)
      window.open("cetak_pdf.php?metode=<?= urlencode($data['metode']) ?>&nama=<?= urlencode($data['nama']) ?>&total=<?= $data['total'] ?>", "_blank");

      // Redirect ke index setelah 2 detik
      setTimeout(() => {
        window.location.href = "index.php";
      }, 2000);
    }, 3000);
  </script>
<?php
}
?>

</body>
</html>
