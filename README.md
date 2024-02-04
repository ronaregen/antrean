<p align="center"><a href="#" target="_blank"><img src="public/image/logo.png" width="400" alt="morqueue Logo"></a></p>

## Tentang Morqueue

Aplikasi ini adalah aplikasi yang dibuangun sebagai persyaratan teknis proses recruitment PT. Medika Digital Nusantara.
aplikasi ini bersifat online dan membutuhkan koneksi internet untuk mengakses server websocket

## Cara Instalasi

untuk deploy aplikasi ini jalankan

```bash
  composer install
```

karena aplikasi ini menggunakan beberapa library node seperti tailwindcss dan pusher, maka anda juga perlu menjalankan

```bash
  npm run build
```

## Route

Aplikasi ini terdiri dari 3 route yaitu:

-   '/' => berisi tampilan utama yang menampilkan halaman nomor antrean yang dilayani dan daftar antrean berikutnya
-   '/kiosk' => halaman untuk ambil nomor antrean
-   '/admin' => halaman untuk mengopreasikan next dan prev antrean.
