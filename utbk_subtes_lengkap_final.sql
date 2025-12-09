-- PERHATIAN: Jalankan script ini pada database yang KOSONG atau setelah TRUNCATE tabel 
-- kursus, materi, kuis, dan tutor, dan pastikan AUTO_INCREMENT sudah diaktifkan.

-- ====================================================================
-- 1. DATA TUTOR (Diperlukan untuk FK di tabel kursus)
-- ====================================================================

-- Asumsi ID Tutor dihasilkan otomatis oleh AUTO_INCREMENT
INSERT INTO tutor (nama_tutor, email, password, no_hp, keahlian) VALUES
('Dr. Karina', 'karina.logis@instan.com', 'hashed_pw1', '08110001', 'Penalaran & Logika'),
('Bpk. Andi', 'andi.teks@instan.com', 'hashed_pw2', '08110002', 'Literasi Bahasa Indonesia & Inggris'),
('Ibu Dewi', 'dewi.mat@instan.com', 'hashed_pw3', '08110003', 'Penalaran Kuantitatif & Matematika');

-- ====================================================================
-- 2. DATA SUBTES UTBK (MENGGUNAKAN TABEL 'KURSUS')
-- Total 7 Subtes: 4 TPS, 3 Literasi
-- ====================================================================

-- KATEGORI: TPS (Tes Potensi Skolastik)
INSERT INTO kursus (id_kursus, id_tutor, nama_kursus, deskripsi, kategori, tingkat) VALUES
(101, 1, 'Penalaran Umum', 'Mengasah kemampuan berpikir logis, analitis, dibagi menjadi Induktif, Deduktif, dan Kuantitatif Dasar.', 'TPS', 'menengah'),
(102, 2, 'Pengetahuan & Pemahaman Umum', 'Menguji kemampuan memahami informasi yang kompleks dari berbagai sumber teks (Bahasa Indonesia dan Bahasa Inggris).', 'TPS', 'menengah'),
(103, 2, 'Pemahaman Bacaan dan Menulis', 'Fokus pada kemampuan berbahasa, ejaan, tata kalimat, dan koherensi dalam menulis.', 'TPS', 'menengah'),
(104, 3, 'Pengetahuan Kuantitatif', 'Materi matematika dasar tingkat SMA, termasuk aljabar, geometri, dan statistika.', 'TPS', 'menengah');

-- KATEGORI: LITERASI
INSERT INTO kursus (id_kursus, id_tutor, nama_kursus, deskripsi, kategori, tingkat) VALUES
(201, 2, 'Literasi dalam Bahasa Indonesia', 'Pemahaman mendalam terhadap berbagai jenis teks dan kemampuan menafsirkan kaidah kebahasaan.', 'LITERASI', 'menengah'),
(202, 2, 'Literasi dalam Bahasa Inggris', 'Menguji kemampuan membaca, menganalisis, dan menyimpulkan teks bahasa Inggris akademik secara kritis.', 'LITERASI', 'menengah'),
(203, 3, 'Penalaran Matematika', 'Aplikasi konsep matematika dalam situasi nyata dan pemecahan masalah yang melibatkan konteks kehidupan sehari-hari.', 'LITERASI', 'menengah');


-- ====================================================================
-- 3. DATA MATERI (Sub-Topik/Modul) DENGAN PENJELASAN PANJANG
-- Asumsi id_materi akan diisi secara otomatis
-- ====================================================================

