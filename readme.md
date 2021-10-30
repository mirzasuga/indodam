# [abizarfarm.com](https://abizarfarm.com/)
# Wallet INDODAM

Adalah sebuah aplikasi web untuk mengelola keanggotaan/membership Indonesia Digital Aset Management (INDODAM).

## Fitur

Fitur pada Aplikasi ini meliputi :

1. Autentikasi
    - Login & logout
    - Google Recapcha Login Form
    - Ganti Password
    - Reset Password
    - Registrasi Guest User (Referal Mode) V2
2. Hak Akses User
    - Hak Akses Member
    - Hak Akses Admin
3. Profil Member
    - Halaman Profil Member
    - Edit Profil Member
    - List Member
    - Data Sewa Cloud
4. Input Member Baru
    - Input Member Baru
    - Pengecekan Wallet untuk Input Member
5. Daftar Transaksi (untuk Admin)
    - Daftar Transaksi
    - Pencarian Transaksi
    - Filter Transaksi
6. History Transaksi Member
    - History Transaksi Pemasukan
    - History Transaksi Pengeluaran
    - Input Deposit Wallet
    - Input Withdraw Wallet
7. Input Transfer Wallet
    - Input Transfer Wallet
    - Pengecekan Jaringan Member
8. Pengelolaan Data Member (Admin)
    - Daftar Member
    - Detail Member
    - Edit Data Member
    - Suspend Member
9. Manajemen Data Paket INDODAM
    - Daftar Paket
    - Input Paket Baru
    - Edit Paket INDODAM
    - Pengaturan Bonus Sponsor
10. Backup/Restore Database Sistem
    - Daftar File Backup
    - Buat Backup
    - Restore Backup
    - Download File Backup
    - Upload File Backup
    - Hapus FIle Backup

## Instalasi
### Spesifikasi
- PHP 7.0 dengan extensi sesuai kebutuhan [Laravel 5.5](https://laravel.com/docs/5.5#server-requirements)
- Maria DB 10.2 atau MySQL >= 5.7

### Cara Install

1. **Copy** dan **extract** pada direktori web server (misal: xampp/htdocs)
2. `$ cd indodam`
3. `$ composer install`
4. Rename file `.env.example` menjadi `.env`
5. Pada terminal `php artisan key:generate`
6. Buat **database pada mysql** untuk aplikasi ini
7. **Setting database** pada file `.env`
8. `php artisan migrate --seed`
9. `php artisan serve`
10. Selesai

### Login Admin
```
Email: admin@example.net
Password: secret
```

## Lisensi

Project Wallet Indodam merupakan software yang free dan open source di bawah [lisensi MIT](LICENSE).
