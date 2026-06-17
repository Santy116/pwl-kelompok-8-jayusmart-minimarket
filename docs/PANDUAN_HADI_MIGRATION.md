# Panduan Pengerjaan Migration Hadi

## Project

Nama project:

```text
Jayusmart Minimarket
```

Repository GitHub:

```text
https://github.com/Santy116/pwl-kelompok-8-jayusmart-minimarket
```

## Pembagian Tugas

| Nama   | Peran     | Tanggung Jawab                                                      |
| ------ | --------- | ------------------------------------------------------------------- |
| Santy  | Ketua     | Setup project, struktur awal, controller, Blade, laporan, integrasi |
| Hadi   | Anggota 1 | Migration dan struktur database                                     |
| Wildan | Anggota 2 | Seeder dan dummy data                                               |

Fokus tugas Hadi adalah membuat migration database untuk sistem minimarket sesuai ERD.

---

# A. Persiapan Project

## 1. Clone Repository

```bash
git clone https://github.com/Santy116/pwl-kelompok-8-jayusmart-minimarket.git
```

Masuk ke folder project:

```bash
cd pwl-kelompok-8-jayusmart-minimarket
```

## 2. Install Dependency Laravel

```bash
composer install
```

## 3. Install Dependency Frontend

```bash
npm install
```

## 4. Buat File Environment

```bash
copy .env.example .env
```

## 5. Generate Application Key

```bash
php artisan key:generate
```

## 6. Atur Database di `.env`

