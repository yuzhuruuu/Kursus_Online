<?php
// public/materi.php
// Asumsi: File ini menyediakan koneksi database ($conn) atau konstanta koneksi.
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Materi.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

// --- PERBAIKAN KONEKSI ---
// Fatal error terjadi di sini karena Class "Database" tidak ditemukan.
// Kami akan mengubahnya menjadi koneksi langsung.
// ASUMSI: config/database.php telah mendefinisikan variabel/konstanta koneksi (e.g., $conn atau DB_HOST, DB_USER, dll.).

// Anda harus mengganti baris ini dengan cara koneksi Anda yang benar:
// Contoh jika database.php hanya memberikan variabel koneksi ($conn)
global $conn; // Deklarasikan $conn sebagai global jika didefinisikan di config/database.php

// Jika Anda menggunakan objek $db untuk koneksi, Anda harus pastikan class Database 
// di-load atau didefinisikan, jika tidak, cara termudah adalah:
// $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); // Jika menggunakan konstanta

// Untuk saat ini, kita akan asumsikan $conn tersedia setelah require config/database.php
// Jika $conn belum tersedia, Anda harus membuatnya di sini.
if (!isset($conn)) {
    // Ini adalah fallback/contoh jika koneksi belum dibuat:
    die("Error: Variabel koneksi \$conn belum didefinisikan di config/database.php.");
}

$materi_model = new Materi($conn);

$id_kursus = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$materi_list = $materi_model->getByKursus($id_kursus);

// Asumsi: Ambil nama kursus untuk judul halaman
$stmt_kursus = $conn->prepare("SELECT nama_kursus FROM kursus WHERE id_kursus = ?");
$stmt_kursus->bind_param("i", $id_kursus);
$stmt_kursus->execute();
$nama_kursus = $stmt_kursus->get_result()->fetch_assoc()['nama_kursus'] ?? 'Materi Kursus';


include __DIR__ . '/../includes/header.php';
?>

<style>
/* CSS Tambahan untuk Gaya List Materi Mirip Dicoding */
.materi-card {
    border-left: 5px solid var(--dicoding-accent, #00bcd4); /* Garis kiri toska/cyan */
    border-radius: 8px;
    transition: all 0.3s ease;
}
.materi-card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}
.materi-header {
    background-color: var(--dicoding-soft, #f8f9fa);
    padding: 10px 15px;
    border-bottom: 1px solid #dee2e6;
}
.materi-title {
    color: var(--dicoding-dark, #0b1c31);
    font-weight: 600;
}
.materi-index {
    background-color: var(--dicoding-accent, #00bcd4);
    color: white;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}
</style>

<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <h2 class="mb-4 text-primary">Materi Kursus: <?= htmlspecialchars($nama_kursus); ?></h2>

        <?php 
        if ($materi_list->num_rows === 0): ?>
            <div class="alert alert-warning">
                Belum ada materi yang ditambahkan untuk kursus ini.
            </div>
        <?php 
        else: 
            $counter = 1;
            while($m = $materi_list->fetch_assoc()):
                $status_icon = '▶️'; // Ikon default: Belum selesai
                // Anda bisa menambahkan logika di sini untuk menentukan apakah materi sudah selesai (misal: jika ada entri di tabel 'penilaian')
                // if (isMateriSelesai($m['id_materi'], $_SESSION['id_siswa'])) { $status_icon = '✅'; } 
        ?>
            <!-- Kartu Materi yang Diperbarui -->
            <div class="card mb-3 materi-card">
                <div class="card-body d-flex align-items-center">
                    <!-- Indeks Langkah (Meniru Alur) -->
                    <div class="materi-index me-3"><?= $counter++; ?></div>

                    <div class="flex-grow-1">
                        <h5 class="materi-title mb-1">
                            <?= $status_icon; ?> <?= htmlspecialchars($m['judul_materi']); ?>
                        </h5>
                        <p class="text-muted small mb-0"><?= htmlspecialchars(substr($m['deskripsi'], 0, 100)); ?>...</p>
                    </div>

                    <a href="materi_detail.php?id=<?= $m['id_materi']; ?>" class="btn btn-sm btn-outline-primary ms-3">
                        Mulai Belajar
                    </a>
                </div>
            </div>

        <?php 
            endwhile; 
        endif; 
        ?>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>