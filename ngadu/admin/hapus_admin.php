<?php
session_start();
include '../config/db.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Proses penghapusan admin
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Pastikan admin yang akan dihapus bukan admin yang sedang login
    if ($id == $_SESSION['user_id']) {
        header("Location: kelola_admin.php?error=Anda tidak dapat menghapus akun Anda sendiri.");
        exit();
    }

    // Hapus admin berdasarkan ID
    $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: kelola_admin.php?success=Admin berhasil dihapus");
        exit();
    } else {
        header("Location: kelola_admin.php?error=Gagal menghapus admin.");
        exit();
    }
} else {
    header("Location: kelola_admin.php?error=ID admin tidak valid.");
    exit();
}
