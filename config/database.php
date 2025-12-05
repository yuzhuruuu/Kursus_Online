<?php
// config/database.php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'kursus_online';

$conn = new mysqli($host, $username, $password, $db_name);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
