<?php
require 'koneksi.php';

// Memastikan ID siswa dikirim melalui URL (metode GET)
if (isset($_GET['id_siswa'])) {
    $id_siswa = $_GET['id_siswa'];

    // Query DELETE
    $query = "DELETE FROM siswa WHERE id_siswa = $id_siswa";
    
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        // Jika berhasil, redirect kembali ke halaman index
        header("Location: index.php");
        exit();
    } else {
        // Kasus jika gagal (misalnya karena ada Foreign Key Constraint, 
        // artinya siswa ini sudah punya data di tabel lain seperti PENDAFTARAN)
        echo "<div class='container mt-3 alert alert-danger'>
                Data Gagal Dihapus! Mungkin siswa ini memiliki data relasi (seperti pendaftaran atau penilaian). 
                Error: " . mysqli_error($conn) . "
              </div>";
        echo "<a href='index.php' class='btn btn-secondary mt-3'>Kembali ke Daftar Siswa</a>";
    }
} else {
    // Jika tidak ada ID yang dikirim
    header("Location: index.php");
    exit();
}
?>