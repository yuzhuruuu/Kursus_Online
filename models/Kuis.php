<?php
// models/Kuis.php

class Kuis {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * Mengambil semua soal kuis yang terkait dengan satu Subtes (Kursus).
     * Ini digunakan untuk Tryout Subtes.
     * @param int $id_kursus ID Kursus/Subtes
     * @return mysqli_result Hasil query soal kuis
     */
    public function getKuisByKursus($id_kursus){
        // Gabungkan semua kuis dari semua materi yang terkait dengan kursus ini.
        $sql = "SELECT 
                    k.id_kuis, 
                    k.pertanyaan, 
                    k.opsi_a, 
                    k.opsi_b, 
                    k.opsi_c, 
                    k.opsi_d,
                    k.jawaban_benar
                FROM kuis k
                JOIN materi m ON k.id_materi = m.id_materi
                WHERE m.id_kursus = ?
                ORDER BY k.id_kuis";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_kursus);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    // Fungsi yang Anda miliki sebelumnya untuk hitung nilai/simpan diubah menjadi helper untuk Controller
    public function getJawabanBenar($id_kuis) {
        $stmt = $this->conn->prepare("SELECT jawaban_benar FROM kuis WHERE id_kuis = ? LIMIT 1");
        $stmt->bind_param("i", $id_kuis);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['jawaban_benar'] ?? null;
    }
}