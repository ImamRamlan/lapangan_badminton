<?php
session_start();
include 'koneksi.php';
$title = "Edit Lapangan | Penyewaan Lapangan";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$success_message = "";
$error_message = "";

// Ambil data lapangan berdasarkan id
$id = $_GET['id'];
$query = "SELECT * FROM lapangan WHERE lapangan_id = $id";
$result = mysqli_query($db, $query);
$dataLapangan = mysqli_fetch_array($result);

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lapangan = $_POST['nama_lapangan'];
    $jenis_lapangan = $_POST['jenis_lapangan'];
    $tarif_per_jam = $_POST['tarif_per_jam'];
    $keterangan = $_POST['keterangan'];
    $gambar = $_FILES['gambar']['name'];
    $target = "gambar_lapangan/" . basename($gambar);

    if (!empty($gambar)) {
        // Simpan file gambar ke folder gambar_lapangan
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            $query = "UPDATE lapangan SET nama_lapangan='$nama_lapangan', jenis_lapangan='$jenis_lapangan', tarif_per_jam='$tarif_per_jam', keterangan='$keterangan', gambar='$gambar' WHERE lapangan_id = $id";
        } else {
            $error_message = "Gagal mengunggah gambar.";
        }
    } else {
        $query = "UPDATE lapangan SET nama_lapangan='$nama_lapangan', jenis_lapangan='$jenis_lapangan', tarif_per_jam='$tarif_per_jam', keterangan='$keterangan' WHERE lapangan_id = $id";
    }

    if (mysqli_query($db, $query)) {
        $_SESSION['success_message'] = "Lapangan berhasil diupdate.";
        header("Location: data_lapangan.php");
        exit();
    } else {
        $error_message = "Gagal mengupdate lapangan.";
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
                    <h5 class="card-title">Edit Lapangan</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nama_lapangan">Nama Lapangan</label>
                            <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan" value="<?php echo $dataLapangan['nama_lapangan']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_lapangan">Jenis Lapangan</label>
                            <input type="text" class="form-control" id="jenis_lapangan" name="jenis_lapangan" value="<?php echo $dataLapangan['jenis_lapangan']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tarif_per_jam">Tarif per Jam</label>
                            <input type="number" step="0.01" class="form-control" id="tarif_per_jam" name="tarif_per_jam" value="<?php echo $dataLapangan['tarif_per_jam']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $dataLapangan['keterangan']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                            <img src="gambar_lapangan/<?php echo $dataLapangan['gambar']; ?>" alt="Gambar Lapangan" style="width: 100px;">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="data_lapangan.php" class="btn btn-warning">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
