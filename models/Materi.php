<?php
class Materi {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
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
