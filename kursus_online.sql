-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Des 2025 pada 09.16
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
-- Database: `kursus_online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kuis`
--

CREATE TABLE `kuis` (
  `id_kuis` bigint(20) NOT NULL,
  `id_materi` bigint(20) NOT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_a` varchar(255) NOT NULL,
  `opsi_b` varchar(255) NOT NULL,
  `opsi_c` varchar(255) NOT NULL,
  `opsi_d` varchar(255) NOT NULL,
  `jawaban_benar` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kuis`
--

INSERT INTO `kuis` (`id_kuis`, `id_materi`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban_benar`) VALUES
(1, 1, 'Apa kepanjangan dari PHP?', 'Personal Home Page', 'PHP Hypertext Preprocessor', 'Private Hosting Platform', 'Public HTML Program', 'B'),
(2, 1, 'Tag PHP dimulai dengan?', '<?php', '<script>', '<php>', '<%', 'A'),
(3, 1, 'Ekstensi file PHP adalah?', '.html', '.php', '.txt', '.css', 'B'),
(4, 2, 'Cara mendeklarasikan variabel di PHP?', 'var $nama', '$nama', 'let nama', 'int $nama', 'B'),
(5, 2, 'Tipe data untuk angka desimal?', 'int', 'float', 'string', 'boolean', 'B'),
(6, 2, 'Fungsi untuk mengecek tipe data variabel?', 'typeof()', 'gettype()', 'check_type()', 'var_type()', 'B'),
(7, 3, 'Statement untuk kondisi banyak pilihan?', 'if-else', 'switch', 'for', 'while', 'B'),
(8, 3, 'Perulangan yang cocok untuk array?', 'do-while', 'switch', 'foreach', 'if', 'C'),
(9, 6, 'Tag untuk judul terbesar di HTML?', '<h6>', '<h1>', '<title>', '<header>', 'B'),
(10, 6, 'Tag untuk membuat link?', '<a>', '<link>', '<href>', '<url>', 'A'),
(11, 7, 'Cara menambahkan CSS di HTML?', '<style>', '<css>', '<script>', '<link>', 'A'),
(12, 7, 'Property CSS untuk warna teks?', 'text-color', 'color', 'font-color', 'text', 'B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kursus`
--

CREATE TABLE `kursus` (
  `id_kursus` bigint(20) NOT NULL,
  `id_tutor` bigint(20) NOT NULL,
  `nama_kursus` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `tingkat` enum('pemula','menengah','lanjutan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kursus`
--

INSERT INTO `kursus` (`id_kursus`, `id_tutor`, `nama_kursus`, `deskripsi`, `kategori`, `tingkat`) VALUES
(1, 1, 'Dasar Pemrograman PHP', 'Belajar PHP dari nol hingga bisa membuat aplikasi web dinamis dengan database MySQL', 'Programming', 'pemula'),
(2, 2, 'HTML & CSS untuk Pemula', 'Pelajari dasar-dasar HTML5 dan CSS3 untuk membuat website yang menarik dan responsive', 'Web Design', 'pemula'),
(3, 1, 'Dasar Pemrograman PHP', 'Belajar PHP dari nol hingga bisa membuat aplikasi web dinamis dengan database MySQL', 'Programming', 'pemula'),
(4, 2, 'HTML & CSS untuk Pemula', 'Pelajari dasar-dasar HTML5 dan CSS3 untuk membuat website yang menarik dan responsive', 'Web Design', 'pemula'),
(5, 1, 'Dasar Pemrograman PHP', 'Belajar PHP dari nol hingga bisa membuat aplikasi web dinamis dengan database MySQL', 'Programming', 'pemula'),
(6, 2, 'HTML & CSS untuk Pemula', 'Pelajari dasar-dasar HTML5 dan CSS3 untuk membuat website yang menarik dan responsive', 'Web Design', 'pemula');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id_materi` bigint(20) NOT NULL,
  `id_kursus` bigint(20) NOT NULL,
  `judul_materi` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `link_video` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materi`
--

INSERT INTO `materi` (`id_materi`, `id_kursus`, `judul_materi`, `deskripsi`, `link_video`) VALUES
(1, 1, 'Pengenalan PHP', 'Apa itu PHP dan bagaimana cara kerjanya', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(2, 1, 'Variabel dan Tipe Data', 'Memahami variabel, string, integer, array dalam PHP', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(3, 1, 'Control Structure', 'If-else, switch, dan perulangan for/while', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(4, 1, 'Fungsi dalam PHP', 'Membuat dan menggunakan function', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(5, 1, 'Koneksi Database MySQL', 'Cara menghubungkan PHP dengan MySQL', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(6, 2, 'Struktur Dasar HTML', 'Tag HTML, heading, paragraph, list', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(7, 2, 'CSS Selector & Properties', 'Cara styling elemen dengan CSS', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(8, 2, 'CSS Layout dengan Flexbox', 'Membuat layout responsive dengan flexbox', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(9, 2, 'Form HTML', 'Membuat form input, button, checkbox', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(26, 2, 'CSS Layout dengan Flexbox', 'Membuat layout responsive dengan flexbox', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(27, 2, 'Form HTML', 'Membuat form input, button, checkbox', 'https://www.youtube.com/embed/dQw4w9WgXcQ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` bigint(20) NOT NULL,
  `id_siswa` bigint(20) NOT NULL,
  `id_kursus` bigint(20) NOT NULL,
  `nilai` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tgl_penilaian` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_siswa`, `id_kursus`, `nilai`, `keterangan`, `tgl_penilaian`) VALUES
(1, 1, 1, 85, 'Kuis Pengenalan PHP', '2024-03-22'),
(2, 1, 2, 90, 'Kuis HTML Dasar', '2024-03-23'),
(3, 2, 1, 75, 'Kuis Variabel PHP', '2024-03-24'),
(4, 3, 2, 88, 'Kuis CSS Selector', '2024-03-25'),
(5, 4, 1, 92, 'Kuis Control Structure', '2024-03-26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `progres_belajar`
--

CREATE TABLE `progres_belajar` (
  `id_progres` bigint(20) NOT NULL,
  `id_siswa` bigint(20) NOT NULL,
  `id_kursus` bigint(20) NOT NULL,
  `materi_selesai` int(11) DEFAULT 0,
  `total_materi` int(11) DEFAULT 0,
  `persentase_progres` int(11) DEFAULT 0,
  `status_progres` enum('belum_mulai','sedang_berjalan','selesai') DEFAULT 'belum_mulai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `progres_belajar`
--

INSERT INTO `progres_belajar` (`id_progres`, `id_siswa`, `id_kursus`, `materi_selesai`, `total_materi`, `persentase_progres`, `status_progres`) VALUES
(1, 1, 1, 4, 5, 80, 'sedang_berjalan'),
(2, 1, 2, 4, 4, 100, 'selesai'),
(3, 2, 1, 2, 5, 40, 'sedang_berjalan'),
(4, 3, 2, 3, 4, 75, 'sedang_berjalan'),
(5, 4, 1, 5, 5, 100, 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` bigint(20) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tgl_daftar` date NOT NULL,
  `status_akun` enum('aktif','nonaktif','banned') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `email`, `password`, `no_hp`, `pekerjaan`, `alamat`, `tgl_daftar`, `status_akun`) VALUES
(1, 'Budi Santoso', 'budi@email.com', '$2y$10$abcdefg12345', '081234567890', 'Mahasiswa', 'Jakarta', '2024-01-15', 'aktif'),
(2, 'Siti Aminah', 'siti@email.com', '$2y$10$abcdefg12345', '081234567891', 'Karyawan', 'Bandung', '2024-01-20', 'aktif'),
(3, 'Rudi Hartono', 'rudi@email.com', '$2y$10$abcdefg12345', '081234567892', 'Freelancer', 'Surabaya', '2024-02-01', 'aktif'),
(4, 'Dewi Lestari', 'dewi@email.com', '$2y$10$abcdefg12345', '081234567893', 'Mahasiswa', 'Yogyakarta', '2024-02-10', 'aktif'),
(5, 'Agus Pratama', 'agus@email.com', '$2y$10$abcdefg12345', '081234567894', 'Wiraswasta', 'Medan', '2024-02-15', 'aktif'),
(6, 'Rina Kusuma', 'rina@email.com', '$2y$10$abcdefg12345', '081234567895', 'Designer', 'Semarang', '2024-03-01', 'aktif'),
(7, 'Eko Wijaya', 'eko@email.com', '$2y$10$abcdefg12345', '081234567896', 'Developer', 'Malang', '2024-03-05', 'aktif'),
(8, 'Lina Marlina', 'lina@email.com', '$2y$10$abcdefg12345', '081234567897', 'Mahasiswa', 'Bogor', '2024-03-10', 'aktif'),
(9, 'Bambang Susilo', 'bambang@email.com', '$2y$10$abcdefg12345', '081234567898', 'PNS', 'Depok', '2024-03-15', 'aktif'),
(10, 'Maya Sari', 'maya@email.com', '$2y$10$abcdefg12345', '081234567899', 'Guru', 'Tangerang', '2024-03-20', 'aktif'),
(31, '1', 'gudyzurar4@hotmail.com', '$2y$10$9svjcSFVtpflf/3pkSJBGOgJ48HMxmo1PCRzyxnvD5uQeNOcLPc6O', NULL, NULL, NULL, '2025-12-07', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa_kursus`
--

CREATE TABLE `siswa_kursus` (
  `id` bigint(20) NOT NULL,
  `id_siswa` bigint(20) NOT NULL,
  `id_kursus` bigint(20) NOT NULL,
  `tgl_gabung` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa_kursus`
--

INSERT INTO `siswa_kursus` (`id`, `id_siswa`, `id_kursus`, `tgl_gabung`) VALUES
(1, 1, 1, '2024-03-21'),
(2, 1, 2, '2024-03-22'),
(3, 2, 1, '2024-03-23'),
(4, 3, 2, '2024-03-24'),
(5, 4, 1, '2024-03-25'),
(6, 5, 2, '2024-03-26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tutor`
--

CREATE TABLE `tutor` (
  `id_tutor` bigint(20) NOT NULL,
  `nama_tutor` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `keahlian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tutor`
--

INSERT INTO `tutor` (`id_tutor`, `nama_tutor`, `email`, `password`, `no_hp`, `keahlian`) VALUES
(1, 'Prof. Ahmad Web', 'ahmad@tutor.com', '$2y$10$xyz123', '082111111111', 'Web Development & PHP'),
(2, 'Dr. Sarah Frontend', 'sarah@tutor.com', '$2y$10$xyz123', '082222222222', 'HTML, CSS, JavaScript'),
(3, 'Pak Joko Backend', 'joko@tutor.com', '$2y$10$xyz123', '082333333333', 'Database & Backend'),
(4, 'Bu Rina Design', 'rina@tutor.com', '$2y$10$xyz123', '082444444444', 'UI/UX Design'),
(5, 'Mas Dedi Fullstack', 'dedi@tutor.com', '$2y$10$xyz123', '082555555555', 'Full Stack Development');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kuis`
--
ALTER TABLE `kuis`
  ADD PRIMARY KEY (`id_kuis`),
  ADD KEY `id_materi` (`id_materi`);

--
-- Indeks untuk tabel `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id_kursus`),
  ADD KEY `id_tutor` (`id_tutor`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `id_kursus` (`id_kursus`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kursus` (`id_kursus`);

--
-- Indeks untuk tabel `progres_belajar`
--
ALTER TABLE `progres_belajar`
  ADD PRIMARY KEY (`id_progres`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kursus` (`id_kursus`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `siswa_kursus`
--
ALTER TABLE `siswa_kursus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kursus` (`id_kursus`);

--
-- Indeks untuk tabel `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`id_tutor`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kuis`
--
ALTER TABLE `kuis`
  MODIFY `id_kuis` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id_kursus` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `progres_belajar`
--
ALTER TABLE `progres_belajar`
  MODIFY `id_progres` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `siswa_kursus`
--
ALTER TABLE `siswa_kursus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tutor`
--
ALTER TABLE `tutor`
  MODIFY `id_tutor` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kuis`
--
ALTER TABLE `kuis`
  ADD CONSTRAINT `kuis_ibfk_1` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kursus`
--
ALTER TABLE `kursus`
  ADD CONSTRAINT `kursus_ibfk_1` FOREIGN KEY (`id_tutor`) REFERENCES `tutor` (`id_tutor`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `progres_belajar`
--
ALTER TABLE `progres_belajar`
  ADD CONSTRAINT `progres_belajar_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `progres_belajar_ibfk_2` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa_kursus`
--
ALTER TABLE `siswa_kursus`
  ADD CONSTRAINT `siswa_kursus_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswa_kursus_ibfk_2` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
