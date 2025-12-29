# Sistem Pelaporan Fasilitas Kampus

Aplikasi berbasis web untuk mengelola laporan kerusakan fasilitas kampus menggunakan **CodeIgniter 4**.

## 📋 Deskripsi Sistem

Sistem ini memungkinkan civitas akademik untuk melaporkan kerusakan fasilitas kampus, admin memverifikasi dan mengelola laporan, serta rektor dapat melihat statistik dan audit log. Dilengkapi dengan notifikasi real-time, manajemen akun multi-role, dan dashboard statistik.

---

## 1️⃣ Mapping Chart Sistem

```mermaid
flowchart TB
    subgraph SISTEM["🏛️ SISTEM E-FASILITAS KAMPUS"]
        direction TB

        subgraph AUTH["🔐 Modul Autentikasi"]
            A1[Login]
            A2[Register]
            A3[Forgot Password]
            A4[Reset Password]
            A5[Logout]
        end

        subgraph USER["👤 Modul User/Mahasiswa"]
            U1[Dashboard User]
            U2[Buat Laporan]
            U3[Laporan Saya]
            U4[Edit Laporan]
            U5[Hapus Laporan]
            U6[Detail Laporan]
            U7[Riwayat Laporan]
            U8[Profil User]
            U9[Notifikasi User]
        end

        subgraph ADMIN["⚙️ Modul Admin"]
            AD1[Dashboard Admin]
            AD2[Laporan Pending]
            AD3[Laporan Diproses]
            AD4[Verifikasi Laporan]
            AD5[Detail Laporan]
            AD6[Riwayat Admin]
            AD7[Kelola Akun User]
            AD8[Profil Admin]
            AD9[Notifikasi Admin]
        end

        subgraph SUPERADMIN["👑 Modul Superadmin"]
            SA1[Dashboard Superadmin]
            SA2[Semua Fitur Admin]
            SA3[Kelola Gedung]
            SA4[Kelola Akun Admin]
            SA5[Tambah Admin Baru]
            SA6[Edit Akun Admin]
            SA7[Hapus Akun Admin]
        end

        subgraph REKTOR["📊 Modul Rektor"]
            R1[Dashboard Rektor]
            R2[Statistik & KPI]
            R3[Laporan Analitik]
            R4[Audit Log]
        end

        subgraph DATA["🗄️ Data Store"]
            D1[(Users)]
            D2[(Laporan)]
            D3[(Gedung)]
            D4[(Notifikasi)]
            D5[(Log Aktivitas)]
        end
    end

    AUTH --> USER
    AUTH --> ADMIN
    AUTH --> SUPERADMIN
    AUTH --> REKTOR

    USER --> D1 & D2 & D4
    ADMIN --> D1 & D2 & D4 & D5
    SUPERADMIN --> D1 & D2 & D3 & D4 & D5
    REKTOR --> D2 & D5
```

---

## 2️⃣ Data Flow Diagram (DFD)

### DFD Level 0 - Context Diagram

```mermaid
flowchart TB
    subgraph External["External Entities"]
        CA[👤 Civitas Akademik]
        A[⚙️ Admin]
        SA[👑 Superadmin]
        R[📊 Rektor]
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
    A -->|Data Gedung/Ruangan| S
    A -->|Data Users| S
    S -->|Data Laporan| A
    S -->|Notifikasi Laporan Baru| A

    SA -->|Data Login| S
    SA -->|Data Verifikasi| S
    SA -->|Data Gedung/Ruangan| S
    SA -->|Data Users| S
    SA -->|Data Akun Admin| S
    S -->|Data Laporan| SA
    S -->|Notifikasi Laporan Baru| SA
    S -->|Data Semua Admin| SA

    R -->|Data Login| S
    S -->|Statistik & Rekap Laporan| R
    S -->|Audit Log Aktivitas| R
```

### DFD Level 1 - Detail Processes