-- MATERI UNTUK PENALARAN UMUM (ID KURSUS 101)
INSERT INTO materi (id_materi, id_kursus, judul_materi, deskripsi, link_video) VALUES
(1001, 101, 'Penalaran Induktif & Pola Bilangan', 'Penalaran Induktif adalah proses menarik kesimpulan umum (generalisasi) dari serangkaian pengamatan atau premis spesifik. Ini sering digunakan dalam ilmu pengetahuan untuk merumuskan hipotesis. **Contoh:** Kucing A berekor panjang, Kucing B berekor panjang... Kesimpulan: Semua kucing berekor panjang. Ingat, kesimpulan induktif hanya bersifat probabilitas, bukan kepastian mutlak. Anda harus mencari pola yang konsisten untuk membuat generalisasi yang kuat.', 'https://www.youtube.com/embed/d2xYWKbu9yo'),
(1002, 101, 'Silogisme dan Penalaran Deduktif', 'Penalaran Deduktif adalah proses menarik kesimpulan spesifik dari premis-premis umum yang sudah dipastikan kebenarannya. Bentuk paling umum adalah silogisme. Hukum utamanya: Jika premis benar, maka kesimpulan **pasti** benar. Anda harus fokus mencari Premis Tengah (kata kunci penghubung) untuk menentukan validitas kesimpulan.', 'https://www.youtube.com/embed/e8Z7pqKr4rk'),
(1003, 101, 'Penalaran Analitis & Pola Kuantitatif Dasar', 'Bagian analitis menguji kemampuan Anda mengatur informasi dan menarik kesimpulan dari urutan, posisi, atau hubungan sebab-akibat. Sementara pola kuantitatif dasar berfokus pada barisan angka, aritmatika, dan deret sederhana. Kunci suksesnya adalah memvisualisasikan data (misalnya dengan tabel atau diagram) dan menemukan selisih atau rasio yang konsisten dalam pola angka.', 'https://www.youtube.com/embed/4q1do98S6QU');

-- MATERI UNTUK PENGETAHUAN & PEMAHAMAN UMUM (ID KURSUS 102)
INSERT INTO materi (id_materi, id_kursus, judul_materi, deskripsi, link_video) VALUES
(1004, 102, 'Memahami Makna Kata & Analisis Teks Pendek', 'Mengenal sinonim, antonim, dan makna leksikal/gramatikal dalam Bahasa Indonesia. Bagian analisis teks pendek menguji kecepatan Anda menangkap informasi tersembunyi (tersirat) dan eksplisit (tersurat) dari paragraf singkat.', 'https://www.youtube.com/embed/O39yXnadd_0'),
(1005, 102, 'Struktur Kalimat Efektif & Pemahaman Teks B. Inggris', 'Analisis pola kalimat SPOK dan menghindari ambiguitas (kalimat tidak efektif). Untuk Bahasa Inggris, fokus pada pemahaman teks non-akademik, seperti berita atau informasi umum, dan mencari ide pokoknya.', 'https://www.youtube.com/embed/mMK9d62KHYk'),
(1006, 102, 'Penyuntingan Ejaan & Tanda Baca (PPU)', 'Fokus pada ejaan dan tata bahasa yang sering muncul di PPU, termasuk penggunaan kata baku dan serapan.', 'LINK_PPU_EB');


-- MATERI UNTUK PEMAHAMAN BACAAN DAN MENULIS (ID KURSUS 103)
INSERT INTO materi (id_materi, id_kursus, judul_materi, deskripsi, link_video) VALUES
(1007, 103, 'Ejaan (PUEBI/EYD V) dan Tanda Baca', 'Ini adalah fondasi penulisan. Pelajari secara detail aturan penggunaan huruf kapital, pemenggalan kata, dan fungsi tanda baca (terutama koma dan titik) agar penulisan Anda sesuai kaidah baku.', 'https://www.youtube.com/embed/mogAO0SVvNM'),
(1008, 103, 'Kepaduan dan Konsistensi Paragraf', 'Kepaduan melibatkan kohesi (keterikatan bentuk, misal penggunaan kata ganti) dan koherensi (keterikatan makna). Fokus pada kata transisi (konjungsi) yang menghubungkan ide antar kalimat dan antar paragraf.', 'https://www.youtube.com/embed/Ny3QB6KCzUg'),
(1009, 103, 'Meringkas Teks dan Menentukan Judul', 'Strategi untuk memadatkan informasi dan memilih judul yang paling sesuai dengan isi paragraf.', 'LINK_PBM_MT');


