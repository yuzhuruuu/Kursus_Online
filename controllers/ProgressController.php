<?php
// controllers/ProgressController.php
require_once __DIR__ . '/../models/Progress.php';

class ProgressController {
    private $model;

    public function __construct($db){
        $this->model = new Progress($db);
    }

    public function getProgress($id_siswa){
        return $this->model->getProgressBySiswa($id_siswa);
    }
}
