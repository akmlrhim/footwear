<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */

// default
$routes->get('/', 'Auth::index');

// auth
$routes->group('auth', static function ($routes) {
	$routes->post('login', 'Auth::login');
	$routes->get('logout', 'Auth::logout');
});

// dashboard`
$routes->group('dashboard', static function ($routes) {
	$routes->get('/', 'Dashboard::index');
});

//barang
$routes->group('barang', static function ($routes) {
	$routes->get('/', 'Barang::index');
	$routes->get('tambah', 'Barang::tambahBarang');
	$routes->post('simpan', 'Barang::simpanBarang');
	$routes->delete('(:num)', 'Barang::hapusBarang/$1');
	$routes->get('edit/(:num)', 'Barang::editBarang/$1');
	$routes->post('update/(:num)', 'Barang::updateBarang/$1');
	$routes->get('detail/(:num)', 'Barang::detailBarang/$1');
	$routes->get('cetak-barang-habis', 'Barang::cetakBarangHabis');
	$routes->get('data-barang', 'Barang::dataBarang');
});

//kategori
$routes->group('kategori', static function ($routes) {
	$routes->get('/', 'Kategori::index');
	$routes->get('tambah', 'Kategori::tambahKategori');
	$routes->delete('(:num)', 'Kategori::hapusKategori/$1');
	$routes->post('simpan', 'Kategori::simpanKategori');
	$routes->get('edit/(:num)', 'Kategori::editKategori/$1');
	$routes->post('update/(:num)', 'Kategori::updateKategori/$1');
	$routes->get('data-kategori', 'Kategori::dataKategori');
});

//barang masuk
$routes->group('barang_masuk', static function ($routes) {
	$routes->get('/', 'BarangMasuk::index');
	$routes->get('krw', 'BarangMasuk::indexs');
	$routes->get('tambah', 'BarangMasuk::tambahBrgMasuk');
	$routes->post('simpan', 'BarangMasuk::simpanBrgMasuk');
	$routes->delete('(:num)', 'BarangMasuk::hapusBrgMasuk/$1');
	$routes->get('rep-barang-masuk', 'BarangMasuk::repMasuk');
	$routes->get('filtered-data', 'BarangMasuk::filterData');
	$routes->get('data-barang-masuk-own', 'BarangMasuk::dataBrgMasuk_own');
	$routes->get('data-barang-masuk-krw', 'BarangMasuk::dataBrgMasuk_krw');
});

//barang keluar
$routes->group('barang_keluar', static function ($routes) {
	$routes->get('/', 'BarangKeluar::index');
	$routes->get('krw', 'BarangKeluar::indexs');
	$routes->get('tambah', 'BarangKeluar::tambahBrgKeluar');
	$routes->post('simpan', 'BarangKeluar::simpanBrgKeluar');
	$routes->delete('(:num)', 'barangKeluar::hapusBrgKeluar/$1');
	$routes->get('rep-barang-keluar', 'BarangKeluar::repKeluar');
	$routes->get('filtered-data', 'BarangKeluar::filterData');
	$routes->get('data-barang-keluar-own', 'BarangKeluar::dataBrgKeluar_own');
	$routes->get('data-barang-keluar-krw', 'BarangKeluar::dataBrgKeluar_krw');
});

//supplier
$routes->group('supplier', static function ($routes) {
	$routes->get('/', 'Supplier::index');
	$routes->get('tambah', 'Supplier::tambahSupplier');
	$routes->post('simpan', 'Supplier::simpanSupplier');
	$routes->get('edit/(:num)', 'Supplier::editSupplier/$1');
	$routes->post('update/(:num)', 'Supplier::updateSupplier/$1');
	$routes->delete('(:num)', 'Supplier::hapusSupplier/$1');
	$routes->get('data-supplier', 'Supplier::dataSupplier');
});

//user
$routes->group('user', static function ($routes) {
	$routes->get('/', 'User::index');
	$routes->get('tambah', 'User::tambahUser');
	$routes->post('simpan', 'User::simpanUser');
	$routes->get('edit/(:num)', 'User::editUser/$1');
	$routes->post('update/(:num)', 'User::updateUser/$1');
	$routes->delete('(:num)', 'User::hapusUser/$1');
	$routes->get('ubah-password', 'User::ubahPassword');
	$routes->post('ubah-password', 'User::updatePassword');
	$routes->get('data-user', 'User::dataUser');
});
