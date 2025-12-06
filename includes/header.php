<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kursus Online</title>
    <!-- Penting: Menggunakan CDN Bootstrap 5 terbaru -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* CSS Kustom Meniru Gaya Dicoding */
        :root {
            --dicoding-dark: #0b1c31; /* Warna Latar Navbar */
            --dicoding-accent: #00bcd4; /* Warna Toska/Cyan */
        }
        
        .navbar-custom {
            background-color: var(--dicoding-dark);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding-top: 15px;
            padding-bottom: 15px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--dicoding-accent) !important;
            font-size: 1.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            margin: 0 5px;
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .nav-link:hover {
            color: var(--dicoding-accent) !important; /* Efek hover toska */
        }

        /* Styling Tombol Aksi Login/Register */
        .btn-custom-outline {
            color: var(--dicoding-accent);
            border-color: var(--dicoding-accent);
            background-color: transparent;
            font-weight: 600;
            padding: 8px 15px;
            margin-right: 10px;
        }
        .btn-custom-outline:hover {
            color: var(--dicoding-dark);
            background-color: var(--dicoding-accent);
            border-color: var(--dicoding-accent);
        }
        
        /* Styling Tombol Aksi Daftar/Logout */
        .btn-custom-fill {
            background-color: #3b4d63; /* Biru tua lembut */
            color: white;
            font-weight: 600;
            padding: 8px 15px;
            border: none;
        }
        .btn-custom-fill:hover {
            background-color: #4b5d73;
        }

        /* Bilah Pencarian (Hanya Tampilan Mockup) */
        .search-bar-mock {
            width: 300px;
            margin-right: 20px;
        }
        .search-bar-mock input {
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .search-bar-mock input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <!-- Brand/Logo (Home) -->
        <a class="navbar-brand" href="/project-SBD/public/index.php">KursOn</a>
        
        <!-- Mock Search Bar (Tampilan seperti di Dicoding) -->
        <div class="d-none d-lg-block search-bar-mock">
            <input type="text" class="form-control form-control-sm" placeholder="🔍 Apa yang ingin Anda pelajari?">
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <?php if(isset($_SESSION['id_siswa'])): ?>
                    <!-- Tautan Navigasi Siswa -->
                    <li class="nav-item"><a class="nav-link" href="/project-SBD/public/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/project-SBD/public/kursus.php">Kursus</a></li>
                    <li class="nav-item"><a class="nav-link" href="/project-SBD/public/progress.php">Progress</a></li>
                    <li class="nav-item"><a class="nav-link" href="/project-SBD/public/profil.php">Profil</a></li>
                    
                    <!-- Tombol Logout -->
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-custom-fill" href="/project-SBD/public/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- Tombol Aksi Publik -->
                    <li class="nav-item">
                        <a class="btn btn-custom-outline" href="/project-SBD/public/login.php">Masuk</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-custom-fill" href="/project-SBD/public/register.php">Daftar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <!-- Harus ada di akhir header agar komponen Bootstrap (toggler) berfungsi -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>