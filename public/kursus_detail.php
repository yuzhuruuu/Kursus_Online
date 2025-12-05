<?php
require_once "../config/database.php";
require_once "../controllers/KursusController.php";
include "../includes/header.php";

if (!isset($_SESSION['id_siswa'])){
    header("Location: login.php");
    exit;
}

$controller = new KursusController($conn);
$id = $_GET['id'];
$kursus = $controller->detail($id);
$sudah = $controller->cekSudahAmbil($_SESSION['id_siswa'], $id);

// jika klik daftar
if (isset($_POST['ambil'])){
    if(!$sudah){
        $controller->daftarKursus($_SESSION['id_siswa'], $id);
        echo "<div class='alert alert-success'>Berhasil mengambil kursus!</div>";
        $sudah = true;
    }
}
?>

<h3><?= htmlspecialchars($kursus['nama_kursus']); ?></h3>

<p><strong>Tutor:</strong> <?= htmlspecialchars($kursus['nama_tutor']); ?></p>
<p><?= htmlspecialchars($kursus['deskripsi']); ?></p>

<?php if($sudah): ?>
  <a href="materi.php?id=<?= $id; ?>" class="btn btn-success">Lihat Materi</a>
<?php else: ?>
  <form method="POST">
    <button name="ambil" class="btn btn-primary">Ambil Kursus</button>
  </form>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>
