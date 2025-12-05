<?php
require_once "../config/database.php";
require_once "../controllers/ProgressController.php";
include "../includes/header.php";

if (!isset($_SESSION['id_siswa'])){
    header("Location: login.php");
    exit;
}

$controller = new ProgressController($conn);
$progress = $controller->getProgress($_SESSION['id_siswa']);
?>

<h3>Progress Belajar Saya</h3>

<table class="table table-bordered mt-3">
    <tr>
        <th>Kursus</th>
        <th>Nilai</th>
        <th>Tanggal</th>
    </tr>

    <?php while($p = $progress->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($p['nama_kursus']); ?></td>
        <td><?= htmlspecialchars($p['nilai']); ?></td>
        <td><?= htmlspecialchars($p['tgl_penilaian']); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include "../includes/footer.php"; ?>