-- MATERI UNTUK PENGETAHUAN KUANTITATIF (ID KURSUS 104)
INSERT INTO materi (id_materi, id_kursus, judul_materi, deskripsi, link_video) VALUES
(1010, 104, 'Aljabar, Fungsi, dan Persamaan Dasar', 'Mencakup manipulasi persamaan linier, kuadrat, dan penerapan dasar fungsi. Fokus pada bagaimana cara tercepat memecahkan sistem persamaan dan pertidaksamaan.', 'https://www.youtube.com/embed/xoHt137BXJE'),
(1011, 104, 'Geometri, Statistika, dan Peluang', 'Materi ini menguji ingatan rumus geometri dasar dan kemampuan menghitung peluang serta statistika sederhana (mean, median, modus, kuartil).', 'https://www.youtube.com/embed/P88cTOZEukE'),
(1012, 104, 'Numerik dan Pola Lanjutan', 'Memecahkan masalah yang melibatkan perbandingan kuantitatif dan analisis pola bilangan yang lebih kompleks.', 'LINK_PK_NL');


-- MATERI UNTUK LITERASI DALAM BAHASA INDONESIA (ID KURSUS 201)
INSERT INTO materi (id_materi, id_kursus, judul_materi, deskripsi, link_video) VALUES
(2001, 201, 'Analisis Struktur dan Tujuan Teks', 'Mengidentifikasi jenis teks (argumentasi, narasi, eksposisi) dan menemukan tujuan utama penulis. Ini melibatkan pembedaan antara klaim (opini) dan fakta (bukti) dalam teks.', 'https://www.youtube.com/embed/KOtM0X8oNqI'),
(2002, 201, 'Inferensi dan Kesimpulan Teks', 'Inferensi adalah kesimpulan logis yang tidak tertulis secara eksplisit. Anda harus menggunakan bukti-bukti dalam teks untuk menarik kesimpulan yang valid.', 'https://www.youtube.com/embed/bsW1hPDZwbs');

-- MATERI UNTUK LITERASI DALAM BAHASA INGGRIS (ID KURSUS 202)
INSERT INTO materi (id_materi, id_kursus, judul_materi, deskripsi, link_video) VALUES
(2003, 202, 'Reading Comprehension: Main Idea & Author\'s Tone', 'Fokus pada kecepatan membaca untuk menangkap ide utama dan menentukan nada (tone) atau sikap penulis terhadap topik yang dibahas (misal: kritis, netral, sinis).', 'https://www.youtube.com/embed/4swFGRhQoMI'),
(2004, 202, 'Vocabulary and Context Clues', 'Strategi untuk menyimpulkan arti kata-kata yang tidak dikenal berdasarkan konteks kalimat dan paragraf di sekitarnya.', 'https://www.youtube.com/embed/CiNggzdWkIo');

-- MATERI UNTUK PENALARAN MATEMATIKA (ID KURSUS 203)
INSERT INTO materi (id_materi, id_kursus, judul_materi, deskripsi, link_video) VALUES
(2005, 203, 'Pemodelan Matematika (Penerapan Konteks)', 'Mempelajari cara menerjemahkan masalah dunia nyata (misalnya, masalah biaya, waktu, atau populasi) menjadi formula atau model matematika (persamaan/fungsi) yang dapat dipecahkan.', 'https://www.youtube.com/embed/gRkTXe-lwhI'),
(2006, 203, 'Analisis Data dan Logika Numerik', 'Keterampilan membaca dan menafsirkan data dari grafik, tabel, dan diagram. Fokus pada perbandingan, rasio, dan persentase dalam konteks pemecahan masalah.', 'https://www.youtube.com/embed/CVZ78VqpP_w');


-- ====================================================================
-- 4. DATA KUIS (TOTAL 70 Pertanyaan = 10 per Subtes)
-- Asumsi kuis ID akan diisi secara otomatis
-- ====================================================================

