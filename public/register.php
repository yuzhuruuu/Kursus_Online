<?php
// public/register.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$auth = new AuthController($conn);
$alert = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $auth->register($_POST);
    $alert = $res;
}

include __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <h3>Daftar Akun Siswa</h3>

    <?php if($alert): ?>
      <div class="alert <?= $alert['success'] ? 'alert-success' : 'alert-danger' ?>"><?= htmlspecialchars($alert['message']) ?></div>
    <?php endif; ?>

    <form method="POST" novalidate>
      <div class="mb-3">
        <label class="form-label">Nama lengkap</label>
        <input type="text" name="nama" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button class="btn btn-success" type="submit">Daftar</button>
      <a class="btn btn-link" href="login.php">Sudah punya akun? Login</a>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