```mermaid
flowchart TB
    CA[👤 Civitas Akademik]
    A[⚙️ Admin]
    SA[👑 Superadmin]
    R[📊 Rektor]

    P1((1.0<br/>Autentikasi))
    P2((2.0<br/>Kelola Laporan))
    P3((3.0<br/>Verifikasi))
    P4((4.0<br/>Notifikasi))
    P5((5.0<br/>Master Data))
    P6((6.0<br/>Statistik))
    P7((7.0<br/>Kelola Admin))

    D1[(D1: Users)]
    D2[(D2: Laporan)]
    D3[(D3: Notifikasi)]
    D4[(D4: Gedung)]
    D5[(D5: Log Aktivitas)]

    CA -->|Registrasi/Login| P1
    A -->|Login| P1
    SA -->|Login| P1
    R -->|Login| P1
    P1 <-->|Validasi| D1
    P1 -->|Session| CA & A & SA & R

    CA -->|Input Laporan| P2
    D4 -.->|Info Gedung| P2
    P2 -->|Simpan| D2
    P2 -->|Status| CA

    A -->|Verifikasi| P3
    SA -->|Verifikasi| P3
    D2 <-->|Read/Update| P3
    P3 -->|Catat Log| D5

    P3 -->|Trigger| P4
    P4 -->|Simpan| D3
    P4 -->|Kirim| CA & A & SA

    SA -->|Manage Gedung| P5
    A -->|Manage User| P5
    SA -->|Manage User| P5
    P5 -->|CRUD Gedung| D4
    P5 -->|CRUD User| D1

    SA -->|Kelola Akun Admin| P7
    P7 -->|CRUD Admin| D1
    P7 -->|Cek Log| D5

    R -->|Request| P6
    D2 -.->|Data| P6
    D5 -.->|Log| P6
    P6 -->|Report| R
```

---

