<?php
session_start();
include 'koneksi.php';
$title = "Data Karyawan | Penyewaan Lapangan";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$success_message = "";

// Cek apakah terdapat pesan sukses, jika ada, atur pesan tersebut ke variabel
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];

    // Hapus pesan sukses dari session agar tidak ditampilkan lagi setelah refresh
    unset($_SESSION['success_message']);
}
include 'header.php';

?>
<?php include 'sidebar.php'; ?>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($success_message)) : ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> Data Karyawan</h5>
                    <a href="tambah_karyawan.php" class="btn btn-primary">Tambah Data +</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>
                                    No
                                </th>
                                <th>
                                    Nama
                                </th>
                                <th>
                                    Username
                                </th>
                                <th>
                                    Role
                                </th>
                                <th>
                                    Jenis Kelamin
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1; // Variabel untuk nomor urut
                                $queryKaryawan = mysqli_query($db, "SELECT * FROM admin"); // Melakukan query ke database untuk mengambil data karyawan
                                while ($dataKaryawan = mysqli_fetch_array($queryKaryawan)) { // Melakukan iterasi melalui hasil query
                                ?>
                                    <tr>
                                        <th><?php echo $no; ?></th> <!-- Menampilkan nomor urut -->
                                        <td><?php echo $dataKaryawan['nama']; ?></td> <!-- Menampilkan data nama -->
                                        <td><?php echo $dataKaryawan['username']; ?></td> <!-- Menampilkan data username -->
                                        <td><?php echo $dataKaryawan['role']; ?></td>
                                        <td><?php echo $dataKaryawan['jenis_kelamin']; ?></td> <!-- Menampilkan data role -->
                                        <td>
                                            <!-- Tombol untuk mengedit data karyawan -->
                                            <a href="edit_karyawan.php?admin_id=<?php echo $dataKaryawan['admin_id']; ?>" class="btn btn-warning"><i class='nc-icon nc-simple-delete'></i></a>
                                            <!-- Tombol untuk menghapus data karyawan -->
                                            <a href="delete_karyawan.php?admin_id=<?php echo $dataKaryawan['admin_id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');"><i class='nc-icon nc-simple-remove'></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    $no++; // Menambah nomor urut
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