<?php
require_once "../config/database.php";
require_once "../controllers/MateriController.php";
include "../includes/header.php";

$id = $_GET['id'];
$c = new MateriController($conn);
$m = $c->detail($id);
?>

<h3><?= htmlspecialchars($m['judul_materi']); ?></h3>
<p><?= htmlspecialchars($m['deskripsi']); ?></p>

<iframe width="100%" height="400" src="<?= htmlspecialchars($m['link_video']); ?>"></iframe>

<a href="kuis.php?id=<?= $id; ?>" class="btn btn-warning mt-3">Mulai Kuis</a>

<?php include "../includes/footer.php"; ?>
