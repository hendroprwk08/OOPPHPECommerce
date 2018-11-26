-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 16, 2013 at 06:08 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `herodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `idBrg` int(5) NOT NULL AUTO_INCREMENT,
  `imageBrg` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `hrgBeli` double NOT NULL DEFAULT '0',
  `hrgJual` double NOT NULL DEFAULT '0',
  `diskon` double NOT NULL DEFAULT '0',
  `deskripsi` text NOT NULL,
  `inputDt` date NOT NULL,
  `username` varchar(20) NOT NULL,
  `stok` int(10) NOT NULL DEFAULT '0',
  `berat` decimal(10,1) NOT NULL,
  PRIMARY KEY (`idBrg`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`idBrg`, `imageBrg`, `nama`, `kategori`, `hrgBeli`, `hrgJual`, `diskon`, `deskripsi`, `inputDt`, `username`, `stok`, `berat`) VALUES
(5, 'image/Merah marun.jpg', 'Merah marun', 'POLO shirt', 12000, 13000, 500, '', '2013-05-05', 'coba', -64, '0.2'),
(7, 'image/Moving blue.jpg', 'Moving blue', 'T shirt lengan pendek', 24000, 36000, 5000, 'hdsf dsfsdfs fds fsdfsd', '2013-05-17', 'coba', 12, '0.3'),
(8, 'image/Kaoe aneh.jpg', 'Kaoe aneh', 'T shirt lengan pendek', 13000, 15000, 0, 'knkndss ', '2013-05-17', 'coba', 41, '0.2'),
(9, 'image/New look.jpg', 'New look', 'T shirt lengan pendek', 15000, 18000, 0, 'jhgjhvjh sdfdsfdsvsdv ds sd', '2013-05-17', 'coba', 0, '0.3'),
(10, 'image/unyu kaos.jpg', 'unyu kaos', 'T shirt lengan pendek', 30000, 70000, 20000, 'Baha katun kulitas dewa', '2013-05-29', 'coba', 0, '0.5');

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE IF NOT EXISTS `beli` (
  `idBeli` varchar(8) NOT NULL,
  `tgl` date NOT NULL,
  `toko` varchar(20) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jumlah` double NOT NULL,
  `diskon` double NOT NULL,
  `total` double NOT NULL,
  `inputDt` date NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`idBeli`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beli`
--


-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `idPost` int(5) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `post` text NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `inputDt` date NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`idPost`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `blog`
--


-- --------------------------------------------------------

--
-- Table structure for table `dbeli`
--

CREATE TABLE IF NOT EXISTS `dbeli` (
  `idBeli` varchar(8) NOT NULL,
  `idBrg` int(5) NOT NULL,
  `qty` int(5) NOT NULL,
  `harga` double NOT NULL,
  `berat` decimal(10,1) NOT NULL,
  `diskon` double NOT NULL,
  `jumlah` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbeli`
--


-- --------------------------------------------------------

--
-- Table structure for table `djual`
--

