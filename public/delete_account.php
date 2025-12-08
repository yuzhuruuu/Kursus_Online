<?php
// public/delete_account.php
require_once __DIR__ . '/../config/database.php';

if (session_status() === PHP_SESSION_NONE) session_start();

global $conn;

// 1. CEK AUTENTIKASI SISWA
if (!isset($_SESSION['id_siswa'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

$siswa_id = $_SESSION['id_siswa'];
$pesan_error = '';
$pesan_sukses = '';

// 2. LOGIKA PENGHAPUSAN (Jika form konfirmasi dikirim)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $conn->begin_transaction(); // Mulai transaksi untuk memastikan konsistensi data

    try {
        // PERINGATAN: Karena ada Foreign Key, penghapusan harus dilakukan berurutan
        // dari tabel anak ke tabel induk.

        // a. Hapus data dari tabel 'siswaKursus'
        $stmt_sk = $conn->prepare("DELETE FROM siswaKursus WHERE id_siswa = ?");
        $stmt_sk->bind_param("i", $siswa_id);
        $stmt_sk->execute();

        // b. Hapus data dari tabel 'penilaian'
        $stmt_p = $conn->prepare("DELETE FROM penilaian WHERE id_siswa = ?");
        $stmt_p->bind_param("i", $siswa_id);
        $stmt_p->execute();

        // c. Hapus data dari tabel 'progres_belajar'
        $stmt_pb = $conn->prepare("DELETE FROM progres_belajar WHERE id_siswa = ?");
        $stmt_pb->bind_param("i", $siswa_id);
        $stmt_pb->execute();

        // d. Hapus data dari tabel 'siswa' (Tabel Induk)
        $stmt_s = $conn->prepare("DELETE FROM siswa WHERE id_siswa = ?");
        $stmt_s->bind_param("i", $siswa_id);
        
        if ($stmt_s->execute()) {
            $conn->commit(); // Commit transaksi jika semua berhasil
            
            // 3. Hapus sesi dan redirect
            session_unset();
            session_destroy();
            header("Location: index.php?msg=" . urlencode("Akun Anda berhasil dihapus. Sampai jumpa lagi!"));
            exit;
        } else {
            $conn->rollback();
            $pesan_error = "Gagal menghapus data siswa utama.";
        }

    } catch (mysqli_sql_exception $e) {
        $conn->rollback();
        // Tangani error, misalnya jika ada FK constraint yang terlewat
        $pesan_error = "Terjadi kesalahan database: " . $e->getMessage();
    }
}

// Ambil data siswa untuk ditampilkan di halaman konfirmasi
$stmt_data = $conn->prepare("SELECT nama_siswa, email FROM siswa WHERE id_siswa = ?");
$stmt_data->bind_param("i", $siswa_id);
$stmt_data->execute();
$result_data = $stmt_data->get_result();
$siswa_data = $result_data->fetch_assoc();

include __DIR__ . '/../includes/header.php';
?>

<!-- ============================================= -->
<!-- TAMPILAN KONFIRMASI (DICODING STYLE) -->
<!-- ============================================= -->
<style>
    .danger-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(255, 0, 0, 0.1);
        border-top: 5px solid red;
    }
    .btn-danger-custom {
        background-color: #dc3545;
        border-color: #dc3545;
        font-weight: 700;
        transition: background-color 0.3s;
    }
    .btn-danger-custom:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .btn-cancel-custom {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }
    .icon-danger {
        color: #dc3545;
        font-size: 2.5rem;
    }
</style>

<div class="row justify-content-center mt-5">
    <div class="col-lg-7 col-md-9">
        <div class="card p-5 danger-card">
            <div class="text-center mb-4">
                <span class="icon-danger">⚠️</span>
                <h3 class="mt-3" style="color: var(--dicoding-dark);">Konfirmasi Penghapusan Akun</h3>
            </div>
            
            <?php if ($pesan_error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($pesan_error); ?></div>
            <?php endif; ?>

            <p class="lead text-center">
                Anda akan menghapus akun **<?= htmlspecialchars($siswa_data['nama_siswa'] ?? 'Pengguna'); ?>** (<?= htmlspecialchars($siswa_data['email'] ?? 'Tidak diketahui'); ?>).
            </p>

            <div class="alert alert-warning text-center fw-bold mb-4">
                Tindakan ini bersifat **permanen** dan tidak dapat dibatalkan. Semua data progres belajar, nilai kuis, dan langganan kursus Anda akan hilang.
            </div>
            
            <form method="POST" class="d-flex justify-content-center gap-3">
                <!-- Field tersembunyi untuk konfirmasi penghapusan -->
                <input type="hidden" name="confirm_delete" value="1"> 

                <a href="profil.php" class="btn btn-lg btn-cancel-custom px-4">Batal & Kembali</a>
                
                <button type="submit" class="btn btn-lg btn-danger-custom px-4">
                    Ya, Hapus Akun Saya Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>