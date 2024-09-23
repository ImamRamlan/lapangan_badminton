<?php
session_start();
include 'koneksi.php';
$title = "Tambah Ketersediaan Lapangan | Penyewaan Lapangan";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lapangan_id = $_POST['lapangan_id'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $status_ketersediaan = $_POST['status_ketersediaan'];

    $query = "INSERT INTO ketersediaan_lapangan (lapangan_id, tanggal, jam_mulai, jam_selesai, status_ketersediaan) 
              VALUES ('$lapangan_id', '$tanggal', '$jam_mulai', '$jam_selesai', '$status_ketersediaan')";

    if (mysqli_query($db, $query)) {
        $_SESSION['success_message'] = "Ketersediaan lapangan berhasil ditambahkan.";
    } else {
        $_SESSION['delete_message'] = "Gagal menambahkan ketersediaan lapangan.";
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
                    <h5 class="card-title">Tambah Ketersediaan Lapangan</h5>
                </div>
                <div class="card-body">
                    <form action="tambah_ketersediaan.php" method="POST">
                        <div class="form-group">
                            <label for="lapangan_id">Nama Lapangan</label>
                            <select class="form-control" id="lapangan_id" name="lapangan_id" required>
                                <?php
                                $queryLapangan = mysqli_query($db, "SELECT * FROM lapangan");
                                while ($dataLapangan = mysqli_fetch_array($queryLapangan)) {
                                    echo "<option value='" . $dataLapangan['lapangan_id'] . "'>" . $dataLapangan['nama_lapangan'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                        </div>
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                        </div>
                        <div class="form-group">
                            <label for="status_ketersediaan">Status Ketersediaan</label>
                            <select class="form-control" id="status_ketersediaan" name="status_ketersediaan" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Tidak Tersedia">Tidak Tersedia</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        <a href="data_ketersediaan.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
