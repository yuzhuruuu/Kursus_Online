<?php
// public/login.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$auth = new AuthController($conn);
$error = null;

// kalau sudah login, arahkan ke dashboard
session_start();
if(isset($_SESSION['id_siswa'])) {
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $auth->login($_POST);
    if($res['success']) {
        header("Location: index.php");
        exit;
    } else {
        $error = $res['message'];
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-4">
    <h3>Login Siswa</h3>

    <?php if($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button class="btn btn-primary w-100" type="submit">Login</button>
    </form>

    <p class="mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
