<?php
// public/kursus_detail.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Progress.php'; // Digunakan untuk cek status progress

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

// Query untuk mengambil detail kursus dan tutor
$stmt = $conn->prepare("
    SELECT 
        k.nama_kursus, k.deskripsi, k.tingkat, k.kategori,
        t.nama_siswa AS nama_tutor 
    FROM kursus k 
    JOIN tutor t ON k.id_tutor = t.id_tutor
    WHERE k.id_kursus = ?
");
$stmt->bind_param("i", $id_kursus);
$stmt->execute();
$kursus = $stmt->get_result()->fetch_assoc();

if (!$kursus) {
    header("Location: kursus.php"); // Redirect jika kursus tidak ditemukan
    exit;
}

// Cek Status Pendaftaran Kursus & Progress
$stmt_check = $conn->prepare("
    SELECT 
        p.presentase_progress, 
        p.status_progress
    FROM progress_belajar p
    WHERE p.id_siswa = ? AND p.id_kursus = ?
");
$stmt_check->bind_param("ii", $id_siswa, $id_kursus);
$stmt_check->execute();
$progress = $stmt_check->get_result()->fetch_assoc();

$sudah_ambil = ($progress != null);
$presentase = $sudah_ambil ? $progress['presentase_progress'] : 0;
$status = $sudah_ambil ? $progress['status_progress'] : 'Belum Diambil';


include __DIR__ . '/../includes/header.php';
?>

<!-- Gaya CSS kustom untuk tombol dan status -->
<style>
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
                <small class="text-success fw-bold">PROGRES ANDA:</small>
                <div class="progress mt-1" style="height: 10px;">
                    <div class="progress-bar progress-bar-custom" 
                         role="progressbar" 
                         style="width: <?= $presentase; ?>%;" 
                         aria-valuenow="<?= $presentase; ?>" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                    </div>
                </div>
                <small class="text-muted"><?= $presentase; ?>% Selesai (Status: <?= $status; ?>)</small>
            </div>
        <?php endif; ?>

        <hr>

        <!-- Deskripsi Lengkap Kursus (Meniru Format Bersih Dicoding) -->
        <h4 class="mt-4 mb-3" style="color: var(--dicoding-dark);">Deskripsi dan Tujuan Pembelajaran</h4>
        <p class="text-secondary">
            <?= nl2br(htmlspecialchars($kursus['deskripsi'])); ?>
            <!-- Anda bisa menambahkan deskripsi lebih panjang di sini -->
            Kursus ini dirancang untuk membekali Anda dengan pengetahuan mendalam. Setelah menyelesaikan kelas ini, Anda akan mampu mengimplementasikan konsep [Kategori Kursus] dalam proyek nyata.
        </p>

    </div>

    <!-- Kolom 2: Kartu Aksi dan Info Samping -->
    <div class="col-lg-4">
        <div class="card p-4 detail-card sticky-top" style="top: 20px;">
            <img src="https://placehold.co/400x225/1f8b88/FFFFFF?text=<?= urlencode(str_replace(' ', '+', $kursus['nama_kursus'])); ?>" class="card-img-top mb-3" alt="Banner Kursus">
            
            <?php if ($sudah_ambil): ?>
                <!-- Tombol LANJUT BELAJAR (Jika sudah ambil) -->
                <a href="materi.php?id=<?= $id_kursus; ?>" class="btn btn-lanjut-belajar btn-block">
                    <?= $presentase == 100 ? 'Lihat Sertifikat/Ulangi Kursus' : 'Lanjut Belajar (Mulai dari Materi)'; ?>
                </a>
            <?php else: ?>
                <!-- Tombol AMBIL KURSUS (Jika belum ambil) -->
                <a href="ambil_kursus.php?id=<?= $id_kursus; ?>" class="btn btn-primary btn-block">
                    Ambil Kursus Sekarang
                </a>
                <p class="text-center text-muted small mt-2">Kursus ini bersifat gratis.</p>
            <?php endif; ?>

            <hr class="mt-3 mb-3">

            <!-- Detail Tambahan (Mockup) -->
            <ul class="list-unstyled small text-muted">
                <li><i class="fas fa-clock me-2"></i> <strong>Durasi:</strong> 10 Jam Pembelajaran</li>
                <li><i class="fas fa-users me-2"></i> <strong>Pendaftar:</strong> 15.000 Siswa</li>
                <li><i class="fas fa-file-alt me-2"></i> <strong>Modul:</strong> 5 Modul & 1 Final Project</li>
            </ul>
        </div>
    </div>
</div>


<?php include __DIR__ . '/../includes/footer.php'; ?>