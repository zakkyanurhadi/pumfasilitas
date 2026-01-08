# Dokumen Black Box Testing
## Sistem Pelaporan Fasilitas Kampus

### Informasi Dokumen
| Item | Keterangan |
|------|------------|
| **Nama Aplikasi** | Sistem Pelaporan Fasilitas Kampus (PUM Fasilitas) |
| **Versi** | 1.0 |
| **Metode Testing** | Black Box Testing |
| **Teknik** | Equivalence Partitioning & Boundary Value Analysis |

---

## 1. Pengujian Modul Autentikasi

### 1.1 Pengujian Halaman Login

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| L-01 | Login dengan kredensial valid | Memasukkan email dan password yang terdaftar | Email: user@test.com, Password: Password123 | Berhasil login dan diarahkan ke dashboard sesuai role | | ☐ |
| L-02 | Login dengan email kosong | Mengosongkan field email | Email: (kosong), Password: Password123 | Menampilkan pesan error "Email wajib diisi" | | ☐ |
| L-03 | Login dengan password kosong | Mengosongkan field password | Email: user@test.com, Password: (kosong) | Menampilkan pesan error "Password wajib diisi" | | ☐ |
| L-04 | Login dengan email dan password kosong | Mengosongkan semua field | Email: (kosong), Password: (kosong) | Menampilkan pesan error validasi | | ☐ |
| L-05 | Login dengan email tidak terdaftar | Memasukkan email yang belum terdaftar | Email: tidakada@test.com, Password: Password123 | Menampilkan pesan error "User tidak ditemukan" | | ☐ |
| L-06 | Login dengan password salah | Memasukkan password yang tidak sesuai | Email: user@test.com, Password: SalahPassword | Menampilkan pesan error "Password salah" | | ☐ |
| L-07 | Login dengan format email tidak valid | Memasukkan email tanpa format yang benar | Email: emailsalah, Password: Password123 | Menampilkan pesan error "Format email tidak valid" | | ☐ |
| L-08 | Login sebagai role User | Login dengan akun role user | Email: mahasiswa@univ.ac.id, Password: User123 | Diarahkan ke Dashboard User | | ☐ |
| L-09 | Login sebagai role Admin | Login dengan akun role admin | Email: admin@univ.ac.id, Password: Admin123 | Diarahkan ke Dashboard Admin | | ☐ |
| L-10 | Login sebagai role Superadmin | Login dengan akun role superadmin | Email: superadmin@univ.ac.id, Password: Super123 | Diarahkan ke Dashboard Superadmin | | ☐ |
| L-11 | Login sebagai role Rektor | Login dengan akun role rektor | Email: rektor@univ.ac.id, Password: Rektor123 | Diarahkan ke Dashboard Rektor | | ☐ |

### 1.2 Pengujian Halaman Register

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| R-01 | Registrasi dengan data valid | Mengisi semua field dengan data valid | Nama: John Doe, NPM: 123456789, Email: john@test.com, Password: Pass123, Konfirmasi: Pass123 | Berhasil registrasi dan diarahkan ke halaman login | | ☐ |
| R-02 | Registrasi dengan nama kosong | Mengosongkan field nama | Nama: (kosong), NPM: 123456789, Email: john@test.com, Password: Pass123 | Menampilkan pesan error "Nama wajib diisi" | | ☐ |
| R-03 | Registrasi dengan NPM kosong | Mengosongkan field NPM | Nama: John Doe, NPM: (kosong), Email: john@test.com, Password: Pass123 | Menampilkan pesan error "NPM wajib diisi" | | ☐ |
| R-04 | Registrasi dengan email kosong | Mengosongkan field email | Nama: John Doe, NPM: 123456789, Email: (kosong), Password: Pass123 | Menampilkan pesan error "Email wajib diisi" | | ☐ |
| R-05 | Registrasi dengan password kosong | Mengosongkan field password | Nama: John Doe, NPM: 123456789, Email: john@test.com, Password: (kosong) | Menampilkan pesan error "Password wajib diisi" | | ☐ |
| R-06 | Registrasi dengan email sudah terdaftar | Menggunakan email yang sudah ada di database | Email: existing@test.com | Menampilkan pesan error "Email sudah digunakan" | | ☐ |
| R-07 | Registrasi dengan NPM sudah terdaftar | Menggunakan NPM yang sudah ada di database | NPM: 111111111 (sudah terdaftar) | Menampilkan pesan error "NPM sudah digunakan" | | ☐ |
| R-08 | Registrasi dengan password tidak cocok | Konfirmasi password berbeda | Password: Pass123, Konfirmasi: Pass456 | Menampilkan pesan error "Konfirmasi password tidak sesuai" | | ☐ |
| R-09 | Registrasi dengan format email tidak valid | Memasukkan email tanpa format yang benar | Email: emailsalah | Menampilkan pesan error "Format email tidak valid" | | ☐ |
| R-10 | Registrasi dengan password terlalu pendek | Password kurang dari minimum karakter | Password: 123 | Menampilkan pesan error "Password minimal 6 karakter" | | ☐ |

