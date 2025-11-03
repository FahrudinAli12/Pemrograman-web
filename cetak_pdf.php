<?php
require('fpdf.php');

$metode = $_GET['metode'] ?? 'N/A';
$nama = $_GET['nama'] ?? 'Tamu';
$total = $_GET['total'] ?? 0;

// Buat dokumen PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Bukti Pembayaran Hotel',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,"Nama: $nama",0,1);
$pdf->Cell(0,10,"Metode Pembayaran: $metode",0,1);
$pdf->Cell(0,10,"Total Bayar: Rp " . number_format($total, 0, ',', '.'),0,1);

// Force Download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="bukti_pembayaran.pdf"');
$pdf->Output('D', 'bukti_pembayaran.pdf');
exit;
