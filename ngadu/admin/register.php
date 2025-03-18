<?php
// register.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../config/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $role = $_POST['role']; // Menambahkan role

    if ($password !== $password_confirm) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Periksa apakah email sudah digunakan
        $query = "SELECT * FROM admin WHERE email = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Simpan data pengguna baru termasuk role
            $insert = "INSERT INTO admin (email, password, role) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert);

            if ($stmt === false) {
                die('MySQL prepare error: ' . $conn->error);
            }

            $stmt->bind_param("sss", $email, $hashed_password, $role);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Gagal mendaftar, coba lagi nanti!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }
        .btn-primary {
            width: 100%;
        }
        .register-footer {
            text-align: center;
            margin-top: 20px;
        }
        .register-footer a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-container">
        <h2>Daftar Akun</h2>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirm" class="form-control" placeholder="Masukkan ulang password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
        <div class="register-footer">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
