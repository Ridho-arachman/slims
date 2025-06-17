# 📚 SLiMS Bulian 9.6 - Modul Rekomendasi Buku & Statistik Peminjaman

## ✅ 1. Langkah Instalasi SLiMS Bulian 9.6

### Persyaratan Sistem

- **Web Server:** Apache/Nginx
- **PHP:** 7.2 atau lebih tinggi
- **Database:** MySQL/MariaDB
- **Tambahan:** Composer (opsional)
- **Tools Lokal:** Laragon/XAMPP

### Langkah Instalasi

1. **Unduh SLiMS:** [GitHub SLiMS Bulian](https://github.com/slims/slims9_bulian)
2. **Ekstrak ke Folder Server Lokal:** Contoh `C:/laragon/www/slims`
3. **Buat Database Baru:** Misalnya `slims_db`
4. **Akses di Browser:** `http://localhost/slims/install`
5. **Ikuti Proses Instalasi:**
   - Isi konfigurasi database
   - Pastikan folder `files/`, `images/`, dan `repository/` bisa ditulis (`chmod 777` di Linux)
6. **SLiMS Siap Digunakan:** Akses di `http://localhost/slims`

---

## 🎨 2. Perubahan Tema & File yang Dimodifikasi

### A. Tema yang Dimodifikasi

- **Lokasi Tema:** `themes/default/`
- **File yang Diubah:**
  - `index_template.inc.php`: Struktur layout halaman
  - `style.css`: Modifikasi tampilan visual (warna, font, padding)
  - Penambahan ikon Font Awesome (jika digunakan)

### B. File Tambahan untuk Fitur

- `admin/modules/rating_buku/save_rating.php`: Menyimpan rating dari member
- `admin/modules/rekomendasi_buku/top_rated.php`: Menampilkan buku dengan rating tertinggi

### C. Halaman Detail Buku

- Menambahkan form rating
- Validasi member login sebelum memberikan rating
- AJAX untuk kirim data rating tanpa reload

---

## ⭐ 3. Deskripsi Modul Rekomendasi Buku

### Nama Modul

**Modul Rekomendasi Buku berdasarkan Rating Tertinggi**

### Tujuan

Memberikan rekomendasi 5 buku terbaik berdasarkan rating tertinggi dari member/pembaca.

### Fungsi

- Mengambil data dari tabel `biblio_rating`
- Menghitung rata-rata rating (`AVG`)
- Menampilkan 5 buku dengan rating tertinggi

### File yang Digunakan

- Struktur tabel `biblio_rating`
- `top_rated.php`
- `save_rating.php`
- `detail_buku.php` (penempatan form rating)

---

## 📊 4. Ekspor Laporan & Statistik

### A. Ekspor Peminjaman ke Excel & PDF

- **Lokasi File:** `admin/modules/laporan_peminjaman/export.php`
- **Fitur:**
  - Input tanggal mulai dan akhir
  - Ekspor ke format `.xls` dan `.pdf`
- **Teknologi:**
  - `.xls`: Header `application/vnd.ms-excel`
  - `.pdf`: Menggunakan library `FPDF`

### B. Statistik Bulanan

- Menampilkan statistik dalam bentuk dashboard admin
- Data yang ditampilkan:
  - Jumlah buku dipinjam (per bulan)
  - Jumlah buku dikembalikan
  - Jumlah keterlambatan

---

## 🖼 5. Screenshot Tampilan Akhir (yang Disarankan)

1. Halaman Beranda (menampilkan form rating ⭐ Rekomendasi buku)
   ![Nama Gambar](./1.png)
2. Alert sukses/gagal setelah submit rating
3. Halaman rekomendasi buku (berisi 5 buku terbaik)
4. Statistik peminjaman bulanan
5. Hasil file Excel dan PDF dari ekspor

---

## 📂 Struktur Tabel `biblio_rating`

```sql
CREATE TABLE `biblio_rating` (
  `id` int NOT NULL AUTO_INCREMENT,
  `biblio_id` int NOT NULL,
  `member_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
```

---

## 🚀 Pengembangan Selanjutnya

- Rating dengan tampilan bintang interaktif (misal menggunakan plugin jQuery Star Rating)
- Statistik grafik menggunakan Chart.js
- Modul rekomendasi berdasarkan genre atau histori peminjaman

---

_Developed by: [MUHAMMAD RIDHO ARACHMAN (14022200148) / UNIVERSITAS BINA BANGSA]_
