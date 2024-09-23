<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah ID reservasi tersedia
if (isset($_GET['id'])) {
    $reservasi_id = $_GET['id'];

    // Query untuk menghapus reservasi berdasarkan ID
    $deleteReservasi = mysqli_query($db, "DELETE FROM reservasi WHERE reservasi_id = $reservasi_id");

    if ($deleteReservasi) {
        // Jika reservasi berhasil dihapus
        $_SESSION['delete_message'] = "Reservasi berhasil dihapus.";
    } else {
        // Jika terjadi kesalahan saat menghapus reservasi
        $_SESSION['error_message'] = "Gagal menghapus reservasi.";
    }
} else {
    // Jika ID reservasi tidak tersedia
    $_SESSION['error_message'] = "ID reservasi tidak ditemukan.";
}

// Redirect kembali ke halaman data_reservasi.php
header("Location: data_reservasi.php");
exit();
