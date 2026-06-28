# SIK Ampel — Sistem Informasi Kependudukan Kecamatan Ampel, Boyolali

> **Status: Phase 1-9 LENGKAP ✅** (dengan beberapa simplifikasi yang didokumentasikan jujur
> di bawah). Auth/RBAC → Master Data Wilayah → Penduduk/KK/Rumah → Verifikasi/QR/Signature →
> Analytics/GIS → Import/Export/Backup → Notifikasi/Email/WhatsApp → Audit Log/Monitoring →
> Security Hardening/Docker/CI-CD. Versi **Laravel 12 + MySQL**, satu codebase utuh.

Platform e-Government untuk mengelola data Penduduk, Kartu Keluarga, dan Rumah di Kecamatan
Ampel, Kabupaten Boyolali — dipakai oleh Super Admin, Operator Kecamatan, Operator Desa,
Validator Desa, Camat, dan Kepala Desa.

---

## ⚠️ WAJIB DIBACA: Keterbatasan Lingkungan Tempat Project Ini Ditulis

Project ini ditulis di sebuah sandbox yang **tidak punya akses ke Packagist/Composer**
(`getcomposer.org`, `packagist.org`, `repo.packagist.org` semua memblokir dengan
`403 host_not_allowed`). Ini saya cek langsung sebelum mulai menulis kode, bukan asumsi.

Akibatnya:

- **Saya menulis seluruh kode PHP secara manual** mengikuti konvensi resmi Laravel 12 (saya
  download skeleton resmi `laravel/laravel` dari GitHub — yang TIDAK diblokir — untuk
  memastikan struktur file, `bootstrap/app.php`, dan config persis sama dengan project Laravel
  12 yang dibuat lewat `composer create-project` sungguhan).
- **Saya TIDAK BISA menjalankan** `composer install`, `php artisan migrate`, `php artisan test`,
  atau menyalakan server di sandbox ini. Belum pernah ada eksekusi nyata terhadap aplikasi ini.
- **Yang SUDAH saya validasi langsung** di sandbox ini:
  - ✅ `php -l` (syntax check) pada **166 file PHP murni** (`app/`, `database/`, `routes/`,
    `tests/`, dll) → semua lolos, 0 error syntax.
  - ⚠️ **Koreksi jujur**: `php -l` pada file `.blade.php` itu **tidak benar-benar memvalidasi
    apa-apa** — file Blade bukan PHP murni (pakai `@if`, `{{ }}`, dst yang baru jadi PHP
    sungguhan setelah dikompilasi Laravel), jadi `php -l` cuma melihatnya sebagai teks biasa
    dan selalu bilang "OK" bahkan kalau ada salah. Saya sempat menulis ini secara tidak akurat
    sebelumnya — sekarang saya koreksi. Untuk 32 file `.blade.php`, yang BENAR-BENAR saya
    lakukan: cek manual tiap baris, cek semua `@if/@foreach/@can/@error` jumlahnya seimbang
    dengan `@endif/@endforeach/@endcan/@enderror`, dan cek setiap `<x-komponen>` yang dipakai
    benar-benar punya file komponennya. Ini tidak sama dengan kompilasi Blade sungguhan.
  - ✅ `npm run build` (Vite + Tailwind v4 + Alpine.js + Leaflet + Chart.js + html5-qrcode) →
    **berhasil build** berkali-kali sepanjang pengembangan, 5 entry point (app, scanner,
    gis-map, analytics-charts) semua sukses di-bundle.
  - ✅ Data wilayah memakai **20 desa ASLI Kecamatan Ampel** (dicek lewat web search saat
    membangun seeder, termasuk kode pos), bukan data karangan.

**Apa artinya ini buat kamu:** kemungkinan ada bug kecil yang baru kelihatan saat
`composer install` & `php artisan migrate` pertama kali dijalankan di komputermu — sesuatu
yang biasanya saya tangkap langsung lewat menjalankan dev server, tapi di sini tidak bisa.
Kalau ada error, **paste pesan errornya ke saya**, saya bantu perbaiki.

---

## ✅ Yang sudah jadi

