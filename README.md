# Sistem Pelaporan Fasilitas Kampus

Aplikasi berbasis web untuk mengelola laporan kerusakan fasilitas kampus menggunakan **CodeIgniter 4**.

## 📋 Deskripsi Sistem

Sistem ini memungkinkan mahasiswa untuk melaporkan kerusakan fasilitas kampus, dan admin dapat memverifikasi serta mengelola laporan tersebut. Sistem dilengkapi dengan notifikasi real-time, manajemen akun multi-role, dan dashboard statistik.

## 🎯 Fitur Utama

### Untuk Mahasiswa (User)

- ✅ Registrasi dan login dengan email verification
- 📝 Membuat laporan kerusakan fasilitas
- 📊 Melihat status laporan pribadi
- ✏️ Edit/hapus laporan (hanya status pending/ditolak)
- 🔔 Notifikasi update status laporan
- 👤 Manajemen profil

### Untuk Admin

- 📋 Dashboard dengan statistik KPI
- ✅ Verifikasi laporan (pending → diproses → selesai/ditolak)
- 🏢 Manajemen gedung dan ruangan
- 👥 Manajemen akun user (untuk superadmin)
- 📊 Laporan dan riwayat lengkap
- 🔔 Notifikasi laporan baru

### Untuk Rektor

- 📈 Dashboard statistik dan KPI
- 📊 Laporan analitik
- 🔍 Audit log aktivitas

## 🗄️ Database Schema

### Tabel Utama

#### `users`

- Menyimpan data pengguna (mahasiswa, admin, superadmin, rektor)
- Role-based access control (RBAC)
- Password reset token

#### `laporan`

- Data laporan kerusakan fasilitas
- Status: pending, diproses, selesai, ditolak
- Prioritas: low, medium, high
- Kategori kerusakan
- Relasi ke gedung, ruangan, dan user

#### `gedung`

- Master data gedung kampus

#### `ruangan`

- Master data ruangan per gedung

#### `notifikasi`

- Notifikasi untuk user
- Status terbaca/belum terbaca

#### `log_aktivitas`

- Audit trail aktivitas admin
- Tracking verifikasi laporan

## 🔄 Alur Sistem (Sequence Diagram)

