<?php
// public/enroll_kursus.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/KursusController.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Cek Autentikasi
if(!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

// 2. Cek Parameter ID Kursus
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: kursus.php");
    exit;
}

global $conn;
$id_siswa = $_SESSION['id_siswa'];
$id_kursus = (int)$_GET['id'];

// 3. Proses Enrollment menggunakan Controller
$kursus_controller = new KursusController($conn);

try {
    // PANGGILAN FUNGSI YANG SAMA DENGAN NAMA DI CONTROLLER
    $hasil_enroll = $kursus_controller->enrollKursus($id_siswa, $id_kursus); 
    
    // 4. Arahkan berdasarkan hasil enrollment
    if ($hasil_enroll === "berhasil") {
        // Redirect ke halaman detail kursus yang baru didaftarkan dengan pesan sukses
        header("Location: kursus_detail.php?id=" . $id_kursus . "&status=enroll_success");
        exit;
    } elseif ($hasil_enroll === "sudah_terdaftar") {
        // Redirect ke detail kursus, karena tidak perlu daftar ulang
        header("Location: kursus_detail.php?id=" . $id_kursus . "&status=already_enrolled");
        exit;
    } else {
        // Hasilnya "gagal"
        header("Location: kursus.php?status=enroll_failed");
        exit;
    }
    
} catch (Error $e) {
    // Tangkap error jika method benar-benar tidak ditemukan
    error_log("Enrollment Error: " . $e->getMessage());
    header("Location: kursus.php?status=system_error");
    exit;
}