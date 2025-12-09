CREATE TABLE siswa (
    id_siswa BIGINT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_siswa VARCHAR(255) NOT NULL,
    tgl_daftar DATE NOT NULL,
    status_akun VARCHAR(255) NOT NULL
);

CREATE TABLE tutor (
    id_tutor BIGINT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_siswa VARCHAR(255) NOT NULL,
    no_hp BIGINT UNIQUE NOT NULL,
    keahlian VARCHAR(255) NOT NULL
);

CREATE TABLE kursus (
    id_kursus BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_tutor BIGINT NOT NULL,
    nama_kursus VARCHAR(255) NOT NULL,
    deskripsi VARCHAR(255) NOT NULL,
    kategori VARCHAR(255) NOT NULL,
    tingkat VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_tutor) REFERENCES tutor(id_tutor)
);

CREATE TABLE siswaKursus (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT NOT NULL,
    id_kursus BIGINT NOT NULL,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa),
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus)
);

CREATE TABLE materi (
    id_materi BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_kursus BIGINT NOT NULL,
    judul_materi VARCHAR(255) NOT NULL,
    deskripsi VARCHAR(255) NOT NULL,
    link_video VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus)
);

CREATE TABLE progress_belajar (
    id_progress BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT NOT NULL,
    id_kursus BIGINT NOT NULL,
    materi_selesai INT NOT NULL,
    total_materi INT NOT NULL,
    presentase_progress INT NOT NULL,
    status_progress VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa),
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus)
);

CREATE TABLE penilaian (
    id_penilaian BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_siswa BIGINT NOT NULL,
    id_kursus BIGINT NOT NULL,
    nilai INT NOT NULL,
    tgl_penilaian DATE NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa),
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus)
);

CREATE TABLE kuis (
    id_kuis BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_materi BIGINT NOT NULL,
    pertanyaan TEXT NOT NULL,
    opsi_a VARCHAR(255) NOT NULL,
    opsi_b VARCHAR(255) NOT NULL,
    opsi_c VARCHAR(255) NOT NULL,
    opsi_d VARCHAR(255) NOT NULL,
    jawaban_benar CHAR(1) NOT NULL,
    FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa),
    FOREIGN KEY (id_kursus) REFERENCES kursus(id_kursus)
);

DROP TABLE IF EXISTS progress_materi;

CREATE TABLE progress_materi (
    id_siswa BIGINT(20) NOT NULL,
    id_materi BIGINT(20) NOT NULL,
    tgl_selesai DATETIME NOT NULL,
    PRIMARY KEY (id_siswa, id_materi),
    
    CONSTRAINT fk_progress_siswa 
        FOREIGN KEY (id_siswa) REFERENCES siswa(id_siswa)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_progress_materi 
        FOREIGN KEY (id_materi) REFERENCES materi(id_materi)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
