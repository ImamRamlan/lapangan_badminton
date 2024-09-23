<?php
session_start(); // Mulai sesi
include '../koneksi.php';
$title = "Riwayat Reservasi | Reservasi Lapangan Badminton";
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pengguna'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login_pengguna.php");
    exit();
}
$pengguna = $_SESSION['pengguna'];

// Ambil data reservasi pengguna dari database, termasuk informasi lapangan
$query = "SELECT reservasi.*, lapangan.nama_lapangan, lapangan.gambar 
          FROM reservasi 
          INNER JOIN lapangan ON reservasi.lapangan_id = lapangan.lapangan_id 
          WHERE reservasi.pengguna_id = '{$pengguna['pengguna_id']}'";
$result = mysqli_query($db, $query);

?>

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
            <div class="col-xl-6 col-lg-8">
                <h1>Riwayat Reservasi<span>.</span></h1>
                <h2>Daftar Riwayat Reservasi Anda</h2>
            </div>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">
    <section class="portfolio">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Riwayat Reservasi</h2>
                <p>Daftar Riwayat Reservasi Anda</p>
            </div>
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                <?php 
                if (mysqli_num_rows($result) > 0) { // Cek apakah ada riwayat reservasi
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                            <div class="portfolio-wrap">
                                <a href="#">
                                    <img src="../gambar_lapangan/<?php echo htmlspecialchars($row['gambar']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['nama_lapangan']); ?>">
                                </a>
                                <div class="portfolio-info">
                                    <h4><?php echo $row['nama_lapangan']; ?></h4>
                                    <h4>Status Pembayaran: <?php echo $row['status_pembayaran']; ?></h4>
                                    <div class="portfolio-links">
                                        <a href="detail_riwayat.php?id=<?php echo $row['reservasi_id']; ?>" title="Detail Riwayat"><i class="bx bx-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } 
                } else { // Jika tidak ada riwayat reservasi ?>
                    <div class="col-lg-12">
                        <p>Anda belum memiliki riwayat reservasi.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
