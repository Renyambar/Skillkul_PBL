## 🎓 [SkillKul] - Marketplace Jasa Mahasiswa

[SkillKul] adalah platform _marketplace_ jasa berbasis web yang dirancang khusus untuk memfasilitasi transaksi *freelance* antar mahasiswa. Proyek ini dikembangkan sebagai pemenuhan tugas Project-Based Learning (PBL) D4 Teknik Informatika.

Berbeda dengan marketplace freelance pada umumnya, platform ini mengusung fitur spesifik yang menyesuaikan dengan gaya hidup dan batasan waktu mahasiswa, seperti **Mode Ujian (Auto-Busy)**, **Pembuatan Portofolio Otomatis**, dan **Split Checkout** untuk fleksibilitas negosiasi.

---

 ✨ Fitur Unggulan (Core Features)

1. **Split Checkout Flow (Project vs Non-Project)**
   * **Non-Project:** Jasa dengan harga tetap. Klien langsung *checkout*, mengisi formulir instruksi, melampirkan *link* bahan (Google Drive), dan membayar.
   * **Project:** Jasa dengan spesifikasi kompleks. Klien diarahkan ke WhatsApp untuk negosiasi harga. Setelah *deal*, *Freelancer* membuat **Custom Invoice** di dalam sistem untuk dibayar oleh klien.
2. **Auto-Busy & Mode Ujian (Concurrency Limit)**
   Sistem mengunci profil *Freelancer* (tombol pesan dinonaktifkan) jika mereka sedang menyalakan "Mode Ujian" atau sedang mengerjakan 1 pesanan aktif. Ini mencegah *overwork* pada mahasiswa.
3. **Escrow Payment System (Midtrans Integration)**
   Keamanan transaksi dijamin. Uang klien ditahan oleh sistem (Admin/Escrow) menggunakan API Midtrans dan baru akan diteruskan ke saldo *Wallet Freelancer* setelah pesanan diselesaikan dan diterima klien.
4. **Auto-Portfolio Generator (PDF)**
   Sistem secara otomatis merangkum riwayat pesanan yang berstatus selesai dan mendapat *rating* bintang 4+ menjadi dokumen CV/Portofolio berformat PDF untuk keperluan magang/karir mahasiswa.

---

## 🔄 Alur Bisnis (Business Workflow)

### 1. Pendaftaran & Buka Jasa
* Mahasiswa mendaftar dan melengkapi profil.
* *Freelancer* membuat etalase jasa dan menentukan tipenya: **Project** (Bisa Nego) atau **Non-Project** (Harga Pas).

### 2. Proses Pemesanan
* **Jalur Non-Project:** Klien mencari jasa -> Klik "Pesan" -> Isi catatan & *link* file bahan -> *Checkout* -> Bayar via Midtrans.
* **Jalur Project:** Klien mencari jasa -> Klik "Nego via WA" -> Diskusi di WhatsApp -> *Freelancer* membuat *Custom Invoice* di sistem -> Klien mendapat *link checkout* -> Bayar via Midtrans.

### 3. Pengerjaan & Penyerahan
* Uang diamankan oleh sistem (Status: `In Progress`).
* *Freelancer* otomatis masuk ke mode "Sibuk" agar tidak menerima pesanan lain.
* Setelah selesai, *Freelancer* mengunggah *link* hasil pekerjaan (Google Drive) ke dalam sistem (Status: `Delivered`).

### 4. Penyelesaian & Pencairan
* Klien meninjau hasil dan menekan "Pesanan Diterima".
* Klien memberikan ulasan dan *rating* bintang 1-5.
* Saldo secara otomatis masuk ke dompet digital (*Wallet*) *Freelancer*.
* Jika *rating* >= 4, data proyek otomatis masuk ke *Database* Portofolio *Freelancer* untuk dicetak menjadi PDF.

---

## 💻 Tech Stack

* **Frontend:** [Contoh: HTML, Tailwind CSS, JavaScript]
* **Backend:** [Contoh: Laravel 11 / Node.js Express]
* **Database:** [Contoh: MySQL]
* **Payment Gateway:** Midtrans (Snap & Webhook API)
* **PDF Generator:** [Contoh: dompdf / puppeteer]

---

## 👥 Tim Pengembang (Kelompok PBL 3 - TI2F)

