# 🚀 Instan UTBK

**Aplikasi Manajemen Kursus & Pemantauan Progres Belajar**

Aplikasi ini adalah solusi manajemen kursus dan pelacakan perkembangan belajar yang dirancang khusus untuk persiapan ujian **UTBK / SNBT**. Keunggulan utamanya terletak pada integrasi basis data yang mendalam untuk menyediakan analisis dan rekomendasi pembelajaran yang dipersonalisasi bagi setiap siswa.

---

## ✨ Fitur Unggulan (Data-Driven)

Proyek ini dibangun di atas fondasi basis data yang kuat, memungkinkan fitur-fitur unik berikut:

* **Sistem Rekomendasi Cerdas**

  * Berdasarkan data historis dari tabel `penilaian`, sistem dapat menyarankan modul remedial atau subtes lanjutan jika skor kuis siswa di bawah standar (misal: `< 60`).

* **Monitoring Progres Real-time**

  * Dashboard siswa menampilkan perkembangan belajar yang diambil langsung dari tabel `progres_belajar` (`persentase_progres`, `materi_selesai`, `total_materi`).

* **Atomic Enrollment (Transaksi / ACID)**

  * Proses pendaftaran kursus (enrollment) dijamin oleh transaksi database sehingga data masuk ke `siswaKursus` **dan** `progres_belajar` secara bersamaan, menjaga integritas data.

* **Learning Reminder**

  * Logika sederhana di dashboard (`public/index.php`) memantau status `progres_belajar` untuk mengingatkan siswa yang stagnan.

* **Struktur Subtes UTBK**

  * Semua kursus (`kursus`) terpetakan ke 7 Subtes UTBK (TPS & Literasi), masing-masing terhubung ke 10 soal kuis terpisah.

---

## 📐 Arsitektur Data (ERD)

Aplikasi dimodelkan menggunakan Entity-Relationship Diagram (ERD) untuk mendukung integritas data dan relasi bisnis kompleks.

* **Tabel Sentral**: `progres_belajar` berfungsi sebagai tabel fakta yang menyimpan metrik kemajuan siswa terhadap setiap Subtes (kursus).
* **Relasi N:M**: Relasi antara `siswa` dan `kursus` diselesaikan melalui tabel penghubung `siswaKursus` (enrollment).
* **Penilaian**: Hasil kuis disimpan di tabel `penilaian`, berelasi dengan `siswa` dan `kursus`.

> *Catatan*: Sertakan file ERD (gambar) di folder `assets/img/` jika ingin menampilkan diagram di README.

---

## 📂 Struktur Folder Proyek

```
PROJECT-SBD/
├── assets/
│   ├── img/          # Gambar Subtes, Ilustrasi
│   └── css/
├── config/
│   └── database.php  # File koneksi database
├── controllers/
│   ├── KursusController.php
│   ├── KuisController.php
│   └── ProgressController.php # Logika Bisnis & Transaksi Database
├── includes/
│   ├── header.php    # Navigasi & Styling Aktif
│   └── footer.php
├── models/
│   ├── Kursus.php
│   ├── Kuis.php
│   ├── Materi.php
│   └── Progress.php # Logika CRUD Progres Belajar
└── public/           # Halaman yang dapat diakses publik/siswa
    ├── index.php     # Dashboard Siswa
    ├── kursus.php    # Katalog Subtes
    ├── kuis.php      # Halaman Kuis (10 Soal/Subtes)
    └── ... (Halaman Login, Register, Profil, Detail)
```

---

## 🛠️ Instalasi Proyek (Local)

**Persyaratan Sistem**

* Web Server (Apache/Nginx)
* PHP 8.0+
* MariaDB / MySQL

**Langkah-Langkah**

1. **Clone repository**

```bash
git clone [Link Repositori Anda] project-SBD
cd project-SBD
```

2. **Konfigurasi Database**

* Buat database baru (misal: `db_kursusonline`).
* Jalankan skema dasar dari file SQL: `kursus_onlinewm 48 fix banget.sql`.
* Jalankan perbaikan Primary Key: `fix_siswa_table.sql` (mengaktifkan `AUTO_INCREMENT`).
* Jalankan script data awal: `utbk_subtes_lengkap_final.sql` (mengisi Tutor, Subtes, Materi, ~70 Kuis).

> Pastikan urutan import SQL sesuai dan tidak ada error karena constraint.

3. **Sesuaikan koneksi**

Edit file `config/database.php` dan atur variabel koneksi:

```php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'db_kursusonline';
```

4. **Akses aplikasi**

* Halaman publik About: `http://localhost/project-SBD/pages/about.php`
* Halaman login: `http://localhost/project-SBD/public/login.php`

---

## 🧭 Penggunaan & Alur Fungsional Singkat

* **Pendaftaran Siswa** → Buat record di tabel `siswa` → Enrollment ke `siswaKursus` (transaksional) → Inisialisasi `progres_belajar` untuk setiap subtes.
* **Siswa Mengerjakan Kuis** → Hasil disimpan di `penilaian` → Cron/logika dashboard menghitung `persentase_progres` dan memicu rekomendasi jika skor < threshold.

---

## 📁 File SQL Penting

* `kursus_onlinewm 48 fix banget.sql` — skema awal
* `fix_siswa_table.sql` — perbaikan primary key & AUTO_INCREMENT
* `utbk_subtes_lengkap_final.sql` — data awal Subtes, Tutor, Materi, Soal

---

## 📌 Tips Debugging (XAMPP / MySQL)

* Jika MySQL tidak bisa start, cek port `3306` apakah sudah digunakan oleh proses lain: `netstat -aon | findstr :3306`.
* Error `Unknown database` → pastikan database sudah dibuat dan nama di `database.php` sesuai.
* Error SQL syntax → cek versi MariaDB/MySQL dan statement SQL (koma ekstra atau kata kunci reserved).

---

## 🧩 Kontribusi

Kontribusi sangat dipersilakan. Beberapa cara kontribusi:

1. Fork repository ini.
2. Buat branch fitur: `git checkout -b feat/nama-fitur`
3. Commit perubahan: `git commit -m "Menambah fitur ..."`
4. Push dan buka Pull Request.

Mohon sertakan deskripsi perubahan dan file SQL jika terkait struktur DB.

---

## 📜 Lisensi

This project menggunakan lisensi **MIT** — lihat file `LICENSE`.

---

## 🤝 Kontak

Jika ada pertanyaan, laporan bug, atau mau kolaborasi, hubungi:

* Nama: Yusri
* Email: *[annisayusri59@gmail.com](mailto:annisayusri59@gmail.com)*

---

*Dibuat dengan semangat untuk lulus UTBK.*
