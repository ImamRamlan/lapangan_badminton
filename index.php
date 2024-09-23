<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Memposisikan konten ke atas */
            min-height: 100vh;
        }

        .container {
            margin-top: 50px; /* Jarak dari atas */
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0 text-center"></h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted text-center">Silakan pilih sesi Anda untuk login.</p>
                        <div class="d-flex justify-content-center mb-3">
                            <a href="login.php" class="btn btn-info mr-3">Karyawan</a>
                            <a href="pengguna/dashboard.php" class="btn btn-outline-info">Pengguna</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