### 1.3 Pengujian Forgot Password

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| FP-01 | Request reset password dengan email valid | Memasukkan email terdaftar | Email: user@test.com | Menampilkan pesan sukses dan email terkirim | | ☐ |
| FP-02 | Request reset password dengan email kosong | Mengosongkan field email | Email: (kosong) | Menampilkan pesan error "Email wajib diisi" | | ☐ |
| FP-03 | Request reset password dengan email tidak terdaftar | Memasukkan email yang tidak ada di database | Email: tidakada@test.com | Menampilkan pesan error "Email tidak terdaftar" | | ☐ |
| FP-04 | Request reset password dengan format email salah | Memasukkan email tanpa format benar | Email: emailsalah | Menampilkan pesan error "Format email tidak valid" | | ☐ |

### 1.4 Pengujian Reset Password

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| RP-01 | Reset password dengan token valid | Mengakses link reset dengan token valid | Token: valid_token, Password: NewPass123 | Password berhasil diubah dan diarahkan ke login | | ☐ |
| RP-02 | Reset password dengan token expired | Mengakses link reset dengan token kadaluarsa | Token: expired_token | Menampilkan pesan error "Token sudah kadaluarsa" | | ☐ |
| RP-03 | Reset password dengan token invalid | Mengakses link reset dengan token salah | Token: invalid_token | Menampilkan pesan error "Token tidak valid" | | ☐ |
| RP-04 | Reset password dengan password tidak cocok | Konfirmasi password berbeda | Password: NewPass123, Konfirmasi: NewPass456 | Menampilkan pesan error "Password tidak sesuai" | | ☐ |
| RP-05 | Reset password dengan password kosong | Mengosongkan field password | Password: (kosong) | Menampilkan pesan error "Password wajib diisi" | | ☐ |

### 1.5 Pengujian Logout

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| LO-01 | Logout dari sistem | Klik tombol logout | User sudah login | Session dihapus dan diarahkan ke halaman login | | ☐ |
| LO-02 | Akses halaman terproteksi setelah logout | Mengakses dashboard setelah logout | URL: /dashboard | Diarahkan ke halaman login | | ☐ |

---

## 2. Pengujian Modul User/Mahasiswa

### 2.1 Pengujian Dashboard User

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| DU-01 | Menampilkan dashboard user | Akses halaman dashboard | User sudah login | Menampilkan dashboard dengan statistik laporan | | ☐ |
| DU-02 | Menampilkan jumlah laporan | Melihat statistik di dashboard | User memiliki laporan | Menampilkan jumlah laporan sesuai status | | ☐ |

