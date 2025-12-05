<?php
class Kuis {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // ambil soal kuis berdasarkan id materi
    public function getByMateri($id_materi){
        $sql = "SELECT * FROM kuis WHERE id_materi=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_materi);
        $stmt->execute();
        return $stmt->get_result();
    }

    // hitung nilai
    public function hitungNilai($jawaban_siswa, $id_materi, $id_siswa){
        $soal = $this->getByMateri($id_materi);
        $benar = 0;
        $total = $soal->num_rows;

        while($row = $soal->fetch_assoc()){
            $id = $row['id_kuis'];
            if(isset($jawaban_siswa[$id]) && $jawaban_siswa[$id] === $row['jawaban_benar']){
                $benar++;
            }
        }

        // nilai dalam skala 100
        $nilai = ($benar / $total) * 100;

        // simpan nilai
        $tgl = date("Y-m-d");
        $q = $this->conn->prepare(
            "INSERT INTO penilaian (id_siswa, id_kursus, nilai, tgl_penilaian, keterangan)
             VALUES (?, ?, ?, ?, 'selesai')"
        );

        // ambil id_kursus dari materi
        $get = $this->conn->query("SELECT id_kursus FROM materi WHERE id_materi=$id_materi")->fetch_assoc();
        $id_kursus = $get['id_kursus'];

        $q->bind_param("iids", $id_siswa, $id_kursus, $nilai, $tgl);
        $q->execute();

        return $nilai;
    }
}
