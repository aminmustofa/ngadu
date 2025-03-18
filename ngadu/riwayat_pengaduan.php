<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari session
$user_id = $_SESSION['user_id']; // Pastikan session user_id sudah diatur saat login

// Hubungkan ke database
include('config/db.php'); // File koneksi database

// Fungsi untuk mengambil riwayat pengaduan berdasarkan user_id
function getRiwayatPengaduan($conn, $user_id) {
    $sql = "SELECT p.id, p.judul, p.status, p.file_aduan, p.komentar, p.created_at, p.updated_at, p.feedback, k.nama_kategori, u.email AS pelapor, a.email AS admin
            FROM pengaduan p
            JOIN kategori_pengaduan k ON p.kategori_id = k.id
            LEFT JOIN users u ON p.user_id = u.id
            LEFT JOIN admin a ON p.admin_id = a.id
            WHERE p.user_id = ? 
            ORDER BY p.created_at DESC";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        die("Query gagal: " . $conn->error);
    }
}

// Fungsi untuk mengupdate feedback
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feedback'])) {
    $feedback = $_POST['feedback'];
    $pengaduan_id = $_POST['pengaduan_id'];
    
    // Update feedback di database
    $sql = "UPDATE pengaduan SET feedback = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $feedback, $pengaduan_id);
        $stmt->execute();
        header("Location: riwayat_pengaduan.php"); // Refresh halaman
        exit();
    } else {
        die("Query gagal: " . $conn->error);
    }
}

// Ambil riwayat pengaduan
$riwayat = getRiwayatPengaduan($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengaduan</title>
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
                        <a class="nav-link active" href="riwayat_pengaduan.php">Riwayat Pengaduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="container mt-4">
        <h1 class="text-center">Riwayat Pengaduan Anda</h1>
    </div>

    <!-- Riwayat Pengaduan -->
    <div class="container my-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Kategori</th>
                    <th>File Aduan</th>
                    <th>Komentar</th>
                    <th>Waktu Pengaduan</th>
                    <th>Waktu Pembaruan</th>
                    <th>Feedback</th>
                    <th>Diproses Oleh</th> <!-- Kolom Admin Ditambahkan -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($riwayat)): ?>
                    <?php foreach ($riwayat as $index => $pengaduan): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($pengaduan['judul']); ?></td>
                            <td>
                                <?php
                                // Ganti status dengan warna berbeda
                                $status = $pengaduan['status'];
                                $badge_class = $status === 'Tunggu' ? 'badge bg-warning text-dark' :
                                               ($status === 'Proses' ? 'badge bg-primary' : 'badge bg-success');
                                ?>
                                <span class="<?php echo $badge_class; ?>"><?php echo htmlspecialchars($status); ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($pengaduan['nama_kategori']); ?></td> <!-- Menampilkan kategori -->
                            <td>
                                <?php if (!empty($pengaduan['file_aduan'])): ?>
                                    <a href="uploads/aduan/<?php echo htmlspecialchars($pengaduan['file_aduan']); ?>" target="_blank" class="btn btn-sm btn-secondary">Lihat File</a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada file</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo !empty($pengaduan['komentar']) ? htmlspecialchars($pengaduan['komentar']) : '<span class="text-muted">Belum ada komentar</span>'; ?>
                            </td>
                            <td><?php echo htmlspecialchars($pengaduan['created_at']); ?></td>
                            <td>
                                <?php echo !empty($pengaduan['updated_at']) ? htmlspecialchars($pengaduan['updated_at']) : '<span class="text-muted">Belum ada pembaruan</span>'; ?>
                            </td>
                            <td>
                                <?php echo !empty($pengaduan['feedback']) ? htmlspecialchars($pengaduan['feedback']) : '<span class="text-muted">Belum ada feedback</span>'; ?>
                            </td>
                            <td>
                                <?php 
                                // Menampilkan nama admin yang memproses komentar jika ada
                                if (!empty($pengaduan['admin'])) {
                                    echo "Diproses oleh: " . htmlspecialchars($pengaduan['admin']);
                                } else {
                                    echo "Belum diproses";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada pengaduan yang diajukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-light">
        <p>&copy; 2024 Sistem Pengaduan Masyarakat | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
