<?php
session_start();
include 'koneksi.php';
$title = "Edit Ketersediaan Lapangan | Penyewaan Lapangan";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan ID ketersediaan yang akan diedit
if (isset($_GET['id'])) {
    $ketersediaan_id = $_GET['id'];
    $query = "SELECT * FROM ketersediaan_lapangan WHERE ketersediaan_id = $ketersediaan_id";
    $result = mysqli_query($db, $query);

    if ($result) {
        $data = mysqli_fetch_array($result);
    } else {
        $_SESSION['delete_message'] = "Data ketersediaan tidak ditemukan.";
        header("Location: data_ketersediaan.php");
        exit();
    }
} else {
    header("Location: data_ketersediaan.php");
    exit();
}

// Menangani form submission untuk memperbarui data ketersediaan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lapangan_id = $_POST['lapangan_id'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $status_ketersediaan = $_POST['status_ketersediaan'];

    $query = "UPDATE ketersediaan_lapangan SET lapangan_id = '$lapangan_id', tanggal = '$tanggal', jam_mulai = '$jam_mulai', jam_selesai = '$jam_selesai', status_ketersediaan = '$status_ketersediaan' WHERE ketersediaan_id = $ketersediaan_id";

    if (mysqli_query($db, $query)) {
        $_SESSION['success_message'] = "Ketersediaan lapangan berhasil diperbarui.";
    } else {
        $_SESSION['delete_message'] = "Gagal memperbarui ketersediaan lapangan.";
    }

    header("Location: data_ketersediaan.php");
    exit();
}

include 'header.php';
include 'sidebar.php';
?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Ketersediaan Lapangan</h5>
                </div>
                <div class="card-body">
                    <form action="edit_ketersediaan.php?id=<?php echo $ketersediaan_id; ?>" method="POST">
                        <div class="form-group">
                            <label for="lapangan_id">Nama Lapangan</label>
                            <select class="form-control" id="lapangan_id" name="lapangan_id" required>
                                <?php
                                $queryLapangan = mysqli_query($db, "SELECT * FROM lapangan");
                                while ($dataLapangan = mysqli_fetch_array($queryLapangan)) {
                                    $selected = ($dataLapangan['lapangan_id'] == $data['lapangan_id']) ? 'selected' : '';
                                    echo "<option value='" . $dataLapangan['lapangan_id'] . "' $selected>" . $dataLapangan['nama_lapangan'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $data['tanggal']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="<?php echo $data['jam_mulai']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="<?php echo $data['jam_selesai']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="status_ketersediaan">Status Ketersediaan</label>
                            <select class="form-control" id="status_ketersediaan" name="status_ketersediaan" required>
                                <option value="Tersedia" <?php echo ($data['status_ketersediaan'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                <option value="Tidak Tersedia" <?php echo ($data['status_ketersediaan'] == 'Tidak Tersedia') ? 'selected' : ''; ?>>Tidak Tersedia</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="data_ketersediaan.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
