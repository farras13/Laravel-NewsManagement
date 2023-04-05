# News Management PROJECT

## Setup Project
1. Clone repository project
2. Setup environtment
```
cp .env.example .env
```
3. Generate an app encryption key
```
php artisan key:generate
```
4. Konfigurasi database pada .env sesuai dengan server yang digunakan.
    4.1 ubah QUEUE_CONNECTION = async menjadi redis
    4.2 tambahkan juga REDIS_CLIENT=predis dibawah REDIS_PORT
5. Jalankan perintah composer
```
composer install
```
6. lakukan migration
```
php artisan migrate
```
7. Jalankan laravel nya
```
php artsian serve
```
8. jalankan redis nya
```
php artisan queue:work
```
## Requirement

- PHP 7 or higher
- Mysql Server 4.1.13 or higher
- Apache / Nginx
- Mysqli extension
- redis

## Postman
1. import jsd.postman_collection
2. lakukan register dan login
3. untuk menjalankan API pada folder news dan comment, tambahkan authorization bearer token dengan token yang didapat setelah login.
