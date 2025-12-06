<?php
class Materi {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Fungsi BARU: Menghitung total materi dalam satu kursus
    public function getTotalMateriByKursus($id_kursus) {
        $sql = "SELECT COUNT(*) AS total_materi FROM materi WHERE id_kursus = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_kursus);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        // Mengembalikan nilai integer total materi, atau 0 jika tidak ada
        return $row ? (int)$row['total_materi'] : 0; 
    }

    public function getByKursus($id_kursus){
        $sql = "SELECT * FROM materi WHERE id_kursus=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_kursus);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getDetail($id){
        $sql = "SELECT * FROM materi WHERE id_materi=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}