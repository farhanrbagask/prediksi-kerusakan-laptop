# 💻 Sistem Prediksi Kerusakan Laptop

Aplikasi web untuk melakukan **prediksi kerusakan laptop menggunakan algoritma Naive Bayes** berdasarkan data gejala atau kondisi perangkat.

Aplikasi ini dibangun menggunakan **Laravel** sebagai framework pengembangan web dan **MySQL** sebagai database. Sistem menyediakan pengelolaan data latih, data uji, proses perhitungan Naive Bayes, hasil prediksi, serta detail perhitungan probabilitas yang digunakan dalam menentukan jenis kerusakan laptop.

Project ini dikembangkan sebagai portfolio yang menggabungkan **Software Engineering, Data Analysis, dan Machine Learning** dalam sebuah aplikasi berbasis web.

---

## 📌 Tentang Project

**Sistem Prediksi Kerusakan Laptop** merupakan aplikasi berbasis web yang dirancang untuk membantu memprediksi kemungkinan jenis kerusakan laptop berdasarkan gejala atau kondisi perangkat yang diberikan.

Sistem menggunakan **algoritma Naive Bayes** untuk melakukan proses klasifikasi berdasarkan data latih yang tersedia.

Pengguna dapat memasukkan atau mengimpor data, kemudian sistem melakukan perhitungan probabilitas untuk menentukan kelas kerusakan dengan probabilitas tertinggi.

Secara umum, proses sistem adalah:

```text
Data Latih
    ↓
Perhitungan Probabilitas
    ↓
Data Uji
    ↓
Perhitungan Naive Bayes
    ↓
Posterior Probability
    ↓
Probabilitas Terbesar
    ↓
Hasil Prediksi Kerusakan
```

---

## 🧠 Algoritma Naive Bayes

Algoritma utama yang digunakan dalam aplikasi ini adalah **Naive Bayes Classifier**.

Naive Bayes merupakan algoritma klasifikasi probabilistik yang menggunakan konsep **Teorema Bayes** untuk menentukan probabilitas suatu data termasuk ke dalam kelas tertentu.

Dalam sistem ini, Naive Bayes digunakan untuk menentukan kemungkinan jenis kerusakan laptop berdasarkan kombinasi gejala atau kondisi perangkat.

### 📐 Teorema Bayes

Secara umum, probabilitas posterior dihitung menggunakan rumus:

```text
P(C|X) = P(X|C) × P(C) / P(X)
```

Keterangan:

| Simbol | Keterangan                |                                           |
| ------ | ------------------------- | ----------------------------------------- |
| `P(C   | X)`                       | Probabilitas kelas C berdasarkan data X   |
| `P(X   | C)`                       | Probabilitas data X jika termasuk kelas C |
| `P(C)` | Probabilitas awal kelas C |                                           |
| `P(X)` | Probabilitas data X       |                                           |

Karena nilai `P(X)` sama untuk setiap kelas yang dibandingkan, proses klasifikasi dapat berfokus pada perbandingan:

```text
P(C|X) ∝ P(C) × P(X|C)
```

---

## 🔢 Tahapan Perhitungan

Proses prediksi dalam sistem dilakukan melalui beberapa tahapan.

### 1. Menghitung Prior Probability

Prior probability merupakan probabilitas awal dari masing-masing kelas kerusakan.

Rumus:

```text
P(C) = jumlah data kelas C / jumlah seluruh data
```

Contoh:

```text
Jumlah data kelas A = 20
Jumlah seluruh data = 100

P(A) = 20 / 100
     = 0.20
```

---

### 2. Menghitung Likelihood

Likelihood digunakan untuk mengetahui probabilitas munculnya suatu gejala atau kondisi tertentu pada sebuah kelas.

Rumus dasar:

```text
P(X|C) = jumlah data dengan fitur X pada kelas C
         ---------------------------------------
                jumlah data pada kelas C
```

Setiap fitur atau gejala dihitung berdasarkan kelas kerusakannya.

---

### 3. Menghitung Posterior Probability

Setelah prior dan likelihood diperoleh, sistem menghitung probabilitas posterior.

Secara sederhana:

```text
P(C|X) ∝ P(C) × P(X1|C) × P(X2|C) × ... × P(Xn|C)
```

Dengan demikian, setiap gejala yang dimiliki data uji akan diperhitungkan terhadap masing-masing kelas kerusakan.

---

### 4. Menentukan Hasil Prediksi

Setelah seluruh probabilitas untuk setiap kelas dihitung, sistem memilih kelas dengan nilai probabilitas terbesar.

```text
Prediksi = kelas dengan posterior probability terbesar
```

Contoh:

```text
Kerusakan A = 0.012
Kerusakan B = 0.035
Kerusakan C = 0.008

Hasil Prediksi = Kerusakan B
```

---

## 📊 Fitur Utama

### Dashboard

Menampilkan ringkasan informasi data yang terdapat pada sistem.

### Data Latih

Digunakan sebagai dataset untuk membangun dasar perhitungan Naive Bayes.

Fitur:

