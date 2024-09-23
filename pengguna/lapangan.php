<?php
session_start(); // Mulai sesi
include '../koneksi.php';
$title = "Lapangan | Lapangan Badminton";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['pengguna'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_pengguna.php");
    exit();
}
// Ambil data pengguna dari sesi
$pengguna = $_SESSION['pengguna'];
include 'header.php';

// Ambil data lapangan dari database
$query = "SELECT * FROM lapangan";
$result = mysqli_query($db, $query);

// Ambil data reservasi lapangan yang sudah terjadi
$reservasi_query = "SELECT DISTINCT lapangan_id FROM reservasi WHERE status_reservasi = 'Sudah'";
$reservasi_result = mysqli_query($db, $reservasi_query);
$reservasi_lapangan = [];
while ($row = mysqli_fetch_assoc($reservasi_result)) {
    $reservasi_lapangan[] = $row['lapangan_id'];
}

?>
<main id="main">
    <section class="portfolio">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Lapangan</h2>
                <p>Daftar Lapangan</p>
            </div>
            <?php
                if (isset($_SESSION['pesan'])) {
                    echo '<div class="alert alert-info">' . $_SESSION['pesan'] . '</div>';
                    unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan
                }
                ?>
            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
               
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">
                            <a href="#">
                                <img src="../gambar_lapangan/<?php echo htmlspecialchars($row['gambar']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['nama_lapangan']); ?>">
                            </a>
                            <div class="portfolio-info">
                                <h4><?php echo htmlspecialchars($row['nama_lapangan']); ?></h4>
                                <p><?php echo htmlspecialchars($row['keterangan']); ?></p>
                                <div class="portfolio-links">
                                    <?php if (in_array($row['lapangan_id'], $reservasi_lapangan)) { ?>
                                        <span class="text-danger">Lapangan sudah dipesan</span>
                                    <?php } else { ?>
                                        <a href="reservasi.php?lapangan_id=<?php echo $row['lapangan_id']; ?>" title="Pesan Tiket"><i class="bx bx-plus"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <h5>Tarif: Rp <?php echo number_format($row['tarif_per_jam'], 0, ',', '.'); ?> per jam</h5>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>