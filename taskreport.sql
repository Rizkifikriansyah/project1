-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Feb 2025 pada 15.54
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
-- Database: `taskreport`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `tugas_id` int(11) NOT NULL,
  `file_tugas` varchar(255) DEFAULT NULL,
  `status_pengerjaan` enum('Dalam Proses','Selesai') DEFAULT 'Dalam Proses',
  `komentar` text DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `tugas_id`, `file_tugas`, `status_pengerjaan`, `komentar`, `tanggal_upload`) VALUES
(8, 30, 'WhatsApp Image 2025-01-22 at 11.31.24.jpeg', 'Selesai', 'bagus', '2025-02-05 21:38:44'),
(9, 31, 'WhatsApp Image 2025-01-22 at 11.31.24.jpeg', 'Selesai', 'keren', '2025-02-05 22:17:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `preview`
--

CREATE TABLE `preview` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_user` varchar(25) NOT NULL,
  `id_proyek` varchar(25) NOT NULL,
  `id_tugas` varchar(25) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `preview`
--

INSERT INTO `preview` (`id`, `tanggal`, `id_user`, `id_proyek`, `id_tugas`, `file`) VALUES
(2, '2025-02-04', 'son heung min', 'Bronjo', 'ikat kawat', '../upload/website(1).png'),
(3, '2025-02-04', 'deden', 'presiden', 'brantas penjajah', '../upload/WhatsApp Image 2025-02-04 at 09.58.59.jpeg'),
(4, '2025-02-04', 'ilham (bima)', 'ayam pejantan', 'kasi makan', '../upload/MAHASISWA ILKOM KELAS.xlsx'),
(5, '2025-02-04', 'f', 'f', 'f', '../upload/Fera Febrianti_B02220125_DS1.pdf'),
(6, '2025-02-04', 'd', 'd', 'd', '../upload/MAHASISWA ILKOM KELAS(3).xlsx'),
(7, '2025-02-04', 's', 's', 's', '../upload/magang.xlsx'),
(8, '2025-02-04', 'f', 'f', 'f', '../upload/LAPORAN TUGAS TAMBAHAN GURU PIKET daus.docx'),
(9, '2025-02-04', 'n', 'n', 'n', '../upload/IMG_6610.mov'),
(10, '2025-02-04', 'kkk', 'kkk', ',,,,', '../upload/JURNAL PBO FINAL 1.docx'),
(11, '2025-02-05', 'kiki', 'video', 'rekam', '../upload/A-comparative-analysis-of-predictive-data-mining-techniques.docx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `proyek`
--

CREATE TABLE `proyek` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal_mulai` varchar(50) NOT NULL,
  `divisi` varchar(100) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `proyek`
--

INSERT INTO `proyek` (`id`, `nama`, `tanggal_mulai`, `divisi`, `deskripsi`) VALUES
(7, 'Hari Kemerdekaan', '2025-02-01', 'Inovasi', 'Bantai jepang dan lain lain'),
(8, 'Analisis Data Air', '1970-01-01', 'Riset', 'masa lampau'),
(9, 'Karya Tulis Ilmiah', '2025-04-25', 'Kreatif', 'terserah'),
(10, 'Task Report', '2025-01-12', 'Kreatif', 'Harus Bagus dan keren'),
(11, 'Analisa Kebutuhan Pangan', '2025-03-18', 'Riset', 'keren banget');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas`
--

CREATE TABLE `tugas` (
  `id` int(11) NOT NULL,
  `proyek_id` int(11) NOT NULL,
  `nama_tugas` varchar(100) NOT NULL,
  `tanggal_mulai` varchar(50) NOT NULL,
  `divisi` varchar(99) NOT NULL,
  `deadline` varchar(100) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status_tugas` enum('belum selesai','selesai') DEFAULT 'belum selesai',
  `status` enum('Selesai','Belum Selesai') DEFAULT 'Belum Selesai',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tugas`
--

INSERT INTO `tugas` (`id`, `proyek_id`, `nama_tugas`, `tanggal_mulai`, `divisi`, `deadline`, `deskripsi`, `status_tugas`, `status`, `user_id`) VALUES
(21, 9, 'Pamflet', '2025-02-12', '', '2025-02-14', 'Harus Bagus', 'belum selesai', 'Belum Selesai', 22),
(22, 7, 'Buat Aplikasi Absensi', '2025-02-21', '', '2025-04-21', 'Harus Enak', 'belum selesai', 'Belum Selesai', 35),
(23, 9, 'Edit Video', '2025-03-28', '', '2025-03-29', 'Bagus yaaaa', 'belum selesai', 'Belum Selesai', 26),
(24, 9, 'Editing Gambar', '2025-02-23', '', '2025-02-25', 'Harus Bagus', 'belum selesai', 'Belum Selesai', 22),
(25, 9, 'Laporan Pendaftaran', '2025-02-28', '', '2025-03-03', 'Lengkap', 'belum selesai', 'Belum Selesai', 22),
(26, 9, 'Gatau', '2025-03-04', '', '2025-03-06', 'enak', 'belum selesai', 'Belum Selesai', 26),
(27, 9, 'Apaaja', '2025-04-12', '', '2025-04-14', 'Ikut aja', 'belum selesai', 'Belum Selesai', 26),
(29, 8, 'Analisa Titik Koordinat', '2025-03-12', '', '2025-03-15', 'Harus Sesuai', 'belum selesai', 'Belum Selesai', 34),
(30, 7, 'Bunuh', '2025-04-16', '', '2025-04-17', 'rataaaaa', 'belum selesai', 'Belum Selesai', 33),
(31, 11, 'Pangan Bagus', '2025-05-12', '', '2025-05-15', 'bagus', 'belum selesai', 'Belum Selesai', 34);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `profil` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Supervisor','admin','user') DEFAULT NULL,
  `divisi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `profil`, `username`, `password`, `role`, `divisi`) VALUES
