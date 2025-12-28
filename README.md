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
    participant Browser
    participant AuthFilter
    participant AuthController
    participant LaporController
    participant AdminLaporController
    participant LaporanModel
    participant UserModel
    participant GedungModel
    participant RuanganModel
    participant LogAktivitasModel
    participant NotifikasiModel
    participant Database

    Mahasiswa->>Browser: Input email & password
    Browser->>AuthController: POST /login
    AuthController->>UserModel: Cari user (email/npm)
    UserModel->>Database: SELECT users
    Database-->>UserModel: Data user
    UserModel-->>AuthController: Validasi password
    AuthController->>AuthController: Set session
    AuthController-->>Browser: Redirect /dashboard

    Mahasiswa->>Browser: Akses /laporan
    Browser->>AuthFilter: Cek session
    AuthFilter-->>Browser: Allowed
    Browser->>LaporController: GET /laporan
    LaporController->>GedungModel: findAll()
    GedungModel->>Database: SELECT gedung
    Database-->>GedungModel: Data gedung
    LaporController->>RuanganModel: findAll()
    RuanganModel->>Database: SELECT ruangan
    Database-->>RuanganModel: Data ruangan
    LaporController-->>Browser: Render form

    Mahasiswa->>Browser: Submit laporan
    Browser->>LaporController: POST /laporan/store
    LaporController->>LaporController: Validasi & upload foto
    LaporController->>LaporanModel: insert()
    LaporanModel->>Database: INSERT laporan (status=pending)
    Database-->>LaporanModel: ID laporan
    LaporanModel-->>LaporController: Success
    LaporController-->>Browser: Redirect /laporan/saya

    Admin->>Browser: Login
    Browser->>AuthController: POST /login
    AuthController->>UserModel: Cari user
    UserModel->>Database: SELECT users
    Database-->>UserModel: Data admin
    UserModel-->>AuthController: Validasi
    AuthController->>AuthController: Set session
    AuthController-->>Browser: Redirect /dashboardadmin

    Admin->>Browser: Akses /laporanadminpending
    Browser->>AdminLaporController: GET /laporanadminpending
    AdminLaporController->>Database: SELECT laporan (status=pending)
    Database-->>AdminLaporController: Data laporan
    AdminLaporController-->>Browser: Render tabel

    Admin->>Browser: Update status laporan
    Browser->>AdminLaporController: POST /admin/laporan/verifikasi
    AdminLaporController->>AdminLaporController: Validasi
    AdminLaporController->>LaporanModel: update()
    LaporanModel->>Database: UPDATE laporan
    Database-->>LaporanModel: Success
    AdminLaporController->>LogAktivitasModel: catat()
    LogAktivitasModel->>Database: INSERT log_aktivitas
    Database-->>LogAktivitasModel: Success
    AdminLaporController->>LaporanModel: find()
    LaporanModel->>Database: SELECT laporan
    Database-->>LaporanModel: Data laporan
    AdminLaporController->>NotifikasiModel: createNotifikasi()
    NotifikasiModel->>Database: INSERT notifikasi
    Database-->>NotifikasiModel: Success
    AdminLaporController-->>Browser: Redirect back

    Mahasiswa->>Browser: Akses /notifikasi
    Browser->>NotifikasiModel: getByUserId()
    NotifikasiModel->>Database: SELECT notifikasi
    Database-->>NotifikasiModel: Data notifikasi
    NotifikasiModel-->>Browser: Render notifikasi
```

## 📊 Data Flow Diagram (DFD)

### DFD Level 0 - Context Diagram

```mermaid
flowchart TB
    subgraph External["External Entities"]
        CA[Civitas Akademik]
        A[Admin]
        R[Rektor]
    end

    subgraph System["Sistem Pelaporan Fasilitas"]
        S((SISTEM<br/>E-Fasilitas))
    end

    CA -->|Data Registrasi| S
    CA -->|Data Login| S
    CA -->|Data Laporan Fasilitas| S
    S -->|Status Laporan| CA
    S -->|Konfirmasi & Notifikasi| CA

    A -->|Data Login| S
    A -->|Data Verifikasi| S
    A -->|Data Gedung / Ruangan| S
    A -->|Data Users| S
    S -->|Data Laporan| A
    S -->|Notifikasi Laporan Baru| A

    R -->|Data Login| S
    S -->|Statistik & Rekap Laporan| R
    S -->|Audit Log Aktivitas| R
