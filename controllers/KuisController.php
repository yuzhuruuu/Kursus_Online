<?php
// controllers/KuisController.php

if (!isset($conn)) {
    require_once __DIR__ . '/../config/database.php';
    global $conn;
}

require_once __DIR__ . '/../models/Kuis.php'; 
require_once __DIR__ . '/../models/Progress.php';
require_once __DIR__ . '/../models/Penilaian.php'; // Asumsi model ini sudah/akan dibuat
require_once __DIR__ . '/../models/Kursus.php'; 

class KuisController {
    private $db;
    private $kuisModel;

    public function __construct($db) {
        $this->db = $db;
        $this->kuisModel = new Kuis($db);
    }
    
    /**
     * [FUNGSI YANG HILANG] Mengambil semua soal kuis untuk Tryout Subtes tertentu (10 soal).
     */
    public function getSoalTryout($id_kursus){
        // Memanggil Model Kuis untuk mengambil soal berdasarkan ID Kursus
        return $this->kuisModel->getKuisByKursus($id_kursus);
    }
    
    /**
     * Memproses jawaban kuis dan menyimpan hasilnya ke tabel penilaian.
     */
    public function submitTryout($id_siswa, $id_kursus, $jawaban){
        $this->db->begin_transaction();
        
        try {
            $total_soal = 0;
            $jawaban_benar = 0;

            // 1. Hitung Nilai
            foreach ($jawaban as $id_kuis => $jawaban_siswa) {
                $total_soal++;
                $jawaban_db = $this->kuisModel->getJawabanBenar($id_kuis);
                
                if (strtoupper($jawaban_siswa) === strtoupper($jawaban_db)) {
                    $jawaban_benar++;
                }
            }
            
            $nilai = ($total_soal > 0) ? round(($jawaban_benar / $total_soal) * 100) : 0;
            
            // 2. Simpan Hasil ke tabel Penilaian
            $penilaianModel = new Penilaian($this->db);
            if (!$penilaianModel->saveNilai($id_siswa, $id_kursus, $nilai, "Kuis Subtes")) {
                throw new Exception("Gagal menyimpan nilai kuis.");
            }
            
            $this->db->commit();
            return $nilai; 

        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Submit Kuis Gagal: " . $e->getMessage());
            return 0; // Mengembalikan nilai 0 jika gagal
        }
    }
}