```mermaid
sequenceDiagram
    autonumber

    actor Mahasiswa
    actor Admin

    participant Browser as Browser (Web)
    participant AF as AuthFilter
    participant AC as AuthController
    participant LC as LaporController
    participant ALC as AdminLaporController
    participant LM as LaporanModel
    participant UM as UserModel
    participant GM as GedungModel
    participant RM as RuanganModel
    participant LOG as LogAktivitasModel
    participant NM as NotifikasiModel
    participant DB as Database

    %% ================= LOGIN MAHASISWA =================
    Note over Mahasiswa,DB: 1. LOGIN MAHASISWA
    Mahasiswa ->> Browser: Input email & password
    Browser ->> AC: POST /login
    AC ->> UM: findByEmail(email)
    UM ->> DB: SELECT * FROM users WHERE email
    DB -->> UM: user row
    UM -->> AC: validate password & status=active
    AC ->> AC: set session(user_id, role=user, isLoggedIn=true)
    AC -->> Browser: redirect to /dashboard

    %% ================= FORM LAPORAN =================
    Note over Mahasiswa,DB: 2. BUKA FORM LAPORAN
    Mahasiswa ->> Browser: Akses /laporan
    Browser ->> AF: before() - cek session
    AF ->> AF: check isLoggedIn & role=user
    AF -->> Browser: allowed
    Browser ->> LC: GET /laporan
    LC ->> GM: findAll()
    GM ->> DB: SELECT * FROM gedung
    DB -->> GM: gedung list
    LC ->> RM: findAll()
    RM ->> DB: SELECT * FROM ruangan
    DB -->> RM: ruangan list
    LC -->> Browser: render form laporan

    %% ================= SUBMIT LAPORAN =================
    Note over Mahasiswa,DB: 3. SUBMIT LAPORAN
    Mahasiswa ->> Browser: Submit form laporan
    Browser ->> LC: POST /laporan/store
    LC ->> LC: validate input & upload foto
    LC ->> LM: insert(data)
    LM ->> DB: INSERT INTO laporan
    Note right of DB: status = 'pending'<br/>user_id<br/>gedung_id<br/>ruangan_id<br/>prioritas<br/>kategori
    DB -->> LM: laporan_id
    LM -->> LC: success
    LC -->> Browser: redirect /laporan/saya + flash success

    %% ================= LOGIN ADMIN =================
    Note over Admin,DB: 4. LOGIN ADMIN
    Admin ->> Browser: Login dengan role admin/superadmin
    Browser ->> AC: POST /login
    AC ->> UM: findByEmail(email)
    UM ->> DB: SELECT * FROM users WHERE email
    DB -->> UM: user row
    UM -->> AC: validate password & role IN (admin,superadmin)
    AC ->> AC: set session(user_id, role, isLoggedIn=true)
    AC -->> Browser: redirect to /dashboardadmin

    %% ================= LIST LAPORAN =================
    Note over Admin,DB: 5. LIHAT DAFTAR LAPORAN
    Admin ->> Browser: Akses /laporanadminpending
    Browser ->> ALC: GET /laporanadminpending
    ALC ->> ALC: statusMapper[uri] = 'pending'
    ALC ->> DB: SELECT * FROM laporan WHERE status='pending'
    DB -->> ALC: laporan list
    ALC -->> Browser: render tabel laporan pending

    %% ================= VERIFIKASI LAPORAN =================
    Note over Admin,DB: 6. VERIFIKASI LAPORAN
    Admin ->> Browser: Update status laporan via form
    Browser ->> ALC: POST /admin/laporan/verifikasi
    ALC ->> ALC: validate status & keterangan
    ALC ->> LM: update(id, data)
    LM ->> DB: UPDATE laporan SET status, tanggal_verifikasi, verifikator, keterangan_verifikasi
    DB -->> LM: success
    LM -->> ALC: success

    %% ================= LOG AKTIVITAS =================
    Note over Admin,DB: 7. CATAT LOG AKTIVITAS
    ALC ->> LOG: catat(admin_id, aktivitas, laporan_id)
    LOG ->> DB: INSERT INTO log_aktivitas
    Note right of DB: admin_id<br/>aktivitas = "Memverifikasi laporan #ID menjadi STATUS"<br/>laporan_id
    DB -->> LOG: success

    %% ================= NOTIFIKASI USER =================
    Note over Admin,DB: 8. KIRIM NOTIFIKASI KE USER
    ALC ->> LM: find(id)
    LM ->> DB: SELECT * FROM laporan WHERE id
    DB -->> LM: laporan data
    LM -->> ALC: laporan with user_id
    ALC ->> NM: createNotifikasi(user_id, laporan_id, pesan)
    NM ->> DB: INSERT INTO notifikasi
    Note right of DB: user_id<br/>laporan_id<br/>pesan sesuai status<br/>terbaca = 0
    DB -->> NM: success
    NM -->> ALC: success
    ALC -->> Browser: redirect back + flash success

    %% ================= CEK NOTIFIKASI =================
    Note over Mahasiswa,DB: 9. MAHASISWA CEK NOTIFIKASI
    Mahasiswa ->> Browser: Akses /notifikasi
    Browser ->> NM: getByUserId(user_id)
    NM ->> DB: SELECT * FROM notifikasi WHERE user_id ORDER BY created_at DESC
    DB -->> NM: notifikasi list
    NM -->> Browser: render notifikasi
```

## 🏗️ Struktur Aplikasi

### Controllers

#### `AuthController`