### Phase 1 — Fondasi
| Area | Status |
|---|---|
| Laravel 12 + PHP 8.3, struktur resmi | ✅ |
| Autentikasi custom (captcha, rate limit, RBAC) | ✅ |
| RBAC 6 role, permission matrix terpusat (`app/Support/Rbac.php`) | ✅ |
| Dashboard shell (sidebar, navbar, bottom-nav mobile) | ✅ |
| Contoh Clean Architecture: modul User (API) | ✅ |
| Audit log otomatis, seeder, test, Pint/Husky/Commitlint | ✅ |

### Phase 2 — Master Data Wilayah & Referensi
| Area | Status |
|---|---|
| Provinsi → Kabupaten → Kecamatan → Desa → Dusun → RT/RW (UUID, hierarki FK) | ✅ |
| **20 Desa Kecamatan Ampel — data riil** (nama + kode pos asli) | ✅ |
| ~150 Dusun, ~600 RT/RW (digenerate, representatif) | ✅ |
| 11 tabel referensi: agama, pendidikan, pekerjaan, status kawin, golongan darah, hubungan keluarga, status penduduk, status rumah, jenis lantai/atap/dinding | ✅ |

### Phase 3 — Penduduk, KK, Rumah
| Area | Status |
|---|---|
| Modul **Penduduk**: CRUD lengkap, NIK unik, upload foto+dokumen, filter (nama/NIK/desa/status/gender), pagination | ✅ |
| Modul **Kartu Keluarga**: CRUD lengkap, kelola anggota keluarga (pivot), kaitan ke Rumah & Kepala Keluarga | ✅ |
| Modul **Rumah**: CRUD lengkap, tombol "📍 Ambil Lokasi Saat Ini" (HTML5 Geolocation), spesifikasi bangunan | ✅ |
| Scoping data: Operator Desa hanya lihat data desanya sendiri | ✅ |

### Phase 4 — Verifikasi, Digital Signature, QR Code, Scanner
| Area | Status |
|---|---|
| Workflow Verifikasi generik (Approve/Reject/Revisi) untuk Penduduk/KK/Rumah sekaligus | ✅ |
| Tanda tangan digital (canvas, disimpan sebagai PNG) — wajib untuk Approve | ✅ |
| QR Code (format SVG, tanpa butuh ext-gd/imagick) untuk **Rumah & KK** | ✅ |
| Halaman verifikasi publik (tanpa login) saat QR di-scan | ✅ |
| Scanner kamera (html5-qrcode) — scan otomatis redirect ke halaman verifikasi | ✅ |
| ⚠️ Barcode (Code128) **belum** dibangun — diprioritaskan QR saja (lebih ditekankan di brief) | — |
| ⚠️ QR publik **TIDAK dibuat untuk Citizen perorangan** (alasan privasi NIK, lihat komentar di `QrCodeService`) | — |

### Phase 5 — Dashboard Analytics & GIS
| Area | Status |
|---|---|
| Peta GIS (Leaflet + OpenStreetMap) — marker rumah warna sesuai status verifikasi | ✅ |
| Popup marker dengan link ke detail rumah | ✅ |
| Analytics: grafik Gender, Agama, Pendidikan, Pekerjaan, Kelompok Umur (Chart.js) | ✅ |
| Dashboard widget menampilkan **angka sungguhan** (bukan placeholder) | ✅ |
| ⚠️ Heatmap, Marker Cluster, Satellite View, Polygon Desa **belum** dibangun (peningkatan GIS lanjutan) | — |

### Phase 6 — Import, Export, Backup, Restore
| Area | Status |
|---|---|
| Import Excel Penduduk: **preview sebelum simpan**, validasi, deteksi NIK duplikat, baris gagal di-skip (tidak menghentikan semua) | ✅ |
| Export Excel & PDF untuk Penduduk, KK, Rumah | ✅ |
| Backup database (`mysqldump` via Symfony Process, tanpa package pihak ketiga tambahan) | ✅ |
| Restore database (`mysql <` via Process) — **Super Admin saja**, ada konfirmasi destruktif | ✅ |
| Riwayat backup, import, export (tabel `database_backups`, `imports`, `exports`) | ✅ |
| ⚠️ Import/Export baru untuk modul **Penduduk** secara penuh; KK & Rumah baru sisi Export (lihat Laporan) | — |

