<?php
require 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_siswa'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $tgl_daftar = date('Y-m-d'); 
    $status = $_POST['status_akun'];

    // Kueri INSERT
    $query = "INSERT INTO siswa (nama_siswa, email, password, tgl_daftar, status_akun) 
              VALUES ('$nama', '$email', '$password', '$tgl_daftar', '$status')";
    
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='container mt-3 alert alert-danger'>Data Gagal Ditambahkan: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa Baru</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <center><h2>Tambah Siswa Baru</h2></center>
        <br>
        <div class="row justify-content-md-center">
            <div class="col-6">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_siswa" id="nama" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status Akun</label>
                        <select class="form-control" name="status_akun" id="status" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                            <option value="Tertunda">Tertunda</option>
                        </select>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mb-2">Submit</button>
                    <a href="index.php" class="btn btn-secondary mb-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>