<?php
session_start();
include 'koneksi.php';
$title = "Edit Karyawan | Penyewaan Lapangan";

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter admin_id telah diberikan
if (!isset($_GET['admin_id'])) {
    header("Location: data_karyawan.php");
    exit();
}

// Inisialisasi variabel error_message
$error_message = "";

// Periksa apakah terdapat pesan error, jika ada, atur pesan tersebut ke variabel
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];

    // Hapus pesan error dari session agar tidak ditampilkan lagi setelah refresh
    unset($_SESSION['error_message']);
}

// Ambil admin_id dari parameter URL
$admin_id = $_GET['admin_id'];

// Query untuk mendapatkan data karyawan berdasarkan admin_id
$query = "SELECT * FROM admin WHERE admin_id = $admin_id";
$result = mysqli_query($db, $query);

// Periksa apakah data karyawan dengan admin_id yang diberikan ditemukan
if (mysqli_num_rows($result) === 0) {
    header("Location: data_karyawan.php");
    exit();
}

// Fetch data karyawan dari hasil query
$dataKaryawan = mysqli_fetch_assoc($result);

// Proses pengeditan data karyawan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai input dari formulir
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $alamat = $_POST['alamat'];
    $keterangan = $_POST['keterangan'];

    // Query untuk melakukan update data karyawan
    $update_query = "UPDATE admin SET nama = '$nama', username = '$username', role = '$role', alamat = '$alamat', keterangan = '$keterangan'";

    // Jika password diisi, tambahkan ke dalam query update
    if (!empty($password)) {
        $update_query .= ", password = '$password'";
    }

    $update_query .= " WHERE admin_id = $admin_id";

    // Jalankan query update
    $update_result = mysqli_query($db, $update_query);

    if ($update_result) {
        // Set pesan sukses
        $_SESSION['success_message'] = "Data karyawan berhasil diupdate.";

        // Redirect ke halaman data karyawan setelah berhasil mengupdate data
        header("Location: data_karyawan.php");
        exit();
    } else {
        // Jika terjadi kesalahan dalam mengupdate data, atur pesan kesalahan
        $_SESSION['error_message'] = "Gagal mengupdate data karyawan.";
        header("Location: edit_karyawan.php?admin_id=$admin_id");
        exit();
    }
}

include 'header.php';
include 'sidebar.php';
?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Data Karyawan</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($error_message)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?admin_id=' . $admin_id; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" value="<?php echo $dataKaryawan['nama']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="<?php echo $dataKaryawan['username']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Masukkan Password Baru">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="role" required>
                                        <option value="admin" <?php echo ($dataKaryawan['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        <option value="karyawan" <?php echo ($dataKaryawan['role'] === 'karyawan') ? 'selected' : ''; ?>>Karyawan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-round">Simpan Perubahan</button>
                                    <a href="data_karyawan.php" class="btn btn-secondary btn-round">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>