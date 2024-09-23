<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="#" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="assets/img/logo-small.png">
            </div>
        </a>
        <a href="#" class="simple-text logo-normal">
            <?php echo $_SESSION['role'] ?> - <?php echo $_SESSION['nama'] ?>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li <?php if(basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') echo 'class="active"'; ?>>
                <a href="admin_dashboard.php">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <!-- Tampilkan fitur untuk admin -->
                <li <?php if(in_array(basename($_SERVER['PHP_SELF']), array('data_karyawan.php', 'tambah_karyawan.php', 'edit_karyawan.php'))) echo 'class="active"'; ?>>
                    <a href="data_karyawan.php">
                        <i class="nc-icon nc-diamond"></i>
                        <p>Data Karyawan</p>
                    </a>
                </li>
                <li <?php if(basename($_SERVER['PHP_SELF']) == 'data_pengguna.php') echo 'class="active"'; ?>>
                    <a href="data_pengguna.php">
                        <i class="nc-icon nc-single-02"></i>
                        <p>Data Pengguna</p>
                    </a>
                </li>
                <li <?php if(basename($_SERVER['PHP_SELF']) == 'data_lapangan.php') echo 'class="active"'; ?>>
                    <a href="data_lapangan.php">
                        <i class="nc-icon nc-pin-3"></i>
                        <p>Data Lapangan</p>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'karyawan'): ?>
                <!-- Tampilkan fitur untuk karyawan dan admin -->
                <li <?php if(basename($_SERVER['PHP_SELF']) == 'data_ketersediaan.php') echo 'class="active"'; ?>>
                    <a href="data_ketersediaan.php">
                        <i class="nc-icon nc-bell-55"></i>
                        <p>Ketersedian Lapangan</p>
                    </a>
                </li>
                <li <?php if(basename($_SERVER['PHP_SELF']) == 'data_reservasi.php') echo 'class="active"'; ?>>
                    <a href="data_reservasi.php">
                        <i class="nc-icon nc-tile-56"></i>
                        <p>Reservasi</p>
                    </a>
                </li>
            <?php endif; ?>
            <li <?php if(basename($_SERVER['PHP_SELF']) == 'logout.php') echo 'class="active"'; ?>>
                <a href="#" onclick="confirmLogout()">
                    <i class="nc-icon nc-spaceship"></i>
                    <p>Keluar</p>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    function confirmLogout() {
        var logout = confirm("Apakah Anda yakin ingin keluar?");
        if (logout) {
            window.location.href = "logout.php";
        }
    }
</script>
