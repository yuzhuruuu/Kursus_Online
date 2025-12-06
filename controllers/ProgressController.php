<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Materi.php';
require_once __DIR__ . '/../models/Progress.php';
// ... require models/controllers lainnya

class KursusController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ambilKursus($id_siswa, $id_kursus) {
        $kursus_diambil = false;

        // 1. Catat Siswa mengambil Kursus (INSERT INTO siswakursus)
        // [ASUMSI] Anda memiliki logic INSERT ke tabel siswakursus di sini
        $stmt_sk = $this->db->prepare("INSERT INTO siswakursus (id_siswa, id_kursus) VALUES (?, ?)");
        $stmt_sk->bind_param("ii", $id_siswa, $id_kursus);
        if ($stmt_sk->execute()) {
            $kursus_diambil = true;
        }

        if ($kursus_diambil) {
            // 2. TRIGGER LOGIC PROGRES AWAL
            $materi_model = new Materi($this->db);
            $progress_model = new Progress($this->db);

            $total_materi = $materi_model->getTotalMateriByKursus($id_kursus);
            
            // Buat entri awal di progress_belajar (progress 0%)
            $progress_model->createInitialProgress($id_siswa, $id_kursus, $total_materi);
            
            return true; // Pendaftaran dan progres awal berhasil
        }

        return false; // Pendaftaran gagal
    }
    
    // ... Tambahkan method lain yang mungkin Anda miliki
}