-- KUIS 1: PENALARAN UMUM (ID KURSUS 101) - 10 Soal
INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(1001, 'Jika semua A adalah B, dan semua B adalah C, maka semua A adalah C. Ini adalah contoh dari penalaran:', 'Induktif', 'Deduktif', 'Analogis', 'Kuantitatif', 'B'),
(1001, 'Urutan angka yang tepat: 2, 5, 11, 23, ...', '40', '47', '52', '60', 'B'),
(1002, 'Semua siswa Instan lulus PTN. Ani adalah siswa Instan. Kesimpulan yang tepat adalah:', 'Ani tidak lulus PTN', 'Beberapa siswa Instan tidak lulus PTN', 'Ani lulus PTN', 'Ani mungkin lulus PTN', 'C'),
(1002, 'Pola: Z, X, V, T, ...', 'R', 'S', 'U', 'W', 'A'),
(1002, 'Jika lampu merah menyala, mobil berhenti. Lampu merah menyala. Maka, ...', 'Mobil harus jalan', 'Mobil tidak harus berhenti', 'Mobil berhenti', 'Lampu harus hijau', 'C'),
(1002, 'Jika Ani lulus, ia akan senang. Ternyata Ani tidak senang. Maka, ...', 'Ani pasti tidak lulus', 'Ani mungkin lulus', 'Ani pasti lulus', 'Tidak dapat ditarik kesimpulan valid.', 'A'),
(1003, 'Jika X lebih besar dari Y, dan Y lebih kecil dari Z, manakah yang pasti benar?', 'X lebih besar dari Z', 'Y adalah yang terkecil', 'X dan Z tidak dapat dibandingkan', 'Z lebih besar dari X', 'C'),
(1003, 'Di antara pilihan berikut, manakah yang paling tidak memiliki kesamaan?', 'Jambu', 'Mangga', 'Anggur', 'Kentang', 'D'),
(1001, 'Jika pernyataan "Beberapa Sapi berwarna putih" benar, manakah yang pasti salah?', 'Semua Sapi berwarna putih.', 'Tidak ada Sapi yang berwarna putih.', 'Beberapa Sapi tidak berwarna putih.', 'Beberapa Sapi berwarna hitam.', 'B'),
(1002, 'Premis Mayor: Semua yang rajin belajar lulus UTBK. Premis Minor: Rina lulus UTBK. Kesimpulan yang paling mungkin:', 'Rina pasti rajin belajar.', 'Rina mungkin rajin belajar.', 'Rina pasti tidak rajin belajar.', 'Semua yang lulus UTBK adalah Rina.', 'B');

-- KUIS 2: PENGETAHUAN & PEMAHAMAN UMUM (ID KURSUS 102) - 10 Soal
INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(1004, 'Antonim dari kata "Eskalasi" adalah:', 'Peningkatan', 'Penyebaran', 'Penurunan', 'Percepatan', 'C'),
(1004, 'Kata "konjungsi" dalam Bahasa Indonesia merujuk pada:', 'Kata benda', 'Kata kerja', 'Kata hubung', 'Kata sifat', 'C'),
(1004, 'Dalam konteks paragraf, kata "inklusif" memiliki makna:', 'Eksklusif', 'Terpisah', 'Meliputi atau mencakup', 'Sempit', 'C'),
(1005, 'Kalimat yang paling efektif dan hemat kata adalah:', 'Sejak dari tadi pagi, ia sudah menunggu.', 'Dari tadi pagi, ia sudah menunggu.', 'Sejak tadi pagi, ia sudah menunggu.', 'Sejak dari tadi, ia sudah menunggu.', 'C'),
(1005, 'Kesalahan pada kalimat "Bagi siswa baru harap segera mendaftar." adalah:', 'Kurangnya subjek', 'Penggunaan kata "bagi"', 'Kurangnya predikat', 'Terlalu panjang', 'B'),
(1005, 'Kalimat yang subjeknya adalah "Pemerintah" adalah:', 'Kebijakan baru telah ditetapkan oleh pemerintah.', 'Pemerintah menetapkan kebijakan baru.', 'Ditetapkannya kebijakan baru oleh pemerintah.', 'Kebijakan baru pemerintah sangat baik.', 'B'),
(1006, 'Tanda koma harus digunakan sebelum konjungsi:', 'Sejak', 'Karena', 'Oleh karena itu', 'Agar', 'C'),
(1006, 'The passage mainly discusses:', 'Topic Sentence', 'Main Idea', 'Supporting Details', 'Inference', 'B'),
(1006, 'The word "crucial" in paragraph 2 is closest in meaning to:', 'Unimportant', 'Trivial', 'Essential', 'Difficult', 'C'),
(1006, 'The author\'s primary purpose in writing the text is:', 'To persuade', 'To inform', 'To entertain', 'To describe', 'B');

