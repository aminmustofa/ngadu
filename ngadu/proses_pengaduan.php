<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna
$user_id = $_SESSION['user_id'];
$kategori_id = $_POST['kategori_id'];
$judul = $_POST['judul'];
$isi = $_POST['isi'];
$file_aduan = $_FILES['file_aduan']['name'];

// Upload file jika ada
if ($file_aduan) {
    $target_dir = "uploads/aduan";
    $target_file = $target_dir . basename($file_aduan);
    move_uploaded_file($_FILES['file_aduan']['tmp_name'], $target_file);
}

// Hubungkan ke database
include('config/db.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Siapkan query
$sql = "INSERT INTO pengaduan (user_id, judul, isi, kategori_id, file_aduan) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Periksa jika query tidak berhasil
if ($stmt === false) {
    die('Query failed: ' . $conn->error);
}

// Bind parameter dan eksekusi
$stmt->bind_param("issis", $user_id, $judul, $isi, $kategori_id, $file_aduan);
if ($stmt->execute()) {
    header("Location: dashboard.php?status=success");
    exit();
} else {
    die("Terjadi kesalahan saat mengajukan pengaduan: " . $stmt->error);
}
?>