1. **[Reny Ambarwati]** - [244107010066]
2. **[Mokhamad Rizki Hadiono Singgih]** - [244107020198]
3. **[Marta Prama Daniswara]** - [244107020205]
4. **[Destian Dwi Mahardika]** - [244107020203]

---

## 🚀 Cara Instalasi (Local Development)

1. Clone repositori ini:
   `git clone https://github.com/username/repo-name.git`
2. Install dependencies:
   `[Contoh: composer install / npm install]`
3. Salin `.env.example` menjadi `.env` dan atur koneksi database serta *Keys* Midtrans Anda.
4. Jalankan migrasi dan seeder:
   `[Contoh: php artisan migrate --seed]`
5. Jalankan server lokal:
   `[Contoh: php artisan serve]`
   
 ## 📅 Timeline Pengerjaan (8 Minggu Sprints)

Proyek ini dikerjakan secara kolaboratif menggunakan pendekatan *Feature-Based* oleh 4 anggota tim. Berikut adalah peta jalan (*roadmap*) pengerjaannya:

### 🚀 Sprint 1: Perancangan & Setup Awal (Minggu 1)
- [ ] Pembuatan skema database (ERD) dan alur sistem (UML).
- [ ] Setup Repository GitHub dan instalasi framework backend/frontend.
- [ ] Pembuatan Wireframe dan penentuan palet warna UI.

### 🔐 Sprint 2: Autentikasi & Profil (Minggu 2)
- [ ] Slicing UI untuk halaman Register, Login, dan Profil.
- [ ] Implementasi sistem Autentikasi (Hash Password & Session/Token).
- [ ] Logika CRUD untuk pengaturan profil User dan foto.

### 📦 Sprint 3: Katalog Jasa (Minggu 3)
- [ ] Pembuatan form Tambah Jasa dengan pemisahan tipe `Project` dan `Non-Project`.
- [ ] Pembuatan halaman Beranda untuk menampilkan etalase jasa.
- [ ] Implementasi fitur pencarian dan filter jasa.

### 🚦 Sprint 4: Fitur Unik & State Management (Minggu 4)
- [ ] Implementasi *toggle* "Mode Ujian" di halaman profil Freelancer.
- [ ] Pembuatan logika "Auto-Busy" (Locking System) agar tombol pesan nonaktif saat Freelancer mengerjakan pesanan aktif.

### 🛒 Sprint 5: Split Checkout & Transaksi (Minggu 5)
- [ ] Pembuatan form *checkout* langsung (catatan & link GDrive) untuk jasa Non-Project.
- [ ] Pembuatan fitur "Custom Invoice" oleh Freelancer untuk jasa Project hasil nego WhatsApp.
- [ ] Persiapan akun sandbox Payment Gateway (Midtrans).

### 💳 Sprint 6: Integrasi Payment Gateway (Minggu 6)
- [ ] Menghubungkan sistem pemesanan dengan API Midtrans (mendapatkan Snap Token).
- [ ] Menampilkan pop-up pembayaran di sisi Klien.
- [ ] Setup Webhook Midtrans agar status `Pending` otomatis berubah menjadi `Paid`.

### 📄 Sprint 7: Penyelesaian & Portofolio (Minggu 7)
- [ ] Pembuatan fitur unggah hasil kerja dan tombol "Pesanan Diterima".
- [ ] Fitur Rating dan Ulasan dari Klien.
- [ ] Logika penambahan uang ke saldo Wallet Freelancer (Escrow release).
- [ ] Auto-Generate data pesanan selesai menjadi PDF Portofolio/CV.

### 🎯 Sprint 8: QA, Bug Fixing & Deployment (Minggu 8)
- [ ] User Acceptance Testing (UAT) dan perbaikan *bug*.
- [ ] Input data *dummy* yang rapi untuk keperluan demo.
- [ ] Deployment aplikasi ke server *hosting* atau VPS.
- [ ] Finalisasi penyusunan dokumen Laporan PBL.


## 👥 Contribution

Pengembangan proyek ini dilakukan secara kolaboratif oleh 4 anggota tim. Berikut adalah rincian kontribusi masing-masing anggota berdasarkan *commit* yang telah dilakukan di repositori GitHub.

---

