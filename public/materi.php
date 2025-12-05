<?php
require_once "../config/database.php";
require_once "../controllers/MateriController.php";
include "../includes/header.php";

$id_kursus = $_GET['id'];
$controller = new MateriController($conn);
$list = $controller->byKursus($id_kursus);
?>

<h3>Materi Kursus</h3>

<ul class="list-group mt-3">
<?php while($m = $list->fetch_assoc()): ?>
  <li class="list-group-item">
    <a href="materi_detail.php?id=<?= $m['id_materi']; ?>">
      <?= htmlspecialchars($m['judul_materi']); ?>
    </a>
  </li>
<?php endwhile; ?>
</ul>

<?php include "../includes/footer.php"; ?>
