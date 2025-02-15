-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Feb 2025 pada 07.03
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
-- Database: `db_kepegawaian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `departemen`
--

CREATE TABLE `departemen` (
  `id` int(11) NOT NULL,
  `nama_departemen` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `departemen`
--

INSERT INTO `departemen` (`id`, `nama_departemen`, `deskripsi`) VALUES
(1, 'Teknologi Informasi', 'Mengelola sistem IT, pengembangan software, dan infrastruktur teknologi.'),
(2, 'Keamanan Siber', 'Menjaga keamanan data dan sistem informasi perusahaan dari ancaman cyber.'),
(3, 'Analisis Data', 'Mengolah data bisnis untuk pengambilan keputusan yang lebih baik.'),
(4, 'Pemasaran Digital', 'Mengelola promosi produk melalui platform digital seperti media sosial dan iklan online.'),
(5, 'Manajemen Produk', 'Mengkoordinasikan pengembangan produk dari sisi teknis dan bisnis.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `id_departemen` int(11) DEFAULT NULL,
  `gaji` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `id_departemen`, `gaji`) VALUES
(1, 'Software Engineer', 1, 12000000.00),
(2, 'System Administrator', 1, 10000000.00),
(3, 'Cyber Security Analyst', 2, 13000000.00),
(4, 'Penetration Tester', 2, 12500000.00),
(5, 'Data Analyst', 3, 11000000.00),
(6, 'Data Scientist', 3, 15000000.00),
(7, 'Digital Marketing Specialist', 4, 9000000.00),
(8, 'SEO Specialist', 4, 8500000.00),
(9, 'Product Manager', 5, 14000000.00),
(10, 'UX/UI Designer', 5, 9500000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_departemen` int(11) DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `gaji` decimal(10,2) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama`, `id_departemen`, `id_jabatan`, `gaji`, `jenis_kelamin`, `tanggal_masuk`) VALUES
(2, '2098765432', 'Siti Aisyah', 1, 2, 10000000.00, 'Perempuan', '2022-07-10'),
(3, '3045678912', 'Budi Santoso', 2, 3, 13000000.00, 'Laki-laki', '2021-05-20'),
(4, '4092837465', 'Dewi Lestari', 2, 4, 12500000.00, 'Perempuan', '2020-10-12'),
(5, '5029384756', 'Fajar Pratama', 3, 5, 11000000.00, 'Laki-laki', '2023-01-05'),
(6, '6038475629', 'Rino Dustin', 3, 6, 15000000.00, 'Laki-laki', '2022-09-30'),
(7, '7046582937', 'Dian Kusuma', 4, 7, 9000000.00, 'Perempuan', '2021-11-22'),
(8, '8057293846', 'Rahmat Hidayat', 4, 8, 8500000.00, 'Laki-laki', '2020-06-18'),
(9, '9065847321', 'Suci Ramadhani', 5, 9, 14000000.00, 'Perempuan', '2023-04-25'),
(10, '1074938562', 'Yoga Firmansyah', 5, 10, 9500000.00, 'Laki-laki', '2022-12-05'),
(11, '1106345739', 'Arya', 4, 7, 8000000.00, 'Laki-laki', '2025-02-25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'admin', '$2y$10$XVumsH1Km4a8qFlxqER7LucYD5mEnew2X/eTN61HtcJ7yFCDU5UBy');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_departemen` (`id_departemen`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_departemen` (`id_departemen`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD CONSTRAINT `jabatan_ibfk_1` FOREIGN KEY (`id_departemen`) REFERENCES `departemen` (`id`);

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_departemen`) REFERENCES `departemen` (`id`),
  ADD CONSTRAINT `pegawai_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
