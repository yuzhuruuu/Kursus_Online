<?php
// public/profil.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Siswa.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['id_siswa'])) { header("Location: login.php"); exit; }

$siswaModel = new Siswa($conn);
$siswa = $siswaModel->findById($_SESSION['id_siswa']);
$alert = null;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $nohp = $_POST['no_hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $pekerjaan = $_POST['pekerjaan'] ?? '';

    if($siswaModel->updateProfile($_SESSION['id_siswa'], $nama, $nohp, $alamat, $pekerjaan)) {
        $alert = ['success'=>true,'message'=>'Profil diperbarui.'];
        $siswa = $siswaModel->findById($_SESSION['id_siswa']); // refresh data
        $_SESSION['nama_siswa'] = $siswa['nama_siswa'];
    } else {
        $alert = ['success'=>false,'message'=>'Gagal menyimpan profil.'];
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="row">
  <div class="col-md-6">
    <h3>Profil Saya</h3>

    <?php if($alert): ?>
      <div class="alert <?= $alert['success'] ? 'alert-success' : 'alert-danger' ?>"><?= htmlspecialchars($alert['message']) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input class="form-control" name="nama" value="<?= htmlspecialchars($siswa['nama_siswa'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">No. HP</label>
        <input class="form-control" name="no_hp" value="<?= htmlspecialchars($siswa['no_hp'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea class="form-control" name="alamat"><?= htmlspecialchars($siswa['alamat'] ?? '') ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Pekerjaan</label>
        <input class="form-control" name="pekerjaan" value="<?= htmlspecialchars($siswa['pekerjaan'] ?? '') ?>">
      </div>
      <button class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