```

### DFD Level 1 - Detail Processes

```mermaid
flowchart TB
    %% Entities
    CA[Civitas Akademik]
    A[Admin]
    R[Rektor]

    %% Processes
    P1(1.0 Autentikasi)
    P2(2.0 Kelola Laporan)
    P3(3.0 Verifikasi Laporan)
    P4(4.0 Kelola Notifikasi)
    P5(5.0 Kelola Master Data)
    P6(6.0 Generate Statistik)

    %% Data Stores
    D1[(D1 Users)]
    D2[(D2 Laporan)]
    D3[(D3 Notifikasi)]
    D4[(D4 Gedung)]
    D5[(D5 Ruangan)]
    D6[(D6 Log Aktivitas)]

    %% Flow: Autentikasi
    CA -->|Data Registrasi / Login| P1
    A -->|Data Login| P1
    R -->|Data Login| P1
    P1 <-->|Validasi Check| D1
    P1 -->|Session / Token| CA
    P1 -->|Session / Token| A
    P1 -->|Session / Token| R

    %% Flow: Kelola Laporan (Civitas Akademik)
    CA -->|Input Laporan| P2
    D4 -.->|Info Gedung| P2
    D5 -.->|Info Ruangan| P2
    P2 -->|Simpan Laporan| D2
    P2 -->|Status Laporan| CA

    %% Flow: Verifikasi (Admin)
    A -->|Verifikasi & Validasi| P3
    D2 <-->|Read / Update Laporan| P3
    P3 -->|Catat Log| D6

    %% Flow: Notifikasi System
    P3 -->|Trigger Notifikasi| P4
    P4 -->|Simpan Notifikasi| D3
    D3 -.->|Load Notifikasi| P4
    P4 -->|Kirim Notifikasi| CA
    P4 -->|Kirim Notifikasi| A

    %% Flow: Master Data (Admin Managing Resources & Users)
    A -->|Manage Gedung / Ruangan / Users| P5
    P5 -->|CRUD Users| D1
    P5 -->|CRUD Gedung| D4
    P5 -->|CRUD Ruangan| D5

    %% Flow: Statistik (Rektor)
    R -->|Req Statistik| P6
    D2 -.->|Data Laporan| P6
    D6 -.->|Log Aktivitas| P6
    P6 -->|Laporan & Audit Log| R
```

### Penjelasan DFD

#### **External Entities:**

- **Civitas Akademik**: User yang membuat laporan kerusakan
- **Admin**: Mengelola dan memverifikasi laporan
- **Rektor**: Melihat statistik dan audit log

#### **Processes:**

1. **Autentikasi (1.0)**: Login, registrasi, forgot password
2. **Kelola Laporan (2.0)**: CRUD laporan oleh Civitas Akademik
3. **Verifikasi Laporan (3.0)**: Admin memverifikasi dan mengubah status
4. **Kelola Notifikasi (4.0)**: Sistem notifikasi untuk user dan admin
5. **Kelola Master Data (5.0)**: Manajemen gedung, ruangan, dan data users
6. **Generate Statistik (6.0)**: Dashboard KPI dan laporan untuk rektor

#### **Data Stores:**

- **D1: users** - Data pengguna (Civitas Akademik, Admin, Rektor)
- **D2: laporan** - Data laporan kerusakan
- **D3: notifikasi** - Data notifikasi
- **D4: gedung** - Master data gedung
- **D5: ruangan** - Master data ruangan
- **D6: log_aktivitas** - Audit trail aktivitas admin

## 🔐 Authentication Flowcharts

### Flowchart Login

```plantuml
@startuml Flowchart_Login
!define PROCESS_COLOR #E3F2FD
!define DECISION_COLOR #FFF9C4
!define TERMINATOR_COLOR #E8F5E9

skinparam activity {
    BackgroundColor PROCESS_COLOR
    BorderColor #1976D2
    FontSize 12
    ArrowColor #1976D2
}

skinparam activityDiamond {
    BackgroundColor DECISION_COLOR
    BorderColor #F57C00
    FontSize 11
}

start
:User Mengisi Form Login;
:Validasi Input;
if (Input Valid?) then (Ya)
    :Cari User di Database;
    if (User Ditemukan & Password Cocok?) then (Ya)
        :Set Session Data;
        if (Role User?) then (Admin/Superadmin)
            :Redirect ke Dashboard Admin;
        elseif (Role User?) then (Rektor)
            :Redirect ke Dashboard Rektor;
        else (Mahasiswa)
            :Redirect ke Dashboard User;
        endif
    else (Tidak)
        :Tampilkan Error "Kredensial Salah";
    endif
else (Tidak)
    :Tampilkan Error Validasi;
endif
stop
@enduml
```

### Flowchart Register

```plantuml
@startuml Flowchart_Register
!define PROCESS_COLOR #E3F2FD
!define DECISION_COLOR #FFF9C4
!define TERMINATOR_COLOR #E8F5E9

skinparam activity {
    BackgroundColor PROCESS_COLOR
    BorderColor #1976D2
    FontSize 12
    ArrowColor #1976D2
}

skinparam activityDiamond {
    BackgroundColor DECISION_COLOR
    BorderColor #F57C00
    FontSize 11
}

start
:Mahasiswa Mengisi Form Register;
:Validasi Kelengkapan Data;
if (Data Lengkap?) then (Ya)
    :Cek Duplikasi Email/NPM;
    if (Email/NPM Sudah Ada?) then (Ya)
        :Tampilkan Error "Sudah Terdaftar";
    else (Tidak)
        :Hash Password;
        :Simpan User ke Database;
        :Tampilkan Pesan Sukses;
        :Redirect ke Halaman Login;
    endif
else (Tidak)
    :Tampilkan Error Validasi;
endif
stop
@enduml
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
