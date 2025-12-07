USE kursus_online;

INSERT INTO siswa (nama_siswa, email, password, no_hp, pekerjaan, alamat, tgl_daftar, status_akun) VALUES
('Budi Santoso', 'budi@email.com', '$2y$10$abcdefg12345', '081234567890', 'Mahasiswa', 'Jakarta', '2024-01-15', 'aktif'),
('Siti Aminah', 'siti@email.com', '$2y$10$abcdefg12345', '081234567891', 'Karyawan', 'Bandung', '2024-01-20', 'aktif'),
('Rudi Hartono', 'rudi@email.com', '$2y$10$abcdefg12345', '081234567892', 'Freelancer', 'Surabaya', '2024-02-01', 'aktif'),
('Dewi Lestari', 'dewi@email.com', '$2y$10$abcdefg12345', '081234567893', 'Mahasiswa', 'Yogyakarta', '2024-02-10', 'aktif'),
('Agus Pratama', 'agus@email.com', '$2y$10$abcdefg12345', '081234567894', 'Wiraswasta', 'Medan', '2024-02-15', 'aktif'),
('Rina Kusuma', 'rina@email.com', '$2y$10$abcdefg12345', '081234567895', 'Designer', 'Semarang', '2024-03-01', 'aktif'),
('Eko Wijaya', 'eko@email.com', '$2y$10$abcdefg12345', '081234567896', 'Developer', 'Malang', '2024-03-05', 'aktif'),
('Lina Marlina', 'lina@email.com', '$2y$10$abcdefg12345', '081234567897', 'Mahasiswa', 'Bogor', '2024-03-10', 'aktif'),
('Bambang Susilo', 'bambang@email.com', '$2y$10$abcdefg12345', '081234567898', 'PNS', 'Depok', '2024-03-15', 'aktif'),
('Maya Sari', 'maya@email.com', '$2y$10$abcdefg12345', '081234567899', 'Guru', 'Tangerang', '2024-03-20', 'aktif');

INSERT INTO tutor (nama_tutor, email, password, no_hp, keahlian) VALUES
('Prof. Ahmad Web', 'ahmad@tutor.com', '$2y$10$xyz123', '082111111111', 'Web Development & PHP'),
('Dr. Sarah Frontend', 'sarah@tutor.com', '$2y$10$xyz123', '082222222222', 'HTML, CSS, JavaScript'),
('Pak Joko Backend', 'joko@tutor.com', '$2y$10$xyz123', '082333333333', 'Database & Backend'),
('Bu Rina Design', 'rina@tutor.com', '$2y$10$xyz123', '082444444444', 'UI/UX Design'),
('Mas Dedi Fullstack', 'dedi@tutor.com', '$2y$10$xyz123', '082555555555', 'Full Stack Development');

INSERT INTO kursus (id_tutor, nama_kursus, deskripsi, kategori, tingkat) VALUES
(1, 'Dasar Pemrograman PHP', 'Belajar PHP dari nol hingga bisa membuat aplikasi web dinamis dengan database MySQL', 'Programming', 'pemula'),
(2, 'HTML & CSS untuk Pemula', 'Pelajari dasar-dasar HTML5 dan CSS3 untuk membuat website yang menarik dan responsive', 'Web Design', 'pemula');

INSERT INTO materi (id_kursus, judul_materi, deskripsi, link_video) VALUES
(1, 'Pengenalan PHP', 'Apa itu PHP dan bagaimana cara kerjanya', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(1, 'Variabel dan Tipe Data', 'Memahami variabel, string, integer, array dalam PHP', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(1, 'Control Structure', 'If-else, switch, dan perulangan for/while', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(1, 'Fungsi dalam PHP', 'Membuat dan menggunakan function', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(1, 'Koneksi Database MySQL', 'Cara menghubungkan PHP dengan MySQL', 'https://www.youtube.com/embed/dQw4w9WgXcQ');

INSERT INTO materi (id_kursus, judul_materi, deskripsi, link_video) VALUES
(2, 'Struktur Dasar HTML', 'Tag HTML, heading, paragraph, list', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(2, 'CSS Selector & Properties', 'Cara styling elemen dengan CSS', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(2, 'CSS Layout dengan Flexbox', 'Membuat layout responsive dengan flexbox', 'https://www.youtube.com/embed/dQw4w9WgXcQ'),
(2, 'Form HTML', 'Membuat form input, button, checkbox', 'https://www.youtube.com/embed/dQw4w9WgXcQ');

INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(1, 'Apa kepanjangan dari PHP?', 'Personal Home Page', 'PHP Hypertext Preprocessor', 'Private Hosting Platform', 'Public HTML Program', 'B'),
(1, 'Tag PHP dimulai dengan?', '<?php', '<script>', '<php>', '<%', 'A'),
(1, 'Ekstensi file PHP adalah?', '.html', '.php', '.txt', '.css', 'B');

INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(2, 'Cara mendeklarasikan variabel di PHP?', 'var $nama', '$nama', 'let nama', 'int $nama', 'B'),
(2, 'Tipe data untuk angka desimal?', 'int', 'float', 'string', 'boolean', 'B'),
(2, 'Fungsi untuk mengecek tipe data variabel?', 'typeof()', 'gettype()', 'check_type()', 'var_type()', 'B');

INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(3, 'Statement untuk kondisi banyak pilihan?', 'if-else', 'switch', 'for', 'while', 'B'),
(3, 'Perulangan yang cocok untuk array?', 'do-while', 'switch', 'foreach', 'if', 'C');

INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(6, 'Tag untuk judul terbesar di HTML?', '<h6>', '<h1>', '<title>', '<header>', 'B'),
(6, 'Tag untuk membuat link?', '<a>', '<link>', '<href>', '<url>', 'A'),
(7, 'Cara menambahkan CSS di HTML?', '<style>', '<css>', '<script>', '<link>', 'A'),
(7, 'Property CSS untuk warna teks?', 'text-color', 'color', 'font-color', 'text', 'B');

INSERT INTO siswa_kursus (id_siswa, id_kursus, tgl_gabung) VALUES
(1, 1, '2024-03-21'), -- Budi ambil PHP
(1, 2, '2024-03-22'), -- Budi ambil HTML&CSS
(2, 1, '2024-03-23'), -- Siti ambil PHP
(3, 2, '2024-03-24'), -- Rudi ambil HTML&CSS
(4, 1, '2024-03-25'), -- Dewi ambil PHP
(5, 2, '2024-03-26'); -- Agus ambil HTML&CSS

INSERT INTO penilaian (id_siswa, id_kursus, nilai, keterangan, tgl_penilaian) VALUES
(1, 1, 85, 'Kuis Pengenalan PHP', '2024-03-22'),
(1, 2, 90, 'Kuis HTML Dasar', '2024-03-23'),
(2, 1, 75, 'Kuis Variabel PHP', '2024-03-24'),
(3, 2, 88, 'Kuis CSS Selector', '2024-03-25'),
(4, 1, 92, 'Kuis Control Structure', '2024-03-26');

INSERT INTO progres_belajar (id_siswa, id_kursus, materi_selesai, total_materi, persentase_progres, status_progres) VALUES
(1, 1, 3, 5, 60, 'sedang_berjalan'),
(1, 2, 4, 4, 100, 'selesai'),
(2, 1, 2, 5, 40, 'sedang_berjalan'),
(3, 2, 3, 4, 75, 'sedang_berjalan'),
(4, 1, 5, 5, 100, 'selesai');