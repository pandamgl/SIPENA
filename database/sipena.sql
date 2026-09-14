-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Sep 2026 pada 03.34
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipena`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_berita`
--

CREATE TABLE `kategori_berita` (
  `id` int(11) NOT NULL COMMENT 'Identifier unik',
  `nama_kategori` varchar(50) NOT NULL COMMENT 'Nama kategori berita'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aksi_admin`
--

CREATE TABLE `log_aksi_admin` (
  `id` int(11) NOT NULL COMMENT 'Identifier log',
  `pengajuan_id` int(11) NOT NULL COMMENT 'Relasi ke pengajuan_berita.id',
  `admin_id` int(11) NOT NULL COMMENT 'Admin yang memproses (users.id)',
  `status_sebelumnya` varchar(20) NOT NULL COMMENT 'Status awal',
  `status_baru` varchar(20) NOT NULL COMMENT 'Status yang diubah',
  `catatan` text DEFAULT NULL COMMENT 'Alasan penolakan / masukan aksi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu aksi dilakukan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_berita`
--

CREATE TABLE `pengajuan_berita` (
  `id` int(20) NOT NULL COMMENT 'Identifier unik pengajuan',
  `user_id` int(20) NOT NULL COMMENT 'Relasi ke users.id',
  `judul_berita` varchar(255) NOT NULL COMMENT 'Judul kegiatan/berita',
  `kategori_id` int(11) NOT NULL COMMENT 'Relasi ke kategori_berita.id',
  `tanggal_Mulai` date NOT NULL COMMENT 'Tanggal mulai kegiatan',
  `tanggal_selesai` date NOT NULL COMMENT 'Tanggal selesai kegiatan',
  `narasi_berita` text NOT NULL COMMENT 'Rincian narasi (unsur 5W+1H)',
  `link_dokumentasi` text NOT NULL COMMENT 'URL Google Drive / Cloud storage foto',
  `kontak_person` varchar(15) NOT NULL COMMENT 'Nomor telepon/WhatsApp aktif',
  `status` enum('Pending','Approved','Rejected') NOT NULL COMMENT 'Status verifikasi admin',
  `link_publikasi` text DEFAULT NULL COMMENT 'Alasan penolakan / catatan revisi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Tanggal pengajuan berita',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Waktu pembaruan status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi_unit`
--

CREATE TABLE `prodi_unit` (
  `id` int(11) NOT NULL COMMENT 'Identifier unik',
  `nama_prodi_unit` varchar(100) NOT NULL COMMENT 'Nama Prodi atau Unit Kerja'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Identifier unik pengguna',
  `username` varchar(10) NOT NULL COMMENT 'NIM/NIK atau username SSO',
  `password` varchar(10) NOT NULL COMMENT 'Password terenkripsi',
  `nama_lengkap` varchar(100) NOT NULL COMMENT 'Nama pengaju berita',
  `nim_nik` varchar(30) NOT NULL COMMENT 'Nomor Induk Mahasiswa / Pegawai',
  `prodi_unit_id` int(11) NOT NULL COMMENT 'Relasi ke prodi_unit.id',
  `role` enum('pengaju','admin') NOT NULL COMMENT 'Hak akses sistem',
  `remember_token` varchar(100) DEFAULT NULL COMMENT 'Token sesi "Remember Me"',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Waktu pendaftaran/sync'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori_berita`
--
ALTER TABLE `kategori_berita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indeks untuk tabel `log_aksi_admin`
--
ALTER TABLE `log_aksi_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengajuan_berita`
--
ALTER TABLE `pengajuan_berita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pengajuan_berita_ibfk_1` (`kategori_id`);

--
-- Indeks untuk tabel `prodi_unit`
--
ALTER TABLE `prodi_unit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_prodi_unit` (`nama_prodi_unit`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodi_unit_id` (`prodi_unit_id`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pengajuan_berita`
--
ALTER TABLE `pengajuan_berita`
  ADD CONSTRAINT `pengajuan_berita_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_berita` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
