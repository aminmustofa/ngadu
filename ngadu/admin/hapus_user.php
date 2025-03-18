<?php
// hapus_user.php

session_start();
include '../config/db.php';

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil ID pengguna dari parameter URL
if (!isset($_GET['id'])) {
    header("Location: kelola_users.php?error=invalid_id");
    exit();
}

$id = intval($_GET['id']);

// Query untuk menghapus pengguna
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Jika berhasil, kembali ke halaman kelola_users dengan pesan sukses
    header("Location: kelola_users.php?success=user_deleted");
    exit();
} else {
    // Jika gagal, kembali ke halaman kelola_users dengan pesan error
    header("Location: kelola_users.php?error=delete_failed");
    exit();
}
?>
