# Jayusmart Minimarket

**Kelompok 8**
**Anggota:**

1. Santy
2. Hadi
3. Wildan

Jayusmart Minimarket adalah aplikasi web berbasis Laravel untuk membantu Bapak Jayusman dalam memonitor cabang minimarket, produk, stok barang, transaksi, laporan, dan pengguna. Sistem ini menerapkan role based access control sehingga setiap pengguna hanya dapat mengakses fitur sesuai perannya, yaitu owner, manager, supervisor, cashier, dan warehouse.

Aplikasi ini memiliki fitur utama berupa dashboard, manajemen cabang, manajemen produk, manajemen stok, transaksi penjualan, invoice, laporan transaksi, laporan stok, user management, dan profile user. Sistem dibangun menggunakan Laravel, MySQL, Blade, Tailwind CSS, Laravel Breeze, Spatie Permission, Composer, NPM, Vite, Laragon, Git, dan GitHub.

Untuk menjalankan project, lakukan instalasi dependency dengan `composer install` dan `npm install`, atur file `.env`, lalu jalankan `php artisan migrate:fresh --seed`. Setelah itu jalankan `php artisan serve` dan `npm run dev`, kemudian akses aplikasi melalui `http://127.0.0.1:8000/login`.
