-- Skrip ini hanya berfungsi jika id_siswa tidak lagi menjadi foreign key
-- yang merujuk ke tabel pengguna.

USE kursus_onlinewm;

-- Hapus foreign key constraint lama (jika ada)
ALTER TABLE siswa
  DROP FOREIGN KEY IF EXISTS siswa_ibfk_1;

-- Mengubah kolom id_siswa agar memiliki AUTO_INCREMENT
ALTER TABLE siswa
  MODIFY id_siswa INT(11) PRIMARY KEY AUTO_INCREMENT;

-- Tambahkan kolom id_pengguna sebagai foreign key yang terpisah
-- (Jika kamu tetap ingin menghubungkannya ke tabel pengguna)
ALTER TABLE siswa
  ADD COLUMN id_pengguna_fk INT(11) AFTER id_siswa,
  ADD CONSTRAINT fk_siswa_pengguna
  FOREIGN KEY (id_pengguna_fk) REFERENCES pengguna(id_pengguna);

-- Catatan: Jika id_siswa dan id_pengguna harus selalu sama,
-- skrip fix ini tidak diperlukan dan harus dipertahankan
-- struktur lama dengan menghilangkan AUTO_INCREMENT pada siswa.