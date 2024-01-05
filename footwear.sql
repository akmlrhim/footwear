-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jan 2024 pada 06.21
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `footwear`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `ukuran` int(11) NOT NULL,
  `warna` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `id_kategori`, `gambar`, `ukuran`, `warna`, `jumlah`, `deskripsi`) VALUES
(93, 'Sepatu AB', 17, 'default_image.jpg', 41, 'Hitam', 46, 'Kondisi: Baru\r\nMin. Pemesanan: 1 Buah\r\nEtalase: Sepatu sneaker wanita\r\nProduk : Sneakers\r\nBahan : Sintesis\r\nWarna : Hitam, Putih\r\nSize : 36, 37, 38, 39, 40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_brg_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `harga_satuan` float(10,2) NOT NULL,
  `total_harga` float(10,2) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `disimpan_oleh` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_brg_keluar`, `id_barang`, `jumlah_keluar`, `harga_satuan`, `total_harga`, `tgl_keluar`, `disimpan_oleh`) VALUES
(14, 93, 120, 120000.00, 14400000.00, '2023-12-24', 'Akmal Rahim'),
(15, 93, 1, 120000.00, 120000.00, '2023-12-29', 'Akmal Rahim'),
(16, 93, 2, 120000.00, 240000.00, '2023-12-29', 'Akmal Rahim');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_brg_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `harga_satuan` float(10,2) NOT NULL,
  `total_harga` float(10,2) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `disimpan_oleh` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_brg_masuk`, `id_barang`, `id_supplier`, `jumlah_masuk`, `harga_satuan`, `total_harga`, `tgl_masuk`, `disimpan_oleh`) VALUES
(84, 93, 13, 3, 120000.00, 360000.00, '2023-12-31', 'karyawan'),
(85, 93, 13, 2, 100000.00, 200000.00, '2024-01-02', 'Owner');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(5, 'Sekolah'),
(17, 'Sneaker'),
(18, 'Wedges'),
(22, 'Loafers'),
(23, 'Boots'),
(24, 'Stiletto'),
(36, 'Flat Shoes'),
(44, 'Sandals'),
(45, 'Formal Shoes'),
(47, 'High Heels Party'),
(48, 'Slip On'),
(49, 'Mary Janes'),
(50, 'Ballerina Flats'),
(51, 'Peep Toe Heels'),
(52, 'Derby Shoes'),
(53, 'Monk-Strap Shoes'),
(54, 'Oxford Shoes'),
(55, 'Brogue'),
(56, 'Running Shoes'),
(57, 'Pumps'),
(58, 'Kitten Heels'),
(59, 'Ankle Boots'),
(60, 'T-straps'),
(61, ' Cone Heels'),
(62, 'Gladiator Sandal'),
(63, 'Gladiator Boots'),
(64, ' Sling Back Heels'),
(66, 'Trainers'),
(67, 'Thigh High Boots'),
(68, 'Spool Heels'),
(69, 'Platform'),
(70, 'Mules'),
(71, 'Espadrille '),
(72, 'Kanvas'),
(73, 'Chelsea Boots');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama`, `kontak`) VALUES
(13, 'PT . AB', '081244569981');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` char(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(47, 'owner', '$2y$10$3gNHAJFlEVAa8gfLScrB6.CxjtRAHN3Tk2TYV9/AENesQyqDxCcey', 'Owners', 'Owner'),
(48, 'karyawans', '$2y$10$Dtd1Z/hdzlmOSRezy/9kOOT9H1.VwLaqaRJig.uAKqvjGPPDTvsHG', 'karyawan123', 'Karyawan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_brg_keluar`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_brg_masuk`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_brg_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_brg_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
