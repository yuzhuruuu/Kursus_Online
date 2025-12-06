<?php
// pages/about.php (Halaman Utama Publik)
require_once __DIR__ . '/../config/database.php';
// Tidak perlu session_start() jika halaman ini adalah publik, 
// tetapi kita akan memerlukannya untuk include header/footer.
if (session_status() === PHP_SESSION_NONE) session_start();

global $conn;

// Ambil statistik dinamis dari database (DB Anda)
$total_siswa = $conn->query("SELECT COUNT(*) FROM siswa")->fetch_row()[0] ?? 0;
$total_kursus = $conn->query("SELECT COUNT(*) FROM kursus")->fetch_row()[0] ?? 0;


include __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <h1 class="mb-5 text-center" style="color: var(--dicoding-dark); font-weight: 700;">
            Wujudkan Karir Digital Anda Bersama Kami
        </h1>
        
        <!-- Bagian Visi & Misi (Menggunakan Deskripsi Ide Proyek Anda) -->
        <div class="p-4 mb-5" style="border-left: 5px solid var(--dicoding-accent); background-color: var(--dicoding-soft);">
            <h4 style="color: var(--dicoding-dark);">Ide Proyek Kami: Manajemen Kursus & Progres Real-time</h4>
            <p class="lead mb-0">
                Platform Kursus Online & Pemantauan Progres Belajar dirancang untuk mengatur kursus, tutor, siswa, materi, penilaian, kuis, dan **dashboard perkembangan belajar** secara terpadu.
            </p>
        </div>

        <!-- Section Keunikan Proyek -->
        <div class="row mb-5">
            <h3 class="text-center mb-4" style="color: var(--dicoding-dark);">Mengapa Memilih Kami?</h3>
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Dampak Positif yang Kami Berikan</h5>
                <ul class="list-unstyled">
                    <li><span class="text-success fw-bold me-2">✅</span> Membantu siswa belajar lebih terstruktur dan terpantau.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Tutor dapat mengelola kelas lebih efisien.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Admin memperoleh data evaluasi pendidikan yang lengkap.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Mengurangi keterlambatan belajar dan meningkatkan retensi siswa.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-success mb-3">Fitur Cerdas dan Unik</h5>
                <ul class="list-unstyled">
                    <li><span class="text-warning fw-bold me-2">💡</span> **Sistem Rekomendasi Kursus** lanjutan berdasarkan performa siswa.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> **Monitoring Progress Real-Time** untuk tutor & admin.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> **Integrasi Evaluasi Otomatis** hasil kuis langsung memengaruhi progres.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> **Fitur Pengingat Belajar** jika siswa stagnan.</li>
                </ul>
            </div>
        </div>

        <hr>

        <!-- Bagian Statistik Dinamis -->
        <h4 class="text-center mt-5 mb-4" style="color: var(--dicoding-dark);">Statistik Kami</h4>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-success"><?= htmlspecialchars($total_siswa); ?>+</h1>
                    <p class="text-muted">Siswa Aktif Terdaftar</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-primary"><?= htmlspecialchars($total_kursus); ?></h1>
                    <p class="text-muted">Total Kelas Tersedia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-warning">4.8</h1>
                    <p class="text-muted">Rata-rata Rating Kelas</p>
                </div>
            </div>
        </div>
        
        <!-- Call to Action -->
        <div class="text-center mt-5 p-4 border rounded bg-light">
            <h4 style="color: var(--dicoding-dark);">Siap untuk Memulai Perjalanan Belajar Anda?</h4>
            <p class="lead">Daftar sekarang dan akses kelas perdana Anda secara gratis!</p>
            <a href="/project-SBD/public/register.php" class="btn btn-lg btn-primary fw-bold">Daftar Sekarang</a>
            <a href="/project-SBD/public/login.php" class="btn btn-lg btn-outline-secondary ms-2">Masuk</a>
        </div>
        
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>