<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Progress.php';
require_once __DIR__ . '/../models/Kuis.php'; // Digunakan untuk mencari id_kursus dari id_materi
require_once __DIR__ . '/../models/Materi.php'; // Digunakan untuk menghitung total materi

class KuisController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fungsi bantu: Menghitung jumlah materi yang sudah dinilai/selesai oleh siswa
    private function countCompletedMateri($id_siswa, $id_kursus) {
        // Dalam konteks ini, kita asumsikan materi 'selesai' jika siswa memiliki penilaian
        // (nilai > 0) untuk kuis yang terhubung dengan materi tersebut.
        $sql = "SELECT COUNT(DISTINCT m.id_materi) AS selesai_count
                FROM penilaian p
                JOIN materi m ON p.id_kursus = m.id_kursus
                WHERE p.id_siswa = ? AND p.id_kursus = ? AND p.nilai > 0";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_siswa, $id_kursus);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (int)$result['selesai_count'];
    }

    public function submitKuis($id_siswa, $id_materi, $jawaban_siswa) {
        // [ASUMSI] Anda mendapatkan hasil dan id_kursus yang relevan di sini
        // Misalnya, Anda perlu mencari id_kursus dari id_materi
        $materi_model = new Materi($this->db);
        $materi_detail = $materi_model->getDetail($id_materi);
        if (!$materi_detail) return false;
        
        $id_kursus = $materi_detail['id_kursus'];

        // 1. Insert Hasil Kuis ke tabel penilaian
        // [ASUMSI] Anda menghitung dan menyimpan nilai/hasil kuis ke tabel penilaian di sini.
        $nilai_akhir = 80; // Contoh nilai
        $tgl_penilaian = date('Y-m-d H:i:s');
        
        $stmt_nilai = $this->db->prepare("INSERT INTO penilaian (id_siswa, id_kursus, id_materi, nilai, tgl_penilaian) VALUES (?, ?, ?, ?, ?)");
        $stmt_nilai->bind_param("iiiis", $id_siswa, $id_kursus, $id_materi, $nilai_akhir, $tgl_penilaian);
        $stmt_nilai->execute();

        // 2. TRIGGER LOGIC UPDATE PROGRES
        $progress_model = new Progress($this->db);
        
        // a. Hitung total materi (diperlukan untuk updateProgress)
        $total_materi = $materi_model->getTotalMateriByKursus($id_kursus);
        
        // b. Hitung materi yang sudah selesai
        $materi_selesai = $this->countCompletedMateri($id_siswa, $id_kursus);
        
        // c. Update progress_belajar
        $progress_model->updateProgress($id_siswa, $id_kursus, $materi_selesai, $total_materi);
        
        return true; // Proses kuis dan update progres berhasil
    }
    
    // ... Tambahkan method lain yang mungkin Anda miliki
}