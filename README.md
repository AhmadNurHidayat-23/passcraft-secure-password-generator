# PassCraft — Generator Kata Sandi Aman

PassCraft adalah aplikasi utilitas berbasis web yang dirancang khusus untuk menghasilkan kata sandi acak yang kuat, aman secara kriptografi, dan mudah digunakan. Aplikasi ini dibangun dengan pendekatan filosofi desain **Clean Minimalist / Swiss Minimalist**, mengutamakan tipografi presisi, hierarki visual yang jelas, serta fungsionalitas tanpa elemen dekorasi yang tidak perlu (*zero AI-slop*).

## Gambaran Sistem

Sistem PassCraft berfokus pada satu tujuan utama: menyediakan pembuatan kata sandi yang aman, cepat, dan transparan bagi pengguna. Seluruh kalkulasi acak dilakukan dengan generator bilangan acak kriptografis (CSPRNG), memastikan kata sandi yang dihasilkan memiliki entropi tinggi dan resistan terhadap serangan *brute-force* maupun analisis probabilistik.

## Fitur dan Fungsionalitas Utama

1. **Pembuatan Kata Sandi Acak Aman**
   - Menghasilkan kata sandi menggunakan pustaka kriptografi acak aman baik di sisi peramban (`window.crypto.getRandomValues`) maupun di sisi server (PHP `random_int`).
   - Setiap set karakter yang dipilih dijamin hadir setidaknya satu karakter dalam hasil, kemudian diacak secara menyeluruh menggunakan algoritma Fisher-Yates.

2. **Kustomisasi Panjang Karakter**
   - Mendukung penyesuaian panjang kata sandi secara fleksibel mulai dari 6 hingga 64 karakter melalui kendali slider interaktif dengan pembaruan instan.

3. **Kontrol Kombinasi Karakter**
   - Fleksibilitas memilih 4 kelompok karakter dasar:
     - **Huruf Besar**: Karakter alfabet kapital (`A-Z`).
     - **Huruf Kecil**: Karakter alfabet kecil (`a-z`).
     - **Angka**: Karakter numerik (`0-9`).
     - **Simbol**: Simbol standar yang aman dan umum digunakan (`!@#$%^&*()_+-=[]{}|;:,.<>?`).
   - Dilengkapi validasi aktif untuk memastikan minimal satu set karakter selalu terpilih.

4. **Evaluasi Kekuatan Kata Sandi Real-Time**
   - Menghitung entropi informasi dalam satuan bit berdasarkan panjang kata sandi dan ukuran ruang karakter.
   - Menyajikan indikator kekuatan sederhana dan mudah dipahami: *Lemah*, *Sedang*, *Kuat*, hingga *Sangat Kuat*.

5. **Penyalinan Instan Satu Klik**
   - Fitur salin ke papan klip (*clipboard*) yang cepat dengan status umpan balik visual (*"Tersalin!"*).

## Prinsip dan Estetika Desain

Sistem PassCraft dirancang dengan panduan desain **Swiss Minimalist**:
- **Fokus Tunggal**: Antarmuka terpusat pada satu kontainer generator tanpa sidebar, dashboard, atau elemen pengalih perhatian.
- **Tipografi Bersih**: Tipografi sans-serif modern Inter dipadukan dengan tipografi monospace untuk pembacaan karakter kata sandi yang jelas dan tidak ambigu.
- **Palet Warna Netral**: Menggunakan latar belakang off-white (`#fbfbfb`), kontainer putih (`#ffffff`), teks hitam (`#111827`), dan abu-abu netral (`#6b7280`).
- **Tanpa Elemen Artifisial**: Meniadakan gradien warna berlebih, efek neon/glow, glassmorphism, maupun animasi lambat demi performa dan kejelasan utilitas.
- **Responsif**: Penataan tata letak proporsional yang beradaptasi secara optimal pada resolusi desktop maupun layar perangkat seluler.

## Arsitektur Teknis

- **Framework**: Laravel 13
- **Templating**: Laravel Blade (Server-Side Rendering)
- **Styling**: Vanilla CSS modular dan terpisah dari markup Blade
- **Interaktivitas**: Vanilla JavaScript murni tanpa dependensi eksternal
- **Keamanan**: CSPRNG (*Cryptographically Secure Pseudo-Random Number Generator*)