### 1. Reny Ambarwati (`Renyambar`)

Bertanggung jawab sebagai **pengembang backend utama** sekaligus **project manager** teknis yang memastikan fondasi sistem dan integrasi pembayaran berjalan dengan baik.

-**First Commit & Inisialisasi Proyek** — Melakukan *first commit* sebagai permulaan proyek, membuat repositori GitHub tim, dan menyiapkan kerangka dasar proyek untuk kolaborasi antar anggota.
-**Setup Struktur Folder** — Menyusun dan mengatur ulang struktur folder proyek (`change folder` & `revisi folder`) agar lebih terorganisir, mengikuti konvensi Laravel, dan mudah dikelola oleh seluruh anggota tim.
-**Instalasi Laravel Breeze (Login & Register)** — Menginstalasi **Laravel Breeze** sebagai fondasi sistem autentikasi berbasis session, menyediakan halaman login, register, dan manajemen sesi pengguna secara langsung.
-**Membuat Controller & Routes** — Membuat seluruh **controller** dan **routes** dasar yang menjadi kerangka navigasi aplikasi, memastikan setiap endpoint terdefinisi dengan rapi dan siap dikembangkan lebih lanjut.
-**Menambahkan Main Layout (Navbar & Footer)** — Membangun komponen **main layout** yang mencakup navbar responsif dan footer konsisten yang digunakan secara global di seluruh halaman aplikasi.
-**Sistem Autentikasi Berbasis NIM Mahasiswa** — Mengembangkan **sistem login & register khusus berbasis NIM** mahasiswa, sehingga hanya mahasiswa terdaftar dengan identitas terverifikasi yang dapat mengakses platform.
-**Tampilan Dashboard Admin** — Membuat **tampilan halaman Dashboard Admin** yang menampilkan ringkasan data platform, statistik pengguna, dan panel navigasi untuk pengelolaan sistem.
-**Fungsionalitas CRUD Layanan Jasa** — Membangun fungsionalitas **CRUD lengkap untuk layanan jasa** di sisi admin, memungkinkan administrator menambahkan, mengedit, menghapus, dan mengelola seluruh jasa yang terdaftar.
-**Admin Panel** — Mengintegrasikan semua fitur menjadi **Admin Panel** yang utuh, memberikan administrator akses penuh untuk memvalidasi, memantau, dan menonaktifkan akun maupun jasa di platform.
-**Setup Midtrans Sandbox** — Melakukan konfigurasi awal akun **Midtrans Sandbox** beserta pengaturan API keys di environment untuk persiapan integrasi payment gateway pada tahap berikutnya.
-**SNAP API + Webhook (Integrasi Awal)** — Melakukan integrasi awal **SNAP API Midtrans** dan konfigurasi Webhook untuk menghubungkan sistem pembayaran dengan aplikasi SkillKul.
-**Revisi SNAP API Midtrans** — Melakukan perbaikan dan penyempurnaan pada implementasi **SNAP API Midtrans** untuk memastikan token pembayaran dihasilkan dengan benar dan pop-up checkout tampil mulus kepada klien.
-**Webhook Midtrans** — Mengimplementasikan **endpoint Webhook Midtrans** yang menerima notifikasi pembayaran dan memperbarui status pesanan secara otomatis di dalam sistem.
-**Revisi Webhook Midtrans** — Melakukan perbaikan pada alur Webhook Midtrans untuk menangani berbagai skenario pembayaran (berhasil, gagal, pending) dengan lebih andal dan aman.
-**Integrasi Sistem Payment Gateway** — Menyempurnakan integrasi penuh **sistem payment gateway** Midtrans secara end-to-end, dari pembuatan token hingga konfirmasi pembayaran dan pembaruan status pesanan.
-**Midtrans untuk Penarikan Saldo (Disbursement)** — Mengimplementasikan fitur **penarikan saldo Freelancer** menggunakan API disbursement Midtrans, memungkinkan Freelancer mencairkan saldo wallet ke rekening bank terdaftar.
-**Auto-Portofolio PDF** — Mengembangkan fungsionalitas **auto-generate portofolio PDF** secara otomatis berdasarkan pesanan selesai yang mendapatkan rating ≥ 4 bintang dari klien.
-**Backend Laporan** — Membuat **backend laporan** khusus untuk mendukung fitur portofolio, mencakup query pengambilan data pesanan selesai dan pengorganisasian data untuk dicetak ke template PDF.
-**Fungsional Generate Portofolio PDF** — Menyempurnakan dan memastikan fitur **generate dokumen PDF portofolio** berjalan secara fungsional penuh, menghasilkan dokumen yang siap digunakan sebagai portofolio profesional.
-**Perbaikan Bahasa pada Tampilan Dasbor & Perubahan Logo** — Melakukan **perbaikan bahasa** pada tampilan dasbor freelancer dan admin agar lebih konsisten dan profesional, sekaligus melakukan **pembaruan logo website** SkillKul untuk tampilan akhir produk.

