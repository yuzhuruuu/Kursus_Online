<?php
require_once __DIR__ . '/../models/Materi.php';

class MateriController {
    private $model;

    public function __construct($db){
        $this->model = new Materi($db);
    }

    public function byKursus($id){
        return $this->model->getByKursus($id);
    }

    public function detail($id){
        return $this->model->getDetail($id);
    }
}
