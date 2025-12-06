<?php
// public/kursus.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Kursus.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

// Inisialisasi
global $conn;
// Asumsi class Kursus tersedia dan memiliki method getAll()
$kursus_model = new Kursus($conn); 
$daftar_kursus = $kursus_model->getAll(); 


include __DIR__ . '/../includes/header.php';
?>

<style>
/* CSS Tambahan untuk Gaya Kartu Kursus */
.course-card {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.course-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

.course-icon {
    height: 100px;
    background-color: var(--dicoding-soft, #f8f9fa); /* Warna latar lembut */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--dicoding-accent, #00bcd4);
    border-bottom: 1px solid #f0f0f0;
}

.course-title {
    color: var(--dicoding-dark, #0b1c31);
    font-weight: 700;
    font-size: 1.2rem;
    min-height: 40px; /* Memastikan tinggi judul seragam */
}

.course-info {
    font-size: 0.85rem;
    color: #6c757d;
}

.btn-detail-custom {
    background-color: var(--dicoding-accent, #00bcd4);
    border-color: var(--dicoding-accent, #00bcd4);
    color: white;
    font-weight: 600;
    margin-top: auto; /* Memastikan tombol selalu di bawah */
    border-radius: 0 0 10px 10px;
}
.btn-detail-custom:hover {
    background-color: #00a0b0;
    border-color: #00a0b0;
    color: white;
}
</style>

<h2 class="mb-4" style="color: var(--dicoding-dark);">Katalog Kelas Digital</h2>
<p class="lead text-muted">Telusuri dan pilih kursus yang sesuai dengan minat dan tingkat keahlian Anda.</p>
<hr>

<div class="row g-4">
    <?php if($daftar_kursus->num_rows > 0): ?>
        <?php while($kursus = $daftar_kursus->fetch_assoc()): 
            // Tentukan ikon berdasarkan kategori (Mockup)
            $icon = '💻';
            if ($kursus['kategori'] == 'Matematika') $icon = '📐';
            if ($kursus['kategori'] == 'Desain') $icon = '🎨';
            if ($kursus['kategori'] == 'Bisnis') $icon = '📊';
            if ($kursus['kategori'] == 'Pemrograman') $icon = '⚛️';
        ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card course-card">
                    <div class="course-icon">
                        <?= $icon; ?>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="course-title"><?= htmlspecialchars($kursus['nama_kursus']); ?></h5>
                        
                        <div class="course-info mb-3">
                            <span class="badge bg-secondary me-2"><?= htmlspecialchars($kursus['kategori']); ?></span>
                            <span class="badge 
                                <?= $kursus['tingkat'] == 'Mahir' ? 'bg-danger' : ($kursus['tingkat'] == 'Menengah' ? 'bg-warning text-dark' : 'bg-success'); ?>">
                                <?= htmlspecialchars($kursus['tingkat']); ?>
                            </span>
                        </div>
                        
                        <p class="card-text small text-muted mb-4 flex-grow-1">
                            <?= htmlspecialchars(substr($kursus['deskripsi'], 0, 80)); ?>...
                        </p>
                        
                        <!-- Tombol Detail yang Baru -->
                        <a href="kursus_detail.php?id=<?= $kursus['id_kursus']; ?>" class="btn btn-detail-custom mt-auto">
                            Lihat Detail Kelas
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning">Tidak ada kursus yang tersedia saat ini.</div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>