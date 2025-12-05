<?php
require_once __DIR__ . '/../models/Kuis.php';

class KuisController {
    private $model;
    public function __construct($db){
        $this->model = new Kuis($db);
    }

    public function tampilSoal($id_materi){
        return $this->model->getByMateri($id_materi);
    }

    public function prosesKuis($jawaban_siswa, $id_materi, $id_siswa){
        return $this->model->hitungNilai($jawaban_siswa, $id_materi, $id_siswa);
    }
}
