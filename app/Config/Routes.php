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
	$routes->get('data-barang', 'Dashboard::dataBarang');
});


//barang
$routes->group('barang', static function ($routes) {
	$routes->get('/', 'Barang::index');
	$routes->get('tambah', 'Barang::tambahBarang');
	$routes->post('simpan', 'Barang::simpanBarang');
	$routes->delete('(:segment)', 'Barang::hapusBarang/$1');
	$routes->get('edit/(:segment)', 'Barang::editBarang/$1');
	$routes->post('update/(:segment)', 'Barang::updateBarang/$1');
	$routes->get('detail/(:segment)', 'Barang::detailBarang/$1');
	$routes->get('cetak-barang-habis', 'Barang::cetakBarangHabis');
});

//kategori
$routes->group('kategori', static function ($routes) {
	$routes->get('/', 'Kategori::index');
	$routes->get('tambah', 'Kategori::tambahKategori');
	$routes->delete('(:segment)', 'Kategori::hapusKategori/$1');
	$routes->post('simpan', 'Kategori::simpanKategori');
	$routes->get('edit/(:segment)', 'Kategori::editKategori/$1');
	$routes->post('update/(:segment)', 'Kategori::updateKategori/$1');
});

//barang masuk
$routes->group('barang_masuk', static function ($routes) {
	$routes->get('/', 'BarangMasuk::index');
	$routes->get('tambah', 'BarangMasuk::tambahBrgMasuk');
	$routes->post('simpan', 'BarangMasuk::simpanBrgMasuk');
	$routes->delete('(:segment)', 'BarangMasuk::hapusBrgMasuk/$1');
	$routes->get('rep-barang-masuk', 'BarangMasuk::repMasuk');
	$routes->get('filtered-data', 'BarangMasuk::filterData');
});

//barang keluar
$routes->group('barang_keluar', static function ($routes) {
	$routes->get('/', 'BarangKeluar::index');
	$routes->get('tambah', 'BarangKeluar::tambahBrgKeluar');
	$routes->post('simpan', 'BarangKeluar::simpanBrgKeluar');
	$routes->delete('(:segment)', 'barangKeluar::hapusBrgKeluar/$1');
	$routes->get('rep-barang-keluar', 'BarangKeluar::repKeluar');
	$routes->get('filtered-data', 'BarangKeluar::filterData');
});


//supplier
$routes->group('supplier', static function ($routes) {
	$routes->get('/', 'Supplier::index');
	$routes->get('tambah', 'Supplier::tambahSupplier');
	$routes->post('simpan', 'Supplier::simpanSupplier');
	$routes->get('edit/(:segment)', 'Supplier::editSupplier/$1');
	$routes->post('update/(:segment)', 'Supplier::updateSupplier/$1');
	$routes->delete('(:segment)', 'Supplier::hapusSupplier/$1');
});

//user
$routes->group('user', static function ($routes) {
	$routes->get('/', 'User::index');
	$routes->get('tambah', 'User::tambahUser');
	$routes->post('simpan', 'User::simpanUser');
	$routes->get('edit/(:segment)', 'User::editUser/$1');
	$routes->post('update/(:segment)', 'User::updateUser/$1');
	$routes->delete('(:segment)', 'User::hapusUser/$1');
	$routes->get('ubah-password', 'User::ubahPassword');
	$routes->post('ubah-password', 'User::updatePassword');
});