- `login()` - Proses login multi-role
- `register()` - Registrasi mahasiswa baru
- `logout()` - Logout dan destroy session
- `forgotPassword()` - Reset password via email
- `resetPage()` - Halaman input password baru
- `changePasswordProcess()` - Proses simpan password baru

#### `LaporController` (User)

- `index()` - Form buat laporan
- `store()` - Simpan laporan baru
- `saya()` - Daftar laporan pribadi
- `edit($id)` - Form edit laporan
- `update($id)` - Update laporan
- `delete($id)` - Hapus laporan
- `detail($id)` - Detail laporan
- `riwayat()` - Riwayat laporan selesai

#### `AdminLaporController` (Admin)

- `index()` - Daftar laporan (pending/diproses/selesai)
- `verifikasi()` - Proses verifikasi laporan
- `detail($id)` - Detail laporan dengan JOIN
- `riwayat()` - Riwayat laporan selesai

#### `NotifikasiController` (User)

- `index()` - Daftar notifikasi
- `markAsRead($id)` - Tandai dibaca
- `markAllAsRead()` - Tandai semua dibaca
- `delete($id)` - Hapus notifikasi
- `deleteAll()` - Hapus semua notifikasi

#### `AdminNotifikasiController` (Admin)

- Sama seperti NotifikasiController untuk admin

### Models

#### `UserModel`

- Manajemen data user
- Validasi login
- Password hashing

#### `LaporanModel`

- CRUD laporan
- Statistik dan KPI (getTotalLaporan, getStatistik, getCompletionRate, dll)
- Query dengan JOIN ke gedung, ruangan, users

#### `GedungModel`

- Master data gedung

#### `RuanganModel`

- Master data ruangan

#### `NotifikasiModel`

- `getByUserId()` - Ambil notifikasi user
- `getWithLaporan()` - Notifikasi dengan JOIN laporan
- `countUnread()` - Hitung notifikasi belum dibaca
- `markAsRead()` - Tandai dibaca
- `createNotifikasi()` - Buat notifikasi baru

#### `LogAktivitasModel`

- `catat()` - Catat aktivitas admin
- Audit trail

### Filters

#### `AuthFilter`

- Cek session `isLoggedIn`
- Validasi role = 'user'
- Redirect ke dashboard sesuai role

#### `AdminFilter`

- Validasi role IN ('admin', 'superadmin')
- Redirect ke /login jika tidak authorized

#### `RektorFilter`

- Validasi role = 'rektor'

#### `SuperadminFilter`

- Validasi role = 'superadmin'

## 🔐 Role-Based Access Control (RBAC)

| Role                 | Akses                                                            |
| -------------------- | ---------------------------------------------------------------- |
| **user** (Mahasiswa) | Dashboard, Laporan, Profil, Notifikasi                           |
| **admin**            | Dashboard Admin, Verifikasi Laporan, Manajemen Gedung, Akun User |
| **superadmin**       | Semua akses Admin + Manajemen Akun Admin                         |
| **rektor**           | Dashboard Statistik, Laporan Analitik, Audit Log                 |

## 🚀 Instalasi

### Requirements

- PHP 8.1 or higher
- MySQL 8.0+
- Composer
- CodeIgniter 4

### Setup

1. **Clone repository**

```bash
git clone <repository-url>
cd new-admin
```

2. **Install dependencies**

```bash
composer install
```

3. **Setup database**

```bash
# Import database
mysql -u root -p db_facility_report < "new db.sql"
```

4. **Configure environment**

```bash
# Copy .env.example ke .env
cp .env.example .env

# Edit .env
database.default.hostname = localhost
database.default.database = db_facility_report
database.default.username = root
database.default.password = your_password
database.default.DBDriver = MySQLi
```

5. **Run development server**

```bash
php spark serve
```

6. **Akses aplikasi**

```
http://localhost:8080
```

## 👥 Default Accounts