### 2.2 Pengujian Buat Laporan

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| BL-01 | Membuat laporan dengan data lengkap | Mengisi semua field dengan benar | Gedung: Gedung A, Lokasi: Lantai 1, Deskripsi: AC rusak, Kategori: Elektronik, Prioritas: High, Foto: gambar.jpg | Laporan berhasil dibuat dengan status "pending" | | ☐ |
| BL-02 | Membuat laporan tanpa pilih gedung | Tidak memilih gedung | Gedung: (tidak dipilih) | Menampilkan pesan error "Gedung wajib dipilih" | | ☐ |
| BL-03 | Membuat laporan tanpa lokasi | Mengosongkan field lokasi | Lokasi: (kosong) | Menampilkan pesan error "Lokasi wajib diisi" | | ☐ |
| BL-04 | Membuat laporan tanpa deskripsi | Mengosongkan field deskripsi | Deskripsi: (kosong) | Menampilkan pesan error "Deskripsi wajib diisi" | | ☐ |
| BL-05 | Membuat laporan tanpa kategori | Tidak memilih kategori | Kategori: (tidak dipilih) | Menampilkan pesan error "Kategori wajib dipilih" | | ☐ |
| BL-06 | Membuat laporan tanpa prioritas | Tidak memilih prioritas | Prioritas: (tidak dipilih) | Menampilkan pesan error "Prioritas wajib dipilih" | | ☐ |
| BL-07 | Membuat laporan dengan foto format tidak valid | Upload file bukan gambar | Foto: document.pdf | Menampilkan pesan error "Format file tidak valid" | | ☐ |
| BL-08 | Membuat laporan dengan foto ukuran terlalu besar | Upload foto melebihi batas | Foto: gambar_besar.jpg (>5MB) | Menampilkan pesan error "Ukuran file terlalu besar" | | ☐ |
| BL-09 | Membuat laporan tanpa foto | Tidak mengupload foto | Foto: (kosong) | Laporan berhasil dibuat tanpa foto | | ☐ |

### 2.3 Pengujian Laporan Saya

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| LS-01 | Melihat daftar laporan saya | Akses halaman laporan saya | User memiliki laporan | Menampilkan daftar laporan milik user | | ☐ |
| LS-02 | Melihat detail laporan | Klik tombol detail pada laporan | ID Laporan: 1 | Menampilkan detail lengkap laporan | | ☐ |
| LS-03 | Melihat daftar laporan kosong | Akses halaman laporan saya | User belum memiliki laporan | Menampilkan pesan "Belum ada laporan" | | ☐ |

### 2.4 Pengujian Edit Laporan

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| EL-01 | Edit laporan dengan status pending | Mengubah data laporan pending | Status: pending, Deskripsi baru: AC mati total | Laporan berhasil diupdate | | ☐ |
| EL-02 | Edit laporan dengan status ditolak | Mengubah data laporan ditolak | Status: ditolak, Data baru | Laporan berhasil diupdate | | ☐ |
| EL-03 | Edit laporan dengan status diproses | Mencoba edit laporan diproses | Status: diproses | Menampilkan pesan error "Tidak dapat mengedit laporan yang sedang diproses" | | ☐ |
| EL-04 | Edit laporan dengan status selesai | Mencoba edit laporan selesai | Status: selesai | Menampilkan pesan error "Tidak dapat mengedit laporan yang sudah selesai" | | ☐ |
| EL-05 | Edit laporan dengan deskripsi kosong | Mengosongkan deskripsi saat edit | Deskripsi: (kosong) | Menampilkan pesan error "Deskripsi wajib diisi" | | ☐ |

### 2.5 Pengujian Hapus Laporan

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| HL-01 | Hapus laporan dengan status pending | Menghapus laporan pending | Status: pending | Laporan berhasil dihapus | | ☐ |
| HL-02 | Hapus laporan dengan status ditolak | Menghapus laporan ditolak | Status: ditolak | Laporan berhasil dihapus | | ☐ |
| HL-03 | Hapus laporan dengan status diproses | Mencoba hapus laporan diproses | Status: diproses | Menampilkan pesan error "Tidak dapat menghapus laporan yang sedang diproses" | | ☐ |
| HL-04 | Hapus laporan dengan status selesai | Mencoba hapus laporan selesai | Status: selesai | Menampilkan pesan error "Tidak dapat menghapus laporan yang sudah selesai" | | ☐ |
| HL-05 | Batalkan konfirmasi hapus | Klik batal pada konfirmasi hapus | Konfirmasi: Tidak | Laporan tidak dihapus, kembali ke daftar | | ☐ |

### 2.6 Pengujian Riwayat Laporan

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| RL-01 | Melihat riwayat laporan selesai | Akses halaman riwayat | User memiliki laporan selesai | Menampilkan daftar laporan dengan status selesai/ditolak | | ☐ |
| RL-02 | Riwayat laporan kosong | Akses halaman riwayat | User belum memiliki riwayat | Menampilkan pesan "Belum ada riwayat laporan" | | ☐ |

