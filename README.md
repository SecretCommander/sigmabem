# SIGMA BEM

Project Laravel ini dibuat untuk membantu pengelolaan sistem proposal dan LPJ secara digital untuk organisasi BEM.

Saat ini project sudah berkembang ke tahap yang lebih lengkap, termasuk tampilan halaman utama, autentikasi pengguna, dashboard, serta modul proposal dan LPJ yang sudah mulai terstruktur.

---

## Progress yang Sudah Dibuat

Berikut beberapa fitur yang sudah tersedia pada project ini:

- Halaman utama (welcome page)
- Halaman About
- Tampilan login yang sudah dibuat dengan alur autentikasi
- Sistem login dan logout
- Penyimpanan data user ke session
- Dashboard setelah login
- Routing berdasarkan role pengguna:
    - Superadmin
    - Admin
    - User
- Halaman daftar Proposal
- Halaman detail Proposal
- Halaman daftar LPJ
- Halaman detail LPJ
- Layout aplikasi yang sudah mulai rapi dan konsisten
- Sidebar navigasi berbasis role untuk akses menu yang berbeda
- Tampilan dashboard yang menyesuaikan hak akses pengguna
- Middleware untuk membatasi akses berdasarkan status login dan role
- Halaman error dan tampilan dasar aplikasi yang lebih terorganisir

---

## Struktur Fitur Utama

### 1. Halaman Publik

- `/` → halaman utama
- `/about` → halaman tentang project

### 2. Autentikasi

- `/login` → halaman login
- `/logout` → proses logout

### 3. Dashboard Setelah Login

- `/dashboard` → halaman utama setelah login

### 4. Modul Proposal dan LPJ

- `/proposal` → daftar proposal
- `/proposal/{id}` → detail proposal
- `/lpj` → daftar LPJ
- `/lpj/{id}` → detail LPJ

### 5. Akses Berdasarkan Role

- Superadmin dapat mengakses fitur manajemen pengguna dan halaman admin
- Admin dapat mengakses proposal dan LPJ
- User dapat melihat data proposal/LPJ yang relevan dengan akun mereka

---

## Cara Menjalankan Project dari GitHub

Untuk tim backend atau siapa pun yang ingin menjalankan project ini di komputer mereka, langkah-langkah standar berikut wajib dilakukan.

### 1. Clone Repository

```bash
git clone https://github.com/hilmisyuhada/sigmabem.git
```

### 2. Masuk ke Folder Project

```bash
cd sigmabem
```

### 3. Install Dependencies (Composer)

Karena folder `vendor` tidak ikut terunggah ke GitHub, install ulang dependency-nya:

```bash
composer install
```

### 4. Buat File Environment (.env)

File `.env` berisi konfigurasi database dan data rahasia aplikasi. Salin file contoh lalu ubah namanya menjadi `.env`.

Jika menggunakan Command Prompt (Windows):

```cmd
copy .env.example .env
```

Jika menggunakan Git Bash / Terminal (Mac/Linux):

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buka file `.env` lalu atur koneksi database lokal sesuai environment masing-masing.

Contoh:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_lokal
DB_USERNAME=root
DB_PASSWORD=
```

Setelah itu, jalankan migrasi database:

```bash
php artisan migrate
```

Jika ingin mengisi data awal, bisa juga menjalankan:

```bash
php artisan db:seed
```

### 7. Jalankan Server

```bash
php artisan serve
```

Setelah itu, buka browser ke:

```text
http://localhost:8000
```

---

## Catatan Penting

- File `.env` dan folder `vendor` tidak disarankan untuk diunggah ke GitHub.
- Pastikan database sudah siap sebelum menjalankan migrasi.
- Project ini masih bisa dilanjutkan untuk fitur CRUD proposal, CRUD LPJ, manajemen pengguna, serta integrasi data yang lebih lengkap.

---

## Rencana Pengembangan Selanjutnya

Beberapa hal yang bisa dilanjutkan berikutnya:

- CRUD Proposal secara penuh
- CRUD LPJ secara penuh
- Integrasi database real untuk data proposal dan LPJ
- Fitur upload file dokumen
- Validasi role dan permission yang lebih detail
- Tampilan admin panel yang lebih modern
- Fitur notifikasi dan histori aktivitas pengguna
