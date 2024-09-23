<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $pengguna_id = $_GET['id'];

    // Query untuk menghapus pengguna berdasarkan pengguna_id
    $query = "DELETE FROM pengguna WHERE pengguna_id = $pengguna_id";

    if (mysqli_query($db, $query)) {
        $_SESSION['delete_message'] = "Pengguna berhasil dihapus.";
    } else {
        $_SESSION['delete_message'] = "Penghapusan pengguna gagal.";
    }
} else {
    $_SESSION['delete_message'] = "ID pengguna tidak ditemukan.";
}

// Arahkan kembali ke halaman data pengguna
header("Location: data_pengguna.php");
exit();
?>