-- KUIS 3: PEMAHAMAN BACAAN DAN MENULIS (ID KURSUS 103) - 10 Soal
INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(1007, 'Penggunaan huruf kapital yang benar terdapat pada kalimat:', 'Kami merayakan Hari Kemerdekaan.', 'Kami merayakan hari kemerdekaan.', 'Kami merayakan hari Kemerdekaan.', 'Kami merayakan idul Fitri.', 'A'),
(1007, 'Penulisan kata yang benar sesuai PUEBI adalah:', 'Tehnologi', 'Kwalitas', 'Sistim', 'Sistem', 'D'),
(1007, 'Tanda baca yang tepat untuk memisahkan anak kalimat dari induk kalimat, jika anak kalimat mendahului induk kalimat, adalah:', 'Titik (.)', 'Koma (,)', 'Titik Koma (;)', 'Tanda Seru (!)', 'B'),
(1008, 'Penulisan bilangan yang benar dalam teks (bukan data) adalah:', 'Terdapat 5 jenis ikan.', 'Terdapat lima jenis ikan.', 'Terdapat Lima jenis ikan.', 'Terdapat 5 Ikan.', 'B'),
(1008, 'Kalimat yang paling baik untuk mengawali paragraf adalah:', 'Oleh karena itu, masalah ini harus diselesaikan.', 'Masalah ini sangat penting untuk dibahas.', 'Kemudian, kita akan melihat dampaknya.', 'Jadi, hal tersebut harus dicegah.', 'B'),
(1008, 'Kata transisi yang menunjukkan hubungan pertentangan adalah:', 'Selain itu', 'Oleh sebab itu', 'Namun', 'Dengan demikian', 'C'),
(1009, 'Kepaduan paragraf sering disebut juga dengan istilah:', 'Kohesi dan koherensi', 'Fakta dan opini', 'Sintaksis dan morfologi', 'Diksi dan ejaan', 'A'),
(1009, 'Kata baku yang benar dari "resiko" adalah:', 'Risiko', 'Resiko', 'Rissiko', 'Risikoo', 'A'),
(1009, 'Penulisan kata "kwalitas" yang benar menurut bahasa baku adalah:', 'Kwalitas', 'Qualitas', 'Kualitas', 'Kualitaas', 'C'),
(1007, 'Dalam PUEBI, penulisan nama geografi yang diikuti nama jenis ditulis terpisah, contohnya:', 'Sungai Citarum', 'DanauToba', 'GunungSemeru', 'PulauSumatra', 'A');

