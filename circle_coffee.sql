-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 16 Bulan Mei 2022 pada 20.20
-- Versi server: 8.0.27-0ubuntu0.20.04.1
-- Versi PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `circle_coffee`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`, `icon`) VALUES
(1, 'Breakfast', 'breakfast-svgrepo-com.svg'),
(2, 'Coffee Break', 'coffee-cup-svgrepo-com.svg'),
(3, 'Signature Coffee', 'signature-coffee.svg'),
(4, 'Espresso Based', 'espresso.svg'),
(5, 'Tea', 'tea.svg'),
(6, 'Fresh', 'fresh.svg'),
(7, 'Menu Main', 'menu-main.svg'),
(8, 'Snack', 'snack.svg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_user` int NOT NULL,
  `id_menu` int NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int NOT NULL,
  `id_kategori` int NOT NULL,
  `menu` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `stok` int NOT NULL,
  `harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `id_kategori`, `menu`, `photo`, `deskripsi`, `stok`, `harga`) VALUES
(1, 1, 'Soto Cirebon', 'sotocirebon.jpg', 'Brush, Bean, Corn Vermicelli, Egg.', 1084, 10000),
(3, 1, 'Mie Balap', 'miebalap.jpg', 'Brush, Bean, Mustard Greens.', 1115, 10000),
(4, 1, 'Lontong Kuah Kacang', 'lontongkuahkacang.jpg', 'Curry Sauce Combined With Pecel Nuts', 1000, 10000),
(5, 2, 'Vietnam Drip', 'vietnamdrip.jpg', 'Blend Coffee and Creamer', 1006, 20000),
(6, 2, 'Americano', 'hotespressobland.jpg', 'Hot Espresso Bland', 1000, 18000),
(7, 2, 'Hot Lemon Tea', 'hotlemontea.jpg', 'Lemon Tea', 1000, 18000),
(8, 2, 'Hot Tea', 'hottea.jpg', 'Jasmine Tea', 1000, 10000),
(9, 3, 'Es Kopi Susu Circle', 'eskopisusu.jpg', '', 1000, 20000),
(10, 3, 'Es kopi Cream Cheese', 'eskopicream.jpg', '', 1000, 25000),
(11, 3, 'Es Krim Kopi Susu', 'eskrimkopisusu.jpg', '', 1000, 25000),
(12, 3, 'Es Kopi Susu Boba', 'eskopisusuboba.jpg', '', 1000, 25000),
(13, 3, 'Es Kopi Susu Regal', 'eskopisusuregal.jpg', '', 1000, 25000),
(14, 3, 'Affogato', 'affogato.jpg', '', 1000, 24000),
(15, 4, 'Americano', 'americano.jpg', '', 1000, 18000),
(16, 4, 'Caramel Machiato', 'caramelmachiato.jpg', '', 1000, 30000),
(17, 4, 'Vanilla Latte', 'vanilalatte.jpg', '', 1000, 22000),
(18, 4, 'Caramel Latte', 'caramellatte.jpg', '', 1000, 22000),
(19, 4, 'Hazelnut Latte', 'hazelnulatte.jpg', '', 1000, 22000),
(20, 4, 'Cappucino', 'cappucino.jpg', '', 1000, 22000),
(21, 4, 'Coffee Mocha', 'coffeemocha.jpg', '', 1000, 27000),
(22, 5, 'Ice Tea', 'icetea.jpg', '', 1000, 15000),
(23, 5, 'Hot/Ice Lemon Tea', 'hoticelemontea.jpg', '', 1000, 18000),
(24, 6, 'Newzea Kiwi Punch', 'newzeakiwipunch.jpg', '', 1000, 22000),
(25, 6, 'Manggo Fresh', 'manggofresh.jpg', '', 1000, 25000),
(26, 6, 'Raspberry Punch', 'raspberrypunch.jpg', '', 1000, 25000),
(27, 7, 'Ayam Kremes', 'ayamkremes.jpg', 'Chicken Drum Stick Coverd with Crunchy Flavour and Chili Shrimp Paste', 1000, 25000),
(28, 7, 'Ayam Geprek', 'ayamgeprek.jpg', 'Chicken Breast with Spicy and Tasty Super Spicy Sambal', 1000, 20000),
(29, 7, 'Tongseng Ayam', 'tongsengayam.jpg', 'Chicken Meat with Salty Peanut Butter', 1000, 20000),
(30, 7, 'Tongseng Sapi', 'tongsengsapi.jpg', 'Tasty Beef Strips along with Tasty Coconut Milk', 1000, 25000),
(31, 7, 'Sate Ayam', 'sateayam.jpg', 'Chicken Meat with Salty Peanut Butter', 1000, 25000),
(32, 7, 'Mie Goreng Spesial Circle', 'miegorengspesialcircle.jpg', 'Special Noodle for Someone Special. Like You.', 1000, 15000),
(33, 7, 'Mie Kuah Spesial', 'miekuahspesial.jpg', 'Warm Noodle to Relax your Tummy', 1000, 15000),
(34, 7, 'Nasi Goreng Kampung', 'nasigorengkampung.jpg', 'Tradisional Fried Rice, with Teri Medan, Kangkung, Slice of Rawit, And ups, without Soy Sauce.', 1000, 20000),
(35, 7, 'Nasi Goreng Pete', 'nasigorengpete.jpg', 'Fried Rice with Petai to Make Your Day.', 1000, 20000),
(36, 7, 'Nasi Goreng Circle', 'nasigorengcircle.jpg', 'Collaboration rice, with Slice of Chicken Meat, a Bit Sausage, and Scramble Egg', 1000, 20000),
(37, 7, 'Chicken Steak', 'chickensteak.jpg', 'Great Chicken Meat, Veggies, slice of Potatoes, and Secret Sauce', 1000, 25000),
(38, 7, 'Beef Steak', 'beefsteak.jpg', 'Super Meat, Veggies, slice of Potatoes, and Special Sauce', 1000, 35000),
(39, 7, 'Spagehtti', 'spagehtti.jpg', 'Try it, then you\'re going to say \"Uh lala\"', 1000, 35000),
(40, 8, 'French Fries', 'frenchfries.jpg', 'Potato stick for you', 1000, 15000),
(41, 7, 'Nugget', 'nugget.jpg', 'Extraordinary Nugget only for you', 1000, 15000),
(42, 8, 'Mix Platter', 'mixplatter.jpg', 'When French Fries, Nugget, Sausage and gathered together.', 1000, 15000),
(43, 8, 'Banana Springroll', 'bananaspringroll.jpg', 'When Banana Covered with Chocolate and Springroll Skin', 1000, 15000),
(44, 7, 'Ubi Goreng', 'ubigoreng.jpg', 'A Traditional Fried Casava', 1000, 15000),
(45, 8, 'Aneka Gorengan', 'anekagorengan.jpg', 'Sumedang Tofu, Combread, Sweet Banana, and also Fried Casava, with Spicy Sauce and Chili', 1000, 20000),
(69, 1, 'menu', '', 'desk', 2000, 222);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_transaksi` int NOT NULL,
  `id_menu` int NOT NULL,
  `harga` int NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` int NOT NULL,
  `reservasi` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int NOT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reservasi`