| Role       | Email                | Password    |
| ---------- | -------------------- | ----------- |
| Mahasiswa  | mahasiswa1@gmail.com | password123 |
| Admin      | admin@gmail.com      | password123 |
| Superadmin | superadmin@gmail.com | password123 |
| Rektor     | rektor@gmail.com     | password123 |

## 📁 Struktur Folder

```
new-admin/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── LaporController.php
│   │   ├── AdminLaporController.php
│   │   ├── NotifikasiController.php
│   │   ├── AdminNotifikasiController.php
│   │   ├── AdminDashboard.php
│   │   ├── AdminGedungController.php
│   │   ├── AdminAkunController.php
│   │   └── RektorController.php
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── LaporanModel.php
│   │   ├── GedungModel.php
│   │   ├── RuanganModel.php
│   │   ├── NotifikasiModel.php
│   │   └── LogAktivitasModel.php
│   ├── Filters/
│   │   ├── AuthFilter.php
│   │   ├── AdminFilter.php
│   │   ├── RektorFilter.php
│   │   └── SuperadminFilter.php
│   ├── Views/
│   │   ├── auth/
│   │   ├── laporan/
│   │   ├── admin/
│   │   ├── notifikasi/
│   │   └── rektor/
│   └── Config/
│       ├── Routes.php
│       └── Filters.php
├── public/
│   ├── uploads/
│   │   └── laporan/
│   └── assets/
├── writable/
│   └── logs/
└── .env
```

## 🔧 Konfigurasi Penting

### Routes (`app/Config/Routes.php`)

- Public routes: `/`, `/login`, `/register`
- User routes: `/dashboard`, `/laporan/*` (filter: auth)
- Admin routes: `/dashboardadmin`, `/laporanadmin*` (filter: admin)
- Rektor routes: `/rektor/*` (filter: rektor)

### Filters (`app/Config/Filters.php`)

```php
public array $aliases = [
    'auth' => \App\Filters\AuthFilter::class,
    'admin' => \App\Filters\AdminFilter::class,
    'rektor' => \App\Filters\RektorFilter::class,
    'superadmin' => \App\Filters\SuperadminFilter::class,
];
```

## 📊 Fitur Statistik & KPI

### Dashboard Admin

- Total laporan
- Laporan pending/diproses/selesai/ditolak
- Completion rate (%)
- Rata-rata waktu penyelesaian
- High risk aktif
- Laporan bulan ini
- Trend bulanan
- Distribusi prioritas
- Laporan per gedung
- Kinerja admin

### Dashboard Rektor

- Statistik lengkap
- Grafik trend
- Audit log aktivitas

## 🔔 Sistem Notifikasi

### Notifikasi User

- Laporan baru dibuat
- Status berubah (pending → diproses → selesai/ditolak)
- Keterangan verifikasi dari admin

### Notifikasi Admin

- Laporan baru masuk (pending)
- Laporan high priority

## 📝 Catatan Pengembangan

### Session Structure

```php
[
    'user_id' => int,
    'role' => 'user|admin|superadmin|rektor',
    'isLoggedIn' => true,
    'nama' => string,
    'email' => string
]
```

### Status Laporan

- `pending` - Menunggu verifikasi
- `diproses` - Sedang dikerjakan
- `selesai` - Selesai dikerjakan
- `ditolak` - Ditolak dengan alasan

### Prioritas

- `low` - Prioritas rendah
- `medium` - Prioritas sedang
- `high` - Prioritas tinggi (urgent)

## 🐛 Troubleshooting

### Error: Session tidak valid

- Pastikan session sudah di-set dengan benar di AuthController
- Cek `isLoggedIn`, `user_id`, dan `role` di session

### Error: Upload foto gagal

- Pastikan folder `public/uploads/laporan/` ada dan writable (chmod 777)

### Error: Notifikasi tidak muncul

- Cek apakah `NotifikasiModel::createNotifikasi()` dipanggil setelah verifikasi
- Pastikan `user_id` di laporan tidak NULL

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Developer

Developed by Zakkya Nurhadi - 2025
