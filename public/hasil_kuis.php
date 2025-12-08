<?php
// public/hasil_kuis.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Kursus.php';
require_once __DIR__ . '/../models/Penilaian.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

// Cek parameter hasil kuis yang dikirim dari kuis.php
if (!isset($_GET['nilai']) || !isset($_GET['kursus_id']) || !is_numeric($_GET['nilai']) || !is_numeric($_GET['kursus_id'])) {
    header("Location: progress.php");
    exit;
}

global $conn;
$id_siswa = $_SESSION['id_siswa'];
$nilai_akhir = (int)$_GET['nilai'];
$id_kursus = (int)$_GET['kursus_id'];

$kursus_model = new Kursus($conn);
$penilaian_model = new Penilaian($conn);

// Ambil data kursus (nama subtes)
$kursus_data = $kursus_model->getById($id_kursus);
$nama_subtes = $kursus_data['nama_kursus'] ?? 'Subtes Tidak Dikenal';

// Menentukan status berdasarkan nilai (Logika Rekomendasi Sederhana)
$status_rekomendasi = '';
$rekomendasi_teks = '';
$warna_nilai = 'text-danger';

if ($nilai_akhir >= 80) {
    $status_rekomendasi = 'Sangat Baik!';
    $rekomendasi_teks = 'Hebat! Lanjutkan ke subtes berikutnya atau ulangi kuis untuk mendapatkan nilai sempurna.';
    $warna_nilai = 'text-success-custom';
} elseif ($nilai_akhir >= 60) {
    $status_rekomendasi = 'Cukup Baik';
    $rekomendasi_teks = 'Nilai Anda sudah baik. Fokus pada materi yang kurang dipahami untuk meningkatkan skor.';
    $warna_nilai = 'text-warning-custom';
} else {
    $status_rekomendasi = 'Perlu Perbaikan';
    $rekomendasi_teks = 'Anda perlu mengulang modul materi ini sebelum mencoba kuis lagi. Evaluasi kelemahan Anda.';
    $warna_nilai = 'text-danger-custom';
}

include __DIR__ . '/../includes/header.php';
?>

<style>
    :root {
        --dicoding-dark: #0b1c31;
        --dicoding-accent: #00bcd4;
    }
    .result-card {
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        text-align: center;
        background-color: #ffffff;
    }
    .nilai-display {
        font-size: 5rem;
        font-weight: 800;
    }
    .btn-rekomendasi {
        background-color: var(--dicoding-accent);
        border-color: var(--dicoding-accent);
        font-weight: 700;
        color: var(--dicoding-dark);
    }
    .btn-rekomendasi:hover {
        background-color: #00a8bb;
    }
    .text-success-custom {
        color: #28a745;
    }
    .text-warning-custom {
        color: #ffc107;
    }
    .text-danger-custom {
        color: #dc3545;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="result-card">
            <h1 class="mb-4" style="color: var(--dicoding-dark);">Hasil Kuis Subtes</h1>
            
            <p class="lead">Subtes yang Diselesaikan: <span class="fw-bold text-primary"><?= htmlspecialchars($nama_subtes); ?></span></p>

            <h3 class="mt-4 mb-2">Nilai Akhir Anda</h3>
            <div class="<?= $warna_nilai; ?> nilai-display mb-4">
                <?= htmlspecialchars($nilai_akhir); ?>
            </div>

            <p class="fw-bold fs-4" style="color: var(--dicoding-dark);"><?= htmlspecialchars($status_rekomendasi); ?></p>
            <p class="text-muted"><?= htmlspecialchars($rekomendasi_teks); ?></p>
            
            <hr class="my-4">

            <!-- Tombol Aksi dan Rekomendasi -->
            <div class="d-grid gap-2 d-md-flex justify-content-center">
                <a href="kursus_detail.php?id=<?= $id_kursus; ?>" class="btn btn-lg btn-rekomendasi px-4">
                    Lihat Progres dan Modul
                </a>
                <a href="progress.php" class="btn btn-lg btn-outline-secondary px-4">
                    Dashboard Progres
                </a>
            </div>
            
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>