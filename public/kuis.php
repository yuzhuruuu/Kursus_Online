<?php
require_once "../config/database.php";
require_once "../controllers/KuisController.php";
include "../includes/header.php";

$id_materi = $_GET['id'];

// ambil info kursus dari materi
$q = $conn->query("SELECT * FROM materi WHERE id_materi=$id_materi");
$materi = $q->fetch_assoc();
$id_kursus = $materi['id_kursus'];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nilai = $_POST['nilai'];

    $controller = new KuisController($conn);
    $controller->simpanNilai($_SESSION['id_siswa'], $id_kursus, $nilai);

    echo "<div class='alert alert-success'>Nilai berhasil disimpan!</div>";
}
?>

<h3>Kuis: <?= htmlspecialchars($materi['judul_materi']); ?></h3>

<form method="POST">
  <label>Masukkan Nilai Anda</label>
  <input type="number" name="nilai" class="form-control" required>

  <button class="btn btn-primary mt-3">Simpan Nilai</button>
</form>

<?php include "../includes/footer.php"; ?>