### Phase 7 — Notifikasi, Email, WhatsApp
| Area | Status |
|---|---|
| Notification Center (bell di navbar) — **data sungguhan**, bukan statis | ✅ |
| Email otomatis saat Verifikasi diputuskan (Laravel Notification, channel `mail`) | ✅ |
| Setiap email yang terkirim otomatis tercatat ke `email_logs` (event listener global) | ✅ |
| WhatsApp: **interface yang siap pasang provider asli** (`WhatsAppServiceInterface`), default-nya catat ke log + `whatsapp_logs` | ⚠️ lihat catatan |
| ⚠️ Push Notification (Web Push API browser) **tidak dibangun** — butuh VAPID key & service worker, scope-nya cukup besar untuk fase ini | — |

### Phase 8 — Audit Log, Monitoring, Laporan
| Area | Status |
|---|---|
| Audit Log UI: filter modul/aksi/tanggal, halaman khusus (`/audit`) | ✅ |
| Monitoring sistem: status Database/Queue/Storage, versi PHP/Laravel (`/monitoring`, Super Admin) | ✅ |
| Laporan: landing page terpusat untuk export Penduduk/KK/Rumah (Excel & PDF) | ✅ |
| ⚠️ Executive Dashboard terpisah **tidak dibangun** — Camat/Kepala Desa sudah punya akses read-only ke Dashboard+Analytics yang sama (lihat Rbac), jadi kebutuhannya sudah cukup terpenuhi tanpa duplikasi halaman | — |

### Phase 9 — Security Hardening, Docker, CI/CD
| Area | Status |
|---|---|
| Security headers (CSP, X-Frame-Options, X-Content-Type-Options, Permissions-Policy) | ✅ |
| Rate limiting API (100 req/menit, sesuai brief) | ✅ |
| Cache untuk data referensi (Phase 9 performance, contoh di `CitizenController`) | ✅ |
| `Dockerfile` (PHP-FPM Alpine) + `docker-compose.prod.yml` (app+nginx+mysql+redis+queue) | ✅ ditulis, belum di-build |
| CI/CD: lint (Pint) → test → build, plus job deploy **placeholder** (perlu diisi target hosting sungguhan) | ✅ |
| ⚠️ Saya **TIDAK BISA** `docker build` di sandbox ini (jaringan terbatas ke registry Docker Hub/Alpine) — konfigurasinya benar secara sintaks tapi belum pernah benar-benar di-build/run | — |

Yang **TIDAK** ada di brief asli tapi saya tambahkan karena perlu untuk kelengkapan: tabel
`verifications`, `email_logs`, `whatsapp_logs`, registry pemetaan modul→model untuk Verifikasi/QR.

---

## 🧱 Tech Stack

| Layer | Pilihan |
|---|---|
| Backend | Laravel 12, PHP 8.3 |
| Database | MySQL 8 |
| Frontend | Blade + Alpine.js 3 (interaktivitas ringan, tanpa build SPA terpisah) |
| CSS | Tailwind CSS v4 (config CSS-first via `@theme`) |
| Build tool | Vite 6 + `laravel-vite-plugin` |
| Auth | Session-based custom (bukan Breeze/Sanctum — API v1 pakai guard session yang sama) |
| Icon | Lucide (markup SVG asli diekstrak dari `lucide-static`, lihat `scripts/generate-icons.mjs`) |
| Maps | Leaflet + OpenStreetMap |
| Charts | Chart.js |
| QR Scanner | html5-qrcode (kamera browser) |
| QR Generator | simplesoftwareio/simple-qrcode (output SVG, tanpa ext-gd/imagick) |
| Excel | maatwebsite/excel (import + export, preview-before-import) |
| PDF | barryvdh/laravel-dompdf |
| Backup | Native (mysqldump/mysql via Symfony Process, tanpa package tambahan) |
| Testing | PHPUnit |
| Code style | Laravel Pint |

---

## 📁 Struktur Folder (ringkas)

