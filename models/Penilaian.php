<?php
// models/Penilaian.php

class Penilaian {
    private $conn;
    private $table_name = "penilaian";

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * Menyimpan hasil nilai kuis ke database.
     * @param int $id_siswa
     * @param int $id_kursus
     * @param int $nilai_akhir Nilai (0-100)
     * @param string $keterangan Keterangan hasil kuis
     * @return bool True jika berhasil disimpan.
     */
    public function saveNilai($id_siswa, $id_kursus, $nilai_akhir, $keterangan){
        $tgl_penilaian = date('Y-m-d');
        
        $stmt = $this->conn->prepare("
            INSERT INTO " . $this->table_name . " (id_siswa, id_kursus, nilai, keterangan, tgl_penilaian)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        // Tipe: integer, integer, integer, string, string
        $stmt->bind_param("iiiss", $id_siswa, $id_kursus, $nilai_akhir, $keterangan, $tgl_penilaian);
        
        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Gagal menyimpan nilai: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Mengambil nilai terakhir siswa untuk rekomendasi
     */
    public function getLatestNilai($id_siswa, $id_kursus) {
        $stmt = $this->conn->prepare("
            SELECT nilai, tgl_penilaian 
            FROM " . $this->table_name . " 
            WHERE id_siswa = ? AND id_kursus = ? 
            ORDER BY tgl_penilaian DESC 
            LIMIT 1
        ");
        $stmt->bind_param("ii", $id_siswa, $id_kursus);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}