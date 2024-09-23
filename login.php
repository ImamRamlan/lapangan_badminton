<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Karyawan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://admin.saraga.id/storage/images/20211005-130436_1633429019.jpg'); /* Ganti 'background-image.jpg' dengan URL gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Tambahkan opasitas putih ke latar belakang */
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        h5, .note {
            text-align: center;
            margin-bottom: 20px;
            color: #333; /* Ubah warna teks */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .note {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h5>Masuk | Karyawan</h5>
        <p class="note">Silahkan Login Untuk sesi anda.</p>
        <?php
        // Tampilkan pesan kesalahan jika ada
        if(isset($_GET['error'])) {
            $error = $_GET['error'];
            echo "<div class='alert alert-danger' role='alert'>$error</div>";
        }
        ?>
        <form action="login.php" method="POST" id="loginForm">
            <input type="text" id="username" name="username" required placeholder="Masukkan Username..">
            <input type="password" id="password" name="password" required placeholder="Masukkan Kata sandi..">
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="karyawan">Karyawan</option>
            </select><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>

<?php
session_start(); // Mulai sesi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'koneksi.php';

    // Mendapatkan nilai dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Melakukan query ke database
    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password' AND role='$role'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // Jika login berhasil
        $row = $result->fetch_assoc();
        
        // Simpan informasi ke dalam sesi
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $role;

        // Redirect sesuai role
        if ($role == 'admin') {
            header("Location: admin_dashboard.php"); // Ganti dengan halaman dashboard admin
        } elseif ($role == 'karyawan') {
            header("Location: admin_dashboard.php"); // Ganti dengan halaman dashboard karyawan
        }
    } else {
        // Jika login gagal, redirect kembali ke halaman login dengan pesan kesalahan
        header("Location: login.php?error=Login gagal. <BR>Periksa kembali username, password, dan role Anda.");
    }

    $db->close();
}
?>
