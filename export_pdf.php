<?php
session_start();
require 'vendor/tecnickcom/tcpdf/tcpdf.php';


include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan ID reservasi dari URL
if (isset($_GET['id'])) {
    $reservasi_id = $_GET['id'];

    // Query untuk mendapatkan detail reservasi
    $queryDetail = mysqli_query($db, "SELECT reservasi.*, lapangan.nama_lapangan, pengguna.nama 
                                      FROM reservasi 
                                      JOIN lapangan ON reservasi.lapangan_id = lapangan.lapangan_id 
                                      JOIN pengguna ON reservasi.pengguna_id = pengguna.pengguna_id
                                      WHERE reservasi_id = $reservasi_id");

    if ($dataDetail = mysqli_fetch_array($queryDetail)) {
        // Detail reservasi berhasil didapatkan
    } else {
        // Jika detail reservasi tidak ditemukan
        $_SESSION['delete_message'] = "Detail reservasi tidak ditemukan.";
        header("Location: data_reservasi.php");
        exit();
    }
} else {
    $_SESSION['delete_message'] = "ID reservasi tidak ditemukan.";
    header("Location: data_reservasi.php");
    exit();
}

// Buat instance TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Atur informasi dokumen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Detail Reservasi');
$pdf->SetSubject('Detail Reservasi');
$pdf->SetKeywords('TCPDF, PDF, detail, reservasi');

// Atur margin
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Atur font
$pdf->SetFont('helvetica', '', 11);

// Tambahkan halaman baru
$pdf->AddPage();

// Tambahkan header
$header = '
<table width="100%" style="border-bottom: 1px solid #ccc;">
    <tr>
        <td width="30%"><img src="logo.png" alt="Logo" style="height:50px;"></td>
        <td width="70%" style="text-align:right;">
            <h1 style="font-size: 24px; margin: 0;">Detail Reservasi</h1>
            <p style="font-size: 14px; margin: 0;">Tanggal: ' . date('Y-m-d') . '</p>
        </td>
    </tr>
</table>';
$pdf->writeHTML($header, true, false, true, false, '');

// Tambahkan konten PDF
$html = '
<table border="1" style="width: 100%; border-collapse: collapse;">
    <tr>
        <th style="padding: 10px; text-align: left; background-color: #f2f2f2;">Nama Lapangan</th>
        <td style="padding: 10px;">' . $dataDetail['nama_lapangan'] . '</td>
    </tr>
    <tr>
        <th style="padding: 10px; text-align: left; background-color: #f2f2f2;">Nama Pengguna</th>
        <td style="padding: 10px;">' . $dataDetail['nama'] . '</td>
    </tr>
    <tr>
        <th style="padding: 10px; text-align: left; background-color: #f2f2f2;">Tanggal</th>
        <td style="padding: 10px;">' . $dataDetail['tanggal'] . '</td>
    </tr>
    <tr>
        <th style="padding: 10px; text-align: left; background-color: #f2f2f2;">Waktu Mulai</th>
        <td style="padding: 10px;">' . $dataDetail['waktu_mulai'] . '</td>
    </tr>
    <tr>
        <th style="padding: 10px; text-align: left; background-color: #f2f2f2;">Waktu Selesai</th>
        <td style="padding: 10px;">' . $dataDetail['waktu_selesai'] . '</td>
    </tr>
    <tr>
        <th style="padding: 10px; text-align: left; background-color: #f2f2f2;">Status Pembayaran</th>
        <td style="padding: 10px;">' . $dataDetail['status_pembayaran'] . '</td>
    </tr>
    <tr>
        <th style="padding: 10px; text-align: left; background-color: #f2f2f2;">Status Reservasi</th>
        <td style="padding: 10px;">' . $dataDetail['status_reservasi'] . '</td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF ke browser
$pdf->Output('detail_reservasi.pdf', 'I');

?>
