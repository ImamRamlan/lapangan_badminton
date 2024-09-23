<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan ID ketersediaan yang akan dihapus
if (isset($_GET['id'])) {
    $ketersediaan_id = $_GET['id'];

    // Menghapus data ketersediaan dari database
    $query = "DELETE FROM ketersediaan_lapangan WHERE ketersediaan_id = $ketersediaan_id";
    
    if (mysqli_query($db, $query)) {
        $_SESSION['delete_message'] = "Ketersediaan lapangan berhasil dihapus.";
    } else {
        $_SESSION['delete_message'] = "Gagal menghapus ketersediaan lapangan.";
    }
} else {
    $_SESSION['delete_message'] = "ID ketersediaan tidak ditemukan.";
}

header("Location: data_ketersediaan.php");
exit();
?>
