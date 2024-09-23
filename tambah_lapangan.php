<?php
session_start();
include 'koneksi.php';
$title = "Tambah Lapangan | Penyewaan Lapangan";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$success_message = "";
$error_message = "";

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lapangan = $_POST['nama_lapangan'];
    $jenis_lapangan = $_POST['jenis_lapangan'];
    $tarif_per_jam = $_POST['tarif_per_jam'];
    $keterangan = $_POST['keterangan'];
    $gambar = $_FILES['gambar']['name'];
    $target = "gambar_lapangan/" . basename($gambar);

    // Simpan file gambar ke folder gambar_lapangan
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
        $query = "INSERT INTO lapangan (nama_lapangan, jenis_lapangan, tarif_per_jam, keterangan, gambar) 
                  VALUES ('$nama_lapangan', '$jenis_lapangan', '$tarif_per_jam', '$keterangan', '$gambar')";
        if (mysqli_query($db, $query)) {
            $_SESSION['success_message'] = "Lapangan berhasil ditambahkan.";
            header("Location: data_lapangan.php");
            exit();
        } else {
            $error_message = "Gagal menambahkan lapangan.";
        }
    } else {
        $error_message = "Gagal mengunggah gambar.";
    }
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
            <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tambah Lapangan</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nama_lapangan">Nama Lapangan</label>
                            <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_lapangan">Jenis Lapangan</label>
                            <input type="text" class="form-control" id="jenis_lapangan" name="jenis_lapangan" required>
                        </div>
                        <div class="form-group">
                            <label for="tarif_per_jam">Tarif per Jam</label>
                            <input type="number" step="0.01" class="form-control" id="tarif_per_jam" name="tarif_per_jam" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
