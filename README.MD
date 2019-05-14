# LARAVEL SKELETON APP FRAMEWORK (LARATON)
Framework Aplikasi berbasis Laravel.
Melalui Skeleton/Rangka Aplikasi ini, anda bisa membuat sebuah aplikasi tanpa harus membuatnya dari nol. Fitur-fitur dasar yang sudah ada di LARATON ini antara lain:
- Authentication (Laravel Auth)
- Login
- Register
- Konfigurasi Menu
- Konfigurasi Grup
- Konfigurasi Role/Hak Akses
- Setting Aplikasi
- [AdminBSB Template](https://github.com/gurayyarar/AdminBSBMaterialDesign "AdminBSBMaterialDesign")
- Setting Profile
	* Informasi Pribadi
	* Media Sosial
	* Foto Profile
	* Poster
	* Riwayat Pendidikan
	* Riwayat Pekerjaan
	* DLL

## TECHNOLOGY
- Laravel 5.8
- AdminBSBMaterialDesign Bootstrap Template
- Intervention Image
- Laravel Collective
- DLL

## REQUIREMENT
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Composer
- Git

## CARA PAKAI
- Pastikan Requirement sudah terpenuhi semua.
- Setelah clone repository buka aplikasi git/cmd/terminal kemudian masuk ke direktori laravel
- jalankan perintah berikut
```
composer install
```
- Setelah selesai kemudian buatlah database di mysql
- PENTING!! Import file sql yang ada di doc/indonesia.sql ke database yang telah di buat tadi
- Buatlah file .env (copy paste dari laravel/.env.example) di direktori laravel/ kemudian sesuaikan konfigurasinya (database, mail setting, etc)
- Untuk generate key jalankan perintah berikut
```
php artisan key:generate
```
- Untuk migrasi database jalankan perintah berikut
```
php artisan migrate
```
- Setelah selesai jalankan perintah berikut untuk memulai aplikasi
```
php artisan serve
```
- Buka browser dan ketikkan alamat berikut
```
http://127.0.0.1:8000
```
- Bisa juga menyesuaikan port sesuai keinginan dengan perintah berikut [contoh port=88]
```
php artisan serve --port=88
```
- Untuk setting smtp supaya bisa kirim email silahkan cari sendiri di google v^^

## CREDENTIAL
- Ada 3 user grup dalam framework aplikasi ini:
```
SUPERADMIN
username 	: superadmin@server.com
password	: rahasiasuper

ADMIN
username 	: admin@server.com
password	: rahasiaadmin

USER
username 	: imale@server.com
password	: rahasiamale

username 	: ifemale@server.com
password	: rahasiafemale
```

## SUPPORT
- Pertanyaan dan Sugesti bisa melalui
```
saklu07@gmail.com
```


regards.

Azkal Fikri
http://azkalfikri.id