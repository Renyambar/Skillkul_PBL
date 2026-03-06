 🎓 [SkillKul] - Marketplace Jasa Mahasiswa

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
2. **[Mokhamad Rizki Hadiono Singgih]** - [244107020205]
3. **[Marta Prama Daniswara]** - [244107020198]
4. **[Destian Dwi Mahardika]** - [244107020203]
5. **[Ghaisan Rafa Pradipta]** - [NIM]

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

Proyek ini dikerjakan secara kolaboratif menggunakan pendekatan *Feature-Based* oleh 5 anggota tim. Berikut adalah peta jalan (*roadmap*) pengerjaannya:

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
