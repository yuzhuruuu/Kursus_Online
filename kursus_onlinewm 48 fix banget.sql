CREATE TABLE `kuis`(
    `id_kuis` BIGINT(20) NOT NULL,
    `id_materi` BIGINT(20) NOT NULL,
    `pertanyaan` TEXT NOT NULL,
    `opsi_a` VARCHAR(255) NOT NULL,
    `opsi_b` VARCHAR(255) NOT NULL,
    `opsi_c` VARCHAR(255) NOT NULL,
    `opsi_d` VARCHAR(255) NOT NULL,
    `jawaban_benar` CHAR(1) NOT NULL,
    PRIMARY KEY(`id_kuis`)
);
CREATE TABLE `kursus`(
    `id_kursus` BIGINT(20) NOT NULL,
    `id_tutor` BIGINT(20) NOT NULL,
    `nama_kursus` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `kategori` VARCHAR(100) NOT NULL,
    `tingkat` ENUM('pemula', 'menengah', 'lanjutan') NOT NULL,
    PRIMARY KEY(`id_kursus`)
);
CREATE TABLE `materi`(
    `id_materi` BIGINT(20) NOT NULL,
    `id_kursus` BIGINT(20) NOT NULL,
    `judul_materi` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT NULL DEFAULT 'DEFAULT NULL',
    `link_video` VARCHAR(255) NULL DEFAULT 'DEFAULT NULL',
    PRIMARY KEY(`id_materi`)
);
CREATE TABLE `penilaian`(
    `id_penilaian` BIGINT(20) NOT NULL,
    `id_siswa` BIGINT(20) NOT NULL,
    `id_kursus` BIGINT(20) NOT NULL,
    `nilai` INT(11) NOT NULL,
    `keterangan` VARCHAR(255) NULL,
    `tgl_penilaian` DATE NOT NULL,
    PRIMARY KEY(`id_penilaian`)
);
CREATE TABLE `progres_belajar`(
    `id_progres` BIGINT(20) NOT NULL,
    `id_siswa` BIGINT(20) NOT NULL,
    `materi_selesai` INT(11) NULL,
    `total_materi` INT(11) NULL,
    `persentase_progres` INT(11) NULL,
    `status_progres` ENUM(
        'belum_mulai',
        'sedang_berjalan',
        'selesai'
    ) NULL DEFAULT 'belum_mulai',
    `id_kursus` BIGINT NOT NULL,
    PRIMARY KEY(`id_progres`)
);
CREATE TABLE `siswa`(
    `id_siswa` BIGINT(20) NOT NULL,
    `nama_siswa` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `no_hp` VARCHAR(20) NULL DEFAULT 'DEFAULT NULL',
    `pekerjaan` VARCHAR(100) NULL DEFAULT 'DEFAULT NULL',
    `alamat` TEXT NULL DEFAULT 'DEFAULT NULL',
    `tgl_daftar` DATE NOT NULL,
    `status_akun` ENUM('aktif', 'nonaktif', 'banned') NULL DEFAULT 'aktif',
    PRIMARY KEY(`id_siswa`)
);
CREATE TABLE `tutor`(
    `id_tutor` BIGINT(20) NOT NULL,
    `nama_tutor` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `no_hp` VARCHAR(20) NOT NULL,
    `keahlian` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id_tutor`)
);
CREATE TABLE `siswaKursus`(
    `id_siswa` BIGINT NOT NULL,
    `id_kursus` BIGINT NOT NULL
);
ALTER TABLE
    `kursus` ADD CONSTRAINT `kursus_id_tutor_foreign` FOREIGN KEY(`id_tutor`) REFERENCES `tutor`(`id_tutor`);
ALTER TABLE
    `siswaKursus` ADD CONSTRAINT `siswakursus_id_kursus_foreign` FOREIGN KEY(`id_kursus`) REFERENCES `kursus`(`id_kursus`);
ALTER TABLE
    `progres_belajar` ADD CONSTRAINT `progres_belajar_id_kursus_foreign` FOREIGN KEY(`id_kursus`) REFERENCES `kursus`(`id_kursus`);
ALTER TABLE
    `penilaian` ADD CONSTRAINT `penilaian_id_siswa_foreign` FOREIGN KEY(`id_siswa`) REFERENCES `siswa`(`id_siswa`);
ALTER TABLE
    `progres_belajar` ADD CONSTRAINT `progres_belajar_id_siswa_foreign` FOREIGN KEY(`id_siswa`) REFERENCES `siswa`(`id_siswa`);
ALTER TABLE
    `materi` ADD CONSTRAINT `materi_id_kursus_foreign` FOREIGN KEY(`id_kursus`) REFERENCES `kursus`(`id_kursus`);
ALTER TABLE
    `kuis` ADD CONSTRAINT `kuis_id_materi_foreign` FOREIGN KEY(`id_materi`) REFERENCES `materi`(`id_materi`);
ALTER TABLE
    `siswaKursus` ADD CONSTRAINT `siswakursus_id_siswa_foreign` FOREIGN KEY(`id_siswa`) REFERENCES `siswa`(`id_siswa`);