```
app/
├── Enums/                   # RoleCode, Gender, VerificationStatus, AuditAction, dst
├── Http/
│   ├── Controllers/         # CitizenController, FamilyCardController, HouseController, dst
│   ├── Controllers/Auth/    # AuthenticatedSessionController
│   ├── Controllers/Api/V1/  # contoh API lengkap (Controller layer)
│   ├── Middleware/          # EnsureModuleAccess (RBAC)
│   └── Requests/            # Form Request validation (Store/Update per modul)
├── Models/                  # User, Citizen, FamilyCard, House, Village, 11 tabel referensi, dst
├── Repositories/            # ⭐ query database saja (Repository layer)
├── Services/                # ⭐ business logic (Service layer)
└── Support/
    ├── Rbac.php                    # ⭐ single source of truth RBAC
    ├── VerifiableModuleRegistry.php # pemetaan modul -> model (Verifikasi & QR)
    └── ApiResponse.php             # format response REST API konsisten
resources/
├── views/
│   ├── components/          # sidebar, navbar, form-group, status-badge, dst (Blade component)
│   ├── auth/, dashboard/
│   ├── citizens/, family-cards/, houses/
│   ├── verification/        # index (daftar pending), show (form approve/reject + signature)
│   ├── scanner/, gis/, analytics/
│   └── public/              # halaman verifikasi publik saat QR di-scan (tanpa login)
├── css/app.css               # Tailwind v4 theme tokens
└── js/
    ├── app.js                # Alpine.js bootstrap (dark mode, sidebar, toast, signature pad)
    ├── scanner.js             # html5-qrcode camera scanner
    ├── gis-map.js             # Leaflet map + marker rumah
    └── analytics-charts.js    # Chart.js wrapper
database/
├── migrations/                # wilayah, referensi, citizens, family_cards, houses, verifications
└── seeders/                   # termasuk data riil 20 desa Kecamatan Ampel
```

Pola **Controller → Service → Repository → Eloquent** dipakai konsisten di seluruh modul
(User, Citizen, FamilyCard, House) sejak Phase 1 — termasuk modul Verifikasi yang ditulis
generik (satu Service untuk Penduduk/KK/Rumah sekaligus, lihat `VerificationService` +
`VerifiableModuleRegistry`).

---

## 🔐 Login (setelah seeding)

| Username | Role | Catatan |
|---|---|---|
| `superadmin` | Super Admin | Akses penuh |
| `kecamatan.ampel` | Operator Kecamatan | |
| `operator.<nama-desa>` (3 desa pertama) | Operator Desa | Hanya lihat data desanya sendiri |
| `validator.ampel` | Validator Desa | |
| `camat.ampel` | Camat | Read-only |
| `kepaladesa.<nama-desa>` | Kepala Desa | Read-only, desanya sendiri |

Password semua akun di atas: `Ampel#2026Boyolali` (bisa diubah lewat `.env`).

⚠️ **Wajib diganti** setelah login pertama dan sebelum deploy production.

---

## 🧭 Role & Permission (ringkasan)

| Role | Bisa apa |
|---|---|
| Super Admin | Semua modul, semua aksi |
| Operator Kecamatan | CRUD Penduduk/KK/Rumah seluruh desa, **tidak bisa** hapus permanen / ubah role / hapus user |
| Operator Desa | Create/Read/Update Penduduk/KK/Rumah desanya sendiri, scan QR |
| Validator Desa | Approve/Reject/Revisi verifikasi + tanda tangan digital |
| Camat | Read-only: dashboard, analytics, GIS, laporan |
| Kepala Desa | Read-only: dashboard, laporan, analytics (desanya sendiri) |

Detail lengkap & gampang diaudit: `app/Support/Rbac.php`. Dipakai juga lewat
`$user->can('penduduk.create')` dan `@can('penduduk.create')` di Blade (lihat
`Gate::before()` di `AppServiceProvider`).

---

## 🗺️ Riwayat Pengembangan (semua sudah selesai)

