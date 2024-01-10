# laravel-dompet

Aplikasi untuk mencatat aktivitas transaksi dan menghitung modal serta pengeluaran pada sebuah wallet

## Requirement

-   8.0.2
-   Composer 2.1^
-   Internet, karena menggunakan composer dan untuk mengunduh dependency yang diperlukan saat install

## Cara Install dan run project

-   Clone Project ini
-   start webserver dan mysql server
-   buat database mysql
-   copy env.example menjadi .env, lalu edit konfigurasi .env nya, seperti nama database, username, password
-   buka terminal dan masuk ke folder project lalu run

```
composer install
```

-   kemudian run

```
php artisan key:generate
```

-   selanjutnya run

```
php artisan migrate --seed
```

-   pastikan tidak ada error, lalu untuk menjalankan project run

```
php artisan serve
```

-   lalu buka url 127.0.0.1:8000 di browser
-   done

### Default Admin Login

```
email = admin@gmail.com
password = admin12345
```

### Default User Login

```
email = user@gmail.com
password = user12345
```

## UPGRADE Ver.1.1

-   Penambahan Kolom Number di Transaksi, Capital dan Expenditure.
-   Disediakan Seeder Untuk Fill Column Number (UpgradeToLatestSeeder)
-   Penambahan Modul Report

### Cara Upgrade Ke Ver.1.1

-   Run Command

```
php artisan migrate
```

-   Untuk seeder auto fill column number

```
php artisan db:seed --class=UpgradeToLatestSeeder
```
