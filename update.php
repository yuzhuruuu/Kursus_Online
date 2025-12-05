<?php
require 'koneksi.php';

$id_siswa = '';

if (isset($_GET['id_siswa'])) {
    $id_siswa = $_GET['id_siswa'];
    
    
    $query_select = "SELECT * FROM siswa WHERE id_siswa = $id_siswa";
    $hasil_select = mysqli_query($conn, $query_select);
    $data_siswa = mysqli_fetch_assoc($hasil_select);

    // Cek jika ID tidak ditemukan
    if (!$data_siswa) {
        die("Data siswa tidak ditemukan.");
    }
}

// --- Bagian 2: Memproses Data yang Di-Submit (UPDATE) ---
if (isset($_POST['submit'])) {
    $id_siswa_post = $_POST['id_siswa'];
    $nama = $_POST['nama_siswa'];
    $email = $_POST['email'];
    $status = $_POST['status_akun'];

    // Query UPDATE
    $query_update = "UPDATE siswa SET 
                      nama_siswa = '$nama', 
                      email = '$email',
                      status_akun = '$status'
                    WHERE id_siswa = $id_siswa_post";
    
    $hasil_update = mysqli_query($conn, $query_update);

    if ($hasil_update) {
        // Redirect kembali ke halaman index setelah berhasil
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='container mt-3 alert alert-danger'>Data Gagal Diperbarui: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <center><h2>Edit Data Siswa</h2></center>
        <br>
        <div class="row justify-content-md-center">
            <div class="col-6">
                <form method="POST" action="update.php">
                    
                    <input type="hidden" name="id_siswa" value="<?php echo $data_siswa['id_siswa']; ?>">
                    
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_siswa" id="nama" 
                               value="<?php echo $data_siswa['nama_siswa']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" 
                               value="<?php echo $data_siswa['email']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status Akun</label>
                        <select class="form-control" name="status_akun" id="status" required>
                            <?php 
                            $status_saat_ini = $data_siswa['status_akun'];
                            $options = ['Aktif', 'Non-Aktif', 'Tertunda'];
                            foreach($options as $opt){
                                $selected = ($opt == $status_saat_ini) ? 'selected' : '';
                                echo "<option value='$opt' $selected>$opt</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mb-2">Simpan Perubahan</button>
                    <a href="index.php" class="btn btn-secondary mb-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>