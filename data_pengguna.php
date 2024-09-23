<?php
session_start();
include 'koneksi.php';
$title = "Data Pengguna | Penyewaan Lapangan";

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
                    <h5 class="card-title">Data Pengguna</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $queryPengguna = mysqli_query($db, "SELECT * FROM pengguna");
                                while ($dataPengguna = mysqli_fetch_array($queryPengguna)) {
                                ?>
                                    <tr>
                                        <th><?php echo $no; ?></th>
                                        <td><?php echo $dataPengguna['nama']; ?></td>
                                        <td><?php echo $dataPengguna['username']; ?></td>
                                        <td><?php echo $dataPengguna['nomor_telepon']; ?></td>
                                        <td>
                                            <a href="delete_pengguna.php?id=<?php echo $dataPengguna['pengguna_id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');">
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