(18, 'Wanul', '', 'Wanul', '30e49523ee3a4f5cdf0ca88423831310', 'admin', 'Kreatif'),
(19, 'Surya', '', 'Surya', 'cffbdd5343eb19a4d7c02341ecc5bd7d', 'admin', 'Riset'),
(22, 'Riska Dwi Ramadhan', '', 'deden', 'd4e044830cfc2124c4c20a2d4e656bc2', 'user', 'Kreatif'),
(25, 'Fera', '', 'Fera', 'bb65857b4e02f494cc9f38dcf7c70a2b', 'user', 'Riset'),
(26, 'Andry', '', 'andry', '1fd07199cca4ff81d01dca373c6e03a9', 'user', 'Kreatif'),
(30, 'Kiki', '../image/1738548644_80406.jpg', 'kiki', '$2y$10$Z64VT4bxDSpHvHw3g979f.SSc4V0hIP4BiPmXtsOT791755h6ve9W', 'admin', 'Inovasi'),
(32, 'Supervisor', '', 'supervisor', '$2y$10$P2kWE0CIFfEbA46ZnkqUkeVTefYeuqPDu/PtPWFXwSU7C3ep2bJLy', 'Supervisor', ''),
(33, 'kuro', '', 'kuro', '$2y$10$BzpjQOACgiN3rmOwOdm.2uRyWs/seNTqw0f6meURiZ9lH1aMLluUm', 'user', 'Inovasi'),
(34, 'sonia', '', 'sonia', '$2y$10$VT.HFba3pfFP3QhelO.bSu5Qjjct6WyCek2QUwWZuCcbyv91l3c6u', 'user', 'Riset'),
(35, 'wow', '', 'wow', '$2y$10$6jsmdoCmgWA5MFSJzQYBxOgQ.Xk9Dam5cU3x3G20ujwKVHePqsAcu', 'user', 'Inovasi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_id` (`tugas_id`);

--
-- Indeks untuk tabel `preview`
--
ALTER TABLE `preview`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `proyek`
--
ALTER TABLE `proyek`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `preview`
--
ALTER TABLE `preview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `proyek`
--
ALTER TABLE `proyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