---

### 2. 🧑‍💻 Mokhamad Rizki Hadiono Singgih (`Rizkihadiono`)

Bertanggung jawab sebagai **pengembang full-stack** dengan fokus pada pengalaman pengguna (*user experience*), arsitektur database, serta fitur-fitur transaksional inti.

-**Revisi NIM (Perbaikan Autentikasi)** — Melakukan revisi pada sistem autentikasi terkait format dan validasi **NIM mahasiswa** agar sesuai dengan standar identifikasi yang benar dan konsisten.
-**Revisi (Perbaikan Umum Awal)** — Melakukan perbaikan umum awal pada berbagai komponen aplikasi yang ditemukan bermasalah selama tahap pengembangan pertama.
-**Migrasi Database `skillkull`** — Membuat **migrasi database** lengkap yang mendefinisikan seluruh struktur tabel utama: `users`, `services`, `orders`, `wallets`, `portfolios`, beserta relasi antar-entitas menggunakan foreign key.
-**Landing Page** — Merancang dan membangun **halaman Landing Page** sebagai wajah utama platform SkillKul, menampilkan hero section, daftar fitur unggulan, dan ajakan bergabung bagi calon pengguna.
-**Update Profile Pengguna** — Mengimplementasikan fungsionalitas **pembaruan profil pengguna** secara lengkap, mencakup perubahan nama, bio, keahlian, foto profil, dan informasi spesifik Freelancer.
-**Revisi Frontend UI** — Melakukan iterasi perbaikan pada tampilan antarmuka pengguna di berbagai halaman, memperbaiki inkonsistensi desain yang ditemukan selama tahap awal pengembangan.
-**Perbaikan Semua Model, Migrasi & Checkout** — Melakukan **refactoring menyeluruh pada semua Model Eloquent** (relasi `hasMany`, `belongsTo`, `hasOne`), memperbaiki skema migrasi, dan menyempurnakan alur checkout pembayaran.
-**Order Management (Client & Freelancer)** — Membangun **sistem manajemen pesanan dua sisi** yang menjadi tulang punggung logika bisnis platform, mengelola alur lengkap dari pemesanan, pengerjaan, hingga penyelesaian pesanan.
-**Custom Invoice** — Mengembangkan fitur **pembuatan tagihan manual (Custom Invoice)** yang memungkinkan Freelancer membuat invoice hasil negosiasi via WhatsApp untuk jasa bertipe *Project*, beserta link checkout yang dikirimkan ke klien.
-**Perbaikan Beberapa Fitur & UI** — Melakukan perbaikan pada berbagai fitur dan komponen antarmuka yang masih belum berfungsi dengan sempurna, memastikan stabilitas aplikasi sebelum tahap finalisasi.
-**Perbaikan Verifikasi Akun User** — Memperbaiki dan memperkuat **alur verifikasi akun** pengguna agar proses validasi identitas mahasiswa berjalan lebih andal dan aman dari celah keamanan.
-**Revisi Semua Tampilan Web & Fitur Dark Mode** — Melakukan **revisi desain antarmuka secara menyeluruh** pada hampir semua halaman web untuk meningkatkan konsistensi visual, sekaligus menambahkan **fitur mode gelap** di seluruh halaman aplikasi.
-**Revisi Template PDF Portofolio** — Memperbarui dan merevisi **desain template PDF portofolio** agar tampilannya lebih profesional dan siap digunakan sebagai dokumen lamaran kerja atau magang.
-**Perbaikan Kata Sesuai KBBI pada Menu Portofolio** — Melakukan **audit dan perbaikan kosakata** di halaman menu portofolio dan halaman lain agar sesuai dengan KBBI demi profesionalitas bahasa produk.
-**Revisi Portofolio** — Melakukan iterasi revisi lanjutan pada fitur dan tampilan portofolio berdasarkan hasil evaluasi dan pengujian, memastikan fitur portofolio berjalan optimal.

