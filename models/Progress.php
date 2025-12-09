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

        $stmt = $this->conn->prepare("
            INSERT INTO " . $this->table_name . " (id_siswa, id_kursus, materi_selesai, total_materi, persentase_progres, status_progres) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        // Tipe: integer, integer, integer, integer, integer, string
        $stmt->bind_param("iiiiis", $id_siswa, $id_kursus, $materi_selesai, $total_materi, $persentase, $status);
        
        return $stmt->execute();
    }
    
    /**
     * Mengambil data progres spesifik siswa untuk suatu kursus
     */
    public function getProgresByKursus($id_siswa, $id_kursus) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE id_siswa = ? AND id_kursus = ?");
        $stmt->bind_param("ii", $id_siswa, $id_kursus);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Memperbarui data progres setelah materi selesai
     */
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
    
    /**
     * [FUNGSI BARU] Menghitung jumlah materi yang sudah dicatat selesai (dari tabel progress_materi).
     * Dibutuhkan oleh ProgressController untuk menghitung ulang persentase.
     */
    public function countMateriSelesaiPerKursus($id_siswa, $id_kursus) {
        // Gabungkan progress_materi dengan tabel materi untuk memfilter berdasarkan id_kursus
        $stmt = $this->conn->prepare("
            SELECT COUNT(pm.id_materi) 
            FROM progress_materi pm
            JOIN materi m ON pm.id_materi = m.id_materi
            WHERE pm.id_siswa = ? AND m.id_kursus = ?
        ");
        $stmt->bind_param("ii", $id_siswa, $id_kursus);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_row()[0] ?? 0;
        return $count;
    }
}