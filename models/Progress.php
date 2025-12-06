<?php
// models/Progress.php
class Progress {
    private $conn;
    private $table = 'progress_belajar';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi 1: Membuat entri progress awal (Dipanggil saat siswa ambil kursus)
    public function createInitialProgress($id_siswa, $id_kursus, $total_materi) {
        // Cek apakah entri sudah ada untuk menghindari duplikat
        $check_query = "SELECT id_progress FROM " . $this->table . " WHERE id_siswa = ? AND id_kursus = ?";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bind_param("ii", $id_siswa, $id_kursus);
        $check_stmt->execute();
        
        if ($check_stmt->get_result()->num_rows > 0) {
            return true; // Entri sudah ada
        }

        // Jika belum ada, buat entri baru
        $query = "INSERT INTO " . $this->table . " 
                  (id_siswa, id_kursus, total_materi, presentase_progress, status_progress) 
                  VALUES (?, ?, ?, 0, 'Baru')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $id_siswa, $id_kursus, $total_materi); 
        
        return $stmt->execute();
    }

    // Fungsi 2: Mengupdate progres (Dipanggil setelah kuis/materi selesai)
    public function updateProgress($id_siswa, $id_kursus, $materi_selesai, $total_materi) {
        // Pastikan total materi tidak nol
        if ($total_materi == 0) {
            return false; 
        }
        
        // Hitung persentase
        $presentase = round(($materi_selesai / $total_materi) * 100);
        $status = ($presentase == 100) ? 'Selesai' : 'Berjalan';
        
        $query = "UPDATE " . $this->table . " 
                  SET presentase_progress = ?, status_progress = ?
                  WHERE id_siswa = ? AND id_kursus = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isii", $presentase, $status, $id_siswa, $id_kursus); 

        return $stmt->execute();
    }
}