--

INSERT INTO `reservasi` (`id_reservasi`, `reservasi`, `deskripsi`, `harga`, `foto`) VALUES
(1, '2 - 5 Orang', 'Nasi Goreng, Coffee Break, Tea', 100000, 'room1.png'),
(2, '5 - 10 Orang', 'Nasi Goreng, Coffee Break, Tea', 200000, 'room2.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'admin'),
(2, 'admin2'),
(3, 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `total` int NOT NULL,
  `status` enum('Belum Bayar','Diproses','Pesanan Sudah Siap','Selesai','Dibatalkan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_transaksi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `petugas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_reservasi`
--

CREATE TABLE `transaksi_reservasi` (
  `id` int NOT NULL,
  `id_reservasi` int NOT NULL,
  `id_user` int NOT NULL,
  `total` int NOT NULL,
  `bayar` int NOT NULL,
  `status` enum('Belum Bayar','Belum Lunas','Lunas','Selesai','Dibatalkan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_reservasi` date DEFAULT NULL,
  `tgl_transaksi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `petugas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int NOT NULL,
  `is_active` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `no_telp`, `password`, `foto`, `create_at`, `role_id`, `is_active`) VALUES
(1, 'Admin', 'admin', '08081290', 'admin123', NULL, '2022-04-16 22:20:17', 1, 1),
(14, 'abcd', 'abcd@gmail.com', '082030232323', 'abcd', NULL, '2022-04-23 23:34:25', 3, 1),
(16, 'tes', 'email@gmail.com', '90', '123', NULL, '2022-04-26 16:30:09', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_reservasi`
--
ALTER TABLE `transaksi_reservasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi_reservasi`
--
ALTER TABLE `transaksi_reservasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
