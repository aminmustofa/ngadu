<?php
session_start();
include 'config/db.php'; // Menyertakan koneksi database

// Jika pengguna sudah login, arahkan ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah email ada di database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Mengecek password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Email atau password salah!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-card h1 {
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

    <div class="login-card">
        <h1>Login</h1>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <strong>Error:</strong> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <!-- Link untuk registrasi dan reset password -->
        <p class="mt-3 form-text">Belum punya akun? <a href="register.php">Registrasi di sini</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
