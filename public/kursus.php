<?php
require_once "../config/database.php";
require_once "../controllers/KursusController.php";
include "../includes/header.php";

if (!isset($_SESSION['id_siswa'])){
    header("Location: login.php");
    exit;
}

$controller = new KursusController($conn);
$data = $controller->index();
?>

<h3>Daftar Kursus</h3>

<div class="row mt-3">
<?php while($k = $data->fetch_assoc()): ?>
  <div class="col-md-4">
    <div class="card mb-3">
      <div class="card-body">
        <h5><?= htmlspecialchars($k['nama_kursus']); ?></h5>
        <p><?= htmlspecialchars($k['kategori']); ?> • <?= htmlspecialchars($k['tingkat']); ?></p>
        <a href="kursus_detail.php?id=<?= $k['id_kursus']; ?>" class="btn btn-primary btn-sm">Detail</a>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>

<?php include "../includes/footer.php"; ?>
