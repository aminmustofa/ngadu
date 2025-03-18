<?php
// lihat_status_pengaduan.php

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config/db.php'; // Koneksi database

// Ambil ID pengguna dari session
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan semua pengaduan yang diajukan oleh pengguna
$sql = "SELECT * FROM pengaduan WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengaduan - Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Status Pengaduan -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Lihat Status Pengaduan Anda</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Pengaduan</th>
                            <th>Status</th>
                            <th>File Terkait</th>
                            <th>Tanggal Pengaduan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['judul']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td>
                                    <?php if ($row['file_aduan']): ?>
                                        <a href="uploads/aduan/<?php echo htmlspecialchars($row['file_aduan']); ?>" target="_blank">Lihat File</a>
                                    <?php else: ?>
                                        Tidak ada file
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="alert alert-info">Anda belum memiliki pengaduan yang diajukan.</p>
        <?php endif; ?>

    </section>

    <!-- Footer -->
    <footer class="bg-light py-3 text-center">
        <p>&copy; 2024 Sistem Pengaduan Masyarakat | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
