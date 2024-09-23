<?php
session_start(); // Mulai sesi
include '../koneksi.php';
$title = "Dashboard | Lapangan Badminton";
// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pengguna'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_pengguna.php");
    exit();
}

// Ambil data pengguna dari sesi
$pengguna = $_SESSION['pengguna'];

include 'header.php';
?>
<main id="main">
</main>
<?php include 'footer.php'; ?>