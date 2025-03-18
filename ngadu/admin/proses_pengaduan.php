<?php
// proses_pengaduan.php

session_start();

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../config/db.php';


// Ambil hanya pengaduan yang belum selesai (status != 'Selesai')
$query = "SELECT p.id, p.judul, p.isi, p.file_aduan, p.status, p.komentar, p.created_at, k.nama_kategori, u.email AS pelapor
          FROM pengaduan p
          JOIN users u ON p.user_id = u.id
          JOIN kategori_pengaduan k ON p.kategori_id = k.id
          WHERE p.status != 'Selesai'
          ORDER BY p.created_at DESC";
$result = $conn->query($query);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengaduan = $_POST['id_pengaduan'];
    $status = $_POST['status'];
    $komentar = $_POST['komentar'];
    $admin_id = $_POST['admin_id'];  // Menyimpan ID admin yang memproses

    // Update status, komentar, dan admin_id pengaduan
    $update_query = "UPDATE pengaduan SET status = ?, komentar = ?, admin_id = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssii", $status, $komentar, $admin_id, $id_pengaduan); // Menambahkan admin_id
    if ($stmt->execute()) {
        $success_message = "Status dan komentar pengaduan berhasil diperbarui!";
        // Reload halaman untuk memperbarui daftar pengaduan
        header("Location: proses_pengaduan.php");
        exit();
    } else {
        $error_message = "Gagal memperbarui status dan komentar pengaduan.";
    }
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pengaduan - Pengaduan Masyarakat</title>
    <!-- Link ke AdminLTE CSS -->
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
            <section class="content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="jumbotron jumbotron-fluid">
                                <div class="container">
                                    <h1 class="display-4">Proses Pengaduan</h1>
                                    <p class="lead">Di sini Anda dapat memproses pengaduan baru atau mengelola pengaduan yang sedang berlangsung.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaduan Baru -->
                    <div class="row">
                        <div class="col-12">
                            <?php if (isset($success_message)) { ?>
                                <div class="alert alert-success"><?php echo $success_message; ?></div>
                            <?php } ?>
                            <?php if (isset($error_message)) { ?>
                                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                            <?php } ?>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul Pengaduan</th>
                                        <th>Isi</th>
                                        <th>Kategori</th> <!-- Kolom Kategori ditambahkan -->
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>Komentar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['judul']; ?></td>
                                            <td><?php echo substr($row['isi'], 0, 50) . '...'; ?></td>
                                            <td><?php echo $row['nama_kategori']; ?></td> <!-- Menampilkan kategori -->
                                            <td>
                                                <?php if ($row['file_aduan']) { ?>
                                                    <a href="../uploads/aduan/<?php echo $row['file_aduan']; ?>" target="_blank">Lihat File</a>
                                                <?php } else { ?>
                                                    Tidak ada file
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <span class='badge badge-warning'>Belum Selesai</span>
                                            </td>
                                            <td>
                                                <?php echo $row['komentar'] ? $row['komentar'] : 'Belum ada komentar'; ?>
                                            </td>
                                            <td>
                                                <form method="POST">
                                                    <input type="hidden" name="id_pengaduan" value="<?php echo $row['id']; ?>">
                                                    <input type="hidden" name="admin_id" value="<?php echo $_SESSION['user_id']; ?>">
                                                    <select name="status" class="form-control mb-2" required>
                                                        <option value="Proses" <?php echo ($row['status'] == 'Proses') ? 'selected' : ''; ?>>Proses</option>
                                                        <option value="Selesai" <?php echo ($row['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                    </select>
                                                    <textarea name="komentar" class="form-control mb-2" placeholder="Tambahkan komentar"><?php echo $row['komentar']; ?></textarea>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($result->num_rows == 0) { ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada pengaduan yang sedang diproses.</td>
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

