<?php
// controllers/ProgressController.php

// Memerlukan koneksi database
if (!isset($conn)) {
    require_once __DIR__ . '/../config/database.php';
    global $conn;
}

require_once __DIR__ . '/../models/Progress.php'; 
require_once __DIR__ . '/../models/Materi.php';

class ProgressController {
    private $db;
    private $progressModel;
    private $materiModel;

    public function __construct($db){
        $this->db = $db;
        $this->progressModel = new Progress($db);
        $this->materiModel = new Materi($db);
    }
    
    /**
     * Mengambil semua progres kursus siswa. (Logika Display Dashboard)
     */
    public function getProgress($id_siswa) {
        $sql = "
            SELECT 
                p.id_progres,
                p.persentase_progres, 
                p.status_progres,
                p.total_materi,
                p.materi_selesai,
                k.nama_kursus,
                k.kategori,
                k.id_kursus,
                -- Ambil nilai tertinggi dari tabel penilaian
                (SELECT MAX(nilai) FROM penilaian pn WHERE pn.id_siswa = p.id_siswa AND pn.id_kursus = k.id_kursus) AS nilai_tertinggi
            FROM progres_belajar p
            JOIN kursus k ON p.id_kursus = k.id_kursus
            WHERE p.id_siswa = ?
            ORDER BY p.status_progres ASC, p.persentase_progres DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_siswa);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * [LOGIC BARU] Memeriksa apakah materi sudah diselesaikan oleh siswa (Membaca dari tabel progress_materi).
     */
    public function isMateriSudahSelesai($id_siswa, $id_materi) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM progress_materi WHERE id_siswa = ? AND id_materi = ?");
        $stmt->bind_param("ii", $id_siswa, $id_materi);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_row()[0] ?? 0;
        return $count > 0;
    }

    /**
     * [LOGIC BARU TRANSAKSI] Menandai materi sebagai selesai dan memperbarui progres total kursus.
     */
    public function markMateriSelesai($id_siswa, $id_kursus, $id_materi){
        $this->db->begin_transaction();
        
        try {
            // 1. Cek duplikat klik (menggunakan tabel progress_materi)
            if ($this->isMateriSudahSelesai($id_siswa, $id_materi)) {
                 $this->db->rollback();
                 return true; // Sudah selesai, anggap sukses dan hentikan proses
            }
            
            // 2. INSERT ke tabel progress_materi
            $stmt_insert = $this->db->prepare("INSERT INTO progress_materi (id_siswa, id_materi, tgl_selesai) VALUES (?, ?, NOW())");
            $stmt_insert->bind_param("ii", $id_siswa, $id_materi);
            if (!$stmt_insert->execute()) {
                throw new Exception("Gagal mencatat materi selesai.");
            }

            // 3. Hitung Ulang Progres Total
            $total_materi = $this->materiModel->getTotalMateriByKursus($id_kursus);
            
            // ASUMSI: progressModel memiliki countMateriSelesaiPerKursus()
            $materi_selesai_baru = $this->progressModel->countMateriSelesaiPerKursus($id_siswa, $id_kursus);
            
            $persentase_baru = round(($materi_selesai_baru / $total_materi) * 100);
            $status_baru = ($persentase_baru == 100) ? 'selesai' : 'sedang_berjalan';
            
            // 4. Update tabel progres_belajar
            $update_result = $this->progressModel->updateProgress($id_siswa, $id_kursus, $materi_selesai_baru, $persentase_baru, $status_baru);
            
            if (!$update_result) {
                throw new Exception("Gagal update progres total.");
            }

            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Progress Update Gagal: " . $e->getMessage());
            return false;
        }
    }

    /**
     * [FUNGSI BARU] Logic untuk Learning Reminder: Cek jika siswa stagnan.
     */
    public function checkStagnation($id_siswa) {
        $sql = "
            SELECT k.nama_kursus, k.id_kursus
            FROM progres_belajar p
            JOIN kursus k ON p.id_kursus = k.id_kursus
            WHERE p.id_siswa = ? 
            AND p.status_progres = 'sedang_berjalan'
            -- Cek jika tidak ada penilaian dalam 7 hari terakhir (atau skor rendah)
            AND DATEDIFF(NOW(), (SELECT MAX(tgl_penilaian) FROM penilaian pn WHERE pn.id_siswa = ? AND pn.id_kursus = p.id_kursus)) > 7
            LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_siswa, $id_siswa);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}