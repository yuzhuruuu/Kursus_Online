<?php
require_once "../config/database.php";
require_once "../controllers/KuisController.php";
include "../includes/header.php";

$id_materi = $_GET['id'];
$controller = new KuisController($conn);

$soal = $controller->tampilSoal($id_materi);

if($soal->num_rows === 0){
    echo "<div class='alert alert-warning'>Belum ada soal kuis.</div>";
    include "../includes/footer.php";
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nilai = $controller->prosesKuis($_POST['jawaban'], $id_materi, $_SESSION['id_siswa']);
    echo "<div class='alert alert-success'>Kuis selesai! Nilai Anda: <strong>$nilai</strong></div>";
}
?>

<h3>Kuis</h3>

<form method="POST">
<?php while($q = $soal->fetch_assoc()): ?>
    <div class="card p-3 mt-3">
        <p><strong><?= $q['pertanyaan'] ?></strong></p>

        <label><input type="radio" name="jawaban[<?= $q['id_kuis'] ?>]" value="A"> <?= $q['jawaban_a'] ?></label><br>
        <label><input type="radio" name="jawaban[<?= $q['id_kuis'] ?>]" value="B"> <?= $q['jawaban_b'] ?></label><br>
        <label><input type="radio" name="jawaban[<?= $q['id_kuis'] ?>]" value="C"> <?= $q['jawaban_c'] ?></label><br>
        <label><input type="radio" name="jawaban[<?= $q['id_kuis'] ?>]" value="D"> <?= $q['jawaban_d'] ?></label><br>
    </div>
<?php endwhile; ?>

    <button class="btn btn-primary mt-3">Kirim Jawaban</button>
</form>

<?php include "../includes/footer.php"; ?>
