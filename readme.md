# Wallet INDODAM

It is a web application to manage membership/membership of Indonesia Digital Asset Management (INDODAM).

## Fitur

1. Authentication
    - Login & logout
    - Google Recaptcha Login Form
    - Change Password
    - Reset Password
    - Guest User Registration (Referal Mode) V2
2. User Access Rights
    - Member Access Rights
    - Admin Access Rights
3. Member Profile
    - Member Profile Page
    - Edit Member Profile
    - List of Members
    - Cloud Rental Data
4. Enter New Member
    - New Member Input
    - Wallet Check for Member Input
5. Transaction List (for Admin)
    - Transaction List
    - Transaction Search
    - Transaction Filter
6. Member Transaction History
    - History of Income Transactions
    - Expenditure Transaction History
    - Input Wallet Deposit
    - Input Withdraw Wallet
7. Input Transfer Wallet
    - Input Transfer Wallet
    - Member Network Check
8. Management of Member Data (Admin)
    - Member List
    - Member details
    - Edit Member Data
    - Suspend Member
9. INDODAM Package Data Management
    - Package List
    - New Package Input
    - Edit INDODAM Packages
    - Sponsor Bonus Settings
10. Backup/Restore System Database
    - List of Backup Files
    - Make Backups
    - Restore Backup
    - Download File Backup
    - Upload Backup Files
    - Delete Backup Files

## Installation
### Specification
- PHP 7.0 with extensions as needed [Laravel 5.5](https://laravel.com/docs/5.5#server-requirements)
- Maria DB 10.2 or MySQL >= 5.7

### How to Install

1. **Copy** and **extract** on the web server directory (eg xampp/htdocs)
2. `$ cd indodam`
3. `$ composer install`
4. Rename the file `.env.example` to `.env`
5. In terminal `php artisan key:generate`
6. Create **database on mysql** for this application
7. **Database settings** in `.env` . file
8. `php artisan migrate --seed`
9. `php artisan serve`
10. Done

### Admin Login
```
Email: admin@example.net
Password: secret
```

## Licence

Project Wallet Indodam is a free and open-source software under [MIT license](LICENSE).
