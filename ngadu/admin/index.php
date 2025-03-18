<?php
// dashboard.php

session_start();

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
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
    <title>Dashboard Admin - Pengaduan Masyarakat</title>
    <!-- Link ke AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css">
    <style>
        /* Kustomisasi tambahan jika diperlukan */
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
                <!-- Sidebar Menu -->
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
            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Dashboard Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="jumbotron jumbotron-fluid">
                                <div class="container">
                                    <h1 class="display-4">Halo, Admin!</h1>
                                    <p class="lead">Selamat datang di dashboard pengaduan masyarakat. Di sini Anda dapat mengelola aduan yang masuk.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dashboard Content -->
                    <div class="row">
                        <!-- Pengaduan Baru -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pengaduan Baru</h3>
                                </div>
                                <div class="card-body">
                                    <p>Anda dapat melihat pengaduan baru yang masuk dan menindaklanjutinya.</p>
                                    <a href="proses_pengaduan.php" class="btn btn-primary btn-block">Lihat Pengaduan Baru</a>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Pengaduan -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Riwayat Pengaduan</h3>
                                </div>
                                <div class="card-body">
                                    <p>Lihat riwayat pengaduan yang sudah diproses beserta statusnya.</p>
                                    <a href="riwayat_pengaduan.php" class="btn btn-warning btn-block">Lihat Riwayat Pengaduan</a>
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
</body>
</html>