Contoh konfigurasi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jayusmart_minimarket
DB_USERNAME=root
DB_PASSWORD=
```

## 7. Buat Database di MySQL

```sql
CREATE DATABASE jayusmart_minimarket;
```

## 8. Jalankan Migration Awal

```bash
php artisan migrate
```

---

# B. Aturan Branch untuk Hadi

Hadi tidak mengerjakan langsung di branch `main`.

Branch kerja Hadi:

```text
hadi/migrations
```

## 1. Ambil Update Terbaru dari Main

```bash
git checkout main
git pull origin main
```

## 2. Buat Branch Hadi

```bash
git checkout -b hadi/migrations
```

## 3. Cek Branch Aktif

```bash
git branch
```

Pastikan branch aktif adalah:

```text
hadi/migrations
```

---

# C. File Migration yang Harus Dibuat

Hadi membuat migration dengan urutan berikut:

```text
1. create_branches_table
2. add_branch_id_to_users_table
3. create_categories_table
4. create_products_table
5. create_stocks_table
6. create_transactions_table
7. create_transaction_items_table
8. create_stock_movements_table
```

Perintah artisan:

```bash
php artisan make:migration create_branches_table
php artisan make:migration add_branch_id_to_users_table --table=users
php artisan make:migration create_categories_table
php artisan make:migration create_products_table
php artisan make:migration create_stocks_table
php artisan make:migration create_transactions_table
php artisan make:migration create_transaction_items_table
php artisan make:migration create_stock_movements_table
```

---

# D. Urutan Pengerjaan Migration

Migration harus dikerjakan sesuai urutan relasi.

## 1. `branches`

Tabel cabang minimarket.

Kolom:

```text
id
name
city
address
phone
created_at
updated_at
```

## 2. `users`

Tabel `users` sudah ada dari Laravel Breeze.

Hadi tidak membuat ulang tabel `users`.

Hadi hanya menambahkan kolom:

```text
branch_id
```

Relasi:

```text
users.branch_id -> branches.id
```

Aturan:

```text
nullable
onDelete set null
onUpdate cascade
```

## 3. `categories`

Tabel kategori produk.

Kolom:

```text
id
name
description
created_at
updated_at
```

## 4. `products`

Tabel data produk.

Kolom:

```text
id
category_id
code
name
unit
purchase_price
selling_price
description
created_at
updated_at
```

Relasi:

```text
products.category_id -> categories.id
```

Aturan:

```text
onDelete restrict
onUpdate cascade
```

## 5. `stocks`

Tabel stok produk per cabang.

Kolom:

```text
id
branch_id
product_id
quantity
minimum_stock
created_at
updated_at
```

Relasi:

```text
stocks.branch_id -> branches.id
stocks.product_id -> products.id
```

Aturan penting:

```text
branch_id dan product_id harus unique bersama.
Satu produk hanya boleh memiliki satu data stok pada satu cabang.
```

Unique key:

```text
unique(branch_id, product_id)
```

## 6. `transactions`

Tabel transaksi penjualan.

Kolom:

```text
id
branch_id
user_id
invoice_number
transaction_date
total_amount
paid_amount
change_amount
payment_method
status
created_at
updated_at
```

Relasi:

```text
transactions.branch_id -> branches.id
transactions.user_id -> users.id
```

Catatan:

```text
user_id adalah kasir atau user yang membuat transaksi.
transaction_date sebaiknya menggunakan dateTime.
invoice_number harus unique.
```

## 7. `transaction_items`

Tabel detail item transaksi.

Kolom:

```text
id
transaction_id
product_id
quantity
price
subtotal
created_at
updated_at
```

Relasi:

```text
transaction_items.transaction_id -> transactions.id
transaction_items.product_id -> products.id
```

Catatan:

```text
Jika transaksi dihapus, detail transaksi ikut terhapus.
```

## 8. `stock_movements`

Tabel keluar-masuk stok barang.

Kolom:

```text
id
branch_id
product_id
user_id
transaction_id
type
quantity
movement_date
description
created_at
updated_at
```

Relasi:

```text
stock_movements.branch_id -> branches.id
stock_movements.product_id -> products.id
stock_movements.user_id -> users.id
stock_movements.transaction_id -> transactions.id
```

Catatan:

```text
transaction_id boleh null.
Digunakan jika pergerakan stok berasal dari transaksi penjualan.
```

---

# E. Testing Migration

Setelah semua migration dibuat, jalankan:

```bash
php artisan migrate:fresh
```

Jika berhasil, lanjut cek database melalui phpMyAdmin/HeidiSQL.

Pastikan tabel berikut muncul:

```text
users
branches
categories
products
stocks
transactions
transaction_items
stock_movements
roles
permissions
model_has_roles
model_has_permissions
role_has_permissions
```

Tabel Spatie tidak perlu dibuat manual karena sudah ada dari package.

---

# F. Jika Ada Error

## Error foreign key

Cek urutan migration.

Pastikan tabel yang direferensikan sudah dibuat lebih dulu.

Contoh:

```text
products membutuhkan categories.
stocks membutuhkan branches dan products.
transactions membutuhkan branches dan users.
transaction_items membutuhkan transactions dan products.
stock_movements membutuhkan branches, products, users, transactions.
```

## Error duplicate migration

Jangan membuat ulang migration `users`.

Yang dibuat hanya:

```text
add_branch_id_to_users_table
```

## Error table already exists

Gunakan:

```bash
php artisan migrate:fresh
```

Jangan digunakan jika database sudah berisi data penting.

---

# G. Commit dan Push Pekerjaan Hadi

## 1. Cek Status

```bash
git status
```

## 2. Add File Migration

```bash
git add database/migrations
```

## 3. Commit Migration

```bash
git commit -m "feat: add minimarket database migrations"
```

## 4. Push Branch Hadi

```bash
git push -u origin hadi/migrations
```

---

# H. Setelah Push

Setelah branch berhasil dipush, Hadi memberi kabar ke Santy:

```text
Migration sudah selesai dan sudah saya push ke branch hadi/migrations.
```

Santy akan melakukan review sebelum merge ke `main`.

---

# I. Catatan Penting

```text
Jangan edit file .env milik orang lain.
Jangan commit file .env.
Jangan commit folder vendor.
Jangan commit folder node_modules.
Jangan mengerjakan seeder sebelum migration stabil.
Jangan mengubah branch main secara langsung.
```

Seeder baru dikerjakan Wildan setelah migration Hadi selesai dan sudah dicek.
