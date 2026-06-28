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

## 🔐 Login (setelah seeding)

| Username | Role | Catatan |
|---|---|---|
| `superadmin` | Super Admin | Akses penuh |
| `kecamatan.ampel` | Operator Kecamatan | |
| `operator.<nama-desa>` (3 desa pertama) | Operator Desa | Hanya lihat data desanya sendiri |
| `validator.ampel` | Validator Desa | |
| `camat.ampel` | Camat | Read-only |
| `kepaladesa.<nama-desa>` | Kepala Desa | Read-only, desanya sendiri |

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

## 📜 Konteks

Dibangun sebagai proyek portofolio pribadi, mengikuti spesifikasi e-Government "Sistem Informasi
Kependudukan Kecamatan Ampel, Kabupaten Boyolali". Lihat [INSTALL.md](./INSTALL.md) untuk cara
menjalankan di komputer lokal — **langkah `composer install` di sana adalah eksekusi PERTAMA
project ini**, jadi luangkan waktu ekstra untuk debugging kalau ada yang tidak langsung jalan.
