<?php
// controllers/KursusController.php
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
}
