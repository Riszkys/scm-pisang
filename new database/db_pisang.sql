-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2023 at 11:55 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pisang`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_bahan_baku`
--

CREATE TABLE `tb_bahan_baku` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `nama_bahan_baku` varchar(30) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `min_stok` int(11) NOT NULL,
  `total` double NOT NULL,
  `keterangan` varchar(30) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_bahan_baku`
--

INSERT INTO `tb_bahan_baku` (`id`, `supplier_id`, `nama_bahan_baku`, `harga`, `stok`, `min_stok`, `total`, `keterangan`, `gambar`) VALUES
(1, 1, 'Barangan Merah Grade A', 9000, 390, 1, 0, 'Mulus', '18263_pisang1.jpg'),
(2, 2, 'Barangan Merah Grade B', 8000, 246, 1, 0, 'Sedikit Berbintik', '4676_pisang5.jpeg'),
(3, 3, 'Barangan Merah Grade A', 9000, 231, 1, 0, 'Mulus', '31842_pisang2.jpg'),
(4, 2, 'Barangan Merah Grade B', 8000, 242, 1, 0, 'Sedikit Berbintik', '4676_pisang5.jpeg'),
(5, 5, 'Barangan Merah Grade C', 70000, 250, 1, 0, 'Berbintik', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_konsumen`
--

