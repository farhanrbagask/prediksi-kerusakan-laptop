# 💻 Sistem Prediksi Kerusakan Laptop

Aplikasi web untuk membantu melakukan **prediksi kerusakan laptop berdasarkan data gejala dan kondisi perangkat**. Aplikasi ini dikembangkan menggunakan **Laravel** sebagai framework backend dan menyediakan pengelolaan data latih, data uji, proses prediksi, serta detail perhitungan hasil prediksi.

Project ini dibuat sebagai bagian dari pengembangan **portfolio Software Engineering dan Data Analysis**, dengan menggabungkan konsep pengembangan aplikasi web, pengolahan data, dan implementasi metode prediksi ke dalam sebuah sistem yang dapat digunakan melalui antarmuka web.

---

## 📌 Tentang Project

**Sistem Prediksi Kerusakan Laptop** merupakan aplikasi berbasis web yang dirancang untuk membantu proses identifikasi kemungkinan kerusakan pada laptop berdasarkan data yang tersedia.

Aplikasi menyediakan beberapa modul utama:

* Dashboard untuk melihat ringkasan data.
* Pengelolaan **Data Latih**.
* Pengelolaan **Data Uji**.
* Import data menggunakan file spreadsheet.
* Proses prediksi kerusakan laptop.
* Prediksi satu data maupun seluruh data uji.
* Detail perhitungan prediksi.
* Riwayat hasil prediksi.
* Manajemen akun dan profil pengguna.

Dengan adanya sistem ini, proses pengolahan data dan prediksi dapat dilakukan secara terstruktur melalui satu aplikasi web.

---

## ✨ Fitur Utama

### 📊 Dashboard

Menampilkan informasi ringkas mengenai data yang tersedia dalam sistem sehingga pengguna dapat memperoleh gambaran kondisi dataset dengan lebih mudah.

### 📚 Data Latih

Digunakan untuk mengelola dataset yang digunakan sebagai dasar proses prediksi.

Fitur yang tersedia:

* Menampilkan data latih.
* Menambahkan data secara manual.
* Mengubah data.
* Menghapus data.
* Import data dari spreadsheet.
* Download template data.
* Menghapus seluruh data.

### 🧪 Data Uji

Digunakan untuk menyimpan data yang akan diproses untuk mendapatkan hasil prediksi.

Fitur yang tersedia:

* Menampilkan data uji.
* Menambahkan data.
* Mengubah data.
* Menghapus data.
* Import data dari spreadsheet.
* Download template data.
* Melihat hasil prediksi terakhir.

### 🤖 Prediksi Kerusakan

Sistem menyediakan proses prediksi terhadap data uji.

Terdapat beberapa pilihan:

* Prediksi satu data.
* Prediksi seluruh data.
* Melihat hasil prediksi.
* Melihat detail perhitungan prediksi.

### 🧮 Detail Perhitungan

Setiap hasil prediksi dapat dilihat lebih detail untuk membantu memahami bagaimana sistem memperoleh hasil tersebut.

Fitur ini juga membuat sistem lebih transparan karena pengguna tidak hanya mendapatkan hasil akhir, tetapi juga dapat melihat proses perhitungannya.

### 🔐 Authentication

Aplikasi menggunakan sistem autentikasi sehingga fitur utama hanya dapat diakses oleh pengguna yang telah login.

---

## 🛠️ Tech Stack

| Teknologi                  | Kegunaan                                |
| -------------------------- | --------------------------------------- |
| **PHP 8.2+**               | Bahasa pemrograman utama                |
| **Laravel 12**             | Framework backend                       |
| **MySQL**                  | Database                                |
| **Blade**                  | Template engine                         |
| **Tailwind CSS**           | Styling dan UI                          |
| **Vite**                   | Asset bundling dan frontend development |
| **PhpSpreadsheet**         | Import dan pengolahan file spreadsheet  |
| **Laravel Eloquent**       | ORM untuk interaksi database            |
| **Laravel Authentication** | Sistem autentikasi pengguna             |

Laravel 12 dan PhpSpreadsheet tercantum sebagai dependency utama pada `composer.json`, sementara frontend menggunakan Vite dan Tailwind CSS.

---

## 🏗️ Struktur Project

```text
prediksi-kerusakan-laptop/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php
│   │       ├── DataLatihController.php
│   │       ├── DataUjiController.php
│   │       ├── PrediksiController.php
│   │       └── ProfileController.php
│   │
│   ├── Models/
│   └── ...
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── ...
│
├── public/
├── resources/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── auth.php
│
├── storage/
├── tests/
│
├── .env.example
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

Struktur route aplikasi menunjukkan pemisahan modul antara **dashboard, data latih, data uji, prediksi, dan profile management**.

---

## ⚙️ Requirements

Sebelum menjalankan aplikasi, pastikan komputer telah memiliki:

* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL / MariaDB
* Git
* Web browser

Disarankan menggunakan:

* XAMPP / Laragon
* Visual Studio Code

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/farhanrbagask/prediksi-kerusakan-laptop.git
```

