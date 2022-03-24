#TATA CARA MENJALANKAN PROJECT

1. Rename .env.example to .env
2. Buka file .env dan ubah

DB_DATABASE=nama_database

DB_USERNAME=root

DB_PASSWORD=password (jika ada)

3. JALANKAN,

# composer install

composer install

# Lalu jalankan

php artisan migrate

# Jalankan Seeder User
php artisan db:seed

# Path storage link
php artisan storage:link

# Lalu jalan serve

php artisan serve


# Akun Login

email = admin@transisi.id

password = transisi

# Cara Import FIle Employee
Cari file yang bernama DATA EMPLOYEE.xlsx didalam project
Lalu import didalam URL 
http://127.0.0.1:8000/employee


TERIMA KASIH !!!!