## 3️⃣ Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS ||--o{ LAPORAN : membuat
    USERS ||--o{ NOTIFIKASI : menerima
    USERS ||--o{ LOG_AKTIVITAS : melakukan

    GEDUNG ||--o{ LAPORAN : lokasi

    LAPORAN ||--o{ NOTIFIKASI : trigger
    LAPORAN ||--o{ LOG_AKTIVITAS : dicatat

    USERS {
        int id PK
        string npm
        string nama
        string email UK
        string password
        string img
        enum role "user,admin,superadmin,rektor"
        enum status "active,suspended"
        datetime created_at
        datetime updated_at
        string reset_token
        datetime token_created_at
    }

    LAPORAN {
        int id PK
        int user_id FK
        int gedung_id FK
        string nama_pelapor
        string lokasi_kerusakan
        string lokasi_spesifik
        text deskripsi
        string foto
        enum status "pending,diproses,selesai,ditolak"
        enum prioritas "low,medium,high"
        string kategori
        int admin_verifikator FK
        datetime tanggal_verifikasi
        text keterangan_verifikasi
        datetime created_at
        datetime updated_at
    }

    GEDUNG {
        int id PK
        string kode
        string nama
        text deskripsi
        datetime created_at
        datetime updated_at
    }

    NOTIFIKASI {
        int id PK
        int user_id FK
        int laporan_id FK
        text pesan
        boolean terbaca
        datetime created_at
    }

    LOG_AKTIVITAS {
        int id PK
        int admin_id FK
        int laporan_id FK
        string aktivitas
        datetime waktu
    }
```

---

## 4️⃣ Flowchart Landing Page

```mermaid
flowchart TD
    START([Mulai]) --> LP[Tampilan Landing Page<br/>Menu:<br/>1. Login<br/>2. Register<br/>3. Lihat Info]

    LP --> D1{Pilihan User?}

    D1 -->|1| LOGIN[Halaman Login]
    D1 -->|2| REGISTER[Halaman Register]
    D1 -->|3| INFO[Lihat Informasi Fasilitas]

    LOGIN --> FC_LOGIN[[Flowchart Login]]
    REGISTER --> FC_REG[[Flowchart Register]]
    INFO --> LP

    FC_LOGIN --> DASHBOARD[Dashboard Sesuai Role]
    FC_REG --> LOGIN

    DASHBOARD --> MENU_UTAMA[[Menu Utama Sesuai Role]]
```

---

## 5️⃣ Flowchart Login

```mermaid
flowchart TD
    START([Mulai]) --> FORM[User Mengisi Form Login<br/>- Email/NPM<br/>- Password]

    FORM --> SUBMIT[Submit Form]
    SUBMIT --> VAL{Input Valid?}

    VAL -->|Tidak| ERR1[Tampilkan Error Validasi]
    ERR1 --> FORM

    VAL -->|Ya| CARI[Cari User di Database]
    CARI --> FOUND{User Ditemukan?}

    FOUND -->|Tidak| ERR2[Tampilkan Error<br/>'User Tidak Ditemukan']
    ERR2 --> FORM

    FOUND -->|Ya| PASS{Password Cocok?}

    PASS -->|Tidak| ERR3[Tampilkan Error<br/>'Password Salah']
    ERR3 --> FORM

    PASS -->|Ya| SESSION[Set Session Data]
    SESSION --> ROLE{Cek Role User?}

    ROLE -->|user| DASH_USER[Redirect Dashboard User]
    ROLE -->|admin| DASH_ADMIN[Redirect Dashboard Admin]
    ROLE -->|superadmin| DASH_SADMIN[Redirect Dashboard Superadmin]
    ROLE -->|rektor| DASH_REKTOR[Redirect Dashboard Rektor]

    DASH_USER --> STOP([Selesai])
    DASH_ADMIN --> STOP
    DASH_SADMIN --> STOP
    DASH_REKTOR --> STOP
```

---

## 6️⃣ Flowchart Register

```mermaid
flowchart TD
    START([Mulai]) --> FORM[Mahasiswa Mengisi Form Register<br/>- Nama Lengkap<br/>- NPM<br/>- Email<br/>- Password<br/>- Konfirmasi Password]

    FORM --> SUBMIT[Submit Form]
    SUBMIT --> VAL{Data Lengkap & Valid?}

    VAL -->|Tidak| ERR1[Tampilkan Error Validasi]
    ERR1 --> FORM

    VAL -->|Ya| CEK_EMAIL{Email Sudah Terdaftar?}

    CEK_EMAIL -->|Ya| ERR2[Tampilkan Error<br/>'Email Sudah Digunakan']
    ERR2 --> FORM

    CEK_EMAIL -->|Tidak| CEK_NPM{NPM Sudah Terdaftar?}

    CEK_NPM -->|Ya| ERR3[Tampilkan Error<br/>'NPM Sudah Digunakan']
    ERR3 --> FORM

    CEK_NPM -->|Tidak| HASH[Hash Password]
    HASH --> SAVE[Simpan User ke Database<br/>Role = 'user']
    SAVE --> SUCCESS[Tampilkan Pesan Sukses]
    SUCCESS --> LOGIN[Redirect ke Halaman Login]
    LOGIN --> STOP([Selesai])
```

---

## 7️⃣ Flowchart Menu User (Mahasiswa)

```mermaid
flowchart TD
    START([Mulai]) --> DASH[Dashboard User<br/>Menu:<br/>1. Buat Laporan<br/>2. Laporan Saya<br/>3. Riwayat<br/>4. Notifikasi<br/>5. Profil<br/>6. Logout]

    DASH --> D1{Pilihan Menu?}

    D1 -->|1| FC_BUAT[[Flowchart Buat Laporan]]
    D1 -->|2| FC_SAYA[[Flowchart Laporan Saya]]
    D1 -->|3| RIWAYAT[Lihat Riwayat Laporan Selesai]
    D1 -->|4| NOTIF[Lihat Notifikasi]
    D1 -->|5| PROFIL[Edit Profil]
    D1 -->|6| LOGOUT[Logout]

    FC_BUAT --> DASH
    FC_SAYA --> DASH
    RIWAYAT --> DASH
    NOTIF --> DASH
    PROFIL --> DASH
    LOGOUT --> STOP([Selesai])
```

---

## 8️⃣ Flowchart Buat Laporan

```mermaid
flowchart TD
    START([Mulai]) --> FORM[Tampilan Form Laporan<br/>Menu:<br/>1. Isi Data Laporan<br/>2. Kembali]

    FORM --> D1{Pilihan?}

    D1 -->|2| BACK[Kembali ke Dashboard]
    BACK --> STOP([Selesai])

    D1 -->|1| ISI[Isi Form Laporan:<br/>- Pilih Gedung<br/>- Pilih Ruangan<br/>- Judul<br/>- Deskripsi<br/>- Kategori<br/>- Prioritas<br/>- Upload Foto]

    ISI --> SUBMIT[Submit Laporan]
    SUBMIT --> VAL{Data Valid?}

    VAL -->|Tidak| ERR[Tampilkan Error Validasi]
    ERR --> ISI

    VAL -->|Ya| FOTO{Ada Foto?}

    FOTO -->|Ya| UPLOAD[Upload & Validasi Foto]
    FOTO -->|Tidak| SAVE

    UPLOAD --> FOTO_VAL{Foto Valid?}
    FOTO_VAL -->|Tidak| ERR_FOTO[Error Format/Ukuran Foto]
    ERR_FOTO --> ISI

    FOTO_VAL -->|Ya| SAVE[Simpan Laporan ke Database<br/>Status = 'pending']

    SAVE --> NOTIF[Kirim Notifikasi ke Admin]
    NOTIF --> SUCCESS[Tampilkan Pesan Sukses]
    SUCCESS --> REDIRECT[Redirect ke Laporan Saya]
    REDIRECT --> STOP
```

---

## 9️⃣ Flowchart Laporan Saya (CRUD)

```mermaid
flowchart TD
    START([Mulai]) --> LIST[Tampilan Daftar Laporan Saya<br/>Menu:<br/>1. Lihat Detail<br/>2. Edit Laporan<br/>3. Hapus Laporan<br/>4. Kembali]

    LIST --> D1{Pilihan?}

    D1 -->|4| BACK[Kembali ke Dashboard]
    BACK --> STOP([Selesai])

    D1 -->|1| DETAIL[Lihat Detail Laporan]
    DETAIL --> LIST

    D1 -->|2| CEK_EDIT{Status = Pending/Ditolak?}
    CEK_EDIT -->|Tidak| ERR_EDIT[Tidak Bisa Edit<br/>Status Sudah Diproses/Selesai]
    ERR_EDIT --> LIST

    CEK_EDIT -->|Ya| EDIT[Form Edit Laporan]
    EDIT --> SAVE_EDIT{Simpan Perubahan?}
    SAVE_EDIT -->|Ya| UPDATE[Update Data di Database]
    UPDATE --> SUCCESS_EDIT[Berhasil Diupdate]
    SUCCESS_EDIT --> LIST
    SAVE_EDIT -->|Tidak| LIST

    D1 -->|3| CEK_DEL{Status = Pending/Ditolak?}
    CEK_DEL -->|Tidak| ERR_DEL[Tidak Bisa Hapus<br/>Status Sudah Diproses/Selesai]
    ERR_DEL --> LIST

    CEK_DEL -->|Ya| KONFIRM{Konfirmasi Hapus?}
    KONFIRM -->|Tidak| LIST
    KONFIRM -->|Ya| HAPUS[Hapus Laporan & Foto]
    HAPUS --> SUCCESS_DEL[Berhasil Dihapus]
    SUCCESS_DEL --> LIST
```

---

## 🔟 Flowchart Menu Admin

```mermaid
flowchart TD
    START([Mulai]) --> DASH[Dashboard Admin<br/>Menu:<br/>1. Laporan Pending<br/>2. Laporan Diproses<br/>3. Riwayat/Selesai<br/>4. Kelola Akun User<br/>5. Notifikasi<br/>6. Profil<br/>7. Logout]

    DASH --> D1{Pilihan Menu?}

    D1 -->|1| FC_PENDING[[Flowchart Verifikasi Pending]]
    D1 -->|2| FC_PROSES[[Flowchart Laporan Diproses]]
    D1 -->|3| RIWAYAT[Lihat Riwayat Selesai/Ditolak]
    D1 -->|4| FC_AKUN_USER[[Flowchart Kelola Akun User]]
    D1 -->|5| NOTIF[Lihat Notifikasi]
    D1 -->|6| PROFIL[Edit Profil Admin]
    D1 -->|7| LOGOUT[Logout]

    FC_PENDING --> DASH
    FC_PROSES --> DASH
    RIWAYAT --> DASH
    FC_AKUN_USER --> DASH
    NOTIF --> DASH
    PROFIL --> DASH
    LOGOUT --> STOP([Selesai])
```

---

## 🔟.1️⃣ Flowchart Menu Superadmin

```mermaid
flowchart TD
    START([Mulai]) --> DASH[Dashboard Superadmin<br/>Menu:<br/>1. Laporan Pending<br/>2. Laporan Diproses<br/>3. Riwayat/Selesai<br/>4. Kelola Gedung<br/>5. Kelola Akun User<br/>6. Kelola Akun Admin<br/>7. Notifikasi<br/>8. Profil<br/>9. Logout]

    DASH --> D1{Pilihan Menu?}

    D1 -->|1| FC_PENDING[[Flowchart Verifikasi Pending]]
    D1 -->|2| FC_PROSES[[Flowchart Laporan Diproses]]
    D1 -->|3| RIWAYAT[Lihat Riwayat Selesai/Ditolak]
    D1 -->|4| FC_GEDUNG[[Flowchart Kelola Gedung]]
    D1 -->|5| FC_AKUN_USER[[Flowchart Kelola Akun User]]
    D1 -->|6| FC_AKUN_ADMIN[[Flowchart Kelola Akun Admin]]
    D1 -->|7| NOTIF[Lihat Notifikasi]
    D1 -->|8| PROFIL[Edit Profil Superadmin]
    D1 -->|9| LOGOUT[Logout]

    FC_PENDING --> DASH
    FC_PROSES --> DASH
    RIWAYAT --> DASH
    FC_GEDUNG --> DASH
    FC_AKUN_USER --> DASH
    FC_AKUN_ADMIN --> DASH
    NOTIF --> DASH
    PROFIL --> DASH
    LOGOUT --> STOP([Selesai])
```

---

## 🔟.2️⃣ Flowchart Kelola Akun Admin (Superadmin Only)

```mermaid
flowchart TD
    START([Mulai]) --> LIST[Tampilan Daftar Akun Admin<br/>Menu:<br/>1. Tambah Admin<br/>2. Edit Admin<br/>3. Hapus Admin<br/>4. Kembali]

    LIST --> D1{Pilihan?}

    D1 -->|4| BACK[Kembali ke Dashboard]
    BACK --> STOP([Selesai])

    D1 -->|1| TAMBAH[Form Tambah Akun Admin<br/>- Nama<br/>- Email<br/>- Password<br/>- Role = admin]
    TAMBAH --> VAL{Data Valid?}
    VAL -->|Tidak| ERR1[Error Validasi]
    ERR1 --> TAMBAH
    VAL -->|Ya| CEK_DUP{Email Duplikat?}
    CEK_DUP -->|Ya| ERR2[Error: Email Sudah Digunakan]
    ERR2 --> TAMBAH
    CEK_DUP -->|Tidak| HASH[Hash Password]
    HASH --> INSERT[Simpan ke Database<br/>Role = 'admin']
    INSERT --> SUCCESS_ADD[Admin Berhasil Ditambah]
    SUCCESS_ADD --> LIST

    D1 -->|2| SELECT_EDIT[Pilih Admin yang Akan Diedit]
    SELECT_EDIT --> EDIT[Form Edit Admin<br/>- Nama<br/>- Email<br/>- Password Baru Optional]
    EDIT --> SAVE_EDIT{Simpan Perubahan?}
    SAVE_EDIT -->|Tidak| LIST
    SAVE_EDIT -->|Ya| UPDATE[Update Database]
    UPDATE --> SUCCESS_EDIT[Admin Berhasil Diupdate]
    SUCCESS_EDIT --> LIST

    D1 -->|3| SELECT_DEL[Pilih Admin yang Akan Dihapus]
    SELECT_DEL --> CEK_SELF{Hapus Diri Sendiri?}
    CEK_SELF -->|Ya| ERR3[Error: Tidak Bisa<br/>Menghapus Akun Sendiri]
    ERR3 --> LIST
    CEK_SELF -->|Tidak| KONFIRM{Konfirmasi Hapus Admin?}
    KONFIRM -->|Tidak| LIST
    KONFIRM -->|Ya| CEK_LOG{Admin Punya Log Aktivitas?}
    CEK_LOG -->|Ya| WARN[Warning: Admin Memiliki<br/>Riwayat Aktivitas]
    WARN --> FORCE{Tetap Hapus?}
    FORCE -->|Tidak| LIST
    FORCE -->|Ya| DELETE
    CEK_LOG -->|Tidak| DELETE[Hapus dari Database]
    DELETE --> SUCCESS_DEL[Admin Berhasil Dihapus]
    SUCCESS_DEL --> LIST
```

---

## 1️⃣1️⃣ Flowchart Verifikasi Laporan (Admin)

```mermaid
flowchart TD
    START([Mulai]) --> LIST[Tampilan Daftar Laporan<br/>Menu:<br/>1. Lihat Detail<br/>2. Verifikasi/Update Status<br/>3. Kembali]

    LIST --> D1{Pilihan?}

    D1 -->|3| BACK[Kembali ke Dashboard]
    BACK --> STOP([Selesai])

    D1 -->|1| DETAIL[Lihat Detail Laporan<br/>+ Foto + Info Pelapor]
    DETAIL --> LIST

    D1 -->|2| VERIF[Form Verifikasi<br/>- Pilih Status Baru<br/>- Isi Keterangan]

    VERIF --> STATUS{Status Baru?}

    STATUS -->|diproses| SIMPAN
    STATUS -->|selesai| SIMPAN
    STATUS -->|ditolak| SIMPAN

    SIMPAN[Update Status di Database]
    SIMPAN --> LOG[Catat Log Aktivitas]
    LOG --> NOTIF[Kirim Notifikasi ke User]
    NOTIF --> SUCCESS[Tampilkan Pesan Sukses]
    SUCCESS --> LIST
```

---

## 1️⃣2️⃣ Flowchart Kelola Gedung (Superadmin Only)

```mermaid
flowchart TD
    START([Mulai]) --> LIST[Tampilan Daftar Gedung<br/>Menu:<br/>1. Tambah Gedung<br/>2. Edit Gedung<br/>3. Hapus Gedung<br/>4. Kembali]

    LIST --> D1{Pilihan?}

    D1 -->|4| BACK[Kembali ke Dashboard]
    BACK --> STOP([Selesai])

    D1 -->|1| TAMBAH[Form Tambah Gedung<br/>- Kode Gedung<br/>- Nama Gedung<br/>- Deskripsi]
    TAMBAH --> SAVE_ADD{Simpan?}
    SAVE_ADD -->|Ya| INSERT[Insert ke Database]
    INSERT --> LOG_ADD[Catat Log Aktivitas]
    LOG_ADD --> SUCCESS_ADD[Gedung Berhasil Ditambah]
    SUCCESS_ADD --> LIST
    SAVE_ADD -->|Tidak| LIST

    D1 -->|2| EDIT[Form Edit Gedung]
    EDIT --> SAVE_EDIT{Simpan?}
    SAVE_EDIT -->|Ya| UPDATE[Update Database]
    UPDATE --> LOG_EDIT[Catat Log Aktivitas]
    LOG_EDIT --> SUCCESS_EDIT[Gedung Berhasil Diupdate]
    SUCCESS_EDIT --> LIST
    SAVE_EDIT -->|Tidak| LIST

    D1 -->|3| KONFIRM{Konfirmasi Hapus?}
    KONFIRM -->|Tidak| LIST
    KONFIRM -->|Ya| CEK{Ada Laporan Terkait?}
    CEK -->|Ya| ERR[Tidak Bisa Hapus<br/>Masih Ada Laporan]
    ERR --> LIST
    CEK -->|Tidak| DELETE[Hapus dari Database]
    DELETE --> LOG_DEL[Catat Log Aktivitas]
    LOG_DEL --> SUCCESS_DEL[Gedung Berhasil Dihapus]
    SUCCESS_DEL --> LIST
```

---

## 1️⃣3️⃣ Flowchart Kelola Akun User

```mermaid
flowchart TD
    START([Mulai]) --> LIST[Tampilan Daftar Akun<br/>Menu:<br/>1. Tambah Akun<br/>2. Edit Akun<br/>3. Hapus Akun<br/>4. Kembali]

    LIST --> D1{Pilihan?}

    D1 -->|4| BACK[Kembali ke Dashboard]
    BACK --> STOP([Selesai])

    D1 -->|1| TAMBAH[Form Tambah Akun<br/>- Nama, Email, NPM<br/>- Password, Role]
    TAMBAH --> VAL{Data Valid?}
    VAL -->|Tidak| ERR1[Error Validasi]
    ERR1 --> TAMBAH
    VAL -->|Ya| CEK_DUP{Email/NPM Duplikat?}
    CEK_DUP -->|Ya| ERR2[Error Duplikasi]
    ERR2 --> TAMBAH
    CEK_DUP -->|Tidak| INSERT[Simpan ke Database]
    INSERT --> SUCCESS_ADD[Berhasil Ditambah]
    SUCCESS_ADD --> LIST

    D1 -->|2| EDIT[Form Edit Akun]
    EDIT --> UPDATE[Update Database]
    UPDATE --> SUCCESS_EDIT[Berhasil Diupdate]
    SUCCESS_EDIT --> LIST

    D1 -->|3| KONFIRM{Konfirmasi Hapus?}
    KONFIRM -->|Tidak| LIST
    KONFIRM -->|Ya| CEK_LAP{Punya Laporan?}
    CEK_LAP -->|Ya| ERR3[Tidak Bisa Hapus<br/>User Punya Laporan]
    ERR3 --> LIST
    CEK_LAP -->|Tidak| DELETE[Hapus dari Database]
    DELETE --> SUCCESS_DEL[Berhasil Dihapus]
    SUCCESS_DEL --> LIST
```

---

## 1️⃣4️⃣ Flowchart Menu Rektor

```mermaid
flowchart TD
    START([Mulai]) --> DASH[Dashboard Rektor<br/>Menu:<br/>1. Statistik & KPI<br/>2. Laporan Analitik<br/>3. Audit Log<br/>4. Logout]

    DASH --> D1{Pilihan Menu?}

    D1 -->|1| STAT[Lihat Statistik:<br/>- Total Laporan<br/>- Completion Rate<br/>- Trend Bulanan<br/>- Per Gedung]
    D1 -->|2| ANALITIK[Lihat Laporan Analitik:<br/>- Grafik Prioritas<br/>- Kinerja Admin<br/>- Distribusi Kategori]
    D1 -->|3| AUDIT[Lihat Audit Log:<br/>- Aktivitas Admin<br/>- Riwayat Verifikasi]
    D1 -->|4| LOGOUT[Logout]

    STAT --> DASH
    ANALITIK --> DASH
    AUDIT --> DASH
    LOGOUT --> STOP([Selesai])
```

---

## 1️⃣5️⃣ Flowchart Notifikasi

```mermaid
flowchart TD
    START([Mulai]) --> LIST[Tampilan Daftar Notifikasi<br/>Menu:<br/>1. Lihat Notifikasi<br/>2. Tandai Dibaca<br/>3. Tandai Semua Dibaca<br/>4. Hapus Notifikasi<br/>5. Hapus Semua<br/>6. Kembali]

    LIST --> D1{Pilihan?}

    D1 -->|6| BACK[Kembali ke Dashboard]
    BACK --> STOP([Selesai])

    D1 -->|1| VIEW[Lihat Detail Notifikasi]
    VIEW --> MARK[Otomatis Tandai Dibaca]
    MARK --> LIST

    D1 -->|2| READ[Update is_read = true]
    READ --> LIST

    D1 -->|3| READ_ALL[Update Semua is_read = true]
    READ_ALL --> LIST

    D1 -->|4| KONFIRM{Konfirmasi Hapus?}
    KONFIRM -->|Tidak| LIST
    KONFIRM -->|Ya| DELETE[Hapus dari Database]
    DELETE --> LIST

    D1 -->|5| KONFIRM_ALL{Hapus Semua?}
    KONFIRM_ALL -->|Tidak| LIST
    KONFIRM_ALL -->|Ya| DELETE_ALL[Hapus Semua Notifikasi]
    DELETE_ALL --> LIST
```

---

## 1️⃣6️⃣ Flowchart Forgot Password

```mermaid
flowchart TD
    START([Mulai]) --> FORM[Form Lupa Password<br/>Input: Email]

    FORM --> SUBMIT[Submit]
    SUBMIT --> VAL{Email Valid?}

    VAL -->|Tidak| ERR1[Error: Format Email Salah]
    ERR1 --> FORM

    VAL -->|Ya| CARI[Cari Email di Database]
    CARI --> FOUND{Email Ditemukan?}

    FOUND -->|Tidak| ERR2[Error: Email Tidak Terdaftar]
    ERR2 --> FORM

    FOUND -->|Ya| TOKEN[Generate Reset Token]
    TOKEN --> SAVE[Simpan Token + Expiry ke DB]
    SAVE --> SEND[Kirim Email Reset Password]
    SEND --> SUCCESS[Tampilkan: Cek Email Anda]
    SUCCESS --> STOP([Selesai])
```

---

## 1️⃣7️⃣ Flowchart Reset Password

```mermaid
flowchart TD
    START([Mulai]) --> LINK[User Klik Link dari Email]

    LINK --> CEK_TOKEN{Token Valid?}

    CEK_TOKEN -->|Tidak| ERR1[Error: Token Invalid/Expired]
    ERR1 --> STOP([Selesai])

    CEK_TOKEN -->|Ya| FORM[Form Password Baru<br/>- Password Baru<br/>- Konfirmasi Password]

    FORM --> SUBMIT[Submit]
    SUBMIT --> MATCH{Password Match?}

    MATCH -->|Tidak| ERR2[Error: Password Tidak Sama]
    ERR2 --> FORM

    MATCH -->|Ya| HASH[Hash Password Baru]
    HASH --> UPDATE[Update Password di Database]
    UPDATE --> CLEAR[Hapus Reset Token]
    CLEAR --> SUCCESS[Tampilkan: Password Berhasil Diubah]
    SUCCESS --> LOGIN[Redirect ke Login]
    LOGIN --> STOP
```

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

### Sequence Diagram - Alur User & Admin

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
    AuthController->>AuthController: Set session (role=admin)
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

### Sequence Diagram - Alur Superadmin (Kelola Akun Admin)

```mermaid
sequenceDiagram
    autonumber

    actor Superadmin
    participant Browser
    participant AuthFilter
    participant AuthController
    participant AdminAkunController
    participant UserModel
    participant LogAktivitasModel
    participant Database

    Superadmin->>Browser: Login
    Browser->>AuthController: POST /login
    AuthController->>UserModel: Cari user
    UserModel->>Database: SELECT users
    Database-->>UserModel: Data superadmin
    UserModel-->>AuthController: Validasi password
    AuthController->>AuthController: Set session (role=superadmin)
    AuthController-->>Browser: Redirect /dashboardadmin

    Superadmin->>Browser: Akses /akunadmin
    Browser->>AuthFilter: Cek session & role
    AuthFilter->>AuthFilter: Validasi role=superadmin
    AuthFilter-->>Browser: Allowed
    Browser->>AdminAkunController: GET /akunadmin
    AdminAkunController->>UserModel: where('role', 'admin')
    UserModel->>Database: SELECT users WHERE role='admin'
    Database-->>UserModel: Data admin
    AdminAkunController-->>Browser: Render tabel akun admin

    Superadmin->>Browser: Tambah Admin Baru
    Browser->>AdminAkunController: POST /akun/store
    AdminAkunController->>AdminAkunController: Validasi input
    AdminAkunController->>UserModel: cekDuplikasiEmail()
    UserModel->>Database: SELECT users WHERE email=?
    Database-->>UserModel: Null (tidak ada)
    AdminAkunController->>AdminAkunController: Hash password
    AdminAkunController->>UserModel: insert(role='admin')
    UserModel->>Database: INSERT users
    Database-->>UserModel: Success
    AdminAkunController-->>Browser: Redirect /akunadmin + Flash success

    Superadmin->>Browser: Edit Akun Admin
    Browser->>AdminAkunController: POST /akun/update
    AdminAkunController->>UserModel: update()
    UserModel->>Database: UPDATE users
    Database-->>UserModel: Success
    AdminAkunController-->>Browser: Redirect back

    Superadmin->>Browser: Hapus Akun Admin
    Browser->>AdminAkunController: GET /akun/delete/{id}
    AdminAkunController->>AdminAkunController: Cek bukan diri sendiri
    AdminAkunController->>LogAktivitasModel: cekLogAdmin()
    LogAktivitasModel->>Database: SELECT log WHERE user_id=?
    Database-->>LogAktivitasModel: Data log (jika ada)
    AdminAkunController->>UserModel: delete()
    UserModel->>Database: DELETE users WHERE id=?
    Database-->>UserModel: Success
    AdminAkunController-->>Browser: Redirect /akunadmin
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
