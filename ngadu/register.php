<?php
session_start();
include 'config/db.php'; // Menyertakan koneksi database

// Menangani form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nik = $_POST['nik'];
    $telepon = $_POST['telepon'];

    // Validasi konfirmasi password
    if ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        // Meng-hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyimpan data ke database
        $sql = "INSERT INTO users (nama, alamat, email, password, nik, telepon) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nama, $alamat, $email, $hashed_password, $nik, $telepon);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: login.php");
            exit();
        } else {
            $error = "Terjadi kesalahan, coba lagi.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .register-card {
            max-width: 500px;
            width: 100%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .register-card h1 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .btn-primary {
            width: 100%;
        }
        .form-text {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <h1>Registrasi</h1>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <strong>Error:</strong> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Tampilkan pesan sukses jika ada -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <strong>Success:</strong> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Form Registrasi -->
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ulangi password Anda" required>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor telepon Anda" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap Anda" required></textarea>
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK Anda" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrasi</button>
        </form>

        <!-- Link untuk login -->
        <p class="mt-3 form-text">Sudah memiliki akun? <a href="login.php">Login di sini</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
