<?php
session_start();
include 'koneksi.php';
$title = "Data Reservasi | Penyewaan Lapangan";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$delete_message = "";


if (isset($_SESSION['delete_message'])) {
    $delete_message = $_SESSION['delete_message'];
    unset($_SESSION['delete_message']);
}

include 'header.php';
include 'sidebar.php';
?>

<div class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if (!empty($delete_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $delete_message; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Reservasi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Lapangan</th>
                                <th>Nama Pengguna</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $queryReservasi = mysqli_query($db, "SELECT reservasi.*, lapangan.nama_lapangan, pengguna.nama 
                                                                     FROM reservasi 
                                                                     JOIN lapangan ON reservasi.lapangan_id = lapangan.lapangan_id 
                                                                     JOIN pengguna ON reservasi.pengguna_id = pengguna.pengguna_id");
                                while ($dataReservasi = mysqli_fetch_array($queryReservasi)) {
                                ?>
                                    <tr>
                                        <th><?php echo $no; ?></th>
                                        <td><?php echo $dataReservasi['nama_lapangan']; ?></td>
                                        <td><?php echo $dataReservasi['nama']; ?></td>
                                        <td><?php echo $dataReservasi['tanggal']; ?></td>
                                        <td>
                                            <a href="detail_reservasi.php?id=<?php echo $dataReservasi['reservasi_id']; ?>" class="btn btn-info">Detail</a>
                                            <a href="delete_reservasi.php?id=<?php echo $dataReservasi['reservasi_id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')">Delete</a>

                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>