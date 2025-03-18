<?php
// dashboard.php

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari session
$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Kustomisasi tambahan */
        .hero-section {
            background-color: #f8f9fa;
            padding: 30px 0;
        }
        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-title {
            font-weight: bold;
        }
        .dashboard-header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
        }
        .dashboard-footer {
            background-color: #f8f9fa;
            padding: 20px 0;
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
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="akun.php">Akun</a>
                         </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <section class="dashboard-header text-center">
        <div class="container">
            <h1 class="display-4">Halo, <?php echo htmlspecialchars($user_email); ?>!</h1>
            <p class="lead">Selamat datang di dashboard pengaduan masyarakat. Silakan ajukan pengaduan atau lihat status pengaduan Anda.</p>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="container my-5">
        <div class="row">
            <!-- Pengaduan Baru -->
            <div class="col-md-4">
                <div class="card">
                    <img src="uploads/img/ajuan.png" alt="Pengaduan Baru" class="card-img-top card-img">
                    <div class="card-body">
                        <h5 class="card-title">Ajukan Pengaduan Baru</h5>
                        <p class="card-text">Jika Anda ingin mengajukan pengaduan, klik tombol di bawah untuk mulai mengisi pengaduan.</p>
                        <a href="form_pengaduan.php" class="btn btn-primary">Ajukan Pengaduan</a>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pengaduan -->
            <div class="col-md-4">
                <div class="card">
                    <img src="uploads/img/riwayat.png" alt="Riwayat Pengaduan" class="card-img-top card-img">
                    <div class="card-body">
                        <h5 class="card-title">Riwayat Pengaduan</h5>
                        <p class="card-text">Lihat riwayat pengaduan yang telah Anda ajukan dan statusnya.</p>
                        <a href="riwayat_pengaduan.php" class="btn btn-warning">Riwayat Pengaduan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="dashboard-footer text-center">
        <p>&copy; 2024 Sistem Pengaduan Masyarakat | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
