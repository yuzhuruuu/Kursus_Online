<?php
// public/kursus_detail.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Progress.php'; 
require_once __DIR__ . '/../models/Kursus.php'; 
require_once __DIR__ . '/../controllers/KursusController.php'; 

if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

// Inisialisasi
global $conn;
$id_siswa = $_SESSION['id_siswa'];
$id_kursus = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$progress_model = new Progress($conn); 
$kursus_controller = new KursusController($conn); 

// Query 1: Ambil detail kursus dan tutor
$stmt = $conn->prepare("
    SELECT 
        k.nama_kursus, k.deskripsi, k.tingkat, k.kategori,
        t.nama_tutor AS nama_tutor 
    FROM kursus k 
    JOIN tutor t ON k.id_tutor = t.id_tutor
    WHERE k.id_kursus = ?
");
$stmt->bind_param("i", $id_kursus);
$stmt->execute();
$kursus = $stmt->get_result()->fetch_assoc();

if (!$kursus) {
    header("Location: kursus.php?error=kursus_not_found"); 
    exit;
}

// Query 2: Cek Status Pendaftaran Kursus & Progress
$stmt_check = $conn->prepare("
    SELECT 
        p.persentase_progres, 
        p.status_progres 
    FROM progres_belajar p
    WHERE p.id_siswa = ? AND p.id_kursus = ?
");
$stmt_check->bind_param("ii", $id_siswa, $id_kursus);
$stmt_check->execute();
$progress = $stmt_check->get_result()->fetch_assoc();

$sudah_ambil = ($progress != null);

// Data Progres
$presentase = $sudah_ambil ? $progress['persentase_progres'] : 0;
$status = $sudah_ambil ? $progress['status_progres'] : 'belum_diambil';

// Ambil total materi dari tabel progres_belajar (sudah tersimpan saat enroll)
$total_materi = 0;
$materi_selesai = 0;
if ($sudah_ambil) {
    $stmt_progress_data = $conn->prepare("SELECT total_materi, materi_selesai FROM progres_belajar WHERE id_siswa = ? AND id_kursus = ?");
    $stmt_progress_data->bind_param("ii", $id_siswa, $id_kursus);
    $stmt_progress_data->execute();
    $data = $stmt_progress_data->get_result()->fetch_assoc();
    $total_materi = $data['total_materi'] ?? 0;
    $materi_selesai = $data['materi_selesai'] ?? 0;
}


// LOGIKA GAMBAR SISI SAMPING
$assets_path = '/project-SBD/assets/img/';
$clean_name_raw = trim(preg_replace('/\s*\([^)]*\)\s*/', '', $kursus['nama_kursus']));
$image_name_cleaned = strtolower(str_replace([' ', '&', '-'], ['_', '_dan_', '_'], $clean_name_raw));
$image_file = $image_name_cleaned . '.jpg'; // ASUMSI .jpg

include __DIR__ . '/../includes/header.php';
?>

<!-- Gaya CSS kustom untuk tombol dan status -->
<style>
/* Style Anda dari file sebelumnya */
:root {
    --dicoding-dark: #0b1c31; 
    --dicoding-accent: #00bcd4; 
}
.detail-card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}
.progress-bar-custom {
    background-color: var(--dicoding-accent, #00bcd4);
}
.btn-lanjut-belajar {
    background-color: #1f8b88; /* Warna hijau tua Dicoding */
    color: white;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 8px;
    transition: background-color 0.3s;
}
.btn-lanjut-belajar:hover {
    background-color: #1a7572;
    color: white;
}
.card-img-top-custom {
    width: 100%;
    height: 150px; 
    object-fit: cover; 
    border-radius: 8px;
}
</style>

<div class="row">
    <!-- Kolom Utama Konten -->
    <div class="col-lg-8">
        <h1 class="mb-3" style="color: var(--dicoding-dark); font-weight: 700;"><?= htmlspecialchars($kursus['nama_kursus']); ?></h1>
        
        <!-- Info Ringkas -->
        <p class="lead text-muted"><?= htmlspecialchars($kursus['deskripsi']); ?></p>

        <div class="d-flex align-items-center mb-4">
            <span class="badge bg-secondary me-3">Tingkat: <?= htmlspecialchars($kursus['tingkat']); ?></span>
            <span class="badge bg-info me-3">Kategori: <?= htmlspecialchars($kursus['kategori']); ?></span>
            <span class="text-muted small">⭐️ 4.7 (Mockup Rating)</span>
        </div>

        <!-- Section Tutor -->
        <p class="mb-4">
            Diajarkan oleh: <span class="fw-bold text-primary"><?= htmlspecialchars($kursus['nama_tutor']); ?></span>
        </p>
        
        <!-- Progres Bar di Bagian Atas (Jika Sudah Diambil) -->
        <?php if ($sudah_ambil): ?>
            <div class="alert alert-light border-start border-4 border-success p-3 mb-4">
                <small class="text-success fw-bold">PROGRES ANDA: (<?= $materi_selesai ?>/<?= $total_materi ?> Materi Selesai)</small>
                <div class="progress mt-1" style="height: 10px;">
                    <div class="progress-bar progress-bar-custom" 
                         role="progressbar" 
                         style="width: <?= $presentase; ?>%;" 
                         aria-valuenow="<?= $presentase; ?>" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                    </div>
                </div>
                <small class="text-muted"><?= $presentase; ?>% Selesai (Status: <?= ucfirst(str_replace('_', ' ', $status)); ?>)</small>
            </div>
        <?php endif; ?>

        <hr>

        <!-- Modul Materi (Penting: Menampilkan daftar materi) -->
        <h4 class="mt-4 mb-3" style="color: var(--dicoding-dark);">Modul Subtes</h4>
        <ul class="list-group list-group-flush">
            <?php 
            // Ambil daftar materi untuk Subtes ini
            $stmt_materi = $conn->prepare("
                SELECT id_materi, judul_materi 
                FROM materi 
                WHERE id_kursus = ?
                ORDER BY id_materi ASC
            ");
            $stmt_materi->bind_param("i", $id_kursus);
            $stmt_materi->execute();
            $materi_list = $stmt_materi->get_result();

            if ($materi_list->num_rows > 0):
                // Ambil ID materi pertama untuk tombol Lanjut Belajar
                $materi_list->data_seek(0); 
                $first_materi = $materi_list->fetch_assoc();
                $first_materi_id = $first_materi['id_materi'];
                $materi_list->data_seek(0); // Reset pointer lagi sebelum loop
                
                while ($m = $materi_list->fetch_assoc()):
            ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold"><?= htmlspecialchars($m['judul_materi']); ?></span>
                            <small class="text-muted d-block">Modul Pembelajaran</small>
                        </div>
                        <?php if ($sudah_ambil): ?>
                            <a href="materi_detail.php?kursus_id=<?= $id_kursus; ?>&materi_id=<?= $m['id_materi']; ?>" 
                               class="btn btn-sm btn-outline-primary">Lihat Materi</a>
                        <?php else: ?>
                            <span class="badge bg-secondary">Daftar Dulu</span>
                        <?php endif; ?>
                    </li>
            <?php 
                endwhile;
            else: ?>
                <li class="list-group-item text-center text-muted">Belum ada modul materi ditambahkan.</li>
            <?php endif; ?>
        </ul>

        <hr>

        <!-- Detail Tambahan / Deskripsi Lengkap -->
        <h4 class="mt-4 mb-3" style="color: var(--dicoding-dark);">Deskripsi dan Tujuan Subtes</h4>
        <p class="text-secondary">
            <?= nl2br(htmlspecialchars($kursus['deskripsi'])); ?>
        </p>

    </div>

    <!-- Kolom 2: Kartu Aksi dan Info Samping -->
    <div class="col-lg-4">
        <div class="card p-4 detail-card sticky-top" style="top: 20px;">
            <!-- GAMBAR SISI SAMPING -->
            <img src="<?= $assets_path . $image_name_cleaned . '.jpg'; ?>" 
                 class="card-img-top-custom mb-3" 
                 alt="<?= htmlspecialchars($kursus['nama_kursus']); ?>"
                 onerror="this.onerror=null;this.src='https://placehold.co/400x150/1f8b88/FFFFFF?text=<?= urlencode(str_replace(' ', '+', $kursus['nama_kursus'])); ?>';">
            
            <?php if ($sudah_ambil): ?>
                <!-- Tombol LANJUT BELAJAR (Jika sudah ambil) -->
                <a href="materi_detail.php?kursus_id=<?= $id_kursus; ?>&materi_id=<?= $first_materi_id ?? ''; ?>" 
                   class="btn btn-lanjut-belajar btn-block">
                    <?= $presentase == 100 ? 'Lihat Sertifikat/Ulangi Kursus' : 'Lanjut Belajar (Mulai Modul)'; ?>
                </a>
            <?php else: ?>
                <!-- Tombol AMBIL KURSUS (Jika belum ambil) -->
                <a href="enroll_kursus.php?id=<?= $id_kursus; ?>" class="btn btn-primary btn-block">
                    Ambil Subtes Sekarang
                </a>
                <p class="text-center text-muted small mt-2">Kursus ini bersifat gratis.</p>
            <?php endif; ?>

            <hr class="mt-3 mb-3">

            <!-- Detail Tambahan -->
            <ul class="list-unstyled small text-muted">
                <li><i class="fas fa-file-alt me-2"></i> <strong>Total Modul:</strong> <?= $total_materi; ?> Materi</li>
                <li><i class="fas fa-question-circle me-2"></i> <strong>Total Kuis:</strong> 10 Soal/Subtes (Mockup)</li>
                <li><i class="fas fa-book-reader me-2"></i> <strong>Tingkat:</strong> <?= htmlspecialchars($kursus['tingkat']); ?></li>
            </ul>
        </div>
    </div>
</div>


<?php include __DIR__ . '/../includes/footer.php'; ?>