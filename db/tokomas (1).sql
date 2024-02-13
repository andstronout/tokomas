-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 13, 2024 at 09:12 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokomas`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int NOT NULL,
  `id_user` int NOT NULL,
  `id_produk` int NOT NULL,
  `qty_cart` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `id_produk` int NOT NULL,
  `qty_transaksi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_produk`, `qty_transaksi`) VALUES
(24, 14, 1, 1),
(25, 14, 3, 3),
(26, 15, 3, 2),
(27, 16, 1, 2),
(28, 17, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `berat` int NOT NULL,
  `harga_produk` int NOT NULL,
  `qty_produk` int NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `gambar_produk` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `jenis`, `berat`, `harga_produk`, `qty_produk`, `deskripsi`, `gambar_produk`) VALUES
(1, 'Anting Diamod Blue', 'Anting', 6, 8000000, 46, 'Anting Diamond Blue terbuat dari emas putih 24 karat dengan desain elegan', 'anting1.jpg'),
(2, 'Anting U Gold', 'Anting', 5, 5000000, 5, 'Anting U Gold terbuat dari emas putih 24 karat dengan desain yang glamour cocok untuk di pakai diberbagai pesta', '1697429674.jpg'),
(3, 'Cincin Couple White Gold', 'Cincin', 10, 10000000, 45, 'Cincin Couple White Gold ialah Cincin yang terbuat dari mas putih yang cocok untuk pasangan yang ingin menikah', 'cincin1.jpg'),
(7, 'Kalung Emas', 'Kalung', 10, 10000000, 10, 'Kalung Emas dengan liontin Love', '1707723186.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `id_pesanan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_user` int NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total_transaksi` int NOT NULL,
  `bukti_bayar` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `no_resi` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pesanan`, `id_user`, `tanggal_transaksi`, `total_transaksi`, `bukti_bayar`, `status`, `no_resi`) VALUES
(14, 'NRJ1697538809', 3, '2023-10-17', 38000000, 'wallpaperflare.com_wallpaper.jpg', 'Selesai', 'IDX90929289'),
(15, 'NRJ1697599880', 3, '2023-10-18', 20000000, 'Screenshot 2023-10-17 160327.png', 'Selesai', 'IDX90929291'),
(16, 'NRJ1707722989', 3, '2024-02-12', 16000000, 'Roti Isi Cokelat.jpg', 'Selesai', 'IDX909292900'),
(17, 'NRJ1707813094', 8, '2024-02-13', 8000000, 'Bukti transfer.jpeg', 'Selesai', 'IDX90935290');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nomor_hp` varchar(40) NOT NULL,
  `alamat` varchar(500) NOT NULL,
  `level` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `email`, `password`, `nomor_hp`, `alamat`, `level`) VALUES
(1, 'Admin', 'admin@tokomas.com', '7815696ecbf1c96e6894b779456d330e', '123123', 'asdasdasd', 2),
(2, 'User', 'user@asd.com', '7815696ecbf1c96e6894b779456d330e', '123123', 'asdasdasd', 1),
(3, 'Andri Hidayat', 'andrih316@gmail.com', '7815696ecbf1c96e6894b779456d330e', '123123', 'asdasdasd', 1),
(4, 'Owner', 'owner@tokomas.com', '7815696ecbf1c96e6894b779456d330e', '123123', 'asdasdasd', 3),
(7, 'Dummy', 'dummy@asd.com', '7815696ecbf1c96e6894b779456d330e', '123', 'asd Tangerang-dsa Kode Pos : 78778', 1),
(8, 'Rivaldo', 'valdo@asd.com', '7815696ecbf1c96e6894b779456d330e', '08963075476', 'Citra Raya Tangerang-Banten Kode Pos : 78778', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