CREATE TABLE IF NOT EXISTS `djual` (
  `idJual` varchar(50) NOT NULL,
  `idBrg` int(5) NOT NULL,
  `qty` int(5) NOT NULL,
  `harga` double NOT NULL,
  `berat` decimal(10,1) NOT NULL,
  `diskon` double NOT NULL,
  `jumlah` double NOT NULL,
  KEY `FKBrg` (`idBrg`),
  KEY `KHJual` (`idJual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `djual`
--

INSERT INTO `djual` (`idJual`, `idBrg`, `qty`, `harga`, `berat`, `diskon`, `jumlah`) VALUES
('mfte9d9hoqbk039r2pjtee89o4', 8, 8, 15000, '2.0', 0, 120000),
('mfte9d9hoqbk039r2pjtee89o4', 9, 8, 18000, '3.0', 0, 144000),
('09iq6v046pqmkvp1312vgf44v6', 8, 8, 15000, '2.0', 0, 120000),
('09iq6v046pqmkvp1312vgf44v6', 9, 8, 18000, '3.0', 0, 144000),
('nsr8atf5lbje7iam22jgh8h5d3', 8, 8, 15000, '2.0', 0, 120000),
('nsr8atf5lbje7iam22jgh8h5d3', 9, 8, 18000, '3.0', 0, 144000),
('1mhd7bsl80ngiprps865sdqvd4', 8, 9, 15000, '2.0', 0, 135000),
('qakra1th452f67kba8kou56uq6', 8, 6, 15000, '2.0', 0, 90000),
('6stg8hld8kpjd7dgl308mguja0', 8, 8, 15000, '2.0', 0, 120000),
('6stg8hld8kpjd7dgl308mguja0', 9, 7, 18000, '3.0', 0, 126000);

-- --------------------------------------------------------

--
-- Table structure for table `jual`
--

CREATE TABLE IF NOT EXISTS `jual` (
  `idJual` varchar(50) NOT NULL,
  `tgl` date NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `berat` decimal(10,1) NOT NULL,
  `delivery` double NOT NULL,
  `total` double NOT NULL,
  `status` varchar(10) NOT NULL,
  `resi` varchar(50) NOT NULL,
  `inputDt` date NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`idJual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jual`
--

INSERT INTO `jual` (`idJual`, `tgl`, `nama`, `alamat`, `telp`, `berat`, `delivery`, `total`, `status`, `resi`, `inputDt`, `username`) VALUES
('09iq6v046pqmkvp1312vgf44v6', '2013-06-11', 'tingkir', 'Jl mangga besar 23A', '0219878979', '5.0', 35000, 264072, '', '', '2013-06-11', 'tingkir'),
('1mhd7bsl80ngiprps865sdqvd4', '2013-06-13', 'jery', 'uoiuoiu', 'jiuoiui', '2.0', 113132, 135033, '', '', '2013-06-13', 'jery'),
('6stg8hld8kpjd7dgl308mguja0', '2013-06-16', 'jkhkjhkj', 'hkjhkjhk', 'kjhkjh', '5.0', 35000, 246075, 'pending', '', '2013-06-16', 'jkhkjhkj'),
('mfte9d9hoqbk039r2pjtee89o4', '2013-06-11', 'tingkir', 'Jl mangga besar 23A', '0219878979', '5.0', 35000, 264096, '', '', '2013-06-11', 'tingkir'),
('nsr8atf5lbje7iam22jgh8h5d3', '2013-06-11', 'tingkir', 'Jl mangga besar 23A', '0219878979', '5.0', 35000, 264043, 'pending', '', '2013-06-11', 'tingkir'),
('qakra1th452f67kba8kou56uq6', '2013-06-13', 'jhjk', 'kjhkjh', 'hjkhkjh', '2.0', 113132, 90071, '', '', '2013-06-13', 'jhjk');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `idReview` int(5) NOT NULL AUTO_INCREMENT,
  `idBrg` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `pesan` text NOT NULL,
  `tampil` tinyint(1) NOT NULL,
  `inputDt` date NOT NULL,
  PRIMARY KEY (`idReview`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `review`
--


-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `toko` varchar(30) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `inputDt` date NOT NULL,
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`toko`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`toko`, `telp`, `alamat`, `inputDt`, `username`) VALUES
('ghfjhf', 'hjgfjhg', 'hgjhfkjh', '2013-06-04', 'coba'),
('jhghg', 'jhgjhg', 'jgjh', '2013-06-06', 'coba'),
('Unrock', '079878979879', 'Tanah abang', '2013-05-17', 'coba');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE IF NOT EXISTS `tarif` (
  `idtarif` int(3) NOT NULL AUTO_INCREMENT,
  `propinsi` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `tarif` double NOT NULL,
  `inputdt` date NOT NULL,
  PRIMARY KEY (`idtarif`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`idtarif`, `propinsi`, `kota`, `tarif`, `inputdt`) VALUES
(1, 'Jawa barat', 'Cimahi barat', 5000, '2013-05-28'),
(2, 'Jawa tengah', 'Brebes', 7000, '2013-05-29'),
(3, 'kjhHKJHK', 'LKJLJ', 56566, '2013-06-06');

-- --------------------------------------------------------

--
-- Table structure for table `username`
--

CREATE TABLE IF NOT EXISTS `username` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `namaLengkap` varchar(30) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `inputDt` date NOT NULL,
  `inputUsername` varchar(30) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `username`
--

INSERT INTO `username` (`username`, `password`, `kategori`, `namaLengkap`, `telp`, `alamat`, `inputDt`, `inputUsername`) VALUES
('coba', 'c3ec0f7b054e729c5a716c8125839829', 'Admin', 'hendro purwoko', '02196364864', 'Jl mangga 12A', '2013-05-29', 'coba');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `djual`
--
ALTER TABLE `djual`
  ADD CONSTRAINT `FKBrg` FOREIGN KEY (`idBrg`) REFERENCES `barang` (`idBrg`),
  ADD CONSTRAINT `KHJual` FOREIGN KEY (`idJual`) REFERENCES `jual` (`idJual`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
