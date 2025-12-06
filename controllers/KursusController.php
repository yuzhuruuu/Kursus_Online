<?php
// controllers/KursusController.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Materi.php';
require_once __DIR__ . '/../models/Progress.php';
require_once __DIR__ . '/../models/Kursus.php';

class KursusController {
    private $model;

    public function __construct($db){
        $this->model = new Kursus($db);
    }

    public function index(){
        return $this->model->getAll();
    }

    public function detail($id){
        return $this->model->getById($id);
    }

    public function daftarKursus($id_siswa, $id_kursus){
        return $this->model->enroll($id_siswa, $id_kursus);
    }

    public function cekSudahAmbil($id_siswa, $id_kursus){
        return $this->model->isTaken($id_siswa, $id_kursus);
    }
    public function ambilKursus($id_siswa, $id_kursus) {
        $kursus_diambil = false;

        // 1. Catat Siswa mengambil Kursus (INSERT INTO siswakursus)
        // [ASUMSI] Anda memiliki logic INSERT ke tabel siswakursus di sini
        $stmt_sk = $this->db->prepare("INSERT INTO siswakursus (id_siswa, id_kursus) VALUES (?, ?)");
        $stmt_sk->bind_param("ii", $id_siswa, $id_kursus);
        if ($stmt_sk->execute()) {
            $kursus_diambil = true;
        }

        if ($kursus_diambil) {
            // 2. TRIGGER LOGIC PROGRES AWAL
            $materi_model = new Materi($this->db);
            $progress_model = new Progress($this->db);

            $total_materi = $materi_model->getTotalMateriByKursus($id_kursus);
            
            // Buat entri awal di progress_belajar (progress 0%)
            $progress_model->createInitialProgress($id_siswa, $id_kursus, $total_materi);
            
            return true; // Pendaftaran dan progres awal berhasil
        }

        return false; // Pendaftaran gagal
    }
}
