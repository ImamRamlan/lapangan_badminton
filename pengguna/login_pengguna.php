<?php
session_start(); // Mulai sesi

include '../koneksi.php'; // Masukkan file koneksi.php

// Inisialisasi pesan error
$error = '';

// Periksa apakah formulir login sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirim dari formulir
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    // Query SQL untuk memeriksa apakah username/email dan password cocok
    $query = "SELECT * FROM pengguna WHERE (username = ? OR email = ?) AND password = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "sss", $identifier, $identifier, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Periksa apakah hasil query mengembalikan baris atau tidak
    if (mysqli_num_rows($result) == 1) {
        // Jika cocok, simpan data pengguna ke dalam sesi
        $row = mysqli_fetch_assoc($result);
        $_SESSION['pengguna'] = $row;

        // Redirect ke halaman berikutnya
        header("Location: dashboard.php");
        exit();
    } else {
        // Jika tidak cocok, tampilkan pesan kesalahan
        $error = "Username, email, atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url("background.jpg");
            /* Ubah 'soccer-field.jpg' sesuai dengan nama gambar Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 80vh;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
            background-color: rgba(255, 255, 255, 0.8);
            /* Menambahkan transparansi ke latar belakang */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .login-container h4 {
            text-align: center;
        }

        .login-container form {
            margin-top: 30px;
        }

        .login-container form .form-group {
            margin-bottom: 20px;
        }

        .login-container form .btn-login {
            width: 100%;
        }

        .note {
            text-align: center;
            margin-bottom: 10px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h4 class="text-center">Login</h4>
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <p class="note">Silahkan Login Untuk sesi anda.</p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="identifier">Username atau Email</label>
                <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Masukkan Username atau Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
            </div>
            <button type="submit" class="btn btn-primary btn-login">Login</button>
            <a class="link-dark link-offset-2 link-underline link-underline-opacity-0" href="registrasi.php">Daftar Akun?</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
