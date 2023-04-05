# News Management PROJECT

## Setup Project
1. Clone repository project
2. Setup environtment
```
cp .env.example .env
```
3. Konfigurasi database pada .env sesuai dengan server yang digunakan.
    3.1 ubah QUEUE_CONNECTION = async menjadi redis
    3.2 tambahkan juga REDIS_CLIENT=predis dibawah REDIS_PORT
4. Jalankan perintah composer
```
composer install
```
5. lakukan migration
```
php artisan migrate
```
6. Jalankan laravel nya
```
php artsian serve
```
7. jalankan redis nya
```
php artisan queue:work
```
## Requirement

- PHP 7 or higher
- Mysql Server 4.1.13 or higher
- Apache / Nginx
- Mysqli extension
- redis

##Postman
1. import jsd.postman_collection
2. lakukan register dan login
3. untuk menjalankan API pada folder news dan comment, tambahkan authorization bearer token dengan token yang didapat setelah login.
