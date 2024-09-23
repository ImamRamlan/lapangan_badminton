<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah ID lapangan telah dikirim melalui URL
if (isset($_GET['id'])) {
    $lapangan_id = $_GET['id'];

    // Ambil data lapangan untuk mendapatkan nama file gambar yang akan dihapus
    $query = "SELECT gambar FROM lapangan WHERE lapangan_id = $lapangan_id";
    $result = mysqli_query($db, $query);
    $dataLapangan = mysqli_fetch_array($result);

    // Hapus data lapangan dari database
    $query = "DELETE FROM lapangan WHERE lapangan_id = $lapangan_id";
    if (mysqli_query($db, $query)) {
        // Hapus file gambar jika ada
        if ($dataLapangan['gambar'] != 'bg_lapangan.jpeg') {
            $gambar_path = "gambar_lapangan/" . $dataLapangan['gambar'];
            if (file_exists($gambar_path)) {
                unlink($gambar_path);
            }
        }

        $_SESSION['delete_message'] = "Lapangan berhasil dihapus.";
    } else {
        $_SESSION['delete_message'] = "Gagal menghapus lapangan.";
    }
} else {
    $_SESSION['delete_message'] = "ID lapangan tidak ditemukan.";
}

header("Location: data_lapangan.php");
exit();
?>
