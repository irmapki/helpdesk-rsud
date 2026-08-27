# Sistem Informasi IT Helpdesk & Ticketing RSUD RAA Soewondo Pati

Aplikasi berbasis web untuk mengelola layanan dan penanganan masalah Teknologi Informasi (IT) di lingkungan RSUD RAA Soewondo Pati. Sistem ini mencatat, mengelola, menugaskan, memantau, dan melaporkan tiket layanan IT secara terpusat — mulai dari pengaduan pegawai unit, penanganan oleh teknisi, hingga monitoring SLA oleh Supervisor IT.

Proyek ini dikembangkan sebagai bagian dari Praktik Kerja Lapangan (PKL) Program Studi Informatika, STT Pati.

---

## 🚀 Fitur Utama

- **Guest Portal Publik** — Pegawai unit dapat mengajukan pengaduan IT tanpa perlu registrasi/login yang rumit, melacak progres penanganan secara *real-time* via nomor tiket, serta memberikan rating & ulasan bintang setelah pengerjaan selesai.
- **Dukungan Berkas Lengkap (Foto, Video & HEIC)** — Mendukung unggah banyak bukti kendala sekaligus: Foto (JPG/PNG/WEBP), Rekaman Video (MP4/WebM), hingga format kamera iPhone (`.heic`/`.heif`).
- **Integrasi WhatsApp 1-Klik** — Pelapor dapat langsung menghubungi teknisi yang ditugaskan melalui tautan WhatsApp otomatis dengan *pre-filled text* nomor tiket.
- **Multi-Role Access (5 Peran)** — Hak akses terpisah dan tampilan dasbor khusus: Super Admin, Admin Helpdesk, Teknisi IT, Supervisor IT, dan Guest.
- **Manajemen & Triage Tiket** — Validasi laporan, penyesuaian kategori & prioritas SLA, penugasan teknisi berbasis beban kerja (*workload balancing*), serta catatan koordinasi internal.
- **Monitoring SLA Real-Time** — Perhitungan tenggat waktu otomatis berbasis prioritas (Critical, High, Medium, Low) lengkap dengan indikator kepatuhan (*On Track, Approaching, Breached*).
- **Audit Trail & Status History** — Riwayat log pergerakan status tiket tercatat detail dengan waktu (WIB) dan penanggung jawabnya.
- **Statistik & Laporan Eksekutif** — Visualisasi sebaran kategori kendala, performa teknisi, unit teraktif, dan filter laporan tiket per periode tanggal.

---

## 👥 Peran Pengguna (Role)

| Role | Deskripsi & Hak Akses |
|---|---|
| **Guest / Pegawai Unit** | Mengajukan tiket, mengunggah foto/video, melacak progres, dan memberi rating kepuasan. |
| **Super Admin** | Mengelola seluruh data master: user, role, unit/ruangan, kategori, prioritas SLA, dan data teknisi. |
| **Admin Helpdesk** | Validasi tiket masuk, triase prioritas/kategori, dan mendisposisikan tugas ke teknisi. |
| **Teknisi IT** | Menerima tugas, update progres pengerjaan (*In Progress / Resolved*), dan mengisi solusi teknis. |
| **Supervisor IT** | Mengawasi kepatuhan SLA secara *real-time*, analisis beban kerja, dan rekap laporan berkala. |

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 13 (PHP 8.3)
- **Autentikasi:** Laravel Breeze
- **Frontend & Styling:** Blade Templates, Alpine.js, Tailwind CSS
- **Database:** MySQL
- **Tooling:** Vite, Composer, NPM

---

## 💻 Instalasi & Menjalankan Proyek

### Prasyarat Sistem
- PHP >= 8.2
- Composer
- MySQL (via Laragon / XAMPP)
- Node.js & NPM

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/irmapki/helpdesk-rsud.git
   cd helpdesk-rsud
   ```

2. **Install dependency PHP & JavaScript**
   ```bash
   composer install
   npm install
   ```

3. **Salin file konfigurasi environment**
   ```bash
   cp .env.example .env
   ```
   *(Pengguna Windows: `copy .env.example .env`)*

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**
   Buat database baru di MySQL (contoh: `helpdesk_rsud`), lalu sesuaikan pengaturan pada file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=helpdesk_rsud
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Jalankan Migration & Seeder Master Data**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Hubungkan Storage Link (Wajib untuk Foto & Video)**
   ```bash
   php artisan storage:link
   ```

8. **Build Asset Frontend**
   ```bash
   npm run build
   ```

9. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Aplikasi siap diakses melalui browser di: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔑 Akun Demo (Hasil Seeder)

| Role | Email Login | Password Default | Keterangan |
|---|---|---|---|
| **Super Admin** | `superadmin@rsud.test` | `password` | Akses penuh master data & user |
| **Admin Helpdesk** | `admin@rsud.test` | `password` | Triage, validasi, & disposisi tiket |
| **Teknisi IT 1** | `teknisi@rsud.test` | `password` | Rian (Hardware & Jaringan) |
| **Teknisi IT 2** | `teknisi2@rsud.test` | `password` | Bayu (SIMRS & Database) |
| **Supervisor IT** | `supervisor@rsud.test` | `password` | Monitoring SLA & Laporan Eksekutif |

---

## 📁 Struktur Direktori Utama

```text
app/Http/Controllers/
├── SuperAdmin/    # CRUD master data (user, unit, kategori, prioritas, teknisi)
├── Admin/         # Validasi tiket, triage prioritas, disposisi teknisi, catatan internal
├── Teknisi/       # Update status penanganan (In Progress, Resolved), histori tugas
├── Supervisor/    # Dashboard analitik, monitoring SLA, laporan rekap tiket
└── Guest/         # Pengajuan tiket publik, pelacakan real-time, upload lampiran, rating

app/Models/
├── Ticket.php          # Model utama tiket, kalkulasi SLA otomatis & mutator
├── TicketStatusLog.php # Audit trail riwayat pergerakan status
├── TicketNote.php      # Catatan koordinasi internal tim IT
└── User.php, Role.php, Unit.php, Category.php, Priority.php

database/seeders/       # Master seeder: role, unit RSUD, kategori, prioritas SLA, akun demo
```

---

## 🔄 Alur Kerja Sistem (Workflow)

```text
[Pelapor / Ruangan] Melaporkan kendala (+ bukti foto/video/HEIC)
        │
        ▼
[Admin Helpdesk] Validasi & Triage Prioritas SLA ──► Disposisikan ke Teknisi
        │
        ▼
[Teknisi IT] Mulai Pengerjaan (In Progress) ──► Selesai Perbaikan (Resolved + Solusi)
        │
        ▼
[Pelapor] Konfirmasi Penyelesaian & Beri Rating Bintang (1 - 5 ★)
        │
        ▼
[Supervisor IT] Mengawasi Kepatuhan SLA & Rekapitulasi Laporan Kinerja
```

---

## 👥 Kontributor

Proyek Praktik Kerja Lapangan (PKL) — Program Studi Informatika, STT Pati di RSUD RAA Soewondo Pati.

| Nama | Kontribusi Modul |
|---|---|
| **Irma Fatimatuz Zahro** | Super Admin, Admin Helpdesk & Guest Portal |
| **Alden Muhammad Rafael** | Teknisi IT & Supervisor IT |

---

## 📄 Lisensi

Proyek ini dikembangkan khusus untuk keperluan akademik (Praktik Kerja Lapangan) dan implementasi internal RSUD RAA Soewondo Pati.