---

## 3. Pengujian Modul Profile

### 3.1 Pengujian Profile User

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| PU-01 | Menampilkan halaman profile | Akses halaman profile | User sudah login | Menampilkan data profile user | | ☐ |
| PU-02 | Update nama profile | Mengubah nama | Nama baru: John Updated | Profile berhasil diupdate | | ☐ |
| PU-03 | Update foto profile dengan format valid | Upload foto baru | Foto: profile.jpg | Foto profile berhasil diubah | | ☐ |
| PU-04 | Update foto profile dengan format tidak valid | Upload file bukan gambar | Foto: document.pdf | Menampilkan pesan error "Format file tidak valid" | | ☐ |
| PU-05 | Update password dengan password lama benar | Mengubah password | Password lama: OldPass123, Password baru: NewPass123 | Password berhasil diubah | | ☐ |
| PU-06 | Update password dengan password lama salah | Password lama tidak sesuai | Password lama: SalahPass | Menampilkan pesan error "Password lama tidak sesuai" | | ☐ |
| PU-07 | Update email dengan format valid | Mengubah email | Email baru: newemail@test.com | Email berhasil diubah | | ☐ |
| PU-08 | Update email dengan format tidak valid | Memasukkan email salah | Email baru: emailsalah | Menampilkan pesan error "Format email tidak valid" | | ☐ |

---

## 4. Pengujian Modul Notifikasi

### 4.1 Pengujian Notifikasi User

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| NU-01 | Menampilkan daftar notifikasi | Akses halaman notifikasi | User memiliki notifikasi | Menampilkan daftar notifikasi | | ☐ |
| NU-02 | Melihat detail notifikasi | Klik pada notifikasi | Notifikasi ID: 1 | Menampilkan detail dan menandai dibaca | | ☐ |
| NU-03 | Tandai notifikasi sudah dibaca | Klik tombol tandai dibaca | Notifikasi ID: 1 | Notifikasi berubah status menjadi dibaca | | ☐ |
| NU-04 | Tandai semua notifikasi sudah dibaca | Klik tombol tandai semua dibaca | User memiliki beberapa notifikasi | Semua notifikasi berubah status menjadi dibaca | | ☐ |
| NU-05 | Hapus satu notifikasi | Klik tombol hapus notifikasi | Notifikasi ID: 1 | Notifikasi berhasil dihapus | | ☐ |
| NU-06 | Hapus semua notifikasi | Klik tombol hapus semua | User memiliki beberapa notifikasi | Semua notifikasi berhasil dihapus | | ☐ |
| NU-07 | Menampilkan badge notifikasi belum dibaca | Melihat badge di navbar | User memiliki 5 notifikasi belum dibaca | Menampilkan badge dengan angka 5 | | ☐ |
| NU-08 | Notifikasi kosong | Akses halaman notifikasi | User tidak memiliki notifikasi | Menampilkan pesan "Tidak ada notifikasi" | | ☐ |

---

## 5. Pengujian Modul Admin

### 5.1 Pengujian Dashboard Admin

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| DA-01 | Menampilkan dashboard admin | Akses halaman dashboard admin | Admin sudah login | Menampilkan dashboard dengan statistik | | ☐ |
| DA-02 | Menampilkan jumlah laporan pending | Melihat statistik laporan | Ada laporan pending | Menampilkan jumlah laporan pending | | ☐ |
| DA-03 | Menampilkan jumlah laporan diproses | Melihat statistik laporan | Ada laporan diproses | Menampilkan jumlah laporan diproses | | ☐ |

