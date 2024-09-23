<?php
session_start();
include 'koneksi.php';
$title = "Dashboard | Lapangan Badminton";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Query untuk menghitung jumlah reservasi
$reservasi_query = "SELECT COUNT(*) as total_reservasi FROM reservasi";
$reservasi_result = mysqli_query($db, $reservasi_query);
$reservasi_data = mysqli_fetch_assoc($reservasi_result);
$total_reservasi = $reservasi_data['total_reservasi'];

// Query untuk menghitung total pemasukan
$pemasukan_query = "SELECT SUM(total_bayar) as total_pemasukan FROM reservasi";
$pemasukan_result = mysqli_query($db, $pemasukan_query);
$pemasukan_data = mysqli_fetch_assoc($pemasukan_result);
$total_pemasukan = $pemasukan_data['total_pemasukan'];

// Query untuk menghitung jumlah lapangan
$lapangan_query = "SELECT COUNT(*) as total_lapangan FROM lapangan";
$lapangan_result = mysqli_query($db, $lapangan_query);
$lapangan_data = mysqli_fetch_assoc($lapangan_result);
$total_lapangan = $lapangan_data['total_lapangan'];

// Query untuk menghitung jumlah pengguna
$pengguna_query = "SELECT COUNT(*) as total_pengguna FROM pengguna";
$pengguna_result = mysqli_query($db, $pengguna_query);
$pengguna_data = mysqli_fetch_assoc($pengguna_result);
$total_pengguna = $pengguna_data['total_pengguna'];

include 'header.php';
?>
<?php include 'sidebar.php'; ?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">
                    <h5>Selamat Datang !</h5>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-globe text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Reservasi</p>
                                                <p class="card-title"><?php echo $total_reservasi; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-refresh"></i>
                                        Update Now
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-money-coins text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Jumlah Pemasukan</p>
                                                <p class="card-title">Rp <?php echo number_format($total_pemasukan, 2, ',', '.'); ?>
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-calendar-o"></i>
                                        Last day
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-vector text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Lapangan</p>
                                                <p class="card-title"><?php echo $total_lapangan; ?>
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i>
                                        In the last hour
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-favourite-28 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Pengguna</p>
                                                <p class="card-title"><?php echo $total_pengguna; ?>
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-refresh"></i>
                                        Update now
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
