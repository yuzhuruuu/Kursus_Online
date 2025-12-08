<?php
// public/kursus.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/KursusController.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Cek autentikasi: Arahkan jika belum login
if(!isset($_SESSION['id_siswa'])) {
    header("Location: ../pages/about.php");
    exit;
}

global $conn;
$id_siswa = $_SESSION['id_siswa'];
// [FINAL PATH KOREKSI] Definisikan path assets langsung ke folder 'img'
$assets_img_path = '/project-SBD/assets/img/';

// Inisialisasi Controller
$kursus_controller = new KursusController($conn);

// Ambil semua data subtes (kursus)
$all_subtes_result = $kursus_controller->index();
$subtes_grouped = [
    'TPS' => [],
    'LITERASI' => []
];

// Kelompokkan hasil berdasarkan Kategori (TPS/LITERASI) dan hitung materi
while ($subtes = $all_subtes_result->fetch_assoc()) {
    $kategori = strtoupper($subtes['kategori']);
    
    // Ambil total materi untuk ditampilkan di kartu
    $stmt_materi = $conn->prepare("SELECT COUNT(*) FROM materi WHERE id_kursus = ?");
    $stmt_materi->bind_param("i", $subtes['id_kursus']);
    $stmt_materi->execute();
    $total_materi = $stmt_materi->get_result()->fetch_row()[0] ?? 0;
    $subtes['total_materi'] = $total_materi;
    
    // Masukkan data ke dalam grup
    if (array_key_exists($kategori, $subtes_grouped)) {
        $subtes_grouped[$kategori][] = $subtes;
    }
}

// [PERBAIKAN WARNING] Cek jika ada pesan status dari enrollment menggunakan isset()
$pesan_sukses = (isset($_GET['status']) && $_GET['status'] == 'enroll_success') ? 'Pendaftaran Subtes berhasil! Selamat belajar.' : '';
$pesan_gagal = (isset($_GET['status']) && $_GET['status'] == 'enroll_failed') ? 'Pendaftaran Subtes gagal. Silakan coba lagi.' : '';


include __DIR__ . '/../includes/header.php';
?>

<style>
    :root {
        --dicoding-dark: #0b1c31; 
        --dicoding-accent: #00bcd4; 
    }
    
    .subtes-card {
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%; 
        overflow: hidden; 
    }
    .subtes-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }
    .subtes-category-header {
        border-bottom: 3px solid var(--dicoding-accent);
        padding-bottom: 10px;
    }
    .subtes-tutor {
        color: #6c757d;
        font-weight: 500;
        font-size: 0.9em;
    }
    .card-img-top-custom {
        width: 100%;
        height: 150px; /* Tinggi tetap untuk konsistensi */
        object-fit: cover; 
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .btn-daftar {
        background-color: var(--dicoding-accent);
        border-color: var(--dicoding-accent);
        color: var(--dicoding-dark);
        font-weight: 700;
    }
</style>

<h3 class="mb-4" style="color: var(--dicoding-dark);">Katalog Subtes UTBK</h3>
<p class="lead text-muted">Pilih subtes yang sesuai dengan tujuan masuk PTN Anda.</p>

<?php if ($pesan_sukses): ?>
    <div class="alert alert-success"><?= htmlspecialchars($pesan_sukses); ?></div>
<?php endif; ?>
<?php if ($pesan_gagal): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($pesan_gagal); ?></div>
<?php endif; ?>

<?php foreach ($subtes_grouped as $kategori => $subtes_list): ?>

    <!-- Header Kategori Subtes (TPS atau LITERASI) -->
    <div class="mt-5 mb-4 subtes-category-header">
        <h4 class="fw-bold" style="color: var(--dicoding-dark);"><?= htmlspecialchars($kategori); ?></h4>
    </div>

    <?php if (empty($subtes_list)): ?>
        <div class="alert alert-warning">Belum ada Subtes yang tersedia di kategori <?= htmlspecialchars($kategori); ?>.</div>
    <?php else: ?>
        <div class="row g-4 mb-5">
            <?php foreach ($subtes_list as $subtes): 
                // 1. Membersihkan nama subtes (menghilangkan tanda kurung)
                $clean_name_raw = trim(preg_replace('/\s*\([^)]*\)\s*/', '', $subtes['nama_kursus']));
                
                // 2. [LOGIC FINAL] Konversi ke lowercase dan ganti karakter khusus dengan underscore
                $image_name_cleaned = strtolower($clean_name_raw);
                $image_name_cleaned = str_replace(' & ', '_dan_', $image_name_cleaned); 
                $image_name_cleaned = str_replace([' ', '-'], ['_', '_'], $image_name_cleaned); 
                $image_name_cleaned = preg_replace('/[^a-z0-9_]/', '', $image_name_cleaned);
                $image_name_cleaned = trim($image_name_cleaned, '_');

                // [PERBAIKAN KHUSUS] Jika nama subtes adalah "pengetahuan_dan_pemahaman_umum", gunakan pengecualian
                if ($image_name_cleaned === 'pengetahuan_dan_pemahaman_umum') {
                    // Jika Anda menggunakan nama file yang lebih pendek, gunakan ini:
                    $image_name_cleaned = 'pengetahuan_umum';
                }
                
                // KOREKSI FILE EXTENSION: ASUMSI .jpeg
                $image_file = $image_name_cleaned . '.jpeg'; 
                
                // Tentukan path gambar
                $image_path = $assets_img_path . $image_file;
                
                // Cek status pendaftaran siswa menggunakan Controller
                $is_terdaftar = $kursus_controller->cekSudahAmbil($id_siswa, $subtes['id_kursus']);
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card subtes-card p-0 shadow-sm">
                        <!-- MENAMPILKAN GAMBAR -->
                        <img src="<?= htmlspecialchars($image_path); ?>" 
                             class="card-img-top-custom" 
                             alt="<?= htmlspecialchars($subtes['nama_kursus']); ?>"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x150/0b1c31/00bcd4?text=Gambar+Tidak+Ditemukan';">
                        
                        <div class="p-4 d-flex flex-column h-100">
                            <span class="badge bg-secondary mb-2" style="width: fit-content;"><?= htmlspecialchars($subtes['total_materi']); ?> Materi</span>
                            <h5 class="fw-bold" style="color: var(--dicoding-dark);"><?= htmlspecialchars($subtes['nama_kursus']); ?></h5>
                            <p class="subtes-tutor mb-3">Oleh: <?= htmlspecialchars($subtes['nama_tutor']); ?></p>
                            
                            <p class="text-muted small mb-3">
                                <?= substr(htmlspecialchars($subtes['deskripsi']), 0, 100) . (strlen($subtes['deskripsi']) > 100 ? '...' : ''); ?>
                            </p>
                            
                            <div class="mt-auto pt-2">
                                <?php if ($is_terdaftar): ?>
                                    <!-- Jika sudah terdaftar, tampilkan tombol Lihat Progres -->
                                    <a href="kursus_detail.php?id=<?= $subtes['id_kursus']; ?>" class="btn btn-sm btn-outline-primary w-100">
                                        Lanjut Belajar &rarr;
                                    </a>
                                <?php else: ?>
                                    <!-- Jika belum terdaftar, tampilkan tombol Daftar -->
                                    <a href="enroll_kursus.php?id=<?= $subtes['id_kursus']; ?>" class="btn btn-sm btn-daftar w-100">
                                        Daftar Sekarang
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>