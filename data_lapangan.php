<?php
session_start();
include 'koneksi.php';
$title = "Data Lapangan | Penyewaan Lapangan";

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
                    <h5 class="card-title">Data Lapangan</h5>
                    <a href="tambah_lapangan.php" class="btn btn-primary">Tambah Lapangan</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Lapangan</th>
                                <th>Jenis Lapangan</th>
                                <th>Tarif per Jam</th>
                                <th>Keterangan</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $queryLapangan = mysqli_query($db, "SELECT * FROM lapangan");
                                while ($dataLapangan = mysqli_fetch_array($queryLapangan)) {
                                ?>
                                    <tr>
                                        <th><?php echo $no; ?></th>
                                        <td><?php echo $dataLapangan['nama_lapangan']; ?></td>
                                        <td><?php echo $dataLapangan['jenis_lapangan']; ?></td>
                                        <td><?php echo $dataLapangan['tarif_per_jam']; ?></td>
                                        <td><?php echo $dataLapangan['keterangan']; ?></td>
                                        <td><img src="gambar_lapangan/<?php echo $dataLapangan['gambar']; ?>" alt="Gambar Lapangan" style="width: 100px;"></td>
                                        <td>
                                            <a href="edit_lapangan.php?id=<?php echo $dataLapangan['lapangan_id']; ?>" class="btn btn-warning">
                                                <i class='nc-icon nc-ruler-pencil'></i>
                                            </a>
                                            <a href="delete_lapangan.php?id=<?php echo $dataLapangan['lapangan_id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');">
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
