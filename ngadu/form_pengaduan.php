<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari session
$user_id = $_SESSION['user_id'];

// Hubungkan ke database
include('config/db.php');

// Fungsi untuk mengambil kategori dari database
function getKategoriPengaduan($conn) {
    $sql = "SELECT * FROM kategori_pengaduan";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Ambil kategori pengaduan
$kategori_pengaduan = getKategoriPengaduan($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Pengaduan - Pengaduan Masyarakat</title>
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
                        <a class="nav-link active" href="form_pengaduan.php">Ajukan Pengaduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Form Pengaduan -->
    <section class="container my-5">
        <h1 class="text-center">Ajukan Pengaduan Anda</h1>
        <form action="proses_pengaduan.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Pengaduan</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Deskripsi Pengaduan</label>
                <textarea class="form-control" id="isi" name="isi" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori Pengaduan</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategori_pengaduan as $kategori): ?>
                        <option value="<?= $kategori['id'] ?>"><?= htmlspecialchars($kategori['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="file_aduan" class="form-label">File Aduan (Opsional)</label>
                <input type="file" class="form-control" id="file_aduan" name="file_aduan">
            </div>
            <button type="submit" class="btn btn-primary">Ajukan Pengaduan</button>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
