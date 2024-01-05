# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

The user guide corresponding to the latest version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library


## How to Instalatiion
Extract File menggunakan pengekstrak file zip, rar, atau sejenisnya
Jika sudah mengekstrak, letakkan file project ini ke dalam xampp/htdocs (jika anda ingin menjalanka tanpa spark)
jika ingin menggunakan spark, bila langsung jalankan php spark serve diterminal anda di dalam project

## Type OF USER
1. Owner ==> Full Access
2. Karyawan ==> hanya data transaksi (barang masuk & barang keluar), beserta laporannya.

dan kedua user dapat melakukan ubah password sendiri


## PROJECT DESCRIPTION
Sistem Informasi Pendataan Stok Barang Toko Sepatu Footwear adalah
sebuah sistem yang dirancang untuk mempermudah pengelolaan inventaris sepatu.
Fitur inti dalam sistem ini mencakup tiga fitur utama yang sangat relevan dalam
operasional toko sepatu, yaitu Kelola Barang, Kelola Transaksi Barang Masuk, dan
Kelola Transaksi Barang Keluar.
Kelola barang adalah fitur yang memungkinkan pemantauan secara rinci
terhadap inventaris sepatu, memungkinkan pencatatan detail seperti merek, jenis
sepatu, ukuran, warna, dan jumlah yang tersedia. Ini membantu pemilik atau staf
toko untuk dengan mudah mengelola dan menyusun stok barang dengan sistematis.
Kelola transaksi barang masuk adalah fitur yang berfungsi untuk pencatatan
barang yang masuk ke toko sepatu. Ini mencakup informasi tentang pemasok,
tanggal kedatangan barang, jumlah yang diterima, dan informasi harga.
Dengan fitur ini, sistem menyediakan informasi yang jelas dan lengkap mengenai
setiap barang baru yang diterima, sehingga memudahkan pemantauan dan
pelacakan asal-usul barang tersebut.
Kelola transaksi barang keluar adalah fitur yang berfungsi untuk mencatat
semua barang yang dijual dari stok toko. Setiap transaksi penjualan dicatat dengan
detail seperti tanggal penjualan, jenis sepatu yang dijual, jumlah, dan harga jualnya.
Hal ini memungkinkan pemantauan akurat terhadap penjualan serta secara otomatis
memperbarui stok setiap kali terjadi penjualan.
Selain itu, sistem ini juga memiliki fitur cetak laporan. Cetak laporan ini
mencatat beberapa data seperti data barang yang sudah dinyatakan habis,
pencatatan transaksi barang keluar dan barang masuk perperiode. Dengan adanya
fitur ini pengguna dapat dengan mudah melakukan pencatatan keuangan dengan
mudah tanpa harus melakukan penghitungan secara manual.
Dengan adanya beberapa fitur ini, sistem menyediakan solusi untuk
manajemen stok sepatu, memungkinkan pemilik toko untuk memantau stok secara
dengan mudah, mengoptimalkan proses pengelolaan persediaan, serta
meminimalkan risiko kekurangan atau kelebihan stok yang tidak diinginkan.