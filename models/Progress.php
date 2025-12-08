<?php
// models/Progress.php

class Progress {
    private $conn;
    private $table_name = "progres_belajar";

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * Fungsi untuk membuat entri progres awal (saat enrollment)
     */
    public function createInitialProgress($id_siswa, $id_kursus, $total_materi){
        // Status awal: 'belum_mulai', Materi Selesai: 0, Persentase: 0
        $status = 'belum_mulai';
        $materi_selesai = 0;
        $persentase = 0;

        // PENTING: Pastikan urutan dan jumlah placeholder (?) sesuai dengan bind_param
        $stmt = $this->conn->prepare("
            INSERT INTO " . $this->table_name . " (id_siswa, id_kursus, materi_selesai, total_materi, persentase_progres, status_progres) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        // Tipe: integer, integer, integer, integer, integer, string
        $stmt->bind_param("iiiiis", $id_siswa, $id_kursus, $materi_selesai, $total_materi, $persentase, $status);
        
        return $stmt->execute();
    }
    
    // ... (Fungsi-fungsi lain yang sudah ada)
    
    // 1. Mengambil data progres spesifik siswa untuk suatu kursus
    public function getProgresByKursus($id_siswa, $id_kursus) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE id_siswa = ? AND id_kursus = ?");
        $stmt->bind_param("ii", $id_siswa, $id_kursus);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // 2. Memperbarui data progres setelah materi selesai
    public function updateProgress($id_siswa, $id_kursus, $materi_selesai_baru, $persentase_baru, $status_baru) {
        $stmt = $this->conn->prepare("
            UPDATE " . $this->table_name . " 
            SET materi_selesai = ?, persentase_progres = ?, status_progres = ? 
            WHERE id_siswa = ? AND id_kursus = ?
        ");
        // Tipe: integer, integer, string, integer, integer
        $stmt->bind_param("iisii", $materi_selesai_baru, $persentase_baru, $status_baru, $id_siswa, $id_kursus);
        
        return $stmt->execute();
    }
}