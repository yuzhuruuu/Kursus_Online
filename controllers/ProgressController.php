<?php
// controllers/ProgressController.php

// Memerlukan koneksi database
if (!isset($conn)) {
    require_once __DIR__ . '/../config/database.php';
    global $conn;
}

require_once __DIR__ . '/../models/Progress.php'; 
require_once __DIR__ . '/../models/Materi.php';

class ProgressController {
    private $db;
    private $progressModel;
    private $materiModel;

    public function __construct($db){
        $this->db = $db;
        $this->progressModel = new Progress($db);
        $this->materiModel = new Materi($db);
    }
    
    /**
     * [FUNGSI YANG HILANG] Mengambil semua progres kursus siswa
     * @param int $id_siswa ID Siswa
     * @return mysqli_result Hasil query data progres dan kursus terkait.
     */
    public function getProgress($id_siswa) {
        // Gabungkan progres_belajar dengan kursus dan penilaian terbaru
        $sql = "
            SELECT 
                p.id_progres,
                p.persentase_progres, 
                p.status_progres,
                p.total_materi,
                p.materi_selesai,
                k.nama_kursus,
                k.kategori,
                k.id_kursus,
                -- Ambil nilai tertinggi dari tabel penilaian
                (SELECT MAX(nilai) FROM penilaian pn WHERE pn.id_siswa = p.id_siswa AND pn.id_kursus = k.id_kursus) AS nilai_tertinggi
            FROM progres_belajar p
            JOIN kursus k ON p.id_kursus = k.id_kursus
            WHERE p.id_siswa = ?
            ORDER BY p.status_progres ASC, p.persentase_progres DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_siswa);
        $stmt->execute();
        return $stmt->get_result();
    }

    // FUNGSI LAINNYA (isMateriSudahSelesai, markMateriSelesai, dll.)
    
    public function isMateriSudahSelesai($id_siswa, $id_materi) {
        // Placeholder, implementasi nyata memerlukan tabel progress_materi
        return false; 
    }

    public function markMateriSelesai($id_siswa, $id_kursus, $id_materi){
        $progres = $this->progressModel->getProgresByKursus($id_siswa, $id_kursus);

        if (!$progres) { return false; }
        
        $materi_selesai_baru = $progres['materi_selesai'] + 1;
        $total_materi = $progres['total_materi'];

        if ($materi_selesai_baru > $total_materi) { $materi_selesai_baru = $total_materi; }

        $persentase_baru = round(($materi_selesai_baru / $total_materi) * 100);

        $status_baru = ($persentase_baru == 100) ? 'selesai' : 'sedang_berjalan';
        
        $update_result = $this->progressModel->updateProgress($id_siswa, $id_kursus, $materi_selesai_baru, $persentase_baru, $status_baru);

        return $update_result;
    }
}