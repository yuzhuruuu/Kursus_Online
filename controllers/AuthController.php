<?php
// controllers/AuthController.php
require_once __DIR__ . '/../models/Siswa.php';

class AuthController {
    private $conn;
    private $siswaModel;

    public function __construct($db) {
        $this->conn = $db;
        $this->siswaModel = new Siswa($db);
    }

    public function register($post) {
        $nama = trim($post['nama']);
        $email = trim($post['email']);
        $password = $post['password'];

        if(empty($nama) || empty($email) || empty($password)) {
            return ['success'=>false,'message'=>'Semua field wajib diisi.'];
        }

        if($this->siswaModel->findByEmail($email)) {
            return ['success'=>false,'message'=>'Email sudah terdaftar.'];
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        if($this->siswaModel->create($nama, $email, $hashed)) {
            return ['success'=>true,'message'=>'Registrasi berhasil. Silakan login.'];
        } else {
            return ['success'=>false,'message'=>'Gagal menyimpan ke database.'];
        }
    }

    public function login($post) {
        session_start();
        $email = trim($post['email']);
        $password = $post['password'];

        $user = $this->siswaModel->findByEmail($email);
        if(!$user) return ['success'=>false,'message'=>'Email tidak ditemukan.'];

        if(password_verify($password, $user['password'])) {
            // set session
            $_SESSION['id_siswa'] = $user['id_siswa'];
            $_SESSION['nama_siswa'] = $user['nama_siswa'];
            return ['success'=>true];
        } else {
            return ['success'=>false,'message'=>'Password salah.'];
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /project-SBD/public/login.php");
        exit;
    }
}
