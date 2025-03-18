<?php
// kelola_users.php

session_start();

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
include '../config/db.php';

// Ambil data pengguna menggunakan prepared statement
$stmt = $conn->prepare("SELECT id, nama, email, alamat, nik, created_at FROM users");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Users - Pengaduan Masyarakat</title>
    <!-- Link ke AdminLTE dan Font Awesome -->
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
                                    <h1 class="display-4">Kelola User</h1>
                                    <p class="lead">Disini Anda Dapat Mengubah Data User atau Menghapus User.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>NIK</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']); ?></td>
                                        <td><?= htmlspecialchars($row['nama']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                                        <td><?= htmlspecialchars($row['nik']); ?></td>
                                        <td><?= htmlspecialchars($row['created_at']); ?></td>
                                        <td>
                                            <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="hapus_user.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?');">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Sistem Pengaduan Masyarakat
            </div>
            <strong>&copy; 2024 <a href="#">Sistem Pengaduan Masyarakat</a>.</strong> All Rights Reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
