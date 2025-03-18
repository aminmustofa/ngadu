<?php
session_start();

// Cek apakah pengguna sudah login
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background-image: url('uploads/img/baner.png');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sistem Pengaduan Masyarakat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($is_logged_in): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Registrasi</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di Sistem Pengaduan Masyarakat</h1>
            <p class="lead">Laporkan masalah Anda dan bantu mewujudkan perubahan di masyarakat.</p>
        </div>
    </section>

    <!-- Tata Cara Mengajukan Pengaduan -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Tata Cara Mengajukan Pengaduan</h2>
        <div class="row">
            <div class="col-md-6">
                <ul>
                    <li>Registrasi akun terlebih dahulu dengan mengisi informasi yang dibutuhkan seperti nama, alamat, email, NIK, dan mengunggah KTP.</li>
                    <li>Login ke sistem menggunakan akun yang sudah dibuat.</li>
                    <li>Setelah login, Anda dapat mengajukan pengaduan melalui dashboard dengan mengisi judul dan isi pengaduan.</li>
                    <li>Pengaduan Anda akan diproses dan statusnya akan diinformasikan di dashboard.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <img src="uploads/img/cara.png" alt="Ilustrasi Pengaduan" class="img-fluid rounded">
            </div>
        </div>
    </section>

    <!-- Fitur dan Keunggulan -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Keunggulan Sistem Pengaduan Masyarakat</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card">
                        <img src="uploads/img/1.png" class="card-img-top" alt="Keunggulan 1">
                        <div class="card-body">
                            <h5 class="card-title">Akses Mudah</h5>
                            <p class="card-text">Sistem ini mudah diakses kapan saja dan dari mana saja, memudahkan masyarakat untuk mengajukan pengaduan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="uploads/img/2.png" class="card-img-top" alt="Keunggulan 2">
                        <div class="card-body">
                            <h5 class="card-title">Transparansi</h5>
                            <p class="card-text">Setiap pengaduan akan diproses dengan transparansi, sehingga masyarakat bisa memantau status pengaduannya.</p>
                        </div>
                    </div>
                </div>  
                <div class="col-md-4">
                    <div class="card">
                        <img src="uploads/img/3.png" class="card-img-top" alt="Keunggulan 3">
                        <div class="card-body">
                            <h5 class="card-title">Keamanan Data</h5>
                            <p class="card-text">Kami menjaga data Anda dengan sangat aman, menjamin privasi setiap pengaduan yang Anda ajukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Sistem Pengaduan Masyarakat | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
