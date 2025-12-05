<?php
require_once "../config/database.php";
include "../includes/header.php";

$id = $_SESSION['id_siswa'];

$sql = "SELECT k.nama_kursus, p.nilai, p.tgl_penilaian 
        FROM penilaian p 
        JOIN kursus k ON p.id_kursus = k.id_kursus
        WHERE p.id_siswa=$id";

$d = $conn->query($sql);
?>

<h3>Progress Belajar</h3>

<table class="table table-bordered mt-3">
  <tr>
    <th>Kursus</th>
    <th>Nilai</th>
    <th>Tanggal</th>
  </tr>

  <?php while($p = $d->fetch_assoc()): ?>
  <tr>
    <td><?= htmlspecialchars($p['nama_kursus']); ?></td>
    <td><?= htmlspecialchars($p['nilai']); ?></td>
    <td><?= htmlspecialchars($p['tgl_penilaian']); ?></td>
  </tr>
  <?php endwhile; ?>
</table>

<?php include "../includes/footer.php"; ?>
