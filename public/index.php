<?php
// public/index.php (dashboard)
require_once __DIR__ . '/../config/database.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect ke about.php jika belum ada sesi siswa (Sesuai Logika Anda)
if(!isset($_SESSION['id_siswa'])) {
    header("Location: ../pages/about.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

// --- QUERY DATA UNTUK DASHBOARD ---

// 1. Ambil jumlah subtes/kursus yang diikuti
$stmt_total = $conn->prepare("SELECT COUNT(*) AS total FROM siswaKursus WHERE id_siswa = ?");
$stmt_total->bind_param("i", $id_siswa);
$stmt_total->execute();
$total_kursus = $stmt_total->get_result()->fetch_assoc()['total'];

// 2. Ambil Progres Kursus Aktif (Untuk Monitoring Real-time)
// Menggunakan JOIN ke tabel kursus untuk mendapatkan nama kursus
$stmt_progress = $conn->prepare("
    SELECT 
        k.nama_kursus, 
        p.persentase_progres, 
        p.status_progres,
        k.id_kursus
    FROM progres_belajar p
    JOIN kursus k ON p.id_kursus = k.id_kursus
    WHERE p.id_siswa = ? 
    ORDER BY p.persentase_progres DESC
    LIMIT 4 -- Batasi agar dashboard tidak terlalu panjang
");
$stmt_progress->bind_param("i", $id_siswa);
$stmt_progress->execute();
$active_progress = $stmt_progress->get_result();

// 3. Ambil ringkasan penilaian terbaru
$stmt_recent = $conn->prepare("
    SELECT 
        k.nama_kursus, 
        p.nilai, 
        p.tgl_penilaian 
    FROM penilaian p 
    JOIN kursus k ON p.id_kursus=k.id_kursus 
    WHERE p.id_siswa=? 
    ORDER BY p.tgl_penilaian DESC 
    LIMIT 3 -- Batasi hanya 3 data terbaru
");
$stmt_recent->bind_param("i", $id_siswa);
$stmt_recent->execute();
$recent_penilaian = $stmt_recent->get_result();

// --- TAMPILAN DASHBOARD ---
include __DIR__ . '/../includes/header.php';
?>

<!-- ============================================================== -->
<!-- HILANGKAN BLOK <style> YANG BERPOTENSI MENIMPA FOOTER -->
<!-- Gunakan nilai heksa atau variabel CSS yang DITETAPKAN di header.php -->
<!-- ============================================================== -->

<h3 class="mb-4" style="color: var(--dicoding-dark);">Hallo, <?= htmlspecialchars($_SESSION['nama_siswa']); ?> 👋</h3>

<div class="row g-4">
    <!-- Kolom Kiri: Statistik & Reminder -->
    <div class="col-lg-4 col-md-12">
        
        <!-- 1. Total Kursus Diikuti (Statistik Utama) -->
        <div class="card p-4 shadow-sm mb-4" 
             style="background-color: var(--dicoding-dark, #0b1c31); color: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
            <small class="text-info text-uppercase fw-bold">Subtes Diikuti</small>
            <h1 class="display-3 fw-bolder my-2"><?= $total_kursus ?></h1>
            <p class="text-light mb-3">Total Subtes yang sudah Anda daftarkan.</p>
            <a class="btn btn-sm btn-info fw-bold w-100" href="kursus.php" 
               style="background-color: var(--dicoding-accent, #00bcd4); border-color: var(--dicoding-accent, #00bcd4); color: var(--dicoding-dark);">
                Telusuri Subtes UTBK
            </a>
        </div>

        <!-- 2. Notifikasi/Reminder (Fitur Unik) -->
        <div class="card p-3 shadow-sm" 
             style="background-color: var(--dicoding-soft, #f8f9fa); border: 1px solid var(--dicoding-accent, #00bcd4); border-radius: 10px;">
            <h5 style="color: var(--dicoding-dark);">🔔 Learning Reminder</h5>
            <small class="text-muted">Jadwal atau subtes yang perlu diperhatikan.</small>
            
            <div class="mt-3">
                <?php if($total_kursus == 0): ?>
                    <p class="mb-0">Ayo mulai Subtes pertamamu sekarang! Pilih Saintek atau Soshum.</p>
                    <a href="kursus.php" class="text-primary fw-bold">Lihat Semua Subtes &rarr;</a>
                <?php else: ?>
                    <p class="mb-0">Anda memiliki subtes yang stagnan. Jangan biarkan belajarmu tertunda!</p>
                    <a href="progress.php" class="text-danger fw-bold">Cek Progres Sekarang &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Progres Aktif dan Penilaian Terbaru -->
    <div class="col-lg-8 col-md-12">
        
        <!-- 3. Progres Aktif (Real-time Monitoring) -->
        <div class="card p-4 shadow-sm mb-4" 
             style="border-left: 4px solid var(--dicoding-accent, #00bcd4); border-radius: 10px;">
            <h4 class="card-title mb-4" style="color: var(--dicoding-dark);">Progres Subtes Aktif (Teratas)</h4>
            <?php if($active_progress->num_rows === 0): ?>
                <div class="alert alert-info border-0">Anda belum mengambil Kuis apapun.</div>
            <?php else: ?>
                <?php while($p = $active_progress->fetch_assoc()): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="fw-bold text-truncate" style="color: var(--dicoding-dark);">
                                <?= htmlspecialchars($p['nama_kursus']); ?>
                            </small>
                            <small class="text-muted text-end">
                                Status: <span class="badge 
                                    <?= $p['status_progres'] == 'selesai' ? 'bg-success' : 
                                      ($p['status_progres'] == 'sedang_berjalan' ? 'bg-primary' : 'bg-secondary'); ?>">
                                    <?= ucfirst(str_replace('_', ' ', htmlspecialchars($p['status_progres']))); ?>
                                </span>
                            </small>
                        </div>
                        <div class="progress mt-1" style="height: 15px; background-color: #f0f0f0;">
                            <div class="progress-bar" 
                                 style="width: <?= $p['persentase_progres']; ?>%; background-color: var(--dicoding-accent, #00bcd4); transition: width 0.6s ease;"
                                 role="progressbar" 
                                 aria-valuenow="<?= $p['persentase_progres']; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                 <small class="fw-bold"><?= $p['persentase_progres']; ?>%</small>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        
        <!-- 4. Penilaian Terbaru -->
        <div class="card p-4 shadow-sm" style="border-radius: 10px;">
            <h4 class="card-title mb-3" style="color: var(--dicoding-dark);">Nilai Kuis Terbaru</h4>
            <?php if($recent_penilaian->num_rows === 0): ?>
                <div class="alert alert-warning border-0">Anda belum menyelesaikan kuis apapun.</div>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php while($r = $recent_penilaian->fetch_assoc()): ?>
                        <?php 
                            // Tentukan warna badge nilai
                            $nilai_badge_class = 'bg-danger';
                            if ($r['nilai'] >= 80) {
                                $nilai_badge_class = 'bg-success';
                            } elseif ($r['nilai'] >= 60) {
                                $nilai_badge_class = 'bg-warning text-dark';
                            } else {
                                $nilai_badge_class = 'bg-danger';
                            }
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            style="border-left: 4px solid transparent; transition: border-left 0.3s ease;">
                            <div>
                                <span class="badge bg-secondary me-3" style="font-weight: normal;"><?= date('d M Y', strtotime($r['tgl_penilaian'])); ?></span>
                                <strong style="color: var(--dicoding-dark);"><?= htmlspecialchars($r['nama_kursus']); ?></strong>
                            </div>
                            <span class="badge <?= $nilai_badge_class; ?> rounded-pill p-2 fs-6">
                                <?= htmlspecialchars($r['nilai']); ?>
                            </span>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div class="text-end mt-3">
                    <a href="progress.php" class="text-primary small fw-bold">Lihat Semua Nilai &rarr;</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php include __DIR__ . '/../includes/footer.php'; ?>