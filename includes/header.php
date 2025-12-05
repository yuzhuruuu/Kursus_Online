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
  <link href="/project-SBD/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/project-SBD/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/project-SBD/public/index.php">KursusOnline</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['id_siswa'])): ?>
          <li class="nav-item"><a class="nav-link" href="/project-SBD/public/kursus.php">Kursus</a></li>
          <li class="nav-item"><a class="nav-link" href="/project-SBD/public/progress.php">Progress</a></li>
          <li class="nav-item"><a class="nav-link" href="/project-SBD/public/profil.php">Profil</a></li>
          <li class="nav-item"><a class="nav-link" href="/project-SBD/public/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/project-SBD/public/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/project-SBD/public/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
