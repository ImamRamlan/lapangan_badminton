<?php
session_start(); // Mulai sesi
include '../koneksi.php';
$title = "Pesan Lapangan | Reservasi Lapangan Badminton";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pengguna'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login_pengguna.php");
    exit();
}
$pengguna = $_SESSION['pengguna'];
// Ambil lapangan_id dari query string
$lapangan_id = $_GET['lapangan_id'];

// Ambil data lapangan dari database
$query = "SELECT * FROM lapangan WHERE lapangan_id = '$lapangan_id'";
$result = mysqli_query($db, $query);

// Memeriksa apakah query berhasil
if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($db));
}

$lapangan = mysqli_fetch_assoc($result);

// Inisialisasi pesan sukses
$success_message = '';

// Jika tombol pesan diklik
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan dari formulir
    $pengguna_id = $_SESSION['pengguna']['pengguna_id']; // Anda perlu menyimpan ID pengguna dalam sesi saat login
    $tanggal = $_POST['tanggal'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $total_bayar = $_POST['total_bayar'];
    $status_pembayaran = 'Belum';
    $status_reservasi = 'Sudah';
    // File upload
    $foto_pembayaran = ''; // Nilai default
    if ($_FILES['foto_pembayaran']['name']) {
        $nama_file = $_FILES['foto_pembayaran']['name'];
        $tmp_file = $_FILES['foto_pembayaran']['tmp_name'];
        $extensi = pathinfo($nama_file, PATHINFO_EXTENSION);
        // Ubah nama file untuk menghindari nama file yang sama
        $foto_pembayaran = uniqid() . '.' . $extensi;
        // Lokasi penyimpanan file
        $lokasi = '../bukti_pembayaran/' . $foto_pembayaran;
        // Upload file ke lokasi yang ditentukan
        if (move_uploaded_file($tmp_file, $lokasi)) {
            $success_message = "Bukti pembayaran berhasil diupload. Silahkan menunggu konfirmasi";
        } else {
            $error = "Gagal mengupload bukti pembayaran.";
        }
    }

    // Query SQL untuk menyimpan data reservasi ke tabel reservasi
    $query_pesan = "INSERT INTO reservasi (lapangan_id, pengguna_id, tanggal, waktu_mulai, waktu_selesai, total_bayar, status_pembayaran, status_reservasi, foto_pembayaran) 
                    VALUES ('$lapangan_id', '$pengguna_id', '$tanggal', '$waktu_mulai', '$waktu_selesai', '$total_bayar', '$status_pembayaran', '$status_reservasi', '$foto_pembayaran')";

    // Eksekusi query
    if (mysqli_query($db, $query_pesan)) {
        $_SESSION['pesan'] = "Reservasi lapangan berhasil.";
        header("Location: lapangan.php"); // Redirect ke halaman daftar lapangan setelah berhasil
        exit();
    } else {
        $error = "Gagal melakukan reservasi: " . mysqli_error($db);
    }
}

include 'header.php';
?>

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
            <div class="col-xl-6 col-lg-8">
                <h1>Pesan Lapangan<span>.</span></h1>
                <h2>Reservasi Lapangan Badminton</h2>
            </div>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">
    <section class="portfolio">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Pesan Lapangan</h2>
                <p><?php echo htmlspecialchars($lapangan['nama_lapangan']); ?></p>
            </div>
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <h2>Gambar Lapangan</h2>
                    <img src="../gambar_lapangan/<?php echo htmlspecialchars($lapangan['gambar']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($lapangan['nama_lapangan']); ?>">
                </div>
                <div class="col-lg-8 col-md-6 portfolio-item filter-card">
                    <?php if (!empty($success_message)) { ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php } ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?lapangan_id=' . htmlspecialchars($lapangan_id); ?>" method="post" enctype="multipart/form-data" id="reservationForm">
                        <div class="form-group">
                            <label for="tanggal">Tanggal Reservasi</label>
                            <input type="date" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required class="form-control">
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <input type="time" id="waktu_mulai" name="waktu_mulai" required class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="waktu_selesai">Waktu Selesai</label>
                                <input type="time" id="waktu_selesai" name="waktu_selesai" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="jam">Durasi (Jam)</label>
                                <input type="text" id="jam" name="jam" required class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="total_bayar">Total Bayar (Rp)</label>
                                <input type="text" id="total_bayar" name="total_bayar" required class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="foto_pembayaran">Upload Bukti Pembayaran</label>
                            <input type="file" id="foto_pembayaran" name="foto_pembayaran" accept="image/*" required class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Pesan Lapangan</button>
                        <a href="lapangan.php" class="btn btn-success">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const waktuMulaiInput = document.getElementById('waktu_mulai');
    const waktuSelesaiInput = document.getElementById('waktu_selesai');
    const durasiInput = document.getElementById('jam');
    const totalBayarInput = document.getElementById('total_bayar');

    function calculateDurationAndTotal() {
        const tarifPerJam = <?php echo $lapangan['tarif_per_jam']; ?>;
        const waktuMulai = waktuMulaiInput.value;
        const waktuSelesai = waktuSelesaiInput.value;

        if (waktuMulai && waktuSelesai) {
            const mulai = new Date('1970-01-01T' + waktuMulai + 'Z');
            const selesai = new Date('1970-01-01T' + waktuSelesai + 'Z');
            const diffMs = selesai - mulai;
            const diffHrs = diffMs / (1000 * 60 * 60);

            if (diffHrs > 0) {
                durasiInput.value = diffHrs.toFixed(2);
                totalBayarInput.value = (diffHrs * tarifPerJam).toFixed(2);
            } else {
                durasiInput.value = '';
                totalBayarInput.value = '';
            }
        }
    }

    waktuMulaiInput.addEventListener('change', calculateDurationAndTotal);
    waktuSelesaiInput.addEventListener('change', calculateDurationAndTotal);
});
</script>

<?php include 'footer.php'; ?>
