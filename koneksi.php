<?php
$db = mysqli_connect("localhost", "root", "", "db_badminton");

// Memeriksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>
