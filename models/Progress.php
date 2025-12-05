<?php
// models/Progress.php

class Progress {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // mengambil semua progress (nilai) siswa
    public function getProgressBySiswa($id_siswa){
        $sql = "SELECT k.nama_kursus, p.nilai, p.tgl_penilaian 
                FROM penilaian p 
                JOIN kursus k ON p.id_kursus = k.id_kursus
                WHERE p.id_siswa = ?
                ORDER BY p.tgl_penilaian DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_siswa);
        $stmt->execute();

        return $stmt->get_result();
    }
}
