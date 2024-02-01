# Kasir CodeIgniter 4

Aplikasi Kasir Sederhana Menggunakan CodeIgniter 4. 

# Installation
### Clone repository:
```
git clone https://github.com/Wiliperdana/kasir-codeigniter4.git
```

### Pindah ke directory Laundry-CodeIgniter-4:
```
cd kasir-codeigniter4
```

### Install dependency:
```
composer install
```

### Copy file .env.example
```
cp .env.example .env
```

### Buat database baru dan konfigurasi file .env:
```
database.default.hostname = localhost
database.default.database = ukk_kasir
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### Migrasi database:
```
php spark migrate
```

### Jalankan aplikasi dengan perintah:
```
php spark serve
``` 

Sekarang buka browser dengan alamat address http://localhost:8080/