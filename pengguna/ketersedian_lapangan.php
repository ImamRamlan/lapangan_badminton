<?php
session_start(); // Mulai sesi
include '../koneksi.php';
$title = "Ketersediaan Lapangan | Reservasi Lapangan Badminton";
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pengguna'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login_pengguna.php");
    exit();
}
$pengguna = $_SESSION['pengguna'];

// Query untuk mengambil data ketersediaan lapangan
$query = "SELECT ketersediaan_lapangan.*, lapangan.nama_lapangan, lapangan.gambar 
          FROM ketersediaan_lapangan 
          INNER JOIN lapangan ON ketersediaan_lapangan.lapangan_id = lapangan.lapangan_id";
$result = mysqli_query($db, $query);

// Memeriksa apakah query berhasil
if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($db));
}
?>

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
            <div class="col-xl-6 col-lg-8">
                <h1>Ketersediaan Lapangan<span>.</span></h1>
                <h2>Informasi Ketersediaan Lapangan</h2>
            </div>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">
    <section class="portfolio">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Ketersediaan Lapangan</h2>
                <p>Daftar Ketersediaan Lapangan</p>
            </div>
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">
                            <a href="#">
                                <img src="../gambar_lapangan/<?php echo htmlspecialchars($row['gambar']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['nama_lapangan']); ?>">
                            </a>
                            <div class="portfolio-info">
                                <h4><?php echo $row['nama_lapangan']; ?></h4>
                                <h4>Tanggal: <?php echo $row['tanggal']; ?></h4>
                                <h4>Waktu: <?php echo $row['jam_mulai'] . ' - ' . $row['jam_selesai']; ?></h4>
                                <h4>Status: <?php echo $row['status_ketersediaan']; ?></h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
