# INSTALL — Menjalankan SIK Ampel (Laravel) di Komputer Lokal

> 📌 Ini adalah **eksekusi pertama** project ini secara nyata (lihat penjelasan di README
> tentang kenapa). Kemungkinan ada langkah yang perlu sedikit penyesuaian — kalau ada error,
> paste pesan errornya ke Claude, jangan langsung berasumsi kodenya salah total.

## Prasyarat

- PHP ≥ 8.2 dengan extension: `mbstring`, `xml`, `curl`, `pdo_mysql`, `zip`, `bcmath`
- Composer ≥ 2
- Node.js ≥ 18 & npm
- MySQL 8 (atau pakai Docker — lihat opsi B)

Cek dulu:
```bash
php -v
composer -V
node -v
```

## 1. Install dependencies PHP

```bash
composer install
```

> Kalau ada error versi PHP/extension, sesuaikan dulu PHP-mu (`php -m` untuk lihat extension
> yang aktif) sebelum lanjut.

## 2. Siapkan file environment

```bash
cp .env.example .env
php artisan key:generate
```

## 3. Siapkan database MySQL

### Opsi A — sudah punya MySQL lokal

Edit `DB_*` di `.env` sesuai kredensial MySQL-mu, lalu buat database:

```sql
CREATE DATABASE sik_ampel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Opsi B — pakai Docker (lebih gampang)

```bash
docker compose up -d
```

Ini menyalakan MySQL di `localhost:3306` (kredensial sudah cocok dengan `.env.example`) plus
phpMyAdmin di [http://localhost:8080](http://localhost:8080) (user `root`, password `root`).

## 4. Jalankan migration

```bash
php artisan migrate
```

Urutan migration sudah diatur supaya `roles` & `permissions` dibuat SEBELUM `users` (karena ada
foreign key `users.role_id` → `roles.id`). Kalau muncul error foreign key, kemungkinan ada
migration yang ke-skip — jalankan `php artisan migrate:fresh` untuk mulai dari nol.

## 5. Isi data awal (role, permission, wilayah, referensi, Super Admin, contoh data)

```bash
php artisan db:seed
```

Seeder ini akan membuat (berurutan): role & permission, data wilayah (Provinsi Jawa Tengah →
Kabupaten Boyolali → Kecamatan Ampel → **20 desa asli** dengan kode pos sungguhan, plus dusun
& RT/RW yang digenerate), data referensi (agama, pendidikan, dst), 1 akun Super Admin, dan
contoh data (beberapa user per role + ~60 Penduduk, ~20 KK, ~20 Rumah) supaya sistem tidak
kosong saat pertama dibuka.

> Catatan: brief asli minta volume data jauh lebih besar (5.000 Penduduk, dst). Untuk Phase 3
> ini saya isi jumlah yang lebih kecil supaya seeding tetap cepat — tinggal ubah angka di
> `DemoDataSeeder` kalau mau diperbesar.

Output akan menampilkan:
```
Login Super Admin:
- Username : superadmin
- Password : Ampel#2026Boyolali
```

Akun contoh lain yang ikut dibuat: `kecamatan.ampel`, `validator.ampel`, `camat.ampel`,
`operator.<nama-desa>` (3 desa pertama), `kepaladesa.<nama-desa>` — semua pakai password yang
sama dengan Super Admin.

## 6. Buat symbolic link storage (WAJIB untuk Phase 3 — upload foto/dokumen)

```bash
php artisan storage:link
```

Tanpa ini, foto Penduduk/Rumah dan dokumen yang diupload tidak akan bisa diakses lewat browser
(404), karena secara default Laravel menyimpan file di `storage/app/public` yang tidak
otomatis bisa diakses publik.

## 7. Install dependencies frontend & build assets

```bash
npm install
npm run build
```

(Sudah saya validasi langsung di sandbox: build ini **berhasil** dan menghasilkan CSS dengan
warna tema custom yang benar.)

## 8. Jalankan development server

```bash
php artisan serve
```

Buka [http://localhost:8000](http://localhost:8000) → otomatis diarahkan ke `/login`.

**Penting untuk Notifikasi/Email (Phase 7):** notifikasi memakai queue (`ShouldQueue`), jadi
selain `php artisan serve`, jalankan juga di terminal terpisah:
```bash
php artisan queue:work
```
Tanpa ini, notifikasi/email tidak akan terkirim — job-nya cuma menumpuk di tabel `jobs`. Mau
tes cepat tanpa queue worker? Set `QUEUE_CONNECTION=sync` di `.env` (notifikasi langsung
diproses synchronous, lebih lambat tapi tidak butuh worker terpisah).

Untuk development sehari-hari (server + Vite watch + queue listener sekaligus):
```bash
composer run dev
```

## 9. (Opsional) Aktifkan Git hooks

```bash
npm run prepare
```

Mengaktifkan Husky supaya `lint-staged` (jalankan Laravel Pint otomatis) & `commitlint` jalan
tiap commit.

---

## Perintah Lain yang Berguna

| Command | Fungsi |
|---|---|
| `php artisan test` | Jalankan semua test (PHPUnit) |
| `php artisan test --filter=RbacTest` | Jalankan satu test class saja |
| `./vendor/bin/pint` | Rapikan code style otomatis |
| `./vendor/bin/pint --test` | Cek code style tanpa mengubah file |
| `php artisan migrate:fresh --seed` | Reset total database + isi ulang data awal |
| `php artisan route:list` | Lihat semua route yang terdaftar |
| `php artisan tinker` | REPL interaktif untuk eksplorasi model/data |

---

## Troubleshooting

**`SQLSTATE[HY000] [2002] Connection refused` saat migrate**
→ MySQL belum jalan. Cek `docker compose ps` (kalau pakai Docker) atau service MySQL lokalmu.

**`Class "App\Models\X" not found` atau error autoload lain**
→ Jalankan `composer dump-autoload`.

**Error foreign key constraint saat `php artisan migrate`**
→ Pastikan tidak ada migration yang dijalankan di luar urutan. Coba `php artisan migrate:fresh`.

**Halaman login muncul tapi soal captcha kosong / error session**
→ Pastikan `SESSION_DRIVER=database` di `.env` dan tabel `sessions` sudah ter-migrate (itu
bagian dari migration `create_users_table`, bukan migration terpisah).

**Login gagal terus padahal username/password sudah benar**
→ Cek apakah `php artisan db:seed` sudah dijalankan, dan apakah `APP_KEY` di `.env` sudah
terisi (lewat `php artisan key:generate`) — tanpa ini, session/cookie tidak bisa di-encrypt.

**Asset CSS/JS tidak muncul (halaman polos tanpa style)**
→ Jalankan `npm run build` (production) atau `npm run dev` (development, perlu tetap berjalan
di terminal terpisah selagi `php artisan serve` jalan).

**Foto Penduduk/Rumah tidak muncul (gambar 404)**
→ Jalankan `php artisan storage:link` (lihat langkah 6).

**Halaman /scanner tidak bisa akses kamera**
→ Browser modern HANYA mengizinkan akses kamera di `https://` atau `http://localhost`. Kalau
test dari HP lewat IP lokal (`http://192.168.x.x:8000`), kamera akan diblokir browser — ini
bukan bug aplikasi, tapi pembatasan keamanan browser. Gunakan `localhost`/`127.0.0.1`, atau
setup HTTPS lokal (`php artisan serve --tls` di Laravel terbaru, atau lewat Laravel Valet/Herd).

**Halaman /gis kosong meski sudah ada data Rumah**
→ GIS hanya menampilkan rumah yang punya `latitude`/`longitude` terisi. Tambah rumah baru
lewat tombol "📍 Ambil Lokasi Saat Ini", atau isi manual koordinatnya.

**Backup gagal dengan error "mysqldump: command not found"**
→ Binary `mysqldump` tidak ada di PATH server. Kalau pakai Docker, exec ke dalam container
`mysql` (`docker compose exec mysql mysqldump ...`) sebagai alternatif manual, atau install
MySQL client tools di server yang menjalankan Laravel.

**Notifikasi tidak muncul / email tidak terkirim**
→ Pastikan `php artisan queue:work` berjalan (lihat langkah 8), atau set
`QUEUE_CONNECTION=sync` di `.env` untuk testing cepat tanpa queue worker.

**Import Excel gagal dengan error class tidak ditemukan (Maatwebsite\Excel)**
→ Jalankan `composer dump-autoload` lalu `php artisan config:clear`.

**Kalau ada error lain yang tidak ada di daftar ini**
→ Wajar — ini eksekusi pertama project ini di lingkungan dengan internet penuh. Paste pesan
errornya lengkap (termasuk stack trace) ke Claude untuk dibantu perbaiki.
