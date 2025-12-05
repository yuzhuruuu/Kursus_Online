<?php
// models/Kursus.php
class Kursus {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // ambil semua kursus
    public function getAll(){
        $sql = "SELECT k.*, t.nama_siswa AS nama_tutor 
                FROM kursus k 
                JOIN tutor t ON k.id_tutor = t.id_tutor";
        return $this->conn->query($sql);
    }

    // ambil kursus berdasarkan ID
    public function getById($id){
        $sql = "SELECT k.*, t.nama_siswa AS nama_tutor
                FROM kursus k 
                JOIN tutor t ON k.id_tutor = t.id_tutor
                WHERE id_kursus = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // cek apakah siswa sudah mengambil kursus
    public function isTaken($id_siswa, $id_kursus){
        $sql = "SELECT * FROM siswaKursus WHERE id_siswa=? AND id_kursus=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $id_siswa, $id_kursus);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // siswa mendaftar kursus
    public function enroll($id_siswa, $id_kursus){
        $sql = "INSERT INTO siswaKursus (id_siswa, id_kursus) VALUES (?,?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->bind_param("ii", $id_siswa, $id_kursus) && $stmt->execute();
    }
}