-- KUIS 4: PENGETAHUAN KUANTITATIF (ID KURSUS 104) - 10 Soal
INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(1010, 'Jika 2x - 3 = 11, maka nilai dari x adalah:', '5', '7', '8', '14', 'B'),
(1010, 'Faktor dari persamaan kuadrat x² - 5x + 6 = 0 adalah:', '(x-2)(x-3)', '(x+2)(x-3)', '(x-1)(x+6)', '(x+1)(x-6)', 'A'),
(1010, 'Pertidaksamaan yang mewakili "bilangan kurang dari 10" adalah:', 'x ≥ 10', 'x > 10', 'x ≤ 10', 'x < 10', 'D'),
(1010, 'Jika f(x) = 3x - 1, maka f(4) adalah:', '10', '11', '12', '13', 'B'),
(1011, 'Keliling persegi dengan luas 16 cm² adalah:', '12 cm', '16 cm', '20 cm', '24 cm', 'B'),
(1011, 'Perbandingan usia A dan B adalah 2:3. Jika usia B adalah 18 tahun, usia A adalah:', '12 tahun', '15 tahun', '16 tahun', '27 tahun', 'A'),
(1011, 'Jika jari-jari lingkaran diperbesar 2 kali, maka luasnya diperbesar menjadi:', '2 kali', '3 kali', '4 kali', '8 kali', 'C'),
(1012, 'Median dari data: 2, 5, 8, 3, 10 adalah:', '3', '5', '8', '10', 'B'),
(1012, 'Peluang munculnya mata dadu genap saat melempar satu dadu adalah:', '1/6', '1/3', '1/2', '2/3', 'C'),
(1012, 'Rata-rata (mean) dari data 4, 6, 7, 8, 10 adalah:', '7', '8', '9', '10', 'A');


-- KUIS 5: LITERASI DALAM BAHASA INDONESIA (ID KURSUS 201) - 10 Soal
INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(2001, 'Gagasan utama atau pesan sentral dari sebuah paragraf disebut:', 'Fakta', 'Opini', 'Ide Pokok', 'Klausa', 'C'),
(2001, 'Kalimat yang dapat dibuktikan kebenarannya dan tidak mengandung penafsiran pribadi disebut:', 'Kalimat Perintah', 'Kalimat Opini', 'Kalimat Fakta', 'Kalimat Majemuk', 'C'),
(2001, 'Kata yang menunjukkan hubungan sebab-akibat dalam teks argumentatif adalah:', 'Walaupun', 'Sejak', 'Oleh karena itu', 'Maka', 'C'),
(2001, 'Jenis teks yang bertujuan untuk mempengaruhi pembaca agar menyetujui pendapat penulis adalah:', 'Teks Narasi', 'Teks Deskripsi', 'Teks Argumentasi', 'Teks Eksposisi', 'C'),
(2001, 'Jika sebuah paragraf dimulai dengan pernyataan umum diikuti contoh-contoh spesifik, paragraf tersebut menggunakan pola pengembangan:', 'Deduktif', 'Induktif', 'Analogi', 'Perbandingan', 'B'),
(2002, 'Penyusunan kalimat yang benar berdasarkan PUEBI adalah:', 'Ia membeli buku, dan pulpen.', 'Ia membeli buku dan pulpen.', 'Ia membeli buku, dan pulpen,', 'Ia, membeli buku dan pulpen.', 'B'),
(2002, 'Kata baku yang benar dari "apotik" adalah:', 'Apotik', 'Apotek', 'Apotekum', 'Aphotik', 'B'),
(2002, 'Kata serapan dari Bahasa Inggris yang sudah dibakukan adalah:', 'Analyze', 'Analisa', 'Analisis', 'Analizing', 'C'),
(2002, 'Kalimat yang efektif dan tidak boros adalah:', 'Mereka berdua saling berpelukan.', 'Mereka saling berpelukan.', 'Mereka berdua berpelukan.', 'Saling berpelukan bersama.', 'B'),
(2002, 'Inferensi yang paling kuat dari sebuah teks yang berisi data statistik tentang penurunan jumlah pembeli adalah:', 'Penjual tidak melakukan promosi.', 'Daya beli masyarakat menurun.', 'Produk yang dijual tidak laku.', 'Penjual harus pindah lokasi.', 'B');

