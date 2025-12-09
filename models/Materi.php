<?php
// models/Materi.php

class Materi {
    private $conn;
    private $table_name = "materi";

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * [FUNGSI BARU] Mendapatkan total materi dalam suatu kursus.
     * Digunakan oleh ProgressController untuk menghitung total_materi.
     */
    public function getTotalMateriByKursus($id_kursus) {
        $sql = "SELECT COUNT(*) AS total_materi FROM " . $this->table_name . " WHERE id_kursus = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_kursus);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        // Mengembalikan nilai integer total materi, atau 0 jika tidak ada
        return $row ? (int)$row['total_materi'] : 0; 
    }
    
    // Fungsi yang Anda miliki sebelumnya untuk mengambil daftar materi per kursus
    public function getByKursus($id_kursus){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_kursus=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_kursus);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Fungsi yang Anda miliki sebelumnya untuk mengambil detail materi
    public function getDetail($id){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_materi=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    // Catatan: Jika ada fungsi lain di models/Materi.php Anda, pastikan ia dipertahankan di sini.
}