<?php
// public/register.php
require_once __DIR__ . '/../config/database.php';
// require_once __DIR__ . '/../controllers/AuthController.php'; // Asumsi Controller Auth ada

if (session_status() === PHP_SESSION_NONE) session_start();
if(isset($_SESSION['id_siswa'])) {
    header("Location: index.php"); // Arahkan ke dashboard jika sudah login
    exit;
}

global $conn;
$pesan_error = '';
$pesan_sukses = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // [ASUMSI] Anda menangani input form dan melakukan validasi di sini
    $nama = $_POST['nama_siswa'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($password !== $password_confirm) {
        $pesan_error = "Konfirmasi password tidak cocok.";
    } elseif (strlen($password) < 8) {
        $pesan_error = "Password minimal 8 karakter.";
    } else {
        // [ASUMSI] Logic INSERT Siswa ke DB (menggunakan hashing password)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("
            INSERT INTO siswa (nama_siswa, email, password, tgl_daftar, status_akun) 
            VALUES (?, ?, ?, NOW(), 'Aktif')
        ");
        $stmt->bind_param("sss", $nama, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $pesan_sukses = "Pendaftaran berhasil! Silakan Masuk.";
            // Arahkan langsung ke halaman login setelah sukses
            header("Location: login.php?success=" . urlencode($pesan_sukses));
            exit;
        } else {
            $pesan_error = "Pendaftaran gagal. Email mungkin sudah terdaftar.";
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<style>
/* Styling tambahan untuk formulir pendaftaran */
.register-card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
.btn-daftar-custom {
    background-color: var(--dicoding-accent, #00bcd4);
    border-color: var(--dicoding-accent, #00bcd4);
    font-weight: 700;
    padding: 10px 0;
}
.btn-daftar-custom:hover {
    background-color: #00a0b0;
    border-color: #00a0b0;
}
.btn-google {
    border: 1px solid #ddd;
    color: #444;
    font-weight: 600;
    transition: background-color 0.3s;
}
.btn-google:hover {
    background-color: #f7f7f7;
    color: #444;
}
</style>

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card p-5 register-card">
            <h3 class="text-center mb-4" style="color: var(--dicoding-dark);">Daftar Akun Siswa</h3>
            
            <?php if ($pesan_error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($pesan_error); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                
                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required 
                           value="<?= htmlspecialchars($_POST['nama_siswa'] ?? ''); ?>" placeholder="Masukkan nama lengkap Anda">
                </div>
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Aktif</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" placeholder="Gunakan alamat email aktif Anda">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required
                           placeholder="Masukkan password baru">
                    <div class="form-text">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.</div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-4">
                    <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required
                           placeholder="Ulangi password Anda">
                </div>
                
                <!-- Tombol Daftar Utama -->
                <button type="submit" class="btn btn-daftar-custom w-100 mb-3">Daftar Akun</button>

                <p class="text-center text-muted">atau</p>
                
                <!-- Tombol Daftar dengan Google (Mockup meniru tampilan Dicoding) -->
                <button type="button" class="btn btn-google w-100 mb-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png" alt="Google Logo" style="height: 18px;" class="me-2">
                    Daftar dengan Google
                </button>
                
                <p class="text-center">
                    Sudah punya akun? <a href="login.php" class="text-primary fw-bold text-decoration-none">Masuk sekarang</a>
                </p>
                
                <p class="text-center small mt-3 text-muted">
                    Dengan melakukan pendaftaran, Anda setuju dengan 
                    <a href="#" class="text-primary text-decoration-none">syarat & ketentuan</a> kami.
                </p>

            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>