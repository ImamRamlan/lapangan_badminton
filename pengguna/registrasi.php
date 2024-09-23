<?php
include '../koneksi.php';
require '../vendor/autoload.php';  // Pastikan Anda telah menginstal PHPMailer melalui Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fungsi untuk memeriksa koneksi internet
function checkInternetConnection() {
    $connected = @fsockopen("www.google.com", 80); 
    if ($connected){
        fclose($connected);
        return true; 
    } else {
        return false; 
    }
}

// Inisialisasi pesan error
$error = '';

// Periksa apakah formulir sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirim dari formulir
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nomor_telepon = $_POST['nomor_telepon'];

    // Periksa koneksi internet
    if (!checkInternetConnection()) {
        $error = "Tidak ada koneksi internet. Silakan coba lagi nanti.";
    } else {
        // Query SQL untuk memeriksa keberadaan username
        $check_query = "SELECT * FROM pengguna WHERE username = ?";
        $stmt = mysqli_prepare($db, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Jika hasil query mengembalikan baris, berarti username sudah ada
        if (mysqli_num_rows($result) > 0) {
            $error = "Username sudah terdaftar. Silakan gunakan username lain.";
        } else {
            // Query SQL untuk menyimpan data ke dalam tabel pengguna
            $query = "INSERT INTO pengguna (nama, username, email, password, nomor_telepon) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "sssss", $nama, $username, $email, $password, $nomor_telepon);

            // Eksekusi query
            if (mysqli_stmt_execute($stmt)) {
                // Pengiriman email konfirmasi
                $mail = new PHPMailer(true);
                try {
                    // Konfigurasi server email
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'imamkiller77@gmail.com';
                    $mail->Password   = 'kxhgtasckhixnrcf';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port       = 465;
                    // Penerima email
                    $mail->setFrom('imamkiller77@gmail.com', 'Lapangan Badminton');
                    $mail->addAddress($email); // Email pengguna

                    // Konten email
                    $mail->isHTML(true);
                    $mail->Subject = 'Konfirmasi Registrasi';
                    $mail->Body    = "Halo $nama,<br><br>Terima kasih telah mendaftar di aplikasi Lapangan Badminton.<br>".
                    "Berikut adalah detail informasi registrasi Anda:<br>" .
                    "Nama: $nama<br>" .
                    "Username: $username<br>" .
                    "Email: $email<br>" .
                    "Password: $password<br>" .
                    "Nomor Telepon: $nomor_telepon<br><br>" .
                    "Terima kasih!";
                    

                    // Kirim email
                    if ($mail->send()) {
                        echo "<div class='alert alert-success' role='alert'>
                                Registrasi akun berhasil, silahkan cek email Anda untuk konfirmasi.
                              </div>";
                    } else {
                        // Hapus data dari database jika email gagal terkirim
                        $delete_query = "DELETE FROM pengguna WHERE username = ?";
                        $stmt_delete = mysqli_prepare($db, $delete_query);
                        mysqli_stmt_bind_param($stmt_delete, "s", $username);
                        mysqli_stmt_execute($stmt_delete);

                        echo "<div class='alert alert-danger' role='alert'>
                                Gagal mengirim email konfirmasi. Registrasi dibatalkan.
                              </div>";
                    }
                } catch (Exception $e) {
                    // Hapus data dari database jika email gagal terkirim
                    $delete_query = "DELETE FROM pengguna WHERE username = ?";
                    $stmt_delete = mysqli_prepare($db, $delete_query);
                    mysqli_stmt_bind_param($stmt_delete, "s", $username);
                    mysqli_stmt_execute($stmt_delete);

                    echo "<div class='alert alert-danger' role='alert'>
                            Gagal mengirim email konfirmasi. Registrasi dibatalkan.
                          </div>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>
                        Gagal registrasi, silahkan periksa kembali form anda.: " . mysqli_error($db) . "
                      </div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("background.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 90vh;
        }
    </style>
    <script>
        function checkInternetConnection() {
            if (!navigator.onLine) {
                alert("Tidak ada koneksi internet. Silakan periksa koneksi Anda dan coba lagi.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Registrasi Akun</div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return checkInternetConnection();">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required>
                                <!-- Tampilkan pesan error jika ada -->
                                <div class="text-danger"><?php echo $error; ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon" placeholder="Masukkan Nomor Telepon" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Daftar</button> <a href="login_pengguna.php" class="btn btn-success">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
