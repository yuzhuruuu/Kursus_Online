<?php
// public/progress.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProgressController.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

global $conn;
$id_siswa = $_SESSION['id_siswa'];

// Inisialisasi Controller
$progress_controller = new ProgressController($conn);

// [KOREKSI ERROR] Panggil fungsi getProgress yang baru ditambahkan
$progress_data = $progress_controller->getProgress($id_siswa);

include __DIR__ . '/../includes/header.php';
?>

<style>
    :root {
        --dicoding-dark: #0b1c31; 
        --dicoding-accent: #00bcd4; 
    }
    .progress-header {
        border-bottom: 3px solid var(--dicoding-accent);
        padding-bottom: 10px;
    }
    .progress-card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        height: 100%;
        transition: transform 0.3s;
    }
    .progress-card:hover {
        transform: translateY(-3px);
    }
    .progress-bar-custom {
        background-color: var(--dicoding-accent);
    }
    .status-badge-selesai {
        background-color: #28a745;
    }
    .status-badge-berjalan {
        background-color: var(--dicoding-accent);
    }
    .status-badge-belum {
        background-color: #6c757d;
    }
</style>

<div class="row progress-header mb-4">
    <div class="col-12">
        <h3 class="fw-bold" style="color: var(--dicoding-dark);">Progres Belajar UTBK Saya</h3>
        <p class="lead text-muted">Pantau perkembangan Anda di setiap subtes dan lihat nilai tertinggi Anda.</p>
    </div>
</div>

<div class="row g-4">
    <?php if ($progress_data->num_rows === 0): ?>
        <div class="col-12">
            <div class="alert alert-info text-center p-4">
                Anda belum mengambil Subtes UTBK apapun. Silakan <a href="kursus.php" class="fw-bold">Daftar Kursus</a> terlebih dahulu.
            </div>
        </div>
    <?php else: ?>
        <?php while ($p = $progress_data->fetch_assoc()): 
            $status_class = '';
            $status_label = ucfirst(str_replace('_', ' ', $p['status_progres']));
            
            if ($p['status_progres'] === 'selesai') {
                $status_class = 'status-badge-selesai';
            } elseif ($p['status_progres'] === 'sedang_berjalan') {
                $status_class = 'status-badge-berjalan';
            } else {
                $status_class = 'status-badge-belum';
            }
        ?>
            <div class="col-lg-6 col-xl-4">
                <div class="card p-4 progress-card">
                    <span class="badge <?= $status_class; ?> mb-3" style="width: fit-content;"><?= htmlspecialchars($status_label); ?></span>
                    
                    <h5 class="fw-bold" style="color: var(--dicoding-dark);"><?= htmlspecialchars($p['nama_kursus']); ?></h5>
                    <p class="small text-muted mb-3">Kategori: <?= htmlspecialchars($p['kategori']); ?></p>

                    <!-- Progress Bar -->
                    <div class="progress" style="height: 15px;">
                        <div class="progress-bar progress-bar-custom" 
                             role="progressbar" 
                             style="width: <?= $p['persentase_progres']; ?>%;" 
                             aria-valuenow="<?= $p['persentase_progres']; ?>" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                             <?= $p['persentase_progres']; ?>%
                        </div>
                    </div>
                    
                    <small class="text-muted mt-2 mb-3">
                        <?= $p['materi_selesai']; ?> dari <?= $p['total_materi']; ?> Materi Selesai
                    </small>

                    <!-- Nilai Tertinggi dan Aksi -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <div class="text-start">
                            <small class="text-muted d-block">Nilai Tertinggi:</small>
                            <span class="fw-bold fs-5 text-danger">
                                <?= $p['nilai_tertinggi'] !== null ? htmlspecialchars($p['nilai_tertinggi']) : 'N/A'; ?>
                            </span>
                        </div>
                        <a href="kursus_detail.php?id=<?= $p['id_kursus']; ?>" class="btn btn-sm btn-outline-primary">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>