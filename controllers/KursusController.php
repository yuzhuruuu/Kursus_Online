<?php
// controllers/KursusController.php
require_once __DIR__ . '/../config/database.php';
// Memastikan semua file model di-include
require_once __DIR__ . '/../models/Materi.php';
require_once __DIR__ . '/../models/Progress.php';
require_once __DIR__ . '/../models/Kursus.php';

class KursusController {
    private $db;
    private $model;

    public function __construct($db){
        $this->db = $db;
        $this->model = new Kursus($db);
    }

    public function index(){
        return $this->model->getAll();
    }

    public function detail($id){
        return $this->model->getById($id);
    }

    public function cekSudahAmbil($id_siswa, $id_kursus){
        return $this->model->isTaken($id_siswa, $id_kursus);
    }

    /**
     * Fungsi untuk mendaftarkan siswa ke subtes dan membuat entri progres awal.
     * Nama fungsi ini harus sama persis dengan yang dipanggil di public/enroll_kursus.php.
     */
    public function enrollKursus($id_siswa, $id_kursus){
        // Cek apakah sudah terdaftar
        if ($this->model->isTaken($id_siswa, $id_kursus)) {
            return "sudah_terdaftar";
        }
        
        // Mulai transaksi database
        $this->db->begin_transaction();
        
        try {
            // 1. Catat Siswa mengambil Kursus (INSERT INTO siswakursus)
            if (!$this->model->enroll($id_siswa, $id_kursus)) {
                throw new Exception("Gagal mendaftarkan siswa ke subtes (Model Enroll).");
            }
            
            // 2. Tentukan total materi untuk progres awal
            $materi_model = new Materi($this->db);
            $total_materi = $materi_model->getTotalMateriByKursus($id_kursus);
            
            // 3. Buat entri awal di progres_belajar (progress 0%)
            $progress_model = new Progress($this->db);
            if (!$progress_model->createInitialProgress($id_siswa, $id_kursus, $total_materi)) {
                throw new Exception("Gagal membuat progres awal.");
            }
            
            $this->db->commit(); // Commit jika semua berhasil
            return "berhasil"; 

        } catch (Exception $e) {
            $this->db->rollback(); // Rollback jika ada error
            error_log("Enrollment Gagal: " . $e->getMessage());
            return "gagal";
        }
    }
}