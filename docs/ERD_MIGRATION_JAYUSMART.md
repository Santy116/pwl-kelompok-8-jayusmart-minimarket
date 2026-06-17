# Dokumen ERD dan Migration Jayusmart Minimarket

## Deskripsi Sistem

Jayusmart Minimarket adalah aplikasi web berbasis Laravel dan MySQL untuk membantu Bapak Jayusman memantau transaksi dan stok barang pada 5 cabang minimarket.

Sistem ini mendukung:

```text
1. Monitoring cabang minimarket.
2. Monitoring transaksi penjualan.
3. Monitoring stok barang.
4. Pencatatan keluar-masuk barang.
5. Pengelolaan user berdasarkan cabang.
6. Cetak laporan transaksi berdasarkan tanggal.
7. Cetak laporan stok barang.
```

---

# A. Daftar Tabel Utama

Tabel utama sistem minimarket:

```text
1. branches
2. users
3. categories
4. products
5. stocks
6. transactions
7. transaction_items
8. stock_movements
```

Tabel bawaan Laravel dan Spatie:

```text
users
password_reset_tokens
sessions
roles
permissions
model_has_roles
model_has_permissions
role_has_permissions
```

Catatan:

```text
Tabel users sudah dibuat oleh Laravel Breeze.
Tabel role dan permission sudah dibuat oleh Spatie.
```

---

# B. Urutan Migration

Urutan migration harus seperti ini:

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

Urutan ini penting karena terdapat relasi foreign key antar tabel.

---

# C. Detail Tabel

## 1. Table: `branches`

Fungsi:

```text
Menyimpan data cabang minimarket milik Bapak Jayusman.
```

Kolom:

| Kolom      | Tipe Data        | Keterangan           |
| ---------- | ---------------- | -------------------- |
| id         | big integer      | Primary key          |
| name       | varchar          | Nama cabang          |
| city       | varchar          | Kota cabang          |
| address    | text             | Alamat cabang        |
| phone      | varchar nullable | Nomor telepon cabang |
| created_at | timestamp        | Waktu dibuat         |
| updated_at | timestamp        | Waktu diubah         |

Relasi:

```text
branches 1..n users
branches 1..n stocks
branches 1..n transactions
branches 1..n stock_movements
```

---

## 2. Table: `users`

Fungsi:

```text
Menyimpan data pengguna aplikasi.
```

Catatan:

```text
Tabel users sudah tersedia dari Laravel Breeze.
Migration tambahan hanya menambahkan branch_id.
```

Kolom tambahan:

| Kolom     | Tipe Data          | Keterangan                 |
| --------- | ------------------ | -------------------------- |
| branch_id | foreignId nullable | Cabang tempat user bekerja |

Relasi:

```text
users.branch_id -> branches.id
```

Aturan:

```text
onDelete set null
onUpdate cascade
```

Role user dikelola menggunakan Spatie Permission, bukan kolom role manual.

Role yang digunakan:

```text
owner
manager
supervisor
cashier
warehouse
```

---

## 3. Table: `categories`

Fungsi:

```text
Menyimpan kategori produk.
```

Kolom:

| Kolom       | Tipe Data     | Keterangan         |
| ----------- | ------------- | ------------------ |
| id          | big integer   | Primary key        |
| name        | varchar       | Nama kategori      |
| description | text nullable | Deskripsi kategori |
| created_at  | timestamp     | Waktu dibuat       |
| updated_at  | timestamp     | Waktu diubah       |

Relasi:

```text
categories 1..n products
```

---

## 4. Table: `products`

Fungsi:

```text
Menyimpan data produk minimarket.
```

Kolom:

| Kolom          | Tipe Data      | Keterangan           |
| -------------- | -------------- | -------------------- |
| id             | big integer    | Primary key          |
| category_id    | foreignId      | Relasi ke categories |
| code           | varchar unique | Kode produk          |
| name           | varchar        | Nama produk          |
| unit           | varchar        | Satuan produk        |
| purchase_price | decimal        | Harga beli           |
| selling_price  | decimal        | Harga jual           |
| description    | text nullable  | Deskripsi produk     |
| created_at     | timestamp      | Waktu dibuat         |
| updated_at     | timestamp      | Waktu diubah         |

Relasi:

```text
products.category_id -> categories.id
```

Aturan:

```text
onDelete restrict
onUpdate cascade
```

---

## 5. Table: `stocks`

Fungsi:

```text
Menyimpan jumlah stok produk pada setiap cabang.
```

Kolom:

| Kolom         | Tipe Data        | Keterangan         |
| ------------- | ---------------- | ------------------ |
| id            | big integer      | Primary key        |
| branch_id     | foreignId        | Relasi ke branches |
| product_id    | foreignId        | Relasi ke products |
| quantity      | unsigned integer | Jumlah stok        |
| minimum_stock | unsigned integer | Batas minimum stok |
| created_at    | timestamp        | Waktu dibuat       |
| updated_at    | timestamp        | Waktu diubah       |

Relasi:

```text
stocks.branch_id -> branches.id
stocks.product_id -> products.id
```

Aturan:

```text
unique(branch_id, product_id)
```

