<?php
// riwayat_pengaduan.php

session_start();

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Ambil semua pengaduan dari database, termasuk kolom komentar
$query = "SELECT p.id, p.judul, p.isi, p.file_aduan, p.status, p.komentar, p.created_at, u.email AS pelapor, k.nama_kategori
          FROM pengaduan p 
          JOIN users u ON p.user_id = u.id
          JOIN kategori_pengaduan k ON p.kategori_id = k.id
          ORDER BY p.created_at DESC";
$result = $conn->query($query);
// Statistik pengaduan berdasarkan status
$status_query = "SELECT status, COUNT(*) AS count FROM pengaduan GROUP BY status";
$status_result = $conn->query($status_query);

// Statistik pengaduan berdasarkan kategori
$kategori_query = "SELECT k.nama_kategori, COUNT(*) AS count
                   FROM pengaduan p
                   JOIN kategori_pengaduan k ON p.kategori_id = k.id
                   GROUP BY k.nama_kategori";
$kategori_result = $conn->query($kategori_query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengaduan - Pengaduan Masyarakat</title>
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
            <section class="content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="jumbotron jumbotron-fluid">
                                <div class="container">
                                    <h1 class="display-4">Riwayat Pengaduan</h1>
                                    <p class="lead">Di sini Anda dapat melihat semua riwayat pengaduan masyarakat yang telah diproses.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Pengaduan -->
                    <div class="row">
                        <div class="col-12">
                            <h4>Statistik Pengaduan</h4>
                            <div class="row">
                                <!-- Statistik Berdasarkan Status -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Jumlah Pengaduan Berdasarkan Status</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <?php while ($row = $status_result->fetch_assoc()) { ?>
                                                    <li><strong><?php echo $row['status']; ?></strong>: <?php echo $row['count']; ?> pengaduan</li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Statistik Berdasarkan Kategori -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Jumlah Pengaduan Berdasarkan Kategori</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <?php while ($row = $kategori_result->fetch_assoc()) { ?>
                                                    <li><strong><?php echo $row['nama_kategori']; ?></strong>: <?php echo $row['count']; ?> pengaduan</li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Riwayat Pengaduan -->
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Isi</th>
                                        <th>Kategori</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>Komentar</th>
                                        <th>Pelapor</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0) { ?>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['judul']; ?></td>
                                                <td><?php echo substr($row['isi'], 0, 50) . '...'; ?></td>
                                                <td><?php echo $row['nama_kategori']; ?></td>
                                                <td>
                                                    <?php if ($row['file_aduan']) { ?>
                                                        <a href="../uploads/aduan/<?php echo $row['file_aduan']; ?>" target="_blank">Lihat File</a>
                                                    <?php } else { ?>
                                                        Tidak ada file
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['komentar'] ? $row['komentar'] : 'Belum ada komentar'; ?></td>
                                                <td><?php echo $row['pelapor']; ?></td>
                                                <td><?php echo $row['created_at']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="9" class="text-center">Belum ada pengaduan yang diproses.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
