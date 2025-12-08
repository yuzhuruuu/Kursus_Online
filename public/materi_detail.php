<?php
// public/materi_detail.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/KursusController.php'; 
require_once __DIR__ . '/../controllers/ProgressController.php'; 

if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Cek Autentikasi dan Parameter
if(!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['kursus_id']) || !isset($_GET['materi_id']) || !is_numeric($_GET['kursus_id']) || !is_numeric($_GET['materi_id'])) {
    header("Location: kursus.php");
    exit;
}

global $conn;
$id_siswa = $_SESSION['id_siswa'];
$id_kursus = (int)$_GET['kursus_id'];
$id_materi = (int)$_GET['materi_id'];

$kursus_controller = new KursusController($conn);
$progress_controller = new ProgressController($conn);

// 2. Cek Enrollment: Pastikan siswa terdaftar di Subtes ini
if (!$kursus_controller->cekSudahAmbil($id_siswa, $id_kursus)) {
    header("Location: kursus_detail.php?id=" . $id_kursus . "&error=not_enrolled");
    exit;
}

// 3. Ambil Detail Materi dan Nama Subtes
$stmt_data = $conn->prepare("
    SELECT 
        m.judul_materi, 
        m.deskripsi, 
        m.link_video,
        k.nama_kursus
    FROM materi m
    JOIN kursus k ON m.id_kursus = k.id_kursus
    WHERE m.id_materi = ? AND m.id_kursus = ?
    LIMIT 1
");
$stmt_data->bind_param("ii", $id_materi, $id_kursus);
$stmt_data->execute();
$materi_data = $stmt_data->get_result()->fetch_assoc();

if (!$materi_data) {
    header("Location: kursus_detail.php?id=" . $id_kursus . "&error=materi_not_found");
    exit;
}

// 4. Cek Status Materi Selesai
$is_materi_selesai = $progress_controller->isMateriSudahSelesai($id_siswa, $id_materi); 

// Definisikan path absolut ke public folder
$PUBLIC_PATH = '/project-SBD/public/'; 

include __DIR__ . '/../includes/header.php';
?>

<style>
    :root {
        --dicoding-dark: #0b1c31; 
        --dicoding-accent: #00bcd4; 
    }
    .materi-container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .video-responsive {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    .video-responsive iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .description-box {
        border-left: 4px solid var(--dicoding-accent);
        padding-left: 15px;
        margin-top: 25px;
    }
    .btn-selesai {
        background-color: #28a745;
        border-color: #28a745;
        font-weight: 700;
        transition: background-color 0.3s;
    }
    .btn-selesai:hover {
        background-color: #1e7e34;
        border-color: #1c7430;
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="kursus.php">Subtes UTBK</a></li>
        <li class="breadcrumb-item"><a href="kursus_detail.php?id=<?= $id_kursus; ?>"><?= htmlspecialchars($materi_data['nama_kursus']); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($materi_data['judul_materi']); ?></li>
    </ol>
</nav>

<div class="materi-container">
    <h2 class="fw-bold" style="color: var(--dicoding-dark);"><?= htmlspecialchars($materi_data['judul_materi']); ?></h2>
    <p class="text-muted mb-4">Bagian dari Subtes: <?= htmlspecialchars($materi_data['nama_kursus']); ?></p>

    <!-- 1. Video Player (YouTube Embed) -->
    <?php if (!empty($materi_data['link_video'])): ?>
        <div class="video-responsive">
            <iframe src="<?= htmlspecialchars($materi_data['link_video']); ?>" 
                    title="<?= htmlspecialchars($materi_data['judul_materi']); ?>" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen></iframe>
        </div>
        <p class="small text-end text-muted">Pastikan Anda menonton video ini sampai selesai untuk pemahaman maksimal.</p>
    <?php else: ?>
        <div class="alert alert-warning">Video materi belum tersedia. Silakan fokus pada penjelasan di bawah ini.</div>
    <?php endif; ?>

    <!-- 2. Deskripsi Materi Panjang -->
    <div class="description-box">
        <h4 style="color: var(--dicoding-dark);">Penjelasan Mendalam:</h4>
        <div class="mt-3 text-break">
            <?= nl2br(htmlspecialchars($materi_data['deskripsi'])); ?>
        </div>
    </div>
    
    <hr class="my-5">

    <!-- 3. Tombol Aksi Kuis & Selesai -->
    <div class="d-flex justify-content-between align-items-center">
        
        <?php if ($is_materi_selesai): ?>
            <button class="btn btn-lg btn-success" disabled>✅ Materi Sudah Selesai</button>
        <?php else: ?>
            <a href="<?= $PUBLIC_PATH ?>update_progress.php?kursus_id=<?= $id_kursus; ?>&materi_id=<?= $id_materi; ?>" 
               class="btn btn-lg btn-selesai">
               Tandai Materi Selesai
            </a>
        <?php endif; ?>

        <!-- BARIS KRITIS: Menggunakan path absolut untuk kuis.php -->
        <a href="<?= $PUBLIC_PATH ?>kuis.php?id=<?= $id_kursus; ?>" class="btn btn-lg btn-primary">
            Lanjut ke Kuis Subtes &rarr;
        </a>
    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>