### 5.2 Pengujian Verifikasi Laporan

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| VL-01 | Melihat daftar laporan pending | Akses halaman laporan pending | Ada laporan pending | Menampilkan daftar laporan dengan status pending | | ☐ |
| VL-02 | Melihat detail laporan | Klik tombol detail | ID Laporan: 1 | Menampilkan detail lengkap laporan termasuk foto | | ☐ |
| VL-03 | Verifikasi laporan menjadi diproses | Ubah status ke diproses | Status baru: diproses, Keterangan: Sedang ditangani | Status berhasil diubah dan notifikasi terkirim ke user | | ☐ |
| VL-04 | Verifikasi laporan menjadi selesai | Ubah status ke selesai | Status baru: selesai, Keterangan: Sudah diperbaiki | Status berhasil diubah dan notifikasi terkirim ke user | | ☐ |
| VL-05 | Verifikasi laporan menjadi ditolak | Ubah status ke ditolak | Status baru: ditolak, Keterangan: Tidak valid | Status berhasil diubah dan notifikasi terkirim ke user | | ☐ |
| VL-06 | Verifikasi tanpa keterangan | Ubah status tanpa isi keterangan | Keterangan: (kosong) | Menampilkan pesan error "Keterangan wajib diisi" | | ☐ |

### 5.3 Pengujian Kelola Akun User (Admin)

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| KU-01 | Melihat daftar akun user | Akses halaman kelola akun | Admin sudah login | Menampilkan daftar akun user | | ☐ |
| KU-02 | Tambah akun user baru | Mengisi form tambah akun | Nama: New User, Email: newuser@test.com, NPM: 999999, Password: Pass123 | Akun berhasil ditambahkan | | ☐ |
| KU-03 | Tambah akun dengan email duplicate | Email sudah ada di database | Email: existing@test.com | Menampilkan pesan error "Email sudah digunakan" | | ☐ |
| KU-04 | Edit akun user | Mengubah data akun | Nama baru: Updated Name | Data akun berhasil diupdate | | ☐ |
| KU-05 | Hapus akun user tanpa laporan | Menghapus user yang tidak memiliki laporan | User ID: 10 (tanpa laporan) | Akun berhasil dihapus | | ☐ |
| KU-06 | Hapus akun user yang memiliki laporan | Menghapus user yang memiliki laporan | User ID: 5 (memiliki laporan) | Menampilkan pesan error "User memiliki laporan, tidak dapat dihapus" | | ☐ |

### 5.4 Pengujian Profile Admin

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| PA-01 | Menampilkan halaman profile admin | Akses halaman profile | Admin sudah login | Menampilkan data profile admin | | ☐ |
| PA-02 | Update profile admin | Mengubah data profile | Nama baru: Admin Updated | Profile berhasil diupdate | | ☐ |

---

## 6. Pengujian Modul Superadmin

### 6.1 Pengujian Kelola Gedung

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| KG-01 | Melihat daftar gedung | Akses halaman kelola gedung | Superadmin sudah login | Menampilkan daftar gedung | | ☐ |
| KG-02 | Tambah gedung baru | Mengisi form tambah gedung | Kode: GD-001, Nama: Gedung A, Deskripsi: Gedung perkuliahan | Gedung berhasil ditambahkan | | ☐ |
| KG-03 | Tambah gedung dengan kode duplicate | Kode gedung sudah ada | Kode: GD-001 (sudah ada) | Menampilkan pesan error "Kode gedung sudah digunakan" | | ☐ |
| KG-04 | Tambah gedung tanpa kode | Mengosongkan field kode | Kode: (kosong) | Menampilkan pesan error "Kode gedung wajib diisi" | | ☐ |
| KG-05 | Tambah gedung tanpa nama | Mengosongkan field nama | Nama: (kosong) | Menampilkan pesan error "Nama gedung wajib diisi" | | ☐ |
| KG-06 | Edit data gedung | Mengubah data gedung | Nama baru: Gedung A Updated | Data gedung berhasil diupdate | | ☐ |
| KG-07 | Hapus gedung tanpa laporan terkait | Menghapus gedung yang tidak memiliki laporan | Gedung ID: 10 | Gedung berhasil dihapus | | ☐ |
| KG-08 | Hapus gedung yang memiliki laporan | Menghapus gedung yang masih ada laporan | Gedung ID: 1 (memiliki laporan) | Menampilkan pesan error "Gedung memiliki laporan terkait, tidak dapat dihapus" | | ☐ |

