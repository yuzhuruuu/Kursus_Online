<?php
// public/index.php (dashboard)
require_once __DIR__ . '/../config/database.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

include __DIR__ . '/../includes/header.php';

// ambil jumlah kursus yang diikuti
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM siswaKursus WHERE id_siswa = ?");
$stmt->bind_param("i", $_SESSION['id_siswa']);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

// ambil ringkasan penilaian terakhir (contoh)
$stmt2 = $conn->prepare("SELECT k.nama_kursus, p.nilai, p.tgl_penilaian FROM penilaian p JOIN kursus k ON p.id_kursus=k.id_kursus WHERE p.id_siswa=? ORDER BY p.tgl_penilaian DESC LIMIT 5");
$stmt2->bind_param("i", $_SESSION['id_siswa']);
$stmt2->execute();
$recent = $stmt2->get_result();
?>

<h3>Halo, <?= htmlspecialchars($_SESSION['nama_siswa']); ?> 👋</h3>

<div class="row mt-3">
  <div class="col-md-4">
    <div class="card p-3">
      <h5>Total Kursus Diikuti</h5>
      <h2><?= $total ?></h2>
      <a class="btn btn-sm btn-primary mt-2" href="kursus.php">Telusuri Kursus</a>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card p-3">
      <h5>Penilaian Terbaru</h5>
      <?php if($recent->num_rows === 0): ?>
        <p>Tidak ada penilaian.</p>
      <?php else: ?>
        <ul class="list-group">
          <?php while($r = $recent->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between">
              <div><?= htmlspecialchars($r['nama_kursus']); ?></div>
              <div><strong><?= htmlspecialchars($r['nilai']); ?></strong> — <?= htmlspecialchars($r['tgl_penilaian']); ?></div>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
