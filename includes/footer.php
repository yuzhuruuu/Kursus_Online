<?php
// includes/footer.php
?>
<!-- includes/footer.php -->
</div> <!-- Menutup div.container mt-4 dari header -->

<!-- Pastikan footer menggunakan variabel CSS yang konsisten -->
<footer class="footer mt-auto py-5" style="background-color: var(--dicoding-soft, #f0f0f0); border-top: 1px solid #e9ecef;">
    <div class="container">
        <div class="row">
            <!-- Kolom 1: Logo & Alamat -->
            <div class="col-md-4 mb-4">
                <h4 style="color: var(--dicoding-dark, #0b1c31); font-weight: 700;">Instan UTBK</h4>
                <p class="small text-muted">
                    Jl. Teknologi Digital No. 101,<br>
                    Kota Semarang, Jawa Tengah 40123
                </p>
                <div class="mt-3">
                    <!-- Placeholder Ikon Sosial Media -->
                    <a href="#" class="text-muted me-2"><img src="https://placehold.co/20x20/cccccc/0b1c31?text=IG" alt="Instagram"></a>
                    <a href="#" class="text-muted me-2"><img src="https://placehold.co/20x20/cccccc/0b1c31?text=TW" alt="Twitter"></a>
                    <a href="#" class="text-muted me-2"><img src="https://placehold.co/20x20/cccccc/0b1c31?text=FB" alt="Facebook"></a>
                </div>
            </div>

            <!-- Kolom 2: Informasi Kursus (Revisi Konten ke UTBK) -->
            <div class="col-md-2 col-6 mb-4">
                <h6 class="fw-bold mb-3" style="color: var(--dicoding-dark, #0b1c31);">Program UTBK</h6>
                <ul class="list-unstyled">
                    <li><a href="/project-SBD/public/kursus.php" class="text-muted small text-decoration-none">Semua Subtes</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Pilihan Saintek</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Pilihan Soshum</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Perusahaan -->
            <div class="col-md-2 col-6 mb-4">
                <h6 class="fw-bold mb-3" style="color: var(--dicoding-dark, #0b1c31);">Perusahaan</h6>
                <ul class="list-unstyled">
                    <li><a href="/project-SBD/pages/about.php" class="text-muted small text-decoration-none">Tentang Kami</a></li> 
                    <li><a href="#" class="text-muted small text-decoration-none">Hubungi Kami</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Tutor Kami</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Bantuan & Legal -->
            <div class="col-md-4 mb-4">
                <h6 class="fw-bold mb-3" style="color: var(--dicoding-dark, #0b1c31);">Bantuan & Legal</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted small text-decoration-none">FAQ</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-muted small text-decoration-none">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Baris Hak Cipta Bawah -->
        <hr class="text-muted">
        <div class="row">
            <div class="col-12 text-center text-muted small">
                © <?= date("Y"); ?> Instan. All rights reserved. 
            </div>
        </div>
    </div>
</footer>

</body>
</html>