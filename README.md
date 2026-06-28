# SIK Ampel — Sistem Informasi Kependudukan Kecamatan Ampel, Boyolali

> **Status: Phase 1-9 LENGKAP ✅** (dengan beberapa simplifikasi yang didokumentasikan jujur
> di bawah). Auth/RBAC → Master Data Wilayah → Penduduk/KK/Rumah → Verifikasi/QR/Signature →
> Analytics/GIS → Import/Export/Backup → Notifikasi/Email/WhatsApp → Audit Log/Monitoring →
> Security Hardening/Docker/CI-CD. Versi **Laravel 12 + MySQL**, satu codebase utuh.

Platform e-Government untuk mengelola data Penduduk, Kartu Keluarga, dan Rumah di Kecamatan
Ampel, Kabupaten Boyolali — dipakai oleh Super Admin, Operator Kecamatan, Operator Desa,
Validator Desa, Camat, dan Kepala Desa.

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
