<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'db_kursusonline'; 

$conn = new mysqli($host, $username, $password, $db_name);

if(!$conn){
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>