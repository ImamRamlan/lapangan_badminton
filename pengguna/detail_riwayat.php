<?php
session_start(); // Mulai sesi
include '../koneksi.php';
$title = "Detail Riwayat Reservasi | Reservasi Lapangan Badminton";
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pengguna'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login_pengguna.php");
    exit();
}
$pengguna = $_SESSION['pengguna'];

// Ambil reservasi_id dari query string
$reservasi_id = $_GET['id'];

// Query untuk mengambil informasi detail reservasi
$query = "SELECT reservasi.*, lapangan.nama_lapangan, lapangan.gambar 
          FROM reservasi 
          INNER JOIN lapangan ON reservasi.lapangan_id = lapangan.lapangan_id 
          WHERE reservasi.reservasi_id = '$reservasi_id'";
$result = mysqli_query($db, $query);

// Memeriksa apakah query berhasil
if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($db));
}

$reservasi = mysqli_fetch_assoc($result);
?>

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
            <div class="col-xl-6 col-lg-8">
                <h1>Detail Riwayat Reservasi<span>.</span></h1>
                <h2>Informasi Detail Reservasi</h2>
            </div>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">
    <section class="portfolio-details">
        <div class="container" data-aos="fade-up">
            <div class="portfolio-description">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="portfolio-wrap">
                            <img src="../gambar_lapangan/<?php echo $reservasi['gambar']; ?>" class="img-fluid" alt="Lapangan Image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="portfolio-info">
                            <h3>Detail Reservasi</h3>
                            <ul>
                                <li><strong>Nama Lapangan:</strong> <?php echo $reservasi['nama_lapangan']; ?></li>
                                <li><strong>Tanggal Reservasi:</strong> <?php echo $reservasi['tanggal']; ?></li>
                                <li><strong>Waktu Mulai:</strong> <?php echo $reservasi['waktu_mulai']; ?></li>
                                <li><strong>Waktu Selesai:</strong> <?php echo $reservasi['waktu_selesai']; ?></li>
                                <li><strong>Status Pembayaran:</strong> <?php echo $reservasi['status_pembayaran']; ?></li>
                                <li><strong>Status Reservasi:</strong> <?php echo $reservasi['status_reservasi']; ?></li>
                                <li><strong><a href="riwayat.php" class="btn btn-secondary btn-round">Kembali</a></strong></li>
                            </ul>
                            <?php if (!empty($reservasi['foto_pembayaran'])) : ?>
                                <div class="portfolio-links">
                                    <h3>Bukti Pembayaran</h3>
                                    <img src="../bukti_pembayaran/<?php echo $reservasi['foto_pembayaran']; ?>" class="img-fluid" alt="Bukti Pembayaran">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<?php include 'footer.php'; ?>