### 6.2 Pengujian Kelola Akun Admin

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| KA-01 | Melihat daftar akun admin | Akses halaman kelola akun admin | Superadmin sudah login | Menampilkan daftar akun admin | | ☐ |
| KA-02 | Tambah akun admin baru | Mengisi form tambah akun | Nama: New Admin, Email: newadmin@test.com, Password: Admin123 | Akun admin berhasil ditambahkan | | ☐ |
| KA-03 | Tambah akun admin dengan email duplicate | Email sudah ada di database | Email: existing@test.com | Menampilkan pesan error "Email sudah digunakan" | | ☐ |
| KA-04 | Edit akun admin | Mengubah data akun admin | Nama baru: Admin Updated | Data akun berhasil diupdate | | ☐ |
| KA-05 | Hapus akun admin | Menghapus akun admin | Admin ID: 5 | Akun admin berhasil dihapus | | ☐ |
| KA-06 | Hapus akun admin sendiri | Mencoba menghapus akun sendiri | Admin ID: (akun yang sedang login) | Menampilkan pesan error "Tidak dapat menghapus akun sendiri" | | ☐ |

---

## 7. Pengujian Modul Rektor

### 7.1 Pengujian Dashboard Rektor

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| DR-01 | Menampilkan dashboard rektor | Akses halaman dashboard rektor | Rektor sudah login | Menampilkan dashboard dengan statistik keseluruhan | | ☐ |
| DR-02 | Melihat statistik total laporan | Akses menu statistik | Ada data laporan | Menampilkan total laporan semua status | | ☐ |

### 7.2 Pengujian Statistik & KPI

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| SK-01 | Melihat halaman statistik | Akses halaman statistik | Rektor sudah login | Menampilkan statistik dan KPI | | ☐ |
| SK-02 | Melihat completion rate | Melihat detail statistik | Ada laporan selesai | Menampilkan persentase completion rate | | ☐ |
| SK-03 | Melihat trend bulanan | Melihat grafik trend | Ada data historis | Menampilkan grafik trend bulanan | | ☐ |
| SK-04 | Melihat statistik per gedung | Filter statistik per gedung | Ada laporan dari berbagai gedung | Menampilkan distribusi laporan per gedung | | ☐ |

### 7.3 Pengujian Laporan Analitik

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| LA-01 | Melihat laporan analitik | Akses halaman laporan analitik | Rektor sudah login | Menampilkan laporan analitik | | ☐ |
| LA-02 | Melihat grafik prioritas | Melihat distribusi prioritas | Ada laporan berbagai prioritas | Menampilkan grafik distribusi prioritas | | ☐ |
| LA-03 | Melihat kinerja admin | Melihat statistik admin | Ada aktivitas admin | Menampilkan kinerja masing-masing admin | | ☐ |

### 7.4 Pengujian Audit Log

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| AL-01 | Melihat audit log | Akses halaman audit log | Rektor sudah login | Menampilkan daftar aktivitas sistem | | ☐ |
| AL-02 | Filter audit log | Memfilter berdasarkan tanggal | Range tanggal tertentu | Menampilkan log sesuai filter | | ☐ |
| AL-03 | Melihat detail audit log | Klik pada item log | Log ID: 1 | Menampilkan detail aktivitas | | ☐ |

---

## 8. Pengujian Akses & Otorisasi

### 8.1 Pengujian Filter Akses

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| FA-01 | User mengakses halaman admin | User mencoba akses dashboard admin | Role: user, URL: /dashboardadmin | Ditolak dan diarahkan ke dashboard user | | ☐ |
| FA-02 | User mengakses halaman superadmin | User mencoba akses kelola gedung | Role: user, URL: /gedung | Ditolak dan diarahkan ke dashboard user | | ☐ |
| FA-03 | Admin mengakses halaman superadmin | Admin mencoba akses kelola gedung | Role: admin, URL: /gedung | Ditolak dan diarahkan ke dashboard admin | | ☐ |
| FA-04 | Admin mengakses halaman rektor | Admin mencoba akses dashboard rektor | Role: admin, URL: /rektor/dashboard | Ditolak dan diarahkan ke dashboard admin | | ☐ |
| FA-05 | User mengakses tanpa login | Akses halaman dashboard tanpa login | Session: (tidak ada) | Diarahkan ke halaman login | | ☐ |
| FA-06 | Admin mengakses halaman kelola akun admin | Admin mencoba akses kelola akun admin | Role: admin, URL: /akunadmin | Ditolak (hanya superadmin yang bisa) | | ☐ |
| FA-07 | Superadmin mengakses semua halaman admin | Superadmin akses halaman admin | Role: superadmin | Berhasil mengakses semua halaman admin | | ☐ |
| FA-08 | User mengakses laporan user lain | User mencoba melihat laporan milik user lain | User ID: 1, Laporan user ID: 2 | Ditolak dan diarahkan ke laporan sendiri | | ☐ |