---

### 3. Marta Prama Daniswara (`martaaa-16`)

Bertanggung jawab sebagai **pengembang backend & frontend** yang menangani fondasi data, autentikasi pengguna, fitur manajemen pesanan, dan pemeliharaan kualitas kode.

-**Make Seeder and Factory** — Membuat **Database Seeder dan Factory** untuk mengisi data awal (*dummy data*) yang realistis, mencakup data pengguna, jasa, dan pesanan, sebagai fondasi pengembangan dan demo aplikasi.
-**Tampilan Login** — Merancang dan membangun **UI halaman Login** yang bersih, intuitif, dan responsif, memberikan kesan pertama yang baik bagi pengguna yang masuk ke platform.
-**Fitur Lupa Kata Sandi (Forgot Password)** — Mengimplementasikan fungsionalitas **reset kata sandi via email**, memungkinkan pengguna yang lupa kata sandi untuk memulihkan akses melalui tautan reset yang aman dan bertenggat waktu.
-**Update untuk Upload Foto Profil** — Mengimplementasikan fitur **upload dan pembaruan foto profil** pengguna, lengkap dengan validasi tipe file, validasi ukuran, dan penyimpanan gambar yang terorganisir di server.
-**Gambar Use Case Diagram** — Mengunggah **Use Case Diagram** ke repositori sebagai bagian dari dokumentasi teknis resmi yang menggambarkan interaksi antar aktor dalam sistem SkillKul.
-**Update List Kontribusi Tiap Anggota** — Memperbarui dan menyusun **daftar kontribusi** seluruh anggota tim pada file README.md agar terdokumentasi secara akurat dan terstruktur.
-**Upload Gambar Activity Diagram** — Mengunggah **Activity Diagram** ke repositori sebagai pelengkap dokumentasi teknis yang menggambarkan alur aktivitas dan proses bisnis di dalam sistem.
-**Seeder Fix** — Melakukan **perbaikan pada file seeder** untuk memastikan data dummy yang dihasilkan konsisten, tidak bertabrakan, dan sesuai dengan perubahan skema database yang berkembang.
-**Revisi Daftar Pesanan UI** — Melakukan revisi awal pada **tampilan halaman Daftar Pesanan** untuk memperbaiki tampilan dan alur navigasi berdasarkan evaluasi awal pengembangan.
-**Revisi Daftar Pesanan UI versi Freelancer** — Mengembangkan dan merevisi **tampilan Daftar Pesanan khusus sisi Freelancer** yang menampilkan seluruh pesanan masuk beserta status terkininya dengan tampilan yang lebih informatif.
-**Detail Pesanan UI** — Membangun **halaman Detail Pesanan** yang memberikan informasi lengkap satu pesanan spesifik, mencakup catatan klien, lampiran file, status, dan tombol aksi sesuai peran pengguna.
-**Wallet UI** — Mengembangkan **tampilan halaman Wallet** Freelancer yang menampilkan saldo aktif, riwayat transaksi masuk dan keluar, serta tombol penarikan saldo ke rekening bank.
-**Manajemen Jasa Fix** — Melakukan perbaikan dan finalisasi pada **backend Manajemen Jasa** untuk memastikan seluruh fungsionalitas CRUD jasa (tambah, edit, hapus, tampil) berjalan stabil dan bebas bug.
-**Revisi Tampilan dan Bahasa** — Melakukan **revisi tampilan antarmuka dan perbaikan bahasa** secara iteratif pada berbagai halaman, termasuk memastikan konsistensi terminologi dan label tombol di seluruh aplikasi.
-**Revisi Mode Ujian dan Bahasa** — Melakukan **perbaikan pada fungsionalitas Mode Ujian** dan konsistensi bahasa antarmuka, memastikan logika penguncian profil Freelancer bekerja dengan benar.
-**Revisi** — Melakukan sesi revisi menyeluruh berdasarkan hasil pengujian, memperbaiki berbagai bug antarmuka termasuk masalah responsivitas, overflow elemen, dan ketidaksesuaian styling.
-**Perbaikan Kata dan Seeder** — Melakukan **perbaikan kosakata** pada antarmuka agar lebih baku dan profesional, sekaligus melakukan iterasi perbaikan final pada seeder untuk konsistensi data demo.

