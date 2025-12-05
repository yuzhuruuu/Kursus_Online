<?php
// models/Siswa.php
class Siswa {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($nama, $email, $password_hashed) {
        $sql = "INSERT INTO siswa (email, password, nama_siswa, tgl_daftar, status_akun) VALUES (?, ?, ?, ?, 'aktif')";
        $stmt = $this->conn->prepare($sql);
        $tgl = date('Y-m-d');
        return $stmt->bind_param("ssss", $email, $password_hashed, $nama, $tgl) && $stmt->execute();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM siswa WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findById($id) {
        $sql = "SELECT * FROM siswa WHERE id_siswa = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($id, $nama, $nohp, $alamat, $pekerjaan) {
        $sql = "UPDATE siswa SET nama_siswa=?, no_hp=?, alamat=?, pekerjaan=? WHERE id_siswa=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->bind_param("ssssi", $nama, $nohp, $alamat, $pekerjaan, $id) && $stmt->execute();
    }
}
