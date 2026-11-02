# PassCraft — Generator Kata Sandi Aman

Aplikasi generator kata sandi acak yang sederhana, cepat, dan mudah digunakan dengan estetika **Clean Minimalist / Swiss Minimalist**.

## Fitur Utama

- **Kriptografi Acak Aman**: Memanfaatkan CSPRNG (`random_int` pada PHP dan `window.crypto.getRandomValues` pada peramban).
- **Desain Clean Minimalist**: Antarmuka bersih, proporsional, berfokus penuh pada kegunaan tanpa elemen dekorasi berlebihan.
- **Pengaturan Panjang Fleksibel**: Slider panjang karakter interaktif (6 hingga 64 karakter).
- **Kontrol Set Karakter Lengkap**: Pilihan huruf besar (A-Z), huruf kecil (a-z), angka (0-9), dan simbol (!@#$).
- **Evaluasi Kekuatan Otomatis**: Indikator kekuatan kata sandi berbasis entropi informasi.
- **Salin Sekali Klik**: Salin kata sandi ke clipboard secara instan dengan umpan balik visual yang halus.
- **Responsif Sepenuhnya**: Desain adaptif untuk desktop maupun perangkat seluler.

## Persyaratan Sistem

- PHP >= 8.3
- Composer
- Node.js & NPM

## Instalasi

1. Clone repositori:
   ```bash
   git clone https://github.com/AhmadNurHidayat-23/passcraft-secure-password-generator.git
   cd passcraft-secure-password-generator
   ```

2. Instal dependensi PHP:
   ```bash
   composer install
   ```

3. Instal dependensi frontend:
   ```bash
   npm install
   ```

4. Konfigurasi file environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Build aset frontend:
   ```bash
   npm run build
   ```

6. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

## Pengujian

Jalankan test suite menggunakan Artisan:
```bash
php artisan test
```

## Lisensi

Open-source di bawah lisensi [MIT](LICENSE).
