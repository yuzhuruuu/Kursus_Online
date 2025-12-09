<?php
// public/update_progress.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProgressController.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Cek Autentikasi dan Parameter
if (!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['kursus_id']) || !isset($_GET['materi_id']) || !is_numeric($_GET['kursus_id']) || !is_numeric($_GET['materi_id'])) {
    // Jika parameter tidak lengkap, kembalikan ke halaman kursus
    header("Location: kursus.php"); // Lebih aman ke halaman kursus daripada index
    exit;
}

global $conn;
$id_siswa = $_SESSION['id_siswa'];
$id_kursus = (int)$_GET['kursus_id'];
$id_materi = (int)$_GET['materi_id'];

$progress_controller = new ProgressController($conn);

// Panggil fungsi controller untuk memperbarui progres secara transaksional
$update_success = $progress_controller->markMateriSelesai($id_siswa, $id_kursus, $id_materi);

if ($update_success) {
    // Redirect kembali ke halaman detail kursus dengan pesan sukses
    header("Location: kursus_detail.php?id=" . $id_kursus . "&status=progress_updated");
    exit;
} else {
    // Redirect kembali ke detail materi dengan pesan error
    header("Location: materi_detail.php?kursus_id=" . $id_kursus . "&materi_id=" . $id_materi . "&error=progress_failed");
    exit;
}