Masuk ke directory project:

```bash
cd prediksi-kerusakan-laptop
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Buat File Environment

Copy file `.env.example` menjadi `.env`.

Windows:

```bash
copy .env.example .env
```

Linux / macOS:

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buat database MySQL, kemudian sesuaikan konfigurasi pada `.env`.

Contoh:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_prediksi_kerusakan
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migration

```bash
php artisan migrate
```

Jika project memiliki seeder:

```bash
php artisan db:seed
```

atau:

```bash
php artisan migrate --seed
```

### 8. Jalankan Vite

Untuk development:

```bash
npm run dev
```

### 9. Jalankan Laravel

Buka terminal baru:

```bash
php artisan serve
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

---

## 📥 Import Data

Aplikasi menyediakan fitur import data menggunakan file spreadsheet.

Alur penggunaan:

```text
Download Template
       ↓
Isi Dataset
       ↓
Upload File
       ↓
Validasi Data
       ↓
Data Masuk Database
       ↓
Digunakan untuk Proses Prediksi
```

Library **PhpSpreadsheet** digunakan untuk mendukung kebutuhan pengolahan file spreadsheet pada aplikasi.

---

## 🔄 Alur Sistem

Secara umum proses aplikasi dapat digambarkan sebagai berikut:

```text
              ┌───────────────┐
              │     Login     │
              └───────┬───────┘
                      │
                      ▼
              ┌───────────────┐
              │   Dashboard   │
              └───────┬───────┘
                      │
          ┌───────────┴───────────┐
          ▼                       ▼
 ┌─────────────────┐     ┌─────────────────┐
 │    Data Latih   │     │     Data Uji    │
 └────────┬────────┘     └────────┬────────┘
          │                       │
          │                       ▼
          │              ┌─────────────────┐
          │              │     Prediksi    │
          │              └────────┬────────┘
          │                       │
          │                       ▼
          │              ┌─────────────────┐
          │              │ Hasil Prediksi  │
          │              └────────┬────────┘
          │                       │
          │                       ▼
          │              ┌─────────────────┐
          └─────────────►│ Detail Hitungan │
                         └─────────────────┘
```

---

## 📈 Tujuan Project

Project ini dikembangkan dengan beberapa tujuan:

1. Menerapkan konsep **data processing** ke dalam aplikasi web.
2. Membangun sistem prediksi yang dapat digunakan secara interaktif.
3. Mengintegrasikan pengelolaan dataset dengan proses prediksi.
4. Menerapkan konsep **CRUD** pada aplikasi Laravel.
5. Menerapkan import dataset menggunakan spreadsheet.
6. Membuat proses prediksi yang lebih terstruktur dan mudah digunakan.
7. Mengembangkan project sebagai portfolio dalam bidang **Software Engineering dan Data Analysis**.

---

## 🧠 Konsep yang Dipelajari

Project ini mencakup beberapa konsep teknis:

* Laravel MVC Architecture
* Routing
* Controller
* Model & Eloquent ORM
* Database & Migration
* CRUD
* Authentication & Authorization
* Data preprocessing
* Dataset management
* Data import
* Prediction logic
* Result processing
* Frontend asset management
* RESTful routing
* Software development workflow

---

## 📸 Application Preview

> Tambahkan screenshot aplikasi di bagian ini agar repository terlihat lebih profesional.

Contoh:

```markdown
## 📸 Application Preview

### Dashboard
![Dashboard](screenshots/dashboard.png)

### Data Latih
![Data Latih](screenshots/data-latih.png)

### Data Uji
![Data Uji](screenshots/data-uji.png)

### Hasil Prediksi
![Hasil Prediksi](screenshots/hasil-prediksi.png)
```

Disarankan membuat folder:

```text
screenshots/
├── dashboard.png
├── data-latih.png
├── data-uji.png
└── hasil-prediksi.png
```

---

## 🔮 Future Development

Beberapa pengembangan yang dapat ditambahkan:

* [ ] Menambahkan visualisasi statistik dataset.
* [ ] Menambahkan confusion matrix.
* [ ] Menambahkan evaluasi akurasi model.
* [ ] Menambahkan grafik performa prediksi.
* [ ] Menambahkan export hasil prediksi ke Excel/PDF.
* [ ] Menambahkan REST API.
* [ ] Menambahkan role-based access control.
* [ ] Menambahkan deployment ke server.
* [ ] Menambahkan dokumentasi algoritma secara lebih detail.

---

## 👨‍💻 Developer

**Farhan Rizqullah Bagaskara**

Informatics Engineering | Software Engineering | Data Analysis | Machine Learning

GitHub:
https://github.com/farhanrbagask

---

## 📄 License

Project ini dikembangkan untuk kebutuhan pembelajaran dan portfolio.

---

⭐ Jika project ini bermanfaat, jangan lupa memberikan **Star** pada repository.
