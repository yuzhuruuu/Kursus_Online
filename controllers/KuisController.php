<?php
require_once __DIR__ . '/../models/Kuis.php';

class KuisController {
    private $model;

    public function __construct($db){
        $this->model = new Kuis($db);
    }

    public function simpanNilai($id_siswa, $id_kursus, $nilai){
        return $this->model->nilai($id_siswa, $id_kursus, $nilai);
    }
}