* Menampilkan data latih.
* Menambahkan data.
* Mengubah data.
* Menghapus data.
* Import data dari Excel.
* Download template data.
* Menghapus data.

### Data Uji

Digunakan sebagai data yang akan diproses oleh algoritma Naive Bayes.

Fitur:

* Menampilkan data uji.
* Menambahkan data.
* Mengubah data.
* Menghapus data.
* Import data.
* Download template.
* Melakukan prediksi.

### Prediksi Kerusakan

Sistem melakukan klasifikasi data uji menggunakan algoritma Naive Bayes.

Prediksi dapat dilakukan terhadap:

* Satu data.
* Seluruh data uji.

### Detail Perhitungan

Salah satu fitur utama aplikasi adalah kemampuan untuk melihat **detail proses perhitungan Naive Bayes**.

Informasi perhitungan dapat digunakan untuk memahami bagaimana sistem menghasilkan prediksi, mulai dari probabilitas kelas hingga probabilitas akhir masing-masing kelas.

### Authentication

Sistem dilengkapi dengan autentikasi pengguna untuk membatasi akses ke aplikasi.

---

## 🔄 Alur Prediksi

```text
                ┌─────────────────┐
                │    Data Latih   │
                └────────┬────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Hitung Prior &       │
              │ Likelihood           │
              └──────────┬───────────┘
                         │
                         ▼
                ┌─────────────────┐
                │     Data Uji    │
                └────────┬────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Perhitungan Naive   │
              │ Bayes                │
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Posterior Probability│
              └──────────┬───────────┘
                         │
                         ▼
              ┌──────────────────────┐
              │ Probabilitas         │
              │ Terbesar             │
              └──────────┬───────────┘
                         │
                         ▼
                ┌─────────────────┐
                │ Hasil Prediksi  │
                └─────────────────┘
```

---

## 🛠️ Tech Stack

| Teknologi          | Kegunaan                |
| ------------------ | ----------------------- |
| **PHP 8.2+**       | Bahasa pemrograman      |
| **Laravel 12**     | Framework backend       |
| **MySQL**          | Database                |
| **Blade**          | Template engine         |
| **Tailwind CSS**   | UI dan styling          |
| **Vite**           | Asset bundling          |
| **PhpSpreadsheet** | Import data spreadsheet |
| **Naive Bayes**    | Algoritma klasifikasi   |

---

## 📚 Konsep yang Diterapkan

Project ini menerapkan beberapa konsep, antara lain:

### Software Engineering

* Laravel MVC
* Routing
* Controller
* Model & Eloquent ORM
* CRUD
* Authentication
* Database migration
* Form validation

### Data Analysis & Machine Learning

* Dataset management
* Data latih
* Data uji
* Probabilitas
* Prior probability
* Likelihood
* Posterior probability
* Naive Bayes classification
* Classification result

---

## 📥 Import Dataset

Aplikasi mendukung proses import dataset menggunakan file spreadsheet.

Alur import:

```text
Download Template
       ↓
Isi Dataset
       ↓
Upload Excel
       ↓
Validasi Data
       ↓
Simpan ke Database
       ↓
Dataset Siap Digunakan
```

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/farhanrbagask/prediksi-kerusakan-laptop.git
cd prediksi-kerusakan-laptop
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
```

Windows:

```bash
copy .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Sesuaikan file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_prediksi_kerusakan
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migration

```bash
php artisan migrate
```

Jika tersedia seeder:

```bash
php artisan migrate --seed
```

### 7. Jalankan Aplikasi

Terminal pertama:

```bash
php artisan serve
```

Terminal kedua:

```bash
npm run dev
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

---

## 🎯 Tujuan Project

Project ini dibuat untuk:

1. Mengimplementasikan algoritma **Naive Bayes** ke dalam aplikasi berbasis web.
2. Menerapkan konsep pengolahan dataset.
3. Mengembangkan sistem prediksi kerusakan laptop.
4. Mengintegrasikan proses data analysis dengan aplikasi Laravel.
5. Menerapkan konsep CRUD dan database management.
6. Menampilkan proses perhitungan probabilitas secara transparan.
7. Mengembangkan portfolio dalam bidang **Software Engineering, Data Analysis, dan Machine Learning**.

---

## 🔮 Future Development

* [ ] Menambahkan evaluasi performa model.
* [ ] Menambahkan accuracy, precision, recall, dan F1-score.
* [ ] Menambahkan confusion matrix.
* [ ] Menambahkan visualisasi distribusi dataset.
* [ ] Menambahkan grafik hasil prediksi.
* [ ] Menambahkan export hasil prediksi ke Excel/PDF.
* [ ] Menambahkan REST API.
* [ ] Menambahkan role-based access control.
* [ ] Melakukan deployment ke server.

---

## 👨‍💻 Developer

**Farhan Rizqullah Bagaskara**

Informatics Engineering | Software Engineering | Data Analysis | Machine Learning

GitHub:
https://github.com/farhanrbagask

---

## 📄 License

Project ini dikembangkan untuk kebutuhan pembelajaran dan portfolio.