| Phase | Isi |
|---|---|
| **1** ✅ | Fondasi: setup, auth, RBAC |
| **2** ✅ | Master Data Wilayah (Desa/Dusun/RT/RW) & referensi (agama, pendidikan, dst) |
| **3** ✅ | Modul Penduduk, KK, Rumah + upload dokumen |
| **4** ✅ | Verifikasi, Digital Signature, QR Code (barcode belum) |
| **5** ✅ | Dashboard Analytics & GIS (Leaflet + OpenStreetMap) |
| **6** ✅ | Import Excel, Export PDF/Excel, Backup & Restore |
| **7** ✅ | Notifikasi, Email, WhatsApp (interface, lihat catatan) |
| **8** ✅ | Audit Log UI, Monitoring, Laporan |
| **9** ✅ | Security Hardening, Docker, CI/CD (belum di-build/run) |

---

## ⚠️ Ringkasan Semua Simplifikasi (dikumpulkan jadi satu, biar tidak tersebar)

Supaya tidak perlu scroll mencari-cari, ini semua penyederhanaan & gap yang saya buat secara
sadar selama membangun Phase 1-9, dengan alasannya:

1. **Barcode (Code128) tidak dibuat** — hanya QR Code. QR mencakup kebutuhan verifikasi yang
   sama, dan brief sendiri lebih detail soal QR.
2. **QR publik tidak dibuat untuk Citizen perorangan** — sengaja, supaya tidak ada endpoint
   publik yang membocorkan NIK. Hanya Rumah & KK yang punya halaman verifikasi publik.
3. **Push Notification (Web Push API browser) tidak dibangun** — butuh VAPID key + service
   worker, scope cukup besar untuk ditambahkan tanpa bisa saya uji coba nyata.
4. **WhatsApp Business API belum terhubung ke provider sungguhan** — saya tidak punya
   kredensial API resmi. Kodenya sudah didesain pakai interface (`WhatsAppServiceInterface`)
   supaya tinggal pasang provider asli tanpa mengubah kode lain.
5. **Volume seed data lebih kecil** dari brief asli (60 Penduduk bukan 5.000, dst) — supaya
   `db:seed` tetap cepat; tinggal perbesar angkanya di `DemoDataSeeder`.
6. **Executive Dashboard tidak dibuat sebagai halaman terpisah** — Camat/Kepala Desa sudah
   punya akses read-only ke Dashboard + Analytics yang sama, jadi kebutuhannya sudah terpenuhi.
7. **GIS belum punya Heatmap/Marker Cluster/Satellite View/Polygon Desa** — baru marker dasar
   berwarna sesuai status verifikasi.
8. **Docker (`Dockerfile`, `docker-compose.prod.yml`) ditulis tapi belum pernah di-`build`/`run`**
   — sandbox saya tidak punya akses ke Docker Hub/registry Alpine untuk mengetesnya.
9. **Backup/Restore butuh shell exec (`mysqldump`/`mysql` di PATH server)** — tidak akan
   berfungsi di shared hosting yang membatasi `exec()`/`proc_open()`.
10. **CI/CD punya job "deploy" yang masih placeholder** — perlu diisi target hosting & secret
    sungguhan sebelum benar-benar dipakai.

Semua ini adalah keputusan desain yang disengaja dan didokumentasikan, bukan sesuatu yang
"terlewat tanpa sadar".

---

## 🐳 Menjalankan dengan Docker (Phase 9)

```bash
cp .env.example .env
# edit .env: DB_HOST=mysql, REDIS_HOST=redis
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan key:generate
docker compose -f docker-compose.prod.yml exec app php artisan migrate --seed
```

App bisa diakses di `http://localhost:8000`. **Belum pernah di-build di sandbox saya** (lihat
poin 8 di atas) — kemungkinan ada penyesuaian kecil yang dibutuhkan.

---

## 📜 Konteks

Dibangun sebagai proyek portofolio pribadi, mengikuti spesifikasi e-Government "Sistem Informasi
Kependudukan Kecamatan Ampel, Kabupaten Boyolali". Lihat [INSTALL.md](./INSTALL.md) untuk cara
menjalankan di komputer lokal — **langkah `composer install` di sana adalah eksekusi PERTAMA
project ini**, jadi luangkan waktu ekstra untuk debugging kalau ada yang tidak langsung jalan.
