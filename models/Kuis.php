<?php
class Kuis {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function nilai($id_siswa, $id_kursus, $nilai){
        $tgl = date('Y-m-d');
        $sql = "INSERT INTO penilaian (id_siswa, id_kursus, nilai, tgl_penilaian, keterangan) 
                VALUES (?,?,?,?, 'selesai')";

        $stmt = $this->conn->prepare($sql);
        return $stmt->bind_param("iiis", $id_siswa, $id_kursus, $nilai, $tgl) && $stmt->execute();
    }
}