---

### 4. Destian Dwi Mahardika (`Destian0870`)

Bertanggung jawab sebagai **pengembang frontend utama** yang membangun hampir seluruh antarmuka pengguna (*UI/UX*) dari awal dengan standar desain premium.

- **Peta Navigasi & Struktur Route Laravel** — Merancang **struktur Route Laravel** secara menyeluruh yang mendefinisikan alur perpindahan halaman seluruh aplikasi, memastikan setiap URL terdefinisi dengan bersih dan konsisten sebagai fondasi navigasi frontend.
- **Registrasi Page** — Membuat **UI halaman Registrasi** yang intuitif dan ramah pengguna, dengan validasi input dan panduan langkah demi langkah bagi calon pengguna baru yang ingin bergabung di platform.
- **UI Toggle Mode Ujian** — Membangun antarmuka **toggle Mode Ujian** yang bersih dan responsif, memungkinkan Freelancer mengunci profil mereka secara mandiri selama periode ujian, mencegah penerimaan pesanan baru dengan satu klik.
- **Verifikasi Identitas Mahasiswa (KTM)** — Membangun **halaman verifikasi KTM** — sebuah fitur unik platform SkillKul — yang meminta calon Freelancer mengunggah foto Kartu Tanda Mahasiswa untuk memastikan hanya mahasiswa aktif yang bergabung.
- **Katalog / Pencarian Pasar Jasa** — Membuat **halaman Katalog Jasa** dengan tampilan *card grid* yang elegan, menampilkan daftar jasa tersedia dengan informasi ringkas (harga, kategori, rating) untuk memudahkan Klien menelusuri penawaran.
- **Profil Publik Freelancer & Portofolio** — Membangun **halaman Profil Publik** lengkap dengan tampilan portofolio, menampilkan foto profil, bio, keahlian, reputasi, dan riwayat proyek Freelancer yang dapat dilihat Klien sebelum memesan.
- **Detail Jasa (Desain Premium ala SaaS)** — Merancang **halaman Detail Jasa** dengan desain premium ala platform SaaS modern, menampilkan deskripsi lengkap jasa, harga, contoh hasil, dan tombol aksi pemesanan yang menonjol.
- **Buka Jasa Baru (Form UI Sleek)** — Membuat **Form Pendaftaran Jasa Baru** dengan UI yang bersih dan terstruktur, memudahkan Freelancer mendaftarkan jasa dengan memasukkan nama, deskripsi, kategori, tipe (Project/Non-Project), dan harga.
- **Form Custom Invoice** — Merancang **UI Form Custom Invoice** yang digunakan Freelancer untuk membuat tagihan setelah negosiasi proyek, dengan input harga, deskripsi pekerjaan, dan tenggat waktu pembayaran.
- **Dompet (Wallet Escrow)** — Membangun **tampilan halaman Wallet** yang menampilkan saldo aktif Freelancer, riwayat transaksi masuk (dari pesanan selesai) dan keluar (penarikan), dengan desain yang rapi dan informatif.
- **Checkout Pembayaran (Midtrans UI)** — Merancang **halaman Checkout Pembayaran** yang menampilkan ringkasan pesanan sebelum pembayaran, terintegrasi dengan pop-up antarmuka **Midtrans Snap** yang muncul secara mulus.
- **Dasbor Freelancer (Tabel & Mode Ujian)** — Membuat **tampilan Dasbor Freelancer** sebagai pusat kendali yang menampilkan tabel ringkasan pesanan aktif, statistik singkat, dan tombol kontrol Mode Ujian dalam satu antarmuka terpadu.
- **Detail Pesanan (Tracker Order Klien & Rilis Dana)** — Membangun **halaman Detail Pesanan** yang berfungsi ganda: sebagai *tracker* status real-time bagi Klien dan sebagai panel aksi bagi Freelancer untuk mengunggah hasil kerja dan memproses *escrow release* setelah pesanan selesai.