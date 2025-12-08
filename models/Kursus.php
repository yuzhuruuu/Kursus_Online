<?php
// models/Kursus.php
// Model untuk interaksi dengan tabel kursus (Subtes UTBK)

class Kursus { 
    private $conn;
    private $table_name = "kursus";
    private $table_enroll = "siswaKursus";

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * Mengambil semua subtes (kursus) dan nama tutornya.
     * Digunakan di public/kursus.php.
     */
    public function getAll(){
        $query = "SELECT k.*, t.nama_tutor 
                  FROM " . $this->table_name . " k
                  JOIN tutor t ON k.id_tutor = t.id_tutor
                  ORDER BY k.kategori, k.nama_kursus";
        $result = $this->conn->query($query);
        return $result;
    }

    /**
     * Mengambil detail satu subtes berdasarkan ID.
     * Digunakan di public/kursus_detail.php.
     */
    public function getById($id){
        $stmt = $this->conn->prepare("
            SELECT k.*, t.nama_tutor 
            FROM " . $this->table_name . " k
            JOIN tutor t ON k.id_tutor = t.id_tutor
            WHERE k.id_kursus = ? LIMIT 1
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Mendaftarkan siswa ke subtes (enrollment).
     * Digunakan di KursusController::enrollKursus().
     */
    public function enroll($id_siswa, $id_kursus){
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table_enroll . " (id_siswa, id_kursus) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_siswa, $id_kursus);
        
        try {
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            // Jika terjadi error (misalnya duplikat entry)
            return false;
        }
    }

    /**
     * Mengecek apakah siswa sudah terdaftar di subtes.
     * Digunakan di KursusController.
     */
    public function isTaken($id_siswa, $id_kursus){
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM " . $this->table_enroll . " WHERE id_siswa = ? AND id_kursus = ?");
        $stmt->bind_param("ii", $id_siswa, $id_kursus);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_row()[0] ?? 0;
        return $count > 0;
    }
}