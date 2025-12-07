
CREATE TABLE siswa (
    id_siswa BIGINT AUTO_INCREMENT PRIMARY KEY,
    nama_siswa VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    no_hp VARCHAR(20), 
    pekerjaan VARCHAR(100),
    alamat TEXT,
    tgl_daftar DATE NOT NULL,
    status_akun ENUM('aktif', 'nonaktif', 'banned') DEFAULT 'aktif'
);

CREATE TABLE tutor (
    id_tutor BIGINT AUTO_INCREMENT PRIMARY KEY,
    nama_tutor VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    keahlian VARCHAR(255) NOT NULL
);

CREATE TABLE kursus (
    id_kursus BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_tutor BIGINT NOT NULL,
    nama_kursus VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    tingkat ENUM('pemula', 'menengah', 'lanjutan') NOT NULL,
    FOREIGN KEY (id_tutor) REFERENCES tutor(id_tutor) ON DELETE CASCADE
);

CREATE TABLE materi (
    id_materi BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_kursus BIGINT NOT NULL,
    judul_materi VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    link_video VARCHAR(255),
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus) ON DELETE CASCADE
);

CREATE TABLE kuis (
    id_kuis BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_materi BIGINT NOT NULL,
    pertanyaan TEXT NOT NULL,
    opsi_a VARCHAR(255) NOT NULL,
    opsi_b VARCHAR(255) NOT NULL,
    opsi_c VARCHAR(255) NOT NULL,
    opsi_d VARCHAR(255) NOT NULL,
    jawaban_benar CHAR(1) NOT NULL, -- Isi 'A', 'B', 'C', atau 'D'
    FOREIGN KEY (id_materi) REFERENCES materi(id_materi) ON DELETE CASCADE
);

CREATE TABLE siswa_kursus (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT NOT NULL,
    id_kursus BIGINT NOT NULL,
    tgl_gabung DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus) ON DELETE CASCADE
);

CREATE TABLE progres_belajar (
    id_progres BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT NOT NULL,
    id_kursus BIGINT NOT NULL,
    materi_selesai INT DEFAULT 0,
    total_materi INT DEFAULT 0,
    persentase_progres INT DEFAULT 0,
    status_progres ENUM('belum_mulai', 'sedang_berjalan', 'selesai') DEFAULT 'belum_mulai',
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus) ON DELETE CASCADE
);

CREATE TABLE penilaian (
    id_penilaian BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT NOT NULL,
    id_kursus BIGINT NOT NULL,
    nilai INT NOT NULL,
    keterangan VARCHAR(255),
    tgl_penilaian DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus) ON DELETE CASCADE
);