Makna aturan unique:

```text
Satu produk hanya boleh memiliki satu data stok di satu cabang.
```

---

## 6. Table: `transactions`

Fungsi:

```text
Menyimpan data transaksi penjualan.
```

Kolom:

| Kolom            | Tipe Data      | Keterangan                        |
| ---------------- | -------------- | --------------------------------- |
| id               | big integer    | Primary key                       |
| branch_id        | foreignId      | Cabang tempat transaksi           |
| user_id          | foreignId      | User/kasir yang membuat transaksi |
| invoice_number   | varchar unique | Nomor invoice                     |
| transaction_date | datetime       | Tanggal dan waktu transaksi       |
| total_amount     | decimal        | Total transaksi                   |
| paid_amount      | decimal        | Jumlah uang dibayar               |
| change_amount    | decimal        | Kembalian                         |
| payment_method   | enum/string    | Metode pembayaran                 |
| status           | enum/string    | Status transaksi                  |
| created_at       | timestamp      | Waktu dibuat                      |
| updated_at       | timestamp      | Waktu diubah                      |

Relasi:

```text
transactions.branch_id -> branches.id
transactions.user_id -> users.id
```

Payment method:

```text
cash
transfer
qris
```

Status:

```text
paid
cancelled
```

---

## 7. Table: `transaction_items`

Fungsi:

```text
Menyimpan detail produk dalam transaksi.
```

Kolom:

| Kolom          | Tipe Data        | Keterangan                  |
| -------------- | ---------------- | --------------------------- |
| id             | big integer      | Primary key                 |
| transaction_id | foreignId        | Relasi ke transactions      |
| product_id     | foreignId        | Relasi ke products          |
| quantity       | unsigned integer | Jumlah produk dibeli        |
| price          | decimal          | Harga produk saat transaksi |
| subtotal       | decimal          | Quantity x price            |
| created_at     | timestamp        | Waktu dibuat                |
| updated_at     | timestamp        | Waktu diubah                |

Relasi:

```text
transaction_items.transaction_id -> transactions.id
transaction_items.product_id -> products.id
```

---

## 8. Table: `stock_movements`

Fungsi:

```text
Mencatat histori keluar-masuk stok barang.
```

Kolom:

| Kolom          | Tipe Data          | Keterangan                                         |
| -------------- | ------------------ | -------------------------------------------------- |
| id             | big integer        | Primary key                                        |
| branch_id      | foreignId          | Cabang stok bergerak                               |
| product_id     | foreignId          | Produk yang bergerak                               |
| user_id        | foreignId          | User yang mencatat pergerakan                      |
| transaction_id | foreignId nullable | Relasi transaksi jika stok keluar karena penjualan |
| type           | enum/string        | Jenis pergerakan stok                              |
| quantity       | unsigned integer   | Jumlah stok bergerak                               |
| movement_date  | datetime           | Tanggal dan waktu pergerakan                       |
| description    | text nullable      | Keterangan                                         |
| created_at     | timestamp          | Waktu dibuat                                       |
| updated_at     | timestamp          | Waktu diubah                                       |

Relasi:

```text
stock_movements.branch_id -> branches.id
stock_movements.product_id -> products.id
stock_movements.user_id -> users.id
stock_movements.transaction_id -> transactions.id
```

Jenis type:

```text
in
out
adjustment
```

---

# D. Ringkasan Relasi ERD

```text
branches 1..n users
branches 1..n stocks
branches 1..n transactions
branches 1..n stock_movements

categories 1..n products

products 1..n stocks
products 1..n transaction_items
products 1..n stock_movements

users 1..n transactions
users 1..n stock_movements

transactions 1..n transaction_items
transactions 1..n stock_movements
```

---

# E. Catatan Implementasi Laravel

## Tipe Data Laravel yang Disarankan

```php
$table->id();
$table->foreignId();
$table->string();
$table->text();
$table->integer();
$table->unsignedInteger();
$table->decimal('amount', 15, 2);
$table->dateTime();
$table->enum();
$table->timestamps();
```

## Aturan Foreign Key

Gunakan aturan berikut sesuai kebutuhan:

```php
->cascadeOnDelete()
->restrictOnDelete()
->nullOnDelete()
->cascadeOnUpdate()
```

## Catatan Penting

```text
1. Tabel users tidak dibuat ulang.
2. Role tidak dibuat manual karena menggunakan Spatie.
3. Seeder dikerjakan setelah semua migration berhasil.
4. Jika ada perubahan struktur tabel, komunikasikan dulu ke Santy.
5. Jalankan php artisan migrate:fresh untuk mengetes migration dari awal.
```

---

# F. Checklist Selesai Migration

Migration Hadi dianggap selesai jika:

```text
[ ] Semua migration berhasil dibuat.
[ ] php artisan migrate:fresh berhasil tanpa error.
[ ] Semua tabel utama muncul di database.
[ ] Foreign key terbentuk dengan benar.
[ ] Tidak ada tabel users baru yang duplikat.
[ ] Branch hadi/migrations sudah dipush ke GitHub.
[ ] Santy sudah bisa pull branch Hadi dan menjalankan migrate:fresh.
```
