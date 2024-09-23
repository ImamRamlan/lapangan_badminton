<?php
session_start();
include 'koneksi.php';
$title = "Detail Reservasi | Penyewaan Lapangan";

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

// Proses perubahan status_pembayaran
if (isset($_POST['status_pembayaran'])) {
    $new_status_pembayaran = $_POST['status_pembayaran'];
    $updateStatusPembayaran = mysqli_query($db, "UPDATE reservasi SET status_pembayaran = '$new_status_pembayaran' WHERE reservasi_id = $reservasi_id");

    if ($updateStatusPembayaran) {
        // Status pembayaran berhasil diubah
        $_SESSION['success_message'] = "Status pembayaran berhasil diperbarui.";
        header("Location: detail_reservasi.php?id=$reservasi_id");
        exit();
    } else {
        // Gagal mengubah status pembayaran
        $_SESSION['error_message'] = "Gagal memperbarui status pembayaran.";
        header("Location: detail_reservasi.php?id=$reservasi_id");
        exit();
    }
}

// Proses perubahan status_reservasi
if (isset($_POST['status_reservasi'])) {
    $new_status_reservasi = $_POST['status_reservasi'];
    $updateStatusReservasi = mysqli_query($db, "UPDATE reservasi SET status_reservasi = '$new_status_reservasi' WHERE reservasi_id = $reservasi_id");

    if ($updateStatusReservasi) {
        // Status reservasi berhasil diubah
        $_SESSION['success_message'] = "Status reservasi berhasil diperbarui.";
        header("Location: detail_reservasi.php?id=$reservasi_id");
        exit();
    } else {
        // Gagal mengubah status reservasi
        $_SESSION['error_message'] = "Gagal memperbarui status reservasi.";
        header("Location: detail_reservasi.php?id=$reservasi_id");
        exit();
    }
}

// Memeriksa apakah pesan berhasil tersedia
$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Hapus pesan setelah digunakan
}

include 'header.php';
include 'sidebar.php';
?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detail Reservasi</h5>
                    <?php if (!empty($success_message)) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Nama Lapangan</th>
                            <td><?php echo $dataDetail['nama_lapangan']; ?></td>
                        </tr>
                        <tr>
                            <th>Nama Pengguna</th>
                            <td><?php echo $dataDetail['nama']; ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td><?php echo $dataDetail['tanggal']; ?></td>
                        </tr>
                        <tr>
                            <th>Waktu Mulai</th>
                            <td><?php echo $dataDetail['waktu_mulai']; ?></td>
                        </tr>
                        <tr>
                            <th>Waktu Selesai</th>
                            <td><?php echo $dataDetail['waktu_selesai']; ?></td>
                        </tr>
                        <tr>
                            <th>Status Pembayaran</th>
                            <td>
                                <form action="detail_reservasi.php?id=<?php echo $reservasi_id; ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status pembayaran?')">
                                    <button type="submit" name="status_pembayaran" value="<?php echo $dataDetail['status_pembayaran'] == 'Belum' ? 'Sudah' : 'Belum'; ?>" class="btn btn-<?php echo $dataDetail['status_pembayaran'] == 'Belum' ? 'danger' : 'success'; ?>"><?php echo $dataDetail['status_pembayaran']; ?></button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>Status Reservasi</th>
                            <td>
                                <form action="detail_reservasi.php?id=<?php echo $reservasi_id; ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status reservasi?')">
                                    <button type="submit" name="status_reservasi" value="<?php echo $dataDetail['status_reservasi'] == 'Belum' ? 'Sudah' : 'Belum'; ?>" class="btn btn-<?php echo $dataDetail['status_reservasi'] == 'Belum' ? 'warning' : 'success'; ?>"><?php echo $dataDetail['status_reservasi']; ?></button>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <th>Foto Pembayaran</th>
                            <td><img src="bukti_pembayaran/<?php echo $dataDetail['foto_pembayaran']; ?>" alt="Foto Pembayaran" style="width: 200px;"></td>
                        </tr>
                    </table>
                    <a href="data_reservasi.php" class="btn btn-secondary">Kembali</a>
                    <a href="export_pdf.php?id=<?php echo $reservasi_id; ?>" class="btn btn-primary">Export to PDF</a>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>