CREATE TABLE `tb_konsumen` (
  `id` int(11) NOT NULL,
  `nama_konsumen` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_handphone` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_konsumen`
--

INSERT INTO `tb_konsumen` (`id`, `nama_konsumen`, `alamat`, `no_handphone`, `username`, `email`, `password`) VALUES
(1, 'Pajak Kartini', 'Kisaran', '082249758444', 'kartini', 'kartini@gmail.com', 'kartini'),
(2, 'ss', 'ss', '081892712', 'ss', 'ss@gmail.com', 'ss'),
(3, 'ari', 'lamongan', '0821863813', 'ari', 'arimahendra@gmail.com', 'ari'),
(4, 'tes', 'jayabaya', '08198291', 'tes', 'tes@gmail.com', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `id` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `bukti` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `lokasi_barang` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`id`, `id_supplier`, `status`, `bukti`, `tanggal`, `lokasi_barang`) VALUES
(54, 1, 0, '', '2023-08-04', NULL),
(55, 1, 1, 'logo kiki.jpg', '2023-08-04', NULL),
(56, 1, 2, 'logo kiki.jpg', '2023-08-05', NULL),
(57, 2, 2, 'logo kiki.jpg', '2023-08-05', NULL),
(58, 1, 0, '', '2023-08-05', NULL),
(59, 1, 0, '', '2023-08-05', NULL),
(60, 1, 2, 'logo kiki.jpg', '2023-08-05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembelian`
--

CREATE TABLE `tb_pembelian` (
  `id` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `nama_bahan_baku` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_pembelian`
--

INSERT INTO `tb_pembelian` (`id`, `id_supplier`, `id_order`, `nama_bahan_baku`, `tanggal`, `jumlah`, `harga`, `keterangan`, `total`) VALUES
(54, 1, 54, 'Barangan Merah Grade A', '2023-08-04', 10, 9000, 'checkout', 90000),
(55, 1, 55, 'Barangan Merah Grade A', '2023-08-04', 10, 9000, 'diterima', 90000),
(56, 1, 56, 'Barangan Merah Grade A', '2023-08-05', 10, 9000, 'selesai', 90000),
(57, 2, 57, 'Barangan Merah Grade B', '2023-08-05', 1, 8000, 'selesai', 8000),
(58, 1, 58, 'Barangan Merah Grade A', '2023-08-05', 11, 9000, 'ditolak', 99000),
(59, 1, 59, 'Barangan Merah Grade A', '2023-08-05', 12, 9000, 'checkout', 108000),
(60, 1, 60, 'Barangan Merah Grade A', '2023-08-05', 11, 9000, 'selesai', 99000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemesanan`
--

CREATE TABLE `tb_pemesanan` (
  `id` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `nama_bahan_baku` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `id` int(11) NOT NULL,
  `produk` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `berat_bersih` int(11) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id`, `nama`, `jumlah`, `berat_bersih`, `harga`, `total`) VALUES
(21, 'Pisang Barangan Merah Grade A', 350, 250, 9000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_produksi`
--

CREATE TABLE `tb_produksi` (
  `id` int(11) NOT NULL,
  `produk` varchar(50) NOT NULL,
  `jumlah` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_produksi`
--

INSERT INTO `tb_produksi` (`id`, `produk`, `jumlah`, `status`, `tanggal`) VALUES
(1, 'Pisang Barangan Merah Grade A', '100', 'produksi', '2023-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produksi_bahan_baku`
--

CREATE TABLE `tb_produksi_bahan_baku` (
  `id` int(11) NOT NULL,
  `produk` varchar(50) NOT NULL,
  `bahan_baku` varchar(50) NOT NULL,
  `jumlah` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_produksi_bahan_baku`
--

INSERT INTO `tb_produksi_bahan_baku` (`id`, `produk`, `bahan_baku`, `jumlah`) VALUES
(12, 'Tepung Tapioka', 'Ubi Kayu (Tinggi Raja)', '40'),
(15, 'Tepung Tapioka Cap Dua Naga (25 kg)', 'Ubi Kayu (Tinggi Raja)', '30'),
(17, 'Tepung Tapioka Cap Dua Naga (50 kg)', 'Ubi Kayu (Dusun)', '30'),
(18, 'Barangan Merah Grade A', 'Barangan Merah Grade A', '1000'),
(19, 'Pisang Barangan Merah Grade A', 'Barangan Merah Grade A', '250');

-- --------------------------------------------------------

--
-- Table structure for table `tb_return`
--

CREATE TABLE `tb_return` (
  `id_return` int(5) NOT NULL,
  `id_konsumen` int(5) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `tanggal_return` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `alasan_return` text NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_return`
--

INSERT INTO `tb_return` (`id_return`, `id_konsumen`, `id_pembelian`, `tanggal_return`, `alasan_return`, `gambar`) VALUES
(16, 3, 33, '2023-08-05 20:44:58', 'cacat', '1697302732.jpg'),
(17, 3, 35, '2023-08-05 20:49:22', 'tes', '765394305.jpg'),
(18, 3, 36, '2023-08-06 09:13:39', 'testing 2', '1437932544.jpg'),
(19, 3, 37, '2023-08-06 09:37:57', 'oke', '892626586.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_handphone` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id`, `nama_supplier`, `alamat`, `no_handphone`, `username`, `email`, `password`) VALUES
(1, 'Maslina', 'Sionggang', '081236318642', 'maslina', 'maslina@gmail.com', 'maslina'),
(2, 'Eko Sujono', 'Air Joman', '081354367834', 'eko', 'eko@gmail.com', 'eko'),
(3, 'Rismawati', 'Sido Rukun', '085343566550', 'risma', 'risma@gmail.com', 'risma'),
(4, 'Taufiq', 'Sei Renggas', '082372333001', 'taufiq', 'Taufiq@gmail.com', 'taufiq'),
(5, 'M. Rivaldi', 'Kisaran', '082257724004', 'rival', 'rival@gmail.com', 'rival');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `hp` varchar(15) NOT NULL,
  `total` int(7) NOT NULL,
  `status` varchar(30) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id`, `id_konsumen`, `alamat`, `hp`, `total`, `status`, `bukti`, `tanggal`) VALUES
(32, 3, 'lamongan', '0821863813', 18000, '8', '1969453321.jpg', '2023-08-06'),
(33, 3, 'lamongan', '0821863813', 54000, '8', '1432523305.jpg', '2023-08-06'),
(34, 3, 'lamongan', '0821863813', 54000, '5', '93795758.jpg', '2023-08-06'),
(35, 3, 'lamongan', '0821863813', 54000, '8', '811506948.png', '2023-08-06'),
(36, 3, 'lamongan', '0821863813', 54000, '8', '2108316177.jpg', '2023-08-06'),
(37, 3, 'lamongan', '0821863813', 54000, '8', '554300995.jpg', '2023-08-06');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_detail`
--

CREATE TABLE `tb_transaksi_detail` (
  `id` int(4) NOT NULL,
  `id_transaksi` int(4) NOT NULL,
  `id_bahan_baku` int(4) NOT NULL,
  `jumlah` int(7) NOT NULL,
  `harga` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_transaksi_detail`
--

INSERT INTO `tb_transaksi_detail` (`id`, `id_transaksi`, `id_bahan_baku`, `jumlah`, `harga`) VALUES
(49, 31, 1, 4, 9000),
(51, 33, 1, 6, 9000),
(52, 34, 1, 6, 9000),
(53, 35, 1, 6, 9000),
(54, 36, 1, 6, 9000),
(55, 37, 1, 6, 9000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'pimpinan', '90973652b88fe07d05a4304f0a945de8', 'pimpinan'),
(3, 'admin1', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_bahan_baku`
--
ALTER TABLE `tb_bahan_baku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_konsumen`
--
ALTER TABLE `tb_konsumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pembelian`
--
ALTER TABLE `tb_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pemesanan`
--
ALTER TABLE `tb_pemesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_produksi`
--
ALTER TABLE `tb_produksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_produksi_bahan_baku`
--
ALTER TABLE `tb_produksi_bahan_baku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_return`
--
ALTER TABLE `tb_return`
  ADD PRIMARY KEY (`id_return`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_transaksi_detail`
--
ALTER TABLE `tb_transaksi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_bahan_baku`
--
ALTER TABLE `tb_bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_konsumen`
--
ALTER TABLE `tb_konsumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tb_pembelian`
--
ALTER TABLE `tb_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tb_pemesanan`
--
ALTER TABLE `tb_pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tb_produksi`
--
ALTER TABLE `tb_produksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_produksi_bahan_baku`
--
ALTER TABLE `tb_produksi_bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_return`
--
ALTER TABLE `tb_return`
  MODIFY `id_return` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tb_transaksi_detail`
--
ALTER TABLE `tb_transaksi_detail`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
