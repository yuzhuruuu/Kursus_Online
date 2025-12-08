<?php
// public/profil.php
require_once __DIR__ . '/../config/database.php';
// require_once __DIR__ . '/../models/Siswa.php'; 
// require_once __DIR__ . '/../models/Progress.php'; 

if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

global $conn;
$id_siswa = $_SESSION['id_siswa'];

// --- QUERY 1: Ambil Data Profil Siswa ---
// Mengambil semua data yang dibutuhkan termasuk foto_profil dan tgl_daftar
$stmt_siswa = $conn->prepare("
    SELECT nama_siswa, email, no_hp, alamat, pekerjaan, foto_profil, tgl_daftar
    FROM siswa 
    WHERE id_siswa = ?
");
$stmt_siswa->bind_param("i", $id_siswa);
$stmt_siswa->execute();
$data_siswa = $stmt_siswa->get_result()->fetch_assoc();


// --- QUERY 2: Ambil Kursus yang Sudah Lulus/Selesai ---
$stmt_lulus = $conn->prepare("
    SELECT 
        k.nama_kursus, 
        p.persentase_progres, 
        k.kategori,
        k.tingkat
    FROM progres_belajar p
    JOIN kursus k ON p.id_kursus = k.id_kursus
    WHERE p.id_siswa = ? AND p.status_progres = 'selesai' -- Pastikan ENUM case-sensitive
    ORDER BY k.id_kursus DESC
");
$stmt_lulus->bind_param("i", $id_siswa);
$stmt_lulus->execute();
$kursus_lulus = $stmt_lulus->get_result();

// --- LOGIKA UPDATE PROFIL ---
$pesan_sukses = '';
$pesan_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_profil'])) {
    $nama = $_POST['nama_siswa'] ?? '';
    $hp = $_POST['no_hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $pekerjaan = $_POST['pekerjaan'] ?? '';
    
    // Validasi Sederhana
    if (empty($nama) || empty($hp) || empty($alamat) || empty($pekerjaan)) {
        $pesan_error = "Semua field harus diisi.";
    } else {
        $stmt_update = $conn->prepare("
            UPDATE siswa 
            SET nama_siswa = ?, no_hp = ?, alamat = ?, pekerjaan = ?
            WHERE id_siswa = ?
        ");
        $stmt_update->bind_param("ssssi", $nama, $hp, $alamat, $pekerjaan, $id_siswa);
        
        if($stmt_update->execute()){
            $pesan_sukses = 'Profil berhasil diperbarui!';
            $_SESSION['nama_siswa'] = $nama; 
            // Refresh data dari database setelah update
            $stmt_refresh = $conn->prepare("
                SELECT nama_siswa, email, no_hp, alamat, pekerjaan, foto_profil, tgl_daftar 
                FROM siswa 
                WHERE id_siswa = ?
            ");
            $stmt_refresh->bind_param("i", $id_siswa);
            $stmt_refresh->execute();
            $data_siswa = $stmt_refresh->get_result()->fetch_assoc();
        } else {
            $pesan_error = 'Gagal memperbarui profil. Silakan coba lagi.';
        }
    }
}


include __DIR__ . '/../includes/header.php';
?>

<style>
/* CSS Tambahan untuk Gaya Profil dan Pencapaian */
.profile-header-card {
    background-color: var(--dicoding-dark, #0b1c31); /* Background gelap meniru Dicoding */
    color: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
.profile-img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--dicoding-accent, #00bcd4); /* Border toska */
}
.achievement-card {
    border-left: 5px solid var(--dicoding-accent, #00bcd4); 
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}
.lulus-tag {
    background-color: #1f8b88; /* Warna Hijau tua untuk LULUS */
    color: white;
    font-weight: 700;
}
.lulus-title {
    color: var(--dicoding-dark, #0b1c31);
    font-weight: 600;
}
</style>

<h3 class="mb-4" style="color: var(--dicoding-dark);">Profil dan Pencapaian Saya</h3>

<?php if ($pesan_error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($pesan_error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if ($pesan_sukses): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($pesan_sukses); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Bagian Header Profil (Meniru Gaya Dicoding) -->
<div class="profile-header-card">
    <div class="d-flex align-items-center">
        <!-- Tampilan Foto Profil -->
        <?php 
            $default_placeholder = 'https://placehold.co/100x100/3b4d63/FFFFFF?text=SISWA';
            $foto_url = htmlspecialchars($data_siswa['foto_profil'] ?? $default_placeholder);
            if (empty($data_siswa['foto_profil']) || !filter_var($data_siswa['foto_profil'], FILTER_VALIDATE_URL)) {
                 $foto_url = $default_placeholder;
            }
        ?>
        <img src="<?= $foto_url; ?>" alt="Foto Profil" class="profile-img me-4">
        
        <div>
            <h2 class="mb-1 text-white"><?= htmlspecialchars($data_siswa['nama_siswa'] ?? 'Siswa Tamu'); ?></h2>
            <?php 
                $tgl_daftar = $data_siswa['tgl_daftar'] ?? date('Y-m-d');
                $tahun_gabung = date('Y', strtotime($tgl_daftar));
            ?>
            <p class="mb-0 small text-info">Bergabung sejak Tahun <?= htmlspecialchars($tahun_gabung); ?></p>
            <p class="mb-0 small text-muted"><?= htmlspecialchars($data_siswa['pekerjaan'] ?? 'Belum Diatur'); ?></p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Kolom Kiri: Formulir Profil (Edit Data) -->
    <div class="col-lg-6 mb-4">
        <div class="card p-4 shadow-sm">
            <h4 class="mb-3" style="color: var(--dicoding-dark);">Informasi Akun</h4>
            <form method="POST">
                
                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" 
                           value="<?= htmlspecialchars($data_siswa['nama_siswa'] ?? ''); ?>" required>
                </div>
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= htmlspecialchars($data_siswa['email'] ?? ''); ?>" disabled>
                    <div class="form-text">Email tidak dapat diubah.</div>
                </div>

                <!-- No. HP -->
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" 
                           value="<?= htmlspecialchars($data_siswa['no_hp'] ?? ''); ?>" required>
                </div>
                
                <!-- Pekerjaan -->
                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" 
                           value="<?= htmlspecialchars($data_siswa['pekerjaan'] ?? ''); ?>" required>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($data_siswa['alamat'] ?? ''); ?></textarea>
                </div>

                <!-- Tombol Aksi -->
                <button type="submit" name="simpan_profil" class="btn btn-primary">Simpan Perubahan</button>
                
                <!-- Tombol Hapus Akun (Menggunakan Modal) -->
                <button type="button" class="btn btn-danger float-end" 
                         data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Hapus Akun
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Kursus Lulus/Selesai -->
    <div class="col-lg-6">
        <div class="card p-4 shadow-sm h-100 bg-light">
            <h4 class="mb-3" style="color: var(--dicoding-dark);">Pencapaian Kursus Lulus</h4>
            
            <?php if ($kursus_lulus->num_rows > 0): ?>
                <?php while($lulus = $kursus_lulus->fetch_assoc()): ?>
                    <div class="card mb-3 achievement-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge lulus-tag me-2">✅ LULUS</span>
                                <span class="lulus-title"><?= htmlspecialchars($lulus['nama_kursus']); ?></span>
                            </div>
                            <small class="text-muted text-end">
                                <?= htmlspecialchars($lulus['kategori']); ?> 
                                <span class="fw-bold d-block"><?= htmlspecialchars($lulus['tingkat']); ?></span>
                            </small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info border-0">
                    Anda belum menyelesaikan kursus apapun. Terus semangat belajar!
                </div>
            <?php endif; ?>
            
            <!-- Statistik Dasar -->
            <div class="mt-4 pt-3 border-top">
                <p class="mb-1 small text-muted">Total Kursus Lulus: <span class="fw-bold text-success"><?= $kursus_lulus->num_rows; ?></span></p>
                <!-- NOTE: Di sini Anda harus menghitung total materi yang diselesaikan siswa secara dinamis. -->
                <p class="mb-0 small text-muted">Total Materi Selesai (Mockup): <span class="fw-bold">7 Modul</span></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Akun (Penting) -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>PERINGATAN!</strong> Tindakan ini tidak dapat dibatalkan.</p>
                <p>Apakah Anda yakin ingin menghapus akun Anda secara permanen? Semua data progres belajar dan penilaian Anda akan hilang.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <!-- REVISI PENTING: Arahkan ke file aksi yang baru -->
                <a href="delete_account.php" class="btn btn-danger">Ya, Hapus Akun Saya</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Logout (Disarankan menggunakan Modal untuk konsistensi) -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda yakin ingin keluar dari akun, <?= htmlspecialchars($_SESSION['nama_siswa'] ?? 'Siswa'); ?>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="/project-SBD/public/logout.php" class="btn btn-primary">Ya, Keluar</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Script JavaScript untuk mengubah link Logout di Header menjadi modal trigger
    document.addEventListener('DOMContentLoaded', function() {
        // Cari link Logout di header
        const logoutLink = document.querySelector('.navbar-nav a[href$="/public/logout.php"]');
        if (logoutLink) {
            // Kita harus mengubah link di header agar memicu modal, bukan langsung logout
            logoutLink.setAttribute('href', '#');
            logoutLink.setAttribute('data-bs-toggle', 'modal');
            logoutLink.setAttribute('data-bs-target', '#logoutModal');
            // Jika ada class seperti btn-custom-fill di header, pastikan modal trigger tetap terlihat bagus.
        }
    });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>