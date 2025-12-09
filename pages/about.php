
<?php
// pages/about.php (Halaman Utama Publik)
require_once __DIR__ . '/../config/database.php';
// Tidak perlu session_start() jika halaman ini adalah publik, 
// tetapi kita akan memerlukannya untuk include header/footer.
if (session_status() === PHP_SESSION_NONE) session_start();

global $conn;

// Ambil statistik dinamis dari database (DB Anda)
$total_siswa = $conn->query("SELECT COUNT(*) FROM siswa")->fetch_row()[0] ?? 0;
$total_kursus = $conn->query("SELECT COUNT(*) FROM kursus")->fetch_row()[0] ?? 0;


include __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <h1 class="mb-5 text-center" style="color: var(--dicoding-dark); font-weight: 700;">
            Lolos PTN Impian? Persiapan UTBK Terstruktur, Terukur, dan Real time
        </h1>
        
        <div class="p-4 mb-5" style="background-color: var(--dicoding-soft); border-radius: 8px;">
            <h4 class="text-center" style="color: var(--dicoding-dark);">Kuis Sesuai Materi & Progres Belajar Khusus UTBK/SNBT</h4>
            <p class="lead mb-0 text-center">
                Platform ini adalah website kursus online yang dirancang khusus untuk menghadapi UTBK/SNBT. Kami mengatur materi per subtes, menyediakan materi, kuis, dan menyajikan progres belajar secara terpadu untuk memastikan fokus belajar Anda tepat sasaran.
            </p>
        </div>

        <div class="row mb-5">
            <h3 class="text-center mb-4" style="color: var(--dicoding-dark);">Mengapa Memilih Kami?</h3>
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Dampak Positif yang Kami Berikan</h5>
                <ul class="list-unstyled">
                    <li><span class="text-success fw-bold me-2">✅</span> Membantu siswa belajar lebih terstruktur dan terpantau.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Tutor dapat mengelola kelas lebih efisien.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Admin memperoleh data evaluasi pendidikan yang lengkap.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Mengurangi keterlambatan belajar dan meningkatkan retensi siswa.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-success mb-3">Fitur Cerdas dan Unik</h5>
                <ul class="list-unstyled">
                    <li><span class="text-warning fw-bold me-2">💡</span> Sistem Rekomendasi Kursus berdasarkan performa kuis.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> Monitoring Progress Real-Time Subtes untuk siswa.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> Integrasi Evaluasi Otomatis Hasil kuis langsung memengaruhi progres belajar siswa.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> Fitur Pengingat Belajar jika progres belajar siswa stagnan.</li>
                </ul>
            </div>
        </div>

        <hr>

        <section class="my-5 p-4 border rounded shadow-sm bg-white">
            <div class="border-start border-4 border-primary ps-3 mb-4">
                <h2 class="mb-0" style="color: var(--dicoding-dark);">Logika Sistem Cerdas 🧠</h2>
            </div>
            <p class="lead text-muted">Diagram alur di bawah ini menggambarkan bagaimana sistem memproses aktivitas siswa mulai dari pendaftaran hingga menghasilkan rekomendasi belajar yang dipersonalisasi.</p>
            

            <div class="d-flex justify-content-between align-items-center mt-4 text-center">
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #f0f8ff; border: 2px solid #b3d9ff;">
                        <span style="font-size: 2rem;">📝</span>
                    </div>
                    <p class="fw-bold mb-0">Registrasi</p>
                    <small class="text-muted">Akun Siswa Aktif</small>
                </div>
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #f0f0ff; border: 2px solid #ccccff;">
                        <span style="font-size: 2rem;">📚</span>
                    </div>
                    <p class="fw-bold mb-0">Akses Materi</p>
                    <small class="text-muted">Video & Modul</small>
                </div>
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #fff8e1; border: 2px solid #ffe082;">
                        <span style="font-size: 2rem;">⚡</span>
                    </div>
                    <p class="fw-bold mb-0">Pengerjaan Kuis</p>
                    <small class="text-muted">10 Soal/Subtes</small>
                </div>
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #fce4ec; border: 2px solid #f8bbd0;">
                        <span style="font-size: 2rem;">📊</span>
                    </div>
                    <p class="fw-bold mb-0">Evaluasi Otomatis</p>
                    <small class="text-muted">Simpan Nilai ke DB</small>
                </div>
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #e8f5e9; border: 2px solid #c8e6c9;">
                        <span style="font-size: 2rem;">💡</span>
                    </div>
                    <p class="fw-bold mb-0">Rekomendasi</p>
                    <small class="text-muted">Remedial / Lanjut</small>
                </div>
            </div>
        </section>

        <hr>

        <section class="my-5 p-4 border rounded shadow-sm bg-white">
            <div class="border-start border-4 border-success ps-3 mb-4">
                <h2 class="mb-0" style="color: var(--dicoding-dark);">Struktur & Distribusi Materi 📚</h2>
            </div>
            <p class="lead text-muted">Analisis mendalam mengenai pembagian materi pembelajaran. UTBK terbagi menjadi dua komponen besar: Tes Potensi Skolastik (TPS) dan Tes Literasi. Grafik ini menunjukkan proporsi dan bobot konten untuk setiap kategori.</p>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="text-center mb-3 text-muted">Komposisi Kategori Ujian</h5>
                    
                    <div class="p-4 border rounded" style="height: 300px; background-color: #fff;">
                        <canvas id="komposisiUjianChart" style="max-height: 250px;"></canvas>
                    </div>
                    
                    <p class="insight mt-3 p-2 bg-light rounded border-start border-warning border-4">
                        <strong>Insight:</strong> TPS memiliki porsi sedikit lebih besar (57%) dibandingkan Literasi, mencerminkan fokus pada kemampuan kognitif dasar.
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="text-center mb-3 text-muted">Volume Materi per Subtes</h5>
                    
                    <div class="p-4 border rounded" style="height: 300px; background-color: #fff;">
                        <canvas id="volumeMateriChart" style="max-height: 250px;"></canvas>
                    </div>
                    
                    <p class="insight mt-3 p-2 bg-light rounded border-start border-warning border-4">
                        <strong>Insight:</strong> "Penalaran Umum" memiliki jumlah modul terbanyak, mengindikasikan kompleksitas topik yang memerlukan pemecahan materi lebih rinci.
                    </p>
                </div>
            </div>
        </section>

        <hr>

        <section class="my-5 p-4 border rounded shadow-sm bg-white">
            <div class="border-start border-4 border-warning ps-3 mb-4">
                <h2 class="mb-0" style="color: var(--dicoding-dark);">Performa & Progres Siswa 📈</h2>
            </div>
            <p class="lead text-muted">Memahami bagaimana siswa berinteraksi dengan materi dan sebaran nilai yang mereka peroleh. Data ini krusial untuk fitur "Rekomendasi Cerdas" dan "Learning Reminder".</p>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="text-center mb-3 text-muted">Sebaran Nilai Kuis</h5>
                    
                    <div class="p-4 border rounded" style="height: 300px; background-color: #fff;">
                        <canvas id="sebaranNilaiChart" style="max-height: 250px;"></canvas>
                    </div>
                    
                    <p class="insight mt-3 p-2 bg-light rounded border-start border-warning border-4">
                        <strong>Insight:</strong> "Pengetahuan Kuantitatif" menunjukkan variasi nilai terluas, menandakan tingkat kesulitan yang beragam bagi siswa.
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="text-center mb-3 text-muted">Tren Penyelesaian Materi (Rata-rata)</h5>
                    
                    <div class="p-4 border rounded" style="height: 300px; background-color: #fff;">
                        <canvas id="trenPenyelesaianChart" style="max-height: 250px;"></canvas>
                    </div>
                    
                    <p class="insight mt-3 p-2 bg-light rounded border-start border-warning border-4">
                        <strong>Insight:</strong> Terjadi lonjakan aktivitas belajar mendekati akhir periode (Minggu 4), memvalidasi efektivitas fitur pengingat belajar.
                    </p>
                </div>
            </div>
        </section>

        <hr>

        <h4 class="text-center mt-5 mb-4" style="color: var(--dicoding-dark);">Statistik Kami</h4>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-success">10K+</h1>
                    <p class="text-muted">Siswa Aktif Terdaftar</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-primary"><?= htmlspecialchars($total_kursus); ?></h1>
                    <p class="text-muted">Total Subtes & Materi Tersedia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-warning">4.9</h1>
                    <p class="text-muted">Rata-rata Rating Kelas</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5 p-4 border rounded bg-light">
            <h4 style="color: var(--dicoding-dark);">Siap untuk Menaklukkan UTBK/SNBT?</h4>
            <p class="lead">Daftar sekarang dan mulai belajar dari Materi perdana Anda secara gratis!</p>
            <a href="/project-SBD/public/register.php" class="btn btn-lg btn-primary fw-bold">Daftar Sekarang</a>
            <a href="/project-SBD/public/login.php" class="btn btn-lg btn-outline-secondary ms-2">Masuk</a>
        </div>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script src="/project-SBD/assets/js/Chart.BoxPlot.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Di v2.9.4, registrasi Plugin ini bersifat OTOMATIS setelah file dimuat.
    // Kita hapus kode registrasi manual (try/catch) yang menyebabkan TypeError.
    
    // --- Data Statis ---
    const dataLiterasi = [60, 58, 65, 70, 75, 78, 80, 55, 62, 72];
    const dataKuantitatif = [35, 40, 50, 60, 70, 85, 30, 80, 55, 45];
    const dataPenalaran = [55, 60, 65, 70, 75, 50, 72, 63, 68, 67];

    // --- 1. Komposisi Kategori Ujian (Donut Chart) ---
    const ctxKomposisi = document.getElementById('komposisiUjianChart');
    if (ctxKomposisi) {
        new Chart(ctxKomposisi, {
            type: 'doughnut',
            data: {
                labels: ['TPS (Tes Potensi Skolastik)', 'Tes Literasi'],
                datasets: [{
                    data: [57, 43],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)', 
                        'rgba(75, 192, 192, 0.8)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { // Catatan: Konfigurasi plugins di v2 berbeda dari v3/v4, tetapi legend masih bisa diatur.
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }

    // --- 2. Volume Materi per Subtes (Bar Chart) ---
    const ctxVolume = document.getElementById('volumeMateriChart');
    if (ctxVolume) {
        new Chart(ctxVolume, {
            type: 'bar',
            data: {
                labels: ['Penalaran Umum', 'Pemahaman & Pengetahuan Umum', 'Pemahaman Bacaan & Menulis', 'Pengetahuan Kuantitatif', 'Literasi B. Indonesia', 'Literasi B. Inggris', 'Penalaran Matematika'],
                datasets: [{
                    label: 'Jumlah Modul',
                    data: [3, 2, 2, 3, 2, 2, 2],
                    backgroundColor: 'rgba(255, 159, 64, 0.8)', 
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ // Menggunakan yAxes di v2
                        ticks: {
                            beginAtZero: true,
                            max: 3,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Volume'
                        }
                    }],
                    xAxes: [{ // Menggunakan xAxes di v2
                        ticks: {
                            maxRotation: 45, 
                            minRotation: 45,
                        }
                    }]
                }
            }
        });
    }

    // --- 3. Sebaran Nilai Kuis (Box Plot) ---
    const ctxSebaran = document.getElementById('sebaranNilaiChart');
    if (ctxSebaran) {
        new Chart(ctxSebaran, {
            type: 'boxplot', 
            data: {
                labels: ['Literasi Indo', 'Kuantitatif', 'Penalaran Umum'],
                datasets: [{
                    label: 'Nilai Akhir',
                    data: [dataLiterasi, dataKuantitatif, dataPenalaran], 
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)', 
                        'rgba(255, 99, 132, 0.5)', 
                        'rgba(54, 162, 235, 0.5)'  
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ // Menggunakan yAxes di v2
                        ticks: {
                            beginAtZero: false,
                            min: 30,
                            max: 100,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Nilai Akhir'
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
    }


    // --- 4. Tren Penyelesaian Materi (Line Chart) ---
    const ctxTren = document.getElementById('trenPenyelesaianChart');
    if (ctxTren) {
        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4 (Ujian)'],
                datasets: [{
                    label: 'Rata-rata Penyelesaian Materi (%)',
                    data: [15, 35, 60, 90],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    lineTension: 0.4 // Menggunakan lineTension di v2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ // Menggunakan yAxes di v2
                        ticks: {
                            beginAtZero: true,
                            max: 100,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Persentase (%)'
                        }
                    }]
                }
            }
        });
    }
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
=======
<?php
// pages/about.php (Halaman Utama Publik)
require_once __DIR__ . '/../config/database.php';
// Tidak perlu session_start() jika halaman ini adalah publik, 
// tetapi kita akan memerlukannya untuk include header/footer.
if (session_status() === PHP_SESSION_NONE) session_start();

global $conn;

// Ambil statistik dinamis dari database (DB Anda)
$total_siswa = $conn->query("SELECT COUNT(*) FROM siswa")->fetch_row()[0] ?? 0;
$total_kursus = $conn->query("SELECT COUNT(*) FROM kursus")->fetch_row()[0] ?? 0;


include __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <h1 class="mb-5 text-center" style="color: var(--dicoding-dark); font-weight: 700;">
            Lolos PTN Impian? Persiapan UTBK Terstruktur, Terukur, dan Real time
        </h1>
        
        <div class="p-4 mb-5" style="background-color: var(--dicoding-soft); border-radius: 8px;">
            <h4 class="text-center" style="color: var(--dicoding-dark);">Kuis Sesuai Materi & Progres Belajar Khusus UTBK/SNBT</h4>
            <p class="lead mb-0 text-center">
                Platform ini adalah website kursus online yang dirancang khusus untuk menghadapi UTBK/SNBT. Kami mengatur materi per subtes, menyediakan materi, kuis, dan menyajikan progres belajar secara terpadu untuk memastikan fokus belajar Anda tepat sasaran.
            </p>
        </div>

        <div class="row mb-5">
            <h3 class="text-center mb-4" style="color: var(--dicoding-dark);">Mengapa Memilih Kami?</h3>
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Dampak Positif yang Kami Berikan</h5>
                <ul class="list-unstyled">
                    <li><span class="text-success fw-bold me-2">✅</span> Membantu siswa belajar lebih terstruktur dan terpantau.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Tutor dapat mengelola kelas lebih efisien.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Admin memperoleh data evaluasi pendidikan yang lengkap.</li>
                    <li><span class="text-success fw-bold me-2">✅</span> Mengurangi keterlambatan belajar dan meningkatkan retensi siswa.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-success mb-3">Fitur Cerdas dan Unik</h5>
                <ul class="list-unstyled">
                    <li><span class="text-warning fw-bold me-2">💡</span> Sistem Rekomendasi Kursus berdasarkan performa kuis.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> Monitoring Progress Real-Time Subtes untuk siswa.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> Integrasi Evaluasi Otomatis Hasil kuis langsung memengaruhi progres belajar siswa.</li>
                    <li><span class="text-warning fw-bold me-2">💡</span> Fitur Pengingat Belajar jika progres belajar siswa stagnan.</li>
                </ul>
            </div>
        </div>

        <hr>

        <section class="my-5 p-4 border rounded shadow-sm bg-white">
            <div class="border-start border-4 border-primary ps-3 mb-4">
                <h2 class="mb-0" style="color: var(--dicoding-dark);">Logika Sistem Cerdas 🧠</h2>
            </div>
            <p class="lead text-muted">Diagram alur di bawah ini menggambarkan bagaimana sistem memproses aktivitas siswa mulai dari pendaftaran hingga menghasilkan rekomendasi belajar yang dipersonalisasi.</p>
            

            <div class="d-flex justify-content-between align-items-center mt-4 text-center">
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #f0f8ff; border: 2px solid #b3d9ff;">
                        <span style="font-size: 2rem;">📝</span>
                    </div>
                    <p class="fw-bold mb-0">Registrasi</p>
                    <small class="text-muted">Akun Siswa Aktif</small>
                </div>
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #f0f0ff; border: 2px solid #ccccff;">
                        <span style="font-size: 2rem;">📚</span>
                    </div>
                    <p class="fw-bold mb-0">Akses Materi</p>
                    <small class="text-muted">Video & Modul</small>
                </div>
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #fff8e1; border: 2px solid #ffe082;">
                        <span style="font-size: 2rem;">⚡</span>
                    </div>
                    <p class="fw-bold mb-0">Pengerjaan Kuis</p>
                    <small class="text-muted">10 Soal/Subtes</small>
                </div>
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #fce4ec; border: 2px solid #f8bbd0;">
                        <span style="font-size: 2rem;">📊</span>
                    </div>
                    <p class="fw-bold mb-0">Evaluasi Otomatis</p>
                    <small class="text-muted">Simpan Nilai ke DB</small>
                </div>
                <div class="flex-fill mx-1">
                    <div class="icon-circle p-3 rounded-circle d-inline-block mb-2" style="background-color: #e8f5e9; border: 2px solid #c8e6c9;">
                        <span style="font-size: 2rem;">💡</span>
                    </div>
                    <p class="fw-bold mb-0">Rekomendasi</p>
                    <small class="text-muted">Remedial / Lanjut</small>
                </div>
            </div>
        </section>

        <hr>

        <section class="my-5 p-4 border rounded shadow-sm bg-white">
            <div class="border-start border-4 border-success ps-3 mb-4">
                <h2 class="mb-0" style="color: var(--dicoding-dark);">Struktur & Distribusi Materi 📚</h2>
            </div>
            <p class="lead text-muted">Analisis mendalam mengenai pembagian materi pembelajaran. UTBK terbagi menjadi dua komponen besar: Tes Potensi Skolastik (TPS) dan Tes Literasi. Grafik ini menunjukkan proporsi dan bobot konten untuk setiap kategori.</p>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="text-center mb-3 text-muted">Komposisi Kategori Ujian</h5>
                    
                    <div class="p-4 border rounded" style="height: 300px; background-color: #fff;">
                        <canvas id="komposisiUjianChart" style="max-height: 250px;"></canvas>
                    </div>
                    
                    <p class="insight mt-3 p-2 bg-light rounded border-start border-warning border-4">
                        <strong>Insight:</strong> TPS memiliki porsi sedikit lebih besar (57%) dibandingkan Literasi, mencerminkan fokus pada kemampuan kognitif dasar.
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="text-center mb-3 text-muted">Volume Materi per Subtes</h5>
                    
                    <div class="p-4 border rounded" style="height: 300px; background-color: #fff;">
                        <canvas id="volumeMateriChart" style="max-height: 250px;"></canvas>
                    </div>
                    
                    <p class="insight mt-3 p-2 bg-light rounded border-start border-warning border-4">
                        <strong>Insight:</strong> "Penalaran Umum" memiliki jumlah modul terbanyak, mengindikasikan kompleksitas topik yang memerlukan pemecahan materi lebih rinci.
                    </p>
                </div>
            </div>
        </section>

        <hr>

        <section class="my-5 p-4 border rounded shadow-sm bg-white">
            <div class="border-start border-4 border-warning ps-3 mb-4">
                <h2 class="mb-0" style="color: var(--dicoding-dark);">Performa & Progres Siswa 📈</h2>
            </div>
            <p class="lead text-muted">Memahami bagaimana siswa berinteraksi dengan materi dan sebaran nilai yang mereka peroleh. Data ini krusial untuk fitur "Rekomendasi Cerdas" dan "Learning Reminder".</p>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="text-center mb-3 text-muted">Sebaran Nilai Kuis</h5>
                    
                    <div class="p-4 border rounded" style="height: 300px; background-color: #fff;">
                        <canvas id="sebaranNilaiChart" style="max-height: 250px;"></canvas>
                    </div>
                    
                    <p class="insight mt-3 p-2 bg-light rounded border-start border-warning border-4">
                        <strong>Insight:</strong> "Pengetahuan Kuantitatif" menunjukkan variasi nilai terluas, menandakan tingkat kesulitan yang beragam bagi siswa.
                    </p>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="text-center mb-3 text-muted">Tren Penyelesaian Materi (Rata-rata)</h5>
                    
                    <div class="p-4 border rounded" style="height: 300px; background-color: #fff;">
                        <canvas id="trenPenyelesaianChart" style="max-height: 250px;"></canvas>
                    </div>
                    
                    <p class="insight mt-3 p-2 bg-light rounded border-start border-warning border-4">
                        <strong>Insight:</strong> Terjadi lonjakan aktivitas belajar mendekati akhir periode (Minggu 4), memvalidasi efektivitas fitur pengingat belajar.
                    </p>
                </div>
            </div>
        </section>

        <hr>

        <h4 class="text-center mt-5 mb-4" style="color: var(--dicoding-dark);">Statistik Kami</h4>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-success">10K+</h1>
                    <p class="text-muted">Siswa Aktif Terdaftar</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-primary"><?= htmlspecialchars($total_kursus); ?></h1>
                    <p class="text-muted">Total Subtes & Materi Tersedia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm">
                    <h1 class="display-4 fw-bold text-warning">4.9</h1>
                    <p class="text-muted">Rata-rata Rating Kelas</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5 p-4 border rounded bg-light">
            <h4 style="color: var(--dicoding-dark);">Siap untuk Menaklukkan UTBK/SNBT?</h4>
            <p class="lead">Daftar sekarang dan mulai belajar dari Materi perdana Anda secara gratis!</p>
            <a href="/project-SBD/public/register.php" class="btn btn-lg btn-primary fw-bold">Daftar Sekarang</a>
            <a href="/project-SBD/public/login.php" class="btn btn-lg btn-outline-secondary ms-2">Masuk</a>
        </div>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script src="/project-SBD/assets/js/Chart.BoxPlot.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Di v2.9.4, registrasi Plugin ini bersifat OTOMATIS setelah file dimuat.
    // Kita hapus kode registrasi manual (try/catch) yang menyebabkan TypeError.
    
    // --- Data Statis ---
    const dataLiterasi = [60, 58, 65, 70, 75, 78, 80, 55, 62, 72];
    const dataKuantitatif = [35, 40, 50, 60, 70, 85, 30, 80, 55, 45];
    const dataPenalaran = [55, 60, 65, 70, 75, 50, 72, 63, 68, 67];

    // --- 1. Komposisi Kategori Ujian (Donut Chart) ---
    const ctxKomposisi = document.getElementById('komposisiUjianChart');
    if (ctxKomposisi) {
        new Chart(ctxKomposisi, {
            type: 'doughnut',
            data: {
                labels: ['TPS (Tes Potensi Skolastik)', 'Tes Literasi'],
                datasets: [{
                    data: [57, 43],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)', 
                        'rgba(75, 192, 192, 0.8)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { // Catatan: Konfigurasi plugins di v2 berbeda dari v3/v4, tetapi legend masih bisa diatur.
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }

    // --- 2. Volume Materi per Subtes (Bar Chart) ---
    const ctxVolume = document.getElementById('volumeMateriChart');
    if (ctxVolume) {
        new Chart(ctxVolume, {
            type: 'bar',
            data: {
                labels: ['Penalaran Umum', 'Pemahaman & Pengetahuan Umum', 'Pemahaman Bacaan & Menulis', 'Pengetahuan Kuantitatif', 'Literasi B. Indonesia', 'Literasi B. Inggris', 'Penalaran Matematika'],
                datasets: [{
                    label: 'Jumlah Modul',
                    data: [3, 2, 2, 3, 2, 2, 2],
                    backgroundColor: 'rgba(255, 159, 64, 0.8)', 
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ // Menggunakan yAxes di v2
                        ticks: {
                            beginAtZero: true,
                            max: 3,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Volume'
                        }
                    }],
                    xAxes: [{ // Menggunakan xAxes di v2
                        ticks: {
                            maxRotation: 45, 
                            minRotation: 45,
                        }
                    }]
                }
            }
        });
    }

    // --- 3. Sebaran Nilai Kuis (Box Plot) ---
    const ctxSebaran = document.getElementById('sebaranNilaiChart');
    if (ctxSebaran) {
        new Chart(ctxSebaran, {
            type: 'boxplot', 
            data: {
                labels: ['Literasi Indo', 'Kuantitatif', 'Penalaran Umum'],
                datasets: [{
                    label: 'Nilai Akhir',
                    data: [dataLiterasi, dataKuantitatif, dataPenalaran], 
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)', 
                        'rgba(255, 99, 132, 0.5)', 
                        'rgba(54, 162, 235, 0.5)'  
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ // Menggunakan yAxes di v2
                        ticks: {
                            beginAtZero: false,
                            min: 30,
                            max: 100,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Nilai Akhir'
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
    }


    // --- 4. Tren Penyelesaian Materi (Line Chart) ---
    const ctxTren = document.getElementById('trenPenyelesaianChart');
    if (ctxTren) {
        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4 (Ujian)'],
                datasets: [{
                    label: 'Rata-rata Penyelesaian Materi (%)',
                    data: [15, 35, 60, 90],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    lineTension: 0.4 // Menggunakan lineTension di v2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ // Menggunakan yAxes di v2
                        ticks: {
                            beginAtZero: true,
                            max: 100,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Persentase (%)'
                        }
                    }]
                }
            }
        });
    }
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
>>>>>>> aa3df1a300e26df55af4814df59176cc98f8a967
