<?php
session_start();
include 'koneksi.php';
$title = "Data Ketersediaan Lapangan | Penyewaan Lapangan";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$success_message = "";
$delete_message = "";

// Cek apakah terdapat pesan sukses, jika ada, atur pesan tersebut ke variabel
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

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
            <?php if (!empty($success_message)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($delete_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $delete_message; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Ketersediaan Lapangan</h5>
                    <a href="tambah_ketersediaan.php" class="btn btn-primary">Tambah Ketersediaan</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Lapangan</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Status Ketersediaan</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $queryKetersediaan = "
                                    SELECT k.ketersediaan_id, l.nama_lapangan, k.tanggal, k.jam_mulai, k.jam_selesai, k.status_ketersediaan 
                                    FROM ketersediaan_lapangan k
                                    JOIN lapangan l ON k.lapangan_id = l.lapangan_id
                                ";
                                $result = mysqli_query($db, $queryKetersediaan);
                                while ($dataKetersediaan = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <th><?php echo $no; ?></th>
                                        <td><?php echo $dataKetersediaan['nama_lapangan']; ?></td>
                                        <td><?php echo $dataKetersediaan['tanggal']; ?></td>
                                        <td><?php echo $dataKetersediaan['jam_mulai']; ?></td>
                                        <td><?php echo $dataKetersediaan['jam_selesai']; ?></td>
                                        <td><?php echo $dataKetersediaan['status_ketersediaan']; ?></td>
                                        <td>
                                            <a href="edit_ketersediaan.php?id=<?php echo $dataKetersediaan['ketersediaan_id']; ?>" class="btn btn-warning">
                                                <i class='nc-icon nc-ruler-pencil'></i>
                                            </a>
                                            <a href="delete_ketersediaan.php?id=<?php echo $dataKetersediaan['ketersediaan_id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');">
                                                <i class='nc-icon nc-simple-remove'></i>
                                            </a>
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
