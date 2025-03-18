-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Mar 2025 pada 10.18
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngadu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'aku@gmail.com', '$2y$10$ym.tnz/GIFiof9sK3UI/be6hqUg4xNDF.cOCrSX/Zjl9VZxcO5PPG', 'admin', '2024-12-20 08:35:56'),
(5, 'admin@gmail.com', '$2y$10$WXDumCu4nTepdjYdJwLeouHonBWzSeXXBN1PdasP1v8CdyAxvULzK', 'admin', '2024-12-20 10:50:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pengaduan`
--

CREATE TABLE `kategori_pengaduan` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori_pengaduan`
--

INSERT INTO `kategori_pengaduan` (`id`, `nama_kategori`) VALUES
(1, 'Layanan Publik'),
(2, 'Infrastruktur'),
(3, 'Lingkungan'),
(4, 'Keamanan & Ketertiban'),
(5, 'Sosial & Kesejahteraan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `file_aduan` varchar(255) DEFAULT NULL,
  `status` enum('Tunggu','Proses','Selesai') DEFAULT 'Tunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `komentar` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `feedback` text DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `user_id`, `judul`, `isi`, `file_aduan`, `status`, `created_at`, `komentar`, `updated_at`, `feedback`, `kategori_id`, `admin_id`) VALUES
(1, 101, 'Laporan Kerusakan Jalan', 'Jalan raya di dekat taman mengalami kerusakan parah, sangat membahayakan pengendara.', 'kerusakan_jalan.jpg', 'Tunggu', '2025-02-17 03:00:00', 'Belum ada tanggapan dari admin.', '2025-02-17 03:30:00', 'Perlu segera perbaikan.', 2, NULL),
(2, 102, 'Sampah Menumpuk di Trotoar', 'Trotoar di sepanjang jalan utama penuh dengan sampah yang tidak dibersihkan.', 'sampah_trotoar.png', 'Proses', '2025-02-17 04:00:00', 'Proses pembersihan sedang berjalan.', '2025-02-17 04:30:00', 'Pembersihan diharapkan selesai dalam 2 hari.', 3, 1),
(3, 103, 'Gangguan Listrik di Kompleks Perumahan', 'Listrik di kompleks perumahan mati tanpa pemberitahuan selama 6 jam.', 'gangguan_listrik.pdf', 'Selesai', '2025-02-18 01:00:00', 'Listrik sudah kembali normal dan masalah telah diatasi.', '2025-02-18 01:30:00', 'Terima kasih atas penanganannya.', 1, 2),
(4, 104, 'Air Kotor di Sumur Umum', 'Sumur umum di desa kami mengeluarkan air keruh, tidak bisa digunakan untuk keperluan sehari-hari.', 'air_kotor_sumur.docx', 'Tunggu', '2025-02-18 02:00:00', 'Menunggu pemeriksaan dari pihak terkait.', '2025-02-18 02:30:00', 'Mohon segera diperiksa.', 4, NULL),
(5, 105, 'Pencurian di Area Publik', 'Terdapat insiden pencurian di area taman publik pada malam hari.', 'pencurian_taman.pdf', 'Proses', '2025-02-18 02:30:00', 'Pihak keamanan sedang melakukan investigasi.', '2025-02-18 03:00:00', 'Tindakan pencegahan diharapkan segera diterapkan.', 5, 3),
(8, 1, 'jalan rusak', 'jalanrusak di wakanda', 'images (3).jpeg', 'Proses', '2025-02-17 10:24:25', 'menuju ke tkp', '2025-02-17 11:14:22', NULL, 2, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `telepon` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `alamat`, `email`, `password`, `nik`, `created_at`, `telepon`) VALUES
(1, 'saya', 'jakarta', 'saya@gmail.com', '$2y$10$eMekWdXfuLlbr4.0.vF5XuEyjpgcA9iIjBnfYwtXTE3VgX8JVcnJa', '121212121', '2024-12-11 08:21:50', 0),
(2, 'saya', 'asssssssssssss', 'sayaa@gmail.com', '$2y$10$Ro99eiWpV4boCCp7mroD4.li5wCyT42y3/QaRoXoQxrVrYktj7xaG', '12122121', '2024-12-11 09:17:17', 0),
(7, 'Amin Mustofa', 'Ciberem RT04RW02,sumbang', 'aminmustofa3105@gmail.com', '$2y$10$o0tWkh9RlOOKy2csY3qM4.khh3YQ4zbHtg5WH3.M/Ot0D1/4xwYja', '1212212111111', '2024-12-20 10:33:15', 2147483647),
(8, 'tes', 'tes', 'tes@gamil.com', '$2y$10$JAMb.3RuAiQzY/SJRjzFAud8yDl6vF8bpOvInTMVTYKhzUOygeoP2', '1111113333', '2024-12-20 10:39:16', 2147483647),
(9, 'amin', 'ciberem', 'amin@gmail.com', '$2y$10$FKPcNpwhDvCTVb3EBQcWTOiDxy6aaeJyL5ZIVGe9CJuarW9oZIC2q', '423354646', '2025-02-15 05:19:18', 82132334),
(101, 'Andi Santoso', 'Jl. Merdeka No. 10, Jakarta', 'andi@example.com', 'hashedpassword123', '1234567890123456', '2025-02-17 03:00:00', 2147483647),
(102, 'Budi Pratama', 'Jl. Sudirman No. 15, Jakarta', 'budi@example.com', 'hashedpassword123', '1234567890123457', '2025-02-17 04:00:00', 2147483647),
(103, 'Cici Handayani', 'Jl. Raya No. 20, Jakarta', 'cici@example.com', 'hashedpassword123', '1234567890123458', '2025-02-18 01:00:00', 2147483647),
(104, 'Dani Wijaya', 'Jl. Kuningan No. 25, Jakarta', 'dani@example.com', 'hashedpassword123', '1234567890123459', '2025-02-18 02:00:00', 2147483647),
(105, 'Eva Yuliana', 'Jl. Kemang No. 30, Jakarta', 'eva@example.com', 'hashedpassword123', '1234567890123460', '2025-02-18 02:30:00', 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `kategori_pengaduan`
--
ALTER TABLE `kategori_pengaduan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_kategori` (`kategori_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori_pengaduan`
--
ALTER TABLE `kategori_pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_pengaduan` (`id`),
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pengaduan_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_pengaduan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
