<?php
// public/login.php
require_once __DIR__ . '/../config/database.php';
// require_once __DIR__ . '/../controllers/AuthController.php'; // Asumsi Controller Auth ada

if (session_status() === PHP_SESSION_NONE) session_start();
if(isset($_SESSION['id_siswa'])) {
    header("Location: index.php"); // Arahkan ke dashboard jika sudah login
    exit;
}

global $conn;
$pesan_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // [ASUMSI] Anda menangani input form dan melakukan validasi/login di sini
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Cari Siswa berdasarkan Email
    $stmt = $conn->prepare("SELECT id_siswa, password, nama_siswa FROM siswa WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $siswa = $result->fetch_assoc();

    if ($siswa && password_verify($password, $siswa['password'])) {
        // Login Berhasil
        $_SESSION['id_siswa'] = $siswa['id_siswa'];
        $_SESSION['nama_siswa'] = $siswa['nama_siswa'];
        header("Location: index.php");
        exit;
    } else {
        $pesan_error = "Email atau Password salah.";
    }
}

// Cek apakah ada pesan sukses dari halaman register
$pesan_sukses = $_GET['success'] ?? '';


include __DIR__ . '/../includes/header.php';
?>

<style>
/* Styling tambahan untuk formulir login, harus konsisten dengan register.php */
.login-card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
.btn-login-custom {
    background-color: var(--dicoding-accent, #00bcd4);
    border-color: var(--dicoding-accent, #00bcd4);
    font-weight: 700;
    padding: 10px 0;
}
.btn-login-custom:hover {
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
    <div class="col-lg-5 col-md-7">
        <div class="card p-5 login-card">
            <h3 class="text-center mb-4" style="color: var(--dicoding-dark);">Masuk Akun Siswa</h3>
            
            <?php if ($pesan_error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($pesan_error); ?></div>
            <?php endif; ?>
            
            <?php if ($pesan_sukses): ?>
                <div class="alert alert-success"><?= htmlspecialchars($pesan_sukses); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" placeholder="Masukkan email Anda">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required
                           placeholder="Masukkan password Anda">
                </div>
                
                <!-- Tombol Login Utama -->
                <button type="submit" class="btn btn-login-custom w-100 mb-3">Masuk</button>

                <p class="text-center text-muted">atau</p>
                
                <!-- Tombol Login dengan Google (Mockup) -->
                <button type="button" class="btn btn-google w-100 mb-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png" alt="Google Logo" style="height: 18px;" class="me-2">
                    Masuk dengan Google
                </button>
                
                <p class="text-center">
                    Belum punya akun? <a href="register.php" class="text-primary fw-bold text-decoration-none">Daftar sekarang</a>
                </p>
                
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>