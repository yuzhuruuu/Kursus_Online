<?php
// public/index.php (dashboard)
require_once __DIR__ . '/../config/database.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect ke login jika belum ada sesi siswa
if(!isset($_SESSION['id_siswa'])) {
    header("Location: ../pages/about.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

// --- QUERY DATA UNTUK DASHBOARD ---

// 1. Ambil jumlah kursus yang diikuti
$stmt_total = $conn->prepare("SELECT COUNT(*) AS total FROM siswaKursus WHERE id_siswa = ?");
$stmt_total->bind_param("i", $id_siswa);
$stmt_total->execute();
$total_kursus = $stmt_total->get_result()->fetch_assoc()['total'];

// 2. Ambil Progres Kursus Aktif (Untuk Monitoring Real-time)
// Menggunakan JOIN ke tabel kursus untuk mendapatkan nama kursus
$stmt_progress = $conn->prepare("
    SELECT 
        k.nama_kursus, 
        p.presentase_progress, 
        p.status_progress
    FROM progress_belajar p
    JOIN kursus k ON p.id_kursus = k.id_kursus
    WHERE p.id_siswa = ? 
    ORDER BY p.presentase_progress DESC
");
$stmt_progress->bind_param("i", $id_siswa);
$stmt_progress->execute();
$active_progress = $stmt_progress->get_result();

// 3. Ambil ringkasan penilaian terakhir
$stmt_recent = $conn->prepare("
    SELECT 
        k.nama_kursus, 
        p.nilai, 
        p.tgl_penilaian 
    FROM penilaian p 
    JOIN kursus k ON p.id_kursus=k.id_kursus 
    WHERE p.id_siswa=? 
    ORDER BY p.tgl_penilaian DESC 
    LIMIT 5
");
$stmt_recent->bind_param("i", $id_siswa);
$stmt_recent->execute();
$recent_penilaian = $stmt_recent->get_result();

// --- TAMPILAN DASHBOARD ---
include __DIR__ . '/../includes/header.php';
?>

<h3 class="mb-4">Halo, Selamat Datang <?= htmlspecialchars($_SESSION['nama_siswa']); ?> 👋</h3>

<div class="row g-4">
    <!-- Kolom 1: Ringkasan & Total Kursus -->
    <div class="col-lg-4 col-md-12">
        <div class="card p-4 shadow-sm bg-primary text-white">
            <h5 class="card-title">Total Kursus Diikuti</h5>
            <h1 class="display-4 fw-bold mb-3"><?= $total_kursus ?></h1>
            <a class="btn btn-sm btn-light mt-2" href="kursus.php">Telusuri Semua Kursus</a>
        </div>

        <!-- Notifikasi/Reminder (Fitur Unik) -->
        <div class="card p-3 mt-4 shadow-sm border-warning">
            <h5 class="text-warning">🔔 Learning Reminder</h5>
            <!-- Logika sederhana: tampilkan pesan jika progres kosong -->
            <?php if($total_kursus == 0): ?>
                <p>Ayo mulai kursus pertamamu sekarang! Kami siap membantumu mencapai tujuan.</p>
            <?php else: ?>
                <p>Cek kembali kursus yang stagnan, jangan biarkan belajarmu tertunda!</p>
                <!-- Di sini, logika yang lebih kompleks bisa memeriksa tabel progress_belajar
                     untuk status_progress='Stagnan' atau tgl_terakhir_update > 7 hari. -->
            <?php endif; ?>
        </div>
    </div>

    <!-- Kolom 2: Progres Aktif (Real-time Monitoring) -->
    <div class="col-lg-8 col-md-12">
        <div class="card p-4 shadow-sm">
            <h4 class="card-title mb-3">Kursus Aktif dan Progres Belajar</h4>
            <?php if($active_progress->num_rows === 0): ?>
                <div class="alert alert-info">Anda belum mengambil kursus apapun.</div>
            <?php else: ?>
                <?php while($p = $active_progress->fetch_assoc()): ?>
                    <div class="mb-3">
                        <small class="fw-bold"><?= htmlspecialchars($p['nama_kursus']); ?> 
                            (<?= htmlspecialchars($p['status_progress']); ?>)
                        </small>
                        <div class="progress mt-1" style="height: 20px;">
                            <div class="progress-bar 
                                <?= $p['presentase_progress'] == 100 ? 'bg-success' : 'bg-info'; ?>" 
                                role="progressbar" 
                                style="width: <?= $p['presentase_progress']; ?>%" 
                                aria-valuenow="<?= $p['presentase_progress']; ?>" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                <?= $p['presentase_progress']; ?>% Selesai
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Kolom 3: Penilaian Terbaru -->
    <div class="col-12">
        <div class="card p-4 shadow-sm">
            <h4 class="card-title mb-3">5 Penilaian Kuis Terbaru</h4>
            <?php if($recent_penilaian->num_rows === 0): ?>
                <p>Anda belum menyelesaikan kuis apapun.</p>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php while($r = $recent_penilaian->fetch_assoc()): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-secondary me-2"><?= date('d M Y', strtotime($r['tgl_penilaian'])); ?></span>
                                <strong><?= htmlspecialchars($r['nama_kursus']); ?></strong>
                            </div>
                            <span class="badge bg-primary rounded-pill p-2 fs-6">Nilai: <?= htmlspecialchars($r['nilai']); ?></span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php include __DIR__ . '/../includes/footer.php'; ?>