-- KUIS 6: LITERASI DALAM BAHASA INGGRIS (ID KURSUS 202) - 10 Soal
INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(2003, 'Which of the following best states the main idea of the passage?', 'Detail 1', 'Supporting Claim', 'Central Topic', 'Minor Argument', 'C'),
(2003, 'The author uses the example of "local farming" primarily to:', 'Provide contrast', 'Illustrate a point', 'Introduce a new topic', 'Cite a source', 'B'),
(2003, 'The second paragraph mainly serves to:', 'Summarize the introduction', 'Refute the main argument', 'Expand on a specific claim', 'Conclude the passage', 'C'),
(2003, 'Which detail does NOT support the author\'s primary assertion?', 'A fact', 'A quote', 'An unrelated anecdote', 'A statistic', 'C'),
(2003, 'According to the text, the most significant factor contributing to global change is:', 'Social media', 'Climate shifts', 'Economic policies', 'Political unrest', 'B'),
(2004, 'The word "ubiquitous" in line 10 most likely means:', 'Scarce', 'Rare', 'Widespread', 'Confined', 'C'),
(2004, 'Based on the context, what does the phrase "paradigm shift" imply?', 'A small adjustment', 'A complete change in pattern', 'A temporary pause', 'A return to tradition', 'B'),
(2004, 'The word "detrimental" suggests something is:', 'Helpful', 'Harmful', 'Neutral', 'Beneficial', 'B'),
(2004, 'The synonym for "mitigate" is:', 'Worsen', 'Aggravate', 'Alleviate', 'Intensify', 'C'),
(2004, 'When the author mentions a "dichotomy," they are referring to:', 'Unity', 'Agreement', 'A contrast between two things', 'A single item', 'C');

-- KUIS 7: PENALARAN MATEMATIKA (ID KURSUS 203) - 10 Soal
INSERT INTO kuis (id_materi, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) VALUES
(2005, 'Sebuah perusahaan menjual X produk dengan biaya y = 5000X + 10000. Jika produk terjual 50 unit, berapa total biaya?', 'Rp 260.000', 'Rp 250.000', 'Rp 270.000', 'Rp 300.000', 'A'),
(2005, 'Debit air 5 liter per menit. Berapa lama waktu yang dibutuhkan untuk mengisi bak 150 liter?', '20 menit', '30 menit', '40 menit', '50 menit', 'B'),
(2005, 'Seorang pedagang membeli 5 kg apel seharga Rp 100.000 dan menjualnya dengan untung 20%. Harga jual per kg apel adalah?', 'Rp 20.000', 'Rp 22.000', 'Rp 24.000', 'Rp 25.000', 'C'),
(2005, 'Jika A = {1, 2, 3} dan B = {4, 5}, berapa banyak pasangan berurutan yang mungkin dari A x B?', '5', '6', '7', '8', 'B'),
(2005, 'Dalam sebuah tim berisi 5 orang, hanya 2 posisi yang tersedia. Berapa banyak cara memilih 2 orang tersebut?', '10', '20', '30', '40', 'A'),
(2006, 'Jika diagram lingkaran menunjukkan 30% siswa menyukai matematika, berapa derajat sudut pusat untuk kategori ini?', '90°', '108°', '120°', '150°', 'B'),
(2006, 'Rata-rata nilai 5 siswa adalah 80. Jika nilai satu siswa (90) dikeluarkan, berapa rata-rata 4 siswa sisanya?', '75.0', '76.5', '77.5', '78.0', 'C'),
(2006, 'Berapa persentase 25 dari 200?', '10%', '12.5%', '15%', '20%', 'B'),
(2006, 'Berdasarkan tabel distribusi frekuensi, manakah yang merupakan nilai median?', 'Nilai yang paling sering muncul', 'Nilai tengah data setelah diurutkan', 'Jumlah semua data dibagi banyaknya data', 'Selisih nilai tertinggi dan terendah', 'B'),
(2006, 'Jika data 5, 7, 7, 8, 8, 10. Berapakah nilai modusnya?', '7', '8', '7 dan 8', '9', 'C');
-- PERINGATAN: Pastikan script ini dijalankan setelah script utbk_subtes_lengkap_final.sql.
-- KOREKSI: Mengganti format youtu.be/d2xYWKbu9yo?si=... menjadi format embed/d2xYWKbu9yo

-- ====================================================================
-- 1. PENALARAN UMUM (ID KURSUS 101)
-- ====================================================================

