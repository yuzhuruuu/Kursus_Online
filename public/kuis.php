<?php
// public/kuis.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/KuisController.php';
require_once __DIR__ . '/../models/Kursus.php'; 
require_once __DIR__ . '/../models/Penilaian.php'; // Diperlukan untuk proses submit

if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Cek Autentikasi dan Parameter
if (!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}
// Ambil ID Subtes (kursus) dari parameter 'id'
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: kursus.php");
    exit;
}

global $conn;
$id_siswa = $_SESSION['id_siswa'];
$id_kursus = (int)$_GET['id']; // Menggunakan ID Kursus

$kuis_controller = new KuisController($conn);
$kursus_model = new Kursus($conn);

// Ambil detail kursus (nama subtes)
$kursus_data = $kursus_model->getById($id_kursus);

if (!$kursus_data) {
    header("Location: kursus.php?error=not_found");
    exit;
}

// 2. Ambil Soal Kuis (10 Soal per Subtes)
$soal_kuis = $kuis_controller->getSoalTryout($id_kursus);

// 3. LOGIKA SUBMIT JAWABAN (POST Request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_kuis'])) {
    
    $jawaban_siswa = [];
    foreach ($_POST as $key => $value) {
        // Asumsi input radio button bernama 'jawaban_[id_kuis]'
        if (strpos($key, 'jawaban_') === 0) {
            $id_kuis = str_replace('jawaban_', '', $key);
            $jawaban_siswa[$id_kuis] = $value;
        }
    }
    
    // Panggil Controller untuk memproses dan menyimpan hasil
    // Fungsi submitTryout akan mengembalikan nilai akhir (0-100)
    $nilai_akhir = $kuis_controller->submitTryout($id_siswa, $id_kursus, $jawaban_siswa);
    
    // Redirect ke halaman hasil kuis
    header("Location: hasil_kuis.php?nilai=" . $nilai_akhir . "&kursus_id=" . $id_kursus);
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

<style>
    /* Styling agar konsisten dengan dashboard/detail materi */
    :root {
        --dicoding-dark: #0b1c31;
        --dicoding-accent: #00bcd4;
    }
    .kuis-card {
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        padding: 30px;
        border-left: 5px solid var(--dicoding-accent);
    }
    .kuis-question-number {
        font-weight: 700;
        color: var(--dicoding-accent);
        font-size: 1.2rem;
        margin-bottom: 5px;
    }
    .kuis-pertanyaan {
        font-weight: 600;
        color: var(--dicoding-dark);
        margin-bottom: 20px;
    }
    .form-check-label {
        margin-left: 10px;
        font-weight: 500;
    }
    .btn-submit-kuis {
        background-color: #dc3545; /* Warna mencolok untuk aksi final */
        border-color: #dc3545;
        font-weight: 700;
        padding: 10px 30px;
    }
    .btn-submit-kuis:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <h2 class="fw-bold mb-3" style="color: var(--dicoding-dark);">
            Kuis Subtes: <?= htmlspecialchars($kursus_data['nama_kursus']); ?>
        </h2>
        <p class="lead text-muted">Jawab semua 10 soal ini. Pastikan Anda sudah mempelajari modulnya!</p>
        
        <form method="POST">
            <?php $soal_count = 0; ?>
            <?php if ($soal_kuis->num_rows === 0): ?>
                <div class='alert alert-warning'>Belum ada soal kuis (10 soal) yang tersedia untuk subtes ini.</div>
            <?php else: ?>
                <?php while ($soal = $soal_kuis->fetch_assoc()): 
                    $soal_count++;
                    $kuis_id = $soal['id_kuis'];
                    $nama_input = 'jawaban_' . $kuis_id;
                ?>
                    <div class="card kuis-card">
                        <p class="kuis-question-number">Soal <?= $soal_count; ?> / <?= $soal_kuis->num_rows; ?></p>
                        <p class="kuis-pertanyaan"><?= htmlspecialchars($soal['pertanyaan']); ?></p>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="<?= $nama_input; ?>" id="<?= $nama_input; ?>_a" value="A" required>
                            <label class="form-check-label" for="<?= $nama_input; ?>_a"><span class="fw-bold">A.</span> <?= htmlspecialchars($soal['opsi_a']); ?></label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="<?= $nama_input; ?>" id="<?= $nama_input; ?>_b" value="B" required>
                            <label class="form-check-label" for="<?= $nama_input; ?>_b"><span class="fw-bold">B.</span> <?= htmlspecialchars($soal['opsi_b']); ?></label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="<?= $nama_input; ?>" id="<?= $nama_input; ?>_c" value="C" required>
                            <label class="form-check-label" for="<?= $nama_input; ?>_c"><span class="fw-bold">C.</span> <?= htmlspecialchars($soal['opsi_c']); ?></label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="<?= $nama_input; ?>" id="<?= $nama_input; ?>_d" value="D" required>
                            <label class="form-check-label" for="<?= $nama_input; ?>_d"><span class="fw-bold">D.</span> <?= htmlspecialchars($soal['opsi_d']); ?></label>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            
            <div class="text-center mt-5 mb-5">
                <input type="hidden" name="submit_kuis" value="1">
                <button type="submit" class="btn btn-submit-kuis btn-lg px-5">
                    Kumpulkan Jawaban & Selesai (<?= $soal_count; ?> Soal)
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>