---

## 9. Pengujian Navigasi & Responsif

### 9.1 Pengujian Navigasi

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| NV-01 | Navigasi menu sidebar | Klik pada menu sidebar | Menu: Dashboard | Berpindah ke halaman yang sesuai | | ☐ |
| NV-02 | Navigasi breadcrumb | Klik pada breadcrumb | Breadcrumb: Home > Laporan | Berpindah ke halaman yang diklik | | ☐ |
| NV-03 | Tombol kembali | Klik tombol kembali di form | Halaman: Form buat laporan | Kembali ke halaman sebelumnya | | ☐ |
| NV-04 | Navigasi pagination | Klik halaman berikutnya | Halaman: 2 | Menampilkan data halaman 2 | | ☐ |

### 9.2 Pengujian Responsif

| No | Skenario Pengujian | Test Case | Data Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|----|-------------------|-----------|----------|----------------------|--------------|--------|
| RS-01 | Tampilan desktop | Akses dengan resolusi desktop | Resolusi: 1920x1080 | Tampilan normal dan lengkap | | ☐ |
| RS-02 | Tampilan tablet | Akses dengan resolusi tablet | Resolusi: 768x1024 | Tampilan menyesuaikan dengan baik | | ☐ |
| RS-03 | Tampilan mobile | Akses dengan resolusi mobile | Resolusi: 375x667 | Tampilan responsif dan navigasi tersembunyi | | ☐ |
| RS-04 | Menu hamburger di mobile | Klik menu hamburger | Resolusi: 375x667 | Sidebar menu muncul | | ☐ |

---

## Ringkasan Test Case

| Modul | Jumlah Test Case |
|-------|-----------------|
| Autentikasi (Login) | 11 |
| Autentikasi (Register) | 10 |
| Autentikasi (Forgot Password) | 4 |
| Autentikasi (Reset Password) | 5 |
| Autentikasi (Logout) | 2 |
| Dashboard User | 2 |
| Buat Laporan | 9 |
| Laporan Saya | 3 |
| Edit Laporan | 5 |
| Hapus Laporan | 5 |
| Riwayat Laporan | 2 |
| Profile User | 8 |
| Notifikasi User | 8 |
| Dashboard Admin | 3 |
| Verifikasi Laporan | 6 |
| Kelola Akun User | 6 |
| Profile Admin | 2 |
| Kelola Gedung (Superadmin) | 8 |
| Kelola Akun Admin (Superadmin) | 6 |
| Dashboard Rektor | 2 |
| Statistik & KPI | 4 |
| Laporan Analitik | 3 |
| Audit Log | 3 |
| Filter Akses & Otorisasi | 8 |
| Navigasi | 4 |
| Responsif | 4 |
| **TOTAL** | **133** |

---

## Keterangan Status

| Simbol | Keterangan |
|--------|------------|
| ☐ | Belum Diuji |
| ✅ | Berhasil (Passed) |
| ❌ | Gagal (Failed) |

---

## Catatan Pengujian

1. Pengujian dilakukan pada browser: Chrome, Firefox, Edge
2. Pengujian responsif dilakukan pada berbagai ukuran layar
3. Setiap test case harus diuji minimal 2 kali untuk memastikan konsistensi
4. Dokumentasikan jika ada bug atau error pada kolom "Hasil Aktual"
5. Screenshot error sebaiknya disimpan sebagai bukti

---

**Dokumen dibuat untuk keperluan Seminar Hasil**  
**Sistem Pelaporan Fasilitas Kampus**
