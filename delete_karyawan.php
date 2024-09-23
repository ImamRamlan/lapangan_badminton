<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter admin_id telah diberikan
if (!isset($_GET['admin_id'])) {
    header("Location: data_karyawan.php");
    exit();
}

// Ambil admin_id dari parameter URL
$admin_id = $_GET['admin_id'];

// Query untuk menghapus data karyawan berdasarkan admin_id
$query = "DELETE FROM admin WHERE admin_id = $admin_id";

// Jalankan query untuk menghapus data karyawan
$result = mysqli_query($db, $query);

if ($result) {
    // Set pesan sukses
    $_SESSION['success_message'] = "Data karyawan berhasil dihapus.";

    // Redirect ke halaman data karyawan setelah berhasil menghapus data
    header("Location: data_karyawan.php");
    exit();
} else {
    // Jika terjadi kesalahan dalam menghapus data, atur pesan kesalahan
    $_SESSION['error_message'] = "Gagal menghapus data karyawan.";
    header("Location: data_karyawan.php");
    exit();
}