-- ID MATERI 1001: Penalaran Induktif & Pola Bilangan
UPDATE materi SET link_video = 'https://www.youtube.com/embed/d2xYWKbu9yo' WHERE id_materi = 1001;

-- ID MATERI 1002: Silogisme dan Penalaran Deduktif
UPDATE materi SET link_video = 'https://www.youtube.com/embed/e8Z7pqKr4rk' WHERE id_materi = 1002;

-- ID MATERI 1003: Penalaran Analitis & Pola Kuantitatif Dasar
UPDATE materi SET link_video = 'https://www.youtube.com/embed/4q1do98S6QU' WHERE id_materi = 1003;


-- ====================================================================
-- 2. PENGETAHUAN & PEMAHAMAN UMUM (ID KURSUS 102)
-- ====================================================================

-- ID MATERI 1004: Memahami Makna Kata & Analisis Teks Pendek
UPDATE materi SET link_video = 'https://www.youtube.com/embed/O39yXnadd_0' WHERE id_materi = 1004;

-- ID MATERI 1005: Struktur Kalimat Efektif & Pemahaman Teks B. Inggris
UPDATE materi SET link_video = 'https://www.youtube.com/embed/mMK9d62KHYk' WHERE id_materi = 1005;


-- ====================================================================
-- 3. PEMAHAMAN BACAAN DAN MENULIS (ID KURSUS 103)
-- ====================================================================

-- ID MATERI 1006: Ejaan (PUEBI/EYD V) dan Tanda Baca
UPDATE materi SET link_video = 'https://www.youtube.com/embed/mogAO0SVvNM' WHERE id_materi = 1006;

-- ID MATERI 1007: Kepaduan dan Konsistensi Paragraf
UPDATE materi SET link_video = 'https://www.youtube.com/embed/Ny3QB6KCzUg' WHERE id_materi = 1007;


-- ====================================================================
-- 4. PENGETAHUAN KUANTITATIF (ID KURSUS 104)
-- ====================================================================

-- ID MATERI 1008: Aljabar, Fungsi, dan Persamaan Dasar
UPDATE materi SET link_video = 'https://www.youtube.com/embed/xoHt137BXJE' WHERE id_materi = 1008;

-- ID MATERI 1009: Geometri, Statistika, dan Peluang
UPDATE materi SET link_video = 'https://www.youtube.com/embed/P88cTOZEukE' WHERE id_materi = 1009;


-- ====================================================================
-- 5. LITERASI DALAM BAHASA INDONESIA (ID KURSUS 201)
-- ====================================================================

-- ID MATERI 2001: Analisis Struktur dan Tujuan Teks
UPDATE materi SET link_video = 'https://www.youtube.com/embed/KOtM0X8oNqI' WHERE id_materi = 2001;

-- ID MATERI 2002: Inferensi dan Kesimpulan Teks
UPDATE materi SET link_video = 'https://www.youtube.com/embed/bsW1hPDZwbs' WHERE id_materi = 2002;


-- ====================================================================
-- 6. LITERASI DALAM BAHASA INGGRIS (ID KURSUS 202)
-- ====================================================================

-- ID MATERI 2003: Reading Comprehension: Main Idea & Author's Tone
UPDATE materi SET link_video = 'https://www.youtube.com/embed/4swFGRhQoMI' WHERE id_materi = 2003;

-- ID MATERI 2004: Vocabulary and Context Clues
UPDATE materi SET link_video = 'https://www.youtube.com/embed/CiNggzdWkIo' WHERE id_materi = 2004;


-- ====================================================================
-- 7. PENALARAN MATEMATIKA (ID KURSUS 203)
-- ====================================================================

-- ID MATERI 2005: Pemodelan Matematika (Penerapan Konteks)
UPDATE materi SET link_video = 'https://www.youtube.com/embed/gRkTXe-lwhI' WHERE id_materi = 2005;

-- ID MATERI 2006: Analisis Data dan Logika Numerik
UPDATE materi SET link_video = 'https://www.youtube.com/embed/CVZ78VqpP_w' WHERE id_materi = 2006;