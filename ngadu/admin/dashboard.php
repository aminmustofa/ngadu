<?php
// dashboard.php

session_start();

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari session
$user_email = $_SESSION['email'];

// Contoh mengambil data statistik dari database
include '../config/db.php';

// Pengaduan baru
$query_baru = "SELECT COUNT(*) FROM pengaduan WHERE status = 'Tunggu'";
$result_baru = mysqli_query($conn, $query_baru);
$row_baru = mysqli_fetch_assoc($result_baru);
$jumlah_baru = $row_baru['COUNT(*)'];

$query_proses = "SELECT COUNT(*) FROM pengaduan WHERE status = 'Proses'";
$result_proses = mysqli_query($conn, $query_proses);
$row_proses = mysqli_fetch_assoc($result_proses);
$jumlah_proses = $row_proses['COUNT(*)'];

$query_selesai = "SELECT COUNT(*) FROM pengaduan WHERE status = 'Selesai'";
$result_selesai = mysqli_query($conn, $query_selesai);
$row_selesai = mysqli_fetch_assoc($result_selesai);
$jumlah_selesai = $row_selesai['COUNT(*)'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pengaduan Masyarakat</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <style>
        .dashboard-header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
        }
        .dashboard-footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .statistik-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .btn-block {
            margin-top: 10px;
        }
        .btn {
            font-size: 16px;
        }
        .row {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <div class="container">
                <a class="navbar-brand" href="dashboard.php">
                    <b>Sistem Pengaduan</b> Masyarakat
                </a>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="../uploads/img/admin.jpg" alt="Admin Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Admin Dashboard</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link active">
                                <i class="fa fa-tachometer"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="riwayat_pengaduan.php" class="nav-link">
                                <i class="fa fa-history"></i>
                                <p>Riwayat Pengaduan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="proses_pengaduan.php" class="nav-link">
                                <i class="fa fa-cogs"></i>
                                <p>Proses Pengaduan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="kelola_users.php" class="nav-link">
                                <i class="fa fa-users"></i>
                                <p>Kelola Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="kelola_admin.php" class="nav-link">
                                <i class="fa fa-users"></i>
                                <p>Kelola Admin</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <!-- Dashboard Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="jumbotron jumbotron-fluid">
                                <div class="container">
                                    <h1 class="display-6">Halo, Admin!</h1>
                                    <p class="lead">Selamat datang di dashboard pengaduan masyarakat. Di sini Anda dapat mengelola aduan yang masuk.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Statistik Pengaduan (Pie Chart) -->
                    <div class="col-lg-6">
                            <div class="card statistik-card">
                                <div class="card-header">
                                    <h3 class="card-title">Statistik Pengaduan</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="pengaduanChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    <!-- Dashboard Content -->
                    <div class="row">
                        <!-- Pengaduan Baru  -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pengaduan Baru</h3>
                                </div>
                                <div class="card-body">
                                    <p>Jumlah pengaduan baru yang perlu ditindaklanjuti: <?php echo $jumlah_baru; ?></p>
                                    <a href="proses_pengaduan.php" class="btn btn-primary btn-block">Lihat Pengaduan Baru</a>
                                </div>
                            </div>
                        </div>

                        <!-- Pengaduan Proses -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pengaduan Dalam Proses</h3>
                                </div>
                                <div class="card-body">
                                    <p>Jumlah pengaduan yang sedang diproses: <?php echo $jumlah_proses; ?></p>
                                    <a href="proses_pengaduan.php" class="btn btn-warning btn-block">Lihat Pengaduan Proses</a>
                                </div>
                            </div>
                        </div>

                        <!-- Pengaduan Selesai -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pengaduan Selesai</h3>
                                </div>
                                <div class="card-body">
                                    <p>Jumlah pengaduan yang sudah selesai diproses: <?php echo $jumlah_selesai; ?></p>
                                    <a href="riwayat_pengaduan.php" class="btn btn-success btn-block">Lihat Riwayat Pengaduan</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </section>
        </div><!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Sistem Pengaduan Masyarakat
            </div>
            <strong>&copy; 2024 <a href="#">Sistem Pengaduan Masyarakat</a>.</strong> All Rights Reserved.
        </footer>
    </div><!-- ./wrapper -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
    <script>
        var ctx = document.getElementById('pengaduanChart').getContext('2d');
        var pengaduanChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pengaduan Baru', 'Pengaduan Proses', 'Pengaduan Selesai'],
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: [<?php echo $jumlah_baru; ?>, <?php echo $jumlah_proses; ?>, <?php echo $jumlah_selesai; ?>],
                    backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 159, 64, 0.6)', 'rgba(75, 192, 192, 0.6)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 159, 64, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>
