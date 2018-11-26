-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 25, 2013 at 02:52 AM
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
-- Table structure for table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `idbann` int(3) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `display` varchar(10) NOT NULL,
  `tglinput` datetime NOT NULL,
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`idbann`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`idbann`, `image`, `caption`, `display`, `tglinput`, `username`) VALUES
(4, 'banner/dsadsad.gif', 'dsadsad', 'Ya', '2013-08-12 20:26:08', 'coba'),
(3, 'banner/dasdsa.gif', 'dasdsa', 'Ya', '2013-08-12 20:25:55', 'coba'),
(6, 'banner/fsdfsdf.gif', 'fsdfsdf', 'Ya', '2013-08-12 20:26:41', 'coba'),
(7, 'banner/dfsdfs.gif', 'dfsdfs', 'Ya', '2013-08-12 20:27:02', 'coba');

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
  `youtube` varchar(50) NOT NULL,
  `keyword` text NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY (`idBrg`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`idBrg`, `imageBrg`, `nama`, `kategori`, `hrgBeli`, `hrgJual`, `diskon`, `deskripsi`, `inputDt`, `username`, `stok`, `berat`, `youtube`, `keyword`, `status`) VALUES
(13, 'image/XBA 4.jpg', 'XBA 4', 'XBA SERIES', 3400000, 3800000, 30, 'Type 	: Closed, Quad Balanced Armature\r\nDriver Unit : Quad Balanced Armature\r\nSensitivity : 108dB (150mV)\r\nPower Handling Capacity : 100mW\r\nImpedance : 8ohms at 1kHz\r\nFrequency Response : 3-28.000HZ\r\nWeight (Without Cord) : Approx. 8g\r\nSupplied Accessories : Hybrid silicone rubber earbuds* (SSx2, Sx2, Mx2, Lx2)', '2013-07-09', 'coba', 0, '0.4', 'OBert1cUpF8', '', ''),
(14, 'image/XBA 3.jpg', 'XBA 3', 'XBA SERIES', 2775000, 3500000, 30, 'Driver Unit : Closed, Triple Balanced Armature\r\nFrequency Response : 4 - 28,000 Hz\r\nImpedance : 12 ohms at 1 kHz\r\nSensitivity (db) : 108 dB/mW\r\nHybrid Silicone Earbuds : SS (2), S (2), M (2), L (2) \r\n', '2013-07-09', 'coba', 0, '0.5', 'RjWL9oJymgs', '', ''),
(15, 'image/XBA 2.jpg', 'XBA 2', 'XBA SERIES', 1825000, 2400000, 30, 'Capacity (mW) : 100\r\nDriver unit (mm) : Dual Balanced Armature\r\nFrequency (Hz) : 4 - 25,000\r\nSensitivity (dB/mW) : 108\r\nMagnet : Neodymium\r\nImpedance (Ohm) : 12\r\nCord type : OFC Litz cord neck-chain\r\nCord length (m) : 1.2\r\nPlug : Gold-plated L-shaped Stereo Mini\r\nSilicone earbuds : 4 size (SS,S,M,L)\r\nNoise isolation earbuds : 3 size (S,M,L)\r\nCarrying pouch/case : Case', '2013-07-09', 'coba', 0, '0.6', 'DgEMJ9JHbjY', '', ''),
(16, 'image/XBA 1.jpg', 'XBA 1', 'XBA SERIES', 725000, 1000000, 30, 'Capacity (mW) : 100\r\nDriver unit (mm) : Balanced Armature\r\nFrequency (Hz) : 5 - 25,000\r\nSensitivity (dB/mW) : 108\r\nMagnet : Neodymium\r\nImpedance (Ohm) : 24\r\nCord type : OFC Litz cord neck-chain\r\nCord length (m) : 1.2\r\nPlug : Gold-plated L-shaped Stereo Mini\r\nWeight (g) : 3\r\nSilicone earbuds : 4 size (SS,S,M,L)\r\nNoise isolation earbuds : 3 size (S,M,L)\r\nCarrying pouch/case : Pouch ', '2013-07-09', 'coba', 0, '0.6', 'iXu_4Bsy59s', '', ''),
(17, 'image/V900HD.jpg', 'V900HD', 'SPORT SERIES', 1900000, 2700000, 30, 'Capacity (W) : 3.0\r\nDriver unit (mm) : 50.0\r\nDiaphragm : PET\r\nFrequency (Hz) : 5 - 80,000\r\nSensitivity (dB/mW) : 107.0\r\nMagnet : 360 kJ/m3 Neodymium\r\nImpedance (Ohm) : 24.0\r\nFoldable : YES\r\nReversible earcups : YES\r\nCord type : LC-OFC Class 1 Litz single-sided, coiled\r\nCord length (m) : 3.0\r\nPlug : Gold-plated straight stereo unimatch plug (screw type)\r\nWeight (g) : 300.0', '2013-07-09', 'coba', -1, '0.8', 'Pi1ZhrlIg6E', '', ''),
(18, 'image/V700DJ.jpg', 'V700DJ', 'SPORT SERIES', 1350000, 1700000, 30, 'Earpiece Design : Ear-Cup (Over the Ear)\r\nSensitivity : 107 dB\r\nFrequency Response : 5 Hz - 30 kHz\r\nImpedance	: 24 ohms\r\nConnectivity Type: Wired\r\nCable Length : 10 ft\r\nDriver Unit Size : 50 mm\r\nPlug Type : 3.5 mm, 6.3 mm, 6.35 mm\r\nWeight : 10.6 oz', '2013-07-09', 'coba', 0, '0.8', 'LyZ1MqgT92w', '', ''),
(20, 'image/AS51G.jpg', 'AS51G', 'SPORT SERIES', 545000, 800000, 30, 'Capacity (mW) : 100\r\nDriver unit (mm) : 9mm dome type\r\nFrequency (Hz) : 8 - 23,000\r\nSensitivity (dB/mW) : 100\r\nMagnet : Neodymium\r\nImpedance (Ohm) : 16 at 1 kHz\r\nCord type : OFC Litz cord\r\nCord length (m) : 0.6\r\nPlug : Gold-plated stereo mini plug\r\nWeight (g) : 13\r\nSilicone earbuds : 2x SS, S, M, L', '2013-07-10', 'coba', 0, '0.6', 'zmfgpq8uGUg', '', ''),
(21, 'image/AS41EX.jpg', 'AS41EX', 'E SERIES', 445000, 800000, 30, 'Capacity (mW) : 100\r\nDriver unit (mm) : 9mm, dome type\r\nFrequency (Hz) : 9 - 23,000\r\nSensitivity (dB/mW) : 100\r\nMagnet : Neodymium\r\nImpedance (Ohm) : 16\r\nCord length (m) : 0.6 \r\nPlug : Gold plated stereo mini\r\nWeight (g) : 6\r\nSilicone earbuds : 2x SS, S, M, L\r\nCarrying pouch/case : YES\r\nClip : YES\r\nExtension cord : 0.6m\r\nOthers : Hangers (2x S, M L )', '2013-07-10', 'coba', -2, '0.6', 'p6CWIB28gHQ', '', ''),
(22, 'image/AS21J.jpg', 'AS21J', 'SPORT SERIES', 265000, 310000, 30, 'Type 	Dynamic : Open Air\r\nDriver Unit : 13.5mm, Dome Type\r\nSensitivity : 104dB/mW\r\nPower Handling Capacity : 50mW (IEC)\r\nImpedance : 16ohms at 1kHz\r\nFrequency Response :	17-22,000Hz\r\nCord 	: Litz cord Y-type\r\nCord Length : 1.2m\r\nPlug : L-shaped stereo mini plug\r\nWeight (Without Cord) : Approx. 12g\r\nSupplied Accessories :	Clip', '2013-07-10', 'coba', -2, '0.5', 'NsIEbLyCH9o', '', ''),
(23, 'image/MDR 370LP BLUE.jpg', 'MDR 370LP BLUE', 'LINE WEIGHT SERIES', 245000, 320000, 30, 'Type 	Dynamic : Open Air\r\nDriver Unit : 30mm, Dome Type\r\nSensitivity : 106dB/mW\r\nPower Handling Capacity : 1,000mW\r\nImpedance : 24ohms at 1kHz\r\nFrequency Response :	14-22,000Hz\r\nDiaphragm : PET\r\nMagnet : Neodymium\r\nCord 	: OFC both sided\r\nCord Length : 1.2m\r\nPlug : Straight stereo mini plug (Gold)\r\nWeight (Without Cord) : Approx. 52g\r\nSupplied Accessories :	Cord Adjuster', '2013-07-10', 'coba', 0, '0.5', 'aFE4o_LrTd8', '', ''),
(24, 'image/MDR 370LP WHITE.jpg', 'MDR 370LP WHITE', 'LINE WEIGHT SERIES', 245000, 320000, 30, 'Type Dynamic : Open Air\r\nDriver Unit : 30mm, Dome Type\r\nSensitivity : 106dB/mW\r\nPower Handling Capacity : 1,000mW\r\nImpedance : 24ohms at 1kHz\r\nFrequency Response : 14-22,000Hz\r\nDiaphragm : PET\r\nMagnet : Neodymium\r\nCord : OFC both sided\r\nCord Length : 1.2m\r\nPlug : Straight stereo mini plug (Gold)\r\nWeight (Without Cord) : Approx. 52g\r\nSupplied Accessories : Cord Adjuster', '2013-07-10', 'coba', 0, '0.5', 'aFE4o_LrTd8', '', ''),
(25, 'image/XB60.jpg', 'XB60 BLACK', 'XB SERIES', 625000, 740000, 30, 'Design : In-Ear, Portable-music/movie/games\r\nMagnet : Neodymium\r\nPlug : Gold-plated L-shaped stereo mini\r\nType of Use : Portable\r\nDriver Unit : 13.5 mm driver, dome type\r\nFrequency Response : 4 to 25,000 Hz\r\nImpedance : 16 ohms at 1 kHz\r\nSensitivity (db) : 105 dB/mW\r\nPower Handling Capacity : 100 mW\r\nEar Cups : Closed, Dynamic\r\nCord Length (Approx.) : 47-1/4 in. (1.2 m). flat cord, Y-type\r\nWeight (Approx.) : .28 oz. (8 g) without cord', '2013-07-10', 'coba', 0, '0.6', 'Mcpkg7mocJw', '', ''),
(26, 'image/XB60 SILVER.jpg', 'XB60 SILVER', 'XB SERIES', 625000, 740000, 30, 'Design : In-Ear, Portable-music/movie/games\r\nMagnet : Neodymium\r\nPlug : Gold-plated L-shaped stereo mini\r\nType of Use : Portable\r\nDriver Unit : 13.5 mm driver, dome type\r\nFrequency Response : 4 to 25,000 Hz\r\nImpedance : 16 ohms at 1 kHz\r\nSensitivity (db) : 105 dB/mW\r\nPower Handling Capacity : 100 mW\r\nEar Cups : Closed, Dynamic\r\nCord Length (Approx.) : 47-1/4 in. (1.2 m). flat cord, Y-type\r\nWeight (Approx.) : .28 oz. (8 g) without cord', '2013-07-10', 'coba', 0, '0.6', 'Mcpkg7mocJw', '', ''),
(27, 'image/XB60 GOLD.jpg', 'XB60 GOLD', 'XB SERIES', 625000, 740000, 30, 'Design : In-Ear, Portable-music/movie/games\r\nMagnet : Neodymium\r\nPlug : Gold-plated L-shaped stereo mini\r\nType of Use : Portable\r\nDriver Unit : 13.5 mm driver, dome type\r\nFrequency Response : 4 to 25,000 Hz\r\nImpedance : 16 ohms at 1 kHz\r\nSensitivity (db) : 105 dB/mW\r\nPower Handling Capacity : 100 mW\r\nEar Cups : Closed, Dynamic\r\nCord Length (Approx.) : 47-1/4 in. (1.2 m). flat cord, Y-type\r\nWeight (Approx.) : .28 oz. (8 g) without cord', '2013-07-10', 'coba', 0, '0.6', 'Mcpkg7mocJw', '', ''),
(28, 'image/XB30.jpg', 'XB30', 'XB SERIES', 425000, 530000, 30, 'Design : In-Ear, Portable-music/movie/games\r\nMagnet : Neodymium\r\nPlug : Gold-plated L-shaped stereo mini\r\nType of Use : Portable\r\nDriver Unit : 13.5 mm driver, dome type\r\nFrequency Response : 4 to 24,000 Hz\r\nImpedance : 16 ohms at 1 kHz\r\nSensitivity (db) : 105 dB/mW\r\nPower Handling Capacity : 100 mW\r\nEar Cups : Closed, Dynamic\r\nCord Length (Approx.) : 47-1/4 in. (1.2 m). flat cord, Y-type\r\nWeight (Approx.) : .28 oz. (8 g) without cord', '2013-07-10', 'coba', 0, '0.6', 'wlJGBGxfdzQ', '', ''),
(29, 'image/E9LP BLACK.jpg', 'E9LP BLACK', 'E SERIES', 70000, 100000, 30, 'Open Air Type : YES\r\nDynamic Type : YES\r\nCapacity (mW) : 100\r\nDriver unit (mm) : 13.5 (Dome Type)\r\nDiaphragm : PET\r\nFrequency (Hz) : 18 - 22,000\r\nSensitivity (dB/mW) : 104\r\nMagnet : Neodymium\r\nImpedance (Ohm) : 16\r\nCord type : Y-Shape\r\nCord length (m) : 1.2\r\nPlug : L-shaped Stereo Mini\r\nWeight (g) : 6\r\nEar pads : x2', '2013-07-10', 'coba', 0, '0.5', 'Ru0OhZga4KM', '', ''),
(30, 'image/E9LP WHITE TRANSPARENT.jpg', 'E9LP WHITE TRANSPARENT', 'E SERIES', 70000, 100000, 30, 'Open Air Type : YES\r\nDynamic Type : YES\r\nCapacity (mW) : 100\r\nDriver unit (mm) : 13.5 (Dome Type)\r\nDiaphragm : PET\r\nFrequency (Hz) : 18 - 22,000\r\nSensitivity (dB/mW) : 104\r\nMagnet : Neodymium\r\nImpedance (Ohm) : 16\r\nCord type : Y-Shape\r\nCord length (m) : 1.2\r\nPlug : L-shaped Stereo Mini\r\nWeight (g) : 6\r\nEar pads : x2', '2013-07-10', 'coba', 0, '0.5', 'Ru0OhZga4KM', '', ''),
(31, 'image/EX10LP BLACK.jpg', 'EX10LP BLACK', 'E SERIES', 160000, 230000, 30, 'Capacity (mW) : 100\r\nDriver unit (mm) : 9 (Dome type ,CCAW)\r\nFrequency (Hz) : 8 - 22,000\r\nSensitivity (dB/mW) : 100\r\nMagnet : Neodymium\r\nImpedance (Ohm) : 16\r\nCord length (m) : 1.2\r\nPlug : Gold-plated L-shaped Stereo Mini\r\nWeight (g) : 3\r\nEar pieces (Small, Medium, Large) : Hybrid x3 (S,M,L)', '2013-07-10', 'coba', 0, '0.6', 'xg9YtfZl1xQ', '', ''),
(34, 'image/ex12ip.jpg', 'EX12IP (FOR IPOD/IPAD/IPHONE)', 'EX SERIES', 345000, 460000, 30, 'Driver Unit : Closed, Dynamic\r\n9 mm, dome type (CCAW)\r\nFrequency Response : 8 - 22,000 Hz\r\nImpedance : 16 ohms at 1kHz\r\nSensitivity (db) : 100 dB/mW\r\nVolume Control : Yes\r\nMicrophone : Yes\r\nHeadset Compatibility : iPod/iPhone/iPad\r\nHeadset Key Features : Adjustable Fit; In-Line Volume Control; iPhone/iPad/iPod Compatible\r\nHeadset Style : Earbud\r\nWeight (Approx.) : .11 oz. (3 g) without cord\r\nEarbuds - S (2), M (2), L (2) ', '2013-07-10', 'coba', 0, '0.6', '5OAY9ovxgus', '', ''),
(35, 'image/EX14VP BLACK.jpg', 'EX14VP (FOR ANDROID & BB)', 'EX SERIES', 345000, 460000, 30, 'Driver Unit : Closed, Dynamic\r\n9 mm, dome type (CCAW) PET Diaphragm\r\nFrequency Response : 8 - 22,000 Hz\r\nImpedance : 16 ohms at 1 kHz\r\nSensitivity (db) : 100 dB/mW\r\nVolume Control : +/- Slider\r\nMicrophone : Electret Condenser \r\nHeadset Compatibility : Smartphone\r\nHeadset Key Features : Adjustable Fit; Smartphone Remote; In-Line Volume Control\r\nHeadset Style : Earbud\r\nCord : 47 1/4 in. (1.2 m), Litz cord Y-Type\r\nHeadphone Type : In-Ear\r\nMicrophone : Electret Condenser\r\nWeight (Approx.) : .11 oz. (3 g) without cord ', '2013-07-21', 'coba', 0, '0.6', '', '', 'Produk terlaris'),
(36, 'image/ex37b black.jpg', 'EX37B', 'E SERIES', 255000, 332000, 30, 'Driver Unit : 9 mm diameter, dome type (CCAW adopted)\r\nFrequency Response : 6-23,000 Hz\r\nImpedance : 16 ohms at 1 kHz\r\nSensitivity (db) : 100 dB/mW\r\nSpeaker Type : Closed, Dynamic\r\nCase Type : Nylon case with slide out tray to hold headphones\r\nMagnet : Neodymium (440kJ/m3) \r\nPlug : Gold-plated L-shaped stereo mini plug\r\nCord Length (Approx.) : OFC neckchain, 47.24 inches (1.2m)\r\nWeight (Approx.) : 0.11 oz. (3 g) without cord', '2013-07-10', 'coba', 0, '0.6', 'o2Tr_2SSBvU', '', ''),
(37, 'image/MDREX10LPDBLue.jpg', 'EX60LP BLUE', 'EX SERIES', 260000, 320000, 30, 'Driver Unit : 9 mm, dome type (CCAW)\r\nFrequency Response : 8 - 22,000Hz\r\nImpedance : 16 ohms at 1kHz\r\nSensitivity (db) : 100 dB/mW\r\nCord : 47 1/4 in. (1.2 m), OFC Litz cord Y-Type\r\nCord Length (Approx.) : 47 1/4 in. (1.2 m)\r\nWeight (Approx.) : 11 oz. (3 g) without cord\r\nEarbuds : S (2), M (2), L (2)\r\n\r\n', '2013-07-10', 'coba', 0, '0.6', '7bwR_9fQcu8', '', ''),
(38, 'image/zx100.jpg', 'ZX100', 'ZX SERIES', 220000, 280000, 30, 'Driver Unit : Closed supra-aural, Dynamic\r\n30 mm, dome type (CCAW Voice Coil)\r\nFrequency Response : 12 - 22,000 Hz\r\nImpedance : 24 ohms at 1 kHz\r\nSensitivity (db) : 100 dB/mW\r\nPower Handling Capacity : 1000 mW\r\nDesign : Over-the-head, Monitor\r\nDiaphragm : PET\r\nHeadband : Wide, Adjustable\r\nMagnet : Neodymium\r\nPlug : L-shaped stereo mini plug\r\nType of Use : Portable, Home, Studio\r\nWeight (Approx.) : 4.23 oz (120 g)\r\nCord : 47 1/4 in. (1.2 m) Y-type', '2013-07-21', 'coba', -5, '0.8', 'cWKLGNJPYdA', '', 'Produk terlaris'),
(39, 'image/MDRZX300 BLACK.jpg', 'ZX300', 'E SERIES', 350000, 420000, 30, 'Driver Unit : Closed supra-aural, Dynamic 30 mm, dome type (CCAW Voice Coil)\r\nFrequency Response : 10 - 24,000 Hz\r\nImpedance : 24 ohms at 1 kHz\r\nSensitivity (db) : 102 dB/mW\r\nPower Handling Capacity : 1000 mW\r\nDesign : Over-the-head, Monitor\r\nDiaphragm : PET\r\nHeadband : Wide, Adjustable\r\nMagnet : Neodymium\r\nPlug : Gold-plated, L-shaped stereo mini plug\r\nType of Use : Portable, Home, Studio\r\nCord Length (Approx.) : 47 1/4 in (1.2 m)\r\nWeight (Approx.) : 4.23 oz (120 g)', '2013-07-21', 'coba', 0, '0.6', '1b1qXjFLI4o', '', 'Produk unggulan'),
(40, 'image/pq5 yellow.jpg', 'PQ5 YELLOW', 'PQ SERIES', 175000, 230000, 0, 'Driver Unit : 13.5 mm, dome type\r\nFrequency Response : 12 – 22,000 Hz\r\nImpedance : 16 ohms at 1 kHz\r\nSensitivity (db) : 104 dB/mW\r\nCord : Connecting cord 3.9 ft (1.2 m)\r\nEar Cups : Open air, Dynamic\r\nPower Handling Capacity : 100 mW\r\nDesign : In-the-ear\r\nHeadband : None\r\nMagnet : Neodymium\r\nPlug : Gold-plated L-shaped stereo mini\r\nType of Use : Portable\r\nWeights and Measurements\r\nCord Length (Approx.) : 47 1/4 in. (1.2 m), Litz cord Y-type\r\nWeight (Approx.) : 0.22 oz. (6 g) without cord', '2013-07-23', 'coba', 0, '0.3', '9FvmG9l7MIw&#8206;', '', ''),
(41, 'image/pq5 red.jpg', 'PQ5 RED', 'PQ SERIES', 175000, 230000, 0, 'Driver Unit : 13.5 mm, dome type\r\nFrequency Response : 12 – 22,000 Hz\r\nImpedance : 16 ohms at 1 kHz\r\nSensitivity (db) : 104 dB/mW\r\nCord : Connecting cord 3.9 ft (1.2 m)\r\nEar Cups : Open air, Dynamic\r\nPower Handling Capacity : 100 mW\r\nDesign : In-the-ear\r\nHeadband : None\r\nMagnet : Neodymium\r\nPlug : Gold-plated L-shaped stereo mini\r\nType of Use : Portable\r\nWeights and Measurements\r\nCord Length (Approx.) : 47 1/4 in. (1.2 m), Litz cord Y-type\r\nWeight (Approx.) : 0.22 oz. (6 g) without cord', '2013-07-23', 'coba', 0, '0.3', '9FvmG9l7MIw&#8206;', 'earphone murah, promo earphone sony, bebas ongkos kirim', 'Promo');

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

INSERT INTO `beli` (`idBeli`, `tgl`, `toko`, `telp`, `alamat`, `jumlah`, `diskon`, `total`, `inputDt`, `username`) VALUES
('13070001', '2013-07-08', 'Unrock', '079878979879', 'Tanah abang', 0, 0, 0, '2013-07-08', 'coba');

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

INSERT INTO `dbeli` (`idBeli`, `idBrg`, `qty`, `harga`, `berat`, `diskon`, `jumlah`) VALUES
('13070001', 5, 12, 45000, '2.4', 0, 540000);

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
('tnu6g727', 17, 1, 2700000, '1.0', 200000, 2500000),
('ojv7v8r4', 38, 5, 280000, '4.0', 90000, 1310000),
('13070001', 22, 2, 310000, '1.0', 0, 620000),
('13070001', 21, 2, 800000, '1.2', 0, 1600000),
('mum36gs5', 24, 1, 320000, '1.0', 30, 319970),
('mum36gs5', 20, 1, 800000, '1.0', 30, 799970),
('mum36gs5', 22, 1, 310000, '1.0', 30, 309970),
('mum36gs5', 31, 1, 230000, '1.0', 30, 229970),
('mum36gs5', 38, 1, 280000, '1.0', 30, 279970),
('mum36gs5', 41, 1, 230000, '1.0', 0, 230000),
('c86ldll7', 41, 1, 230000, '1.0', 0, 230000),
('c86ldll7', 38, 7, 280000, '6.0', 588000, 1372000),
('nh6rt6s7', 41, 1, 230000, '1.0', 0, 230000),
('nh6rt6s7', 38, 7, 280000, '6.0', 588000, 1372000),
('3sigt9v2', 41, 1, 230000, '1.0', 0, 230000),
('3sigt9v2', 38, 7, 280000, '6.0', 588000, 1372000),
('0i8qgcq2', 41, 1, 230000, '1.0', 0, 230000),
('0i8qgcq2', 38, 7, 280000, '6.0', 588000, 1372000),
('2qhc4h84', 41, 1, 230000, '1.0', 0, 230000),
('2qhc4h84', 38, 7, 280000, '6.0', 588000, 1372000),
('4mv0e7k2', 41, 1, 230000, '1.0', 0, 230000),
('4mv0e7k2', 38, 7, 280000, '6.0', 588000, 1372000),
('utqbcef3', 41, 1, 230000, '1.0', 0, 230000),
('utqbcef3', 38, 7, 280000, '6.0', 588000, 1372000),
('4jpvpo52', 41, 1, 230000, '1.0', 0, 230000),
('4jpvpo52', 38, 7, 280000, '6.0', 588000, 1372000),
('ei2tnkv1', 41, 1, 230000, '1.0', 0, 230000),
('ei2tnkv1', 38, 7, 280000, '6.0', 588000, 1372000),
('fsbk6064', 41, 1, 230000, '1.0', 0, 230000),
('fsbk6064', 38, 7, 280000, '6.0', 588000, 1372000),
('lvglokd6', 41, 1, 230000, '1.0', 0, 230000),
('lvglokd6', 38, 7, 280000, '6.0', 588000, 1372000),
('vvog1n82', 41, 1, 230000, '1.0', 0, 230000),
('vvog1n82', 38, 7, 280000, '6.0', 588000, 1372000),
('bu8nv671', 38, 1, 280000, '1.0', 84000, 196000),
('bu8nv671', 29, 5, 100000, '3.0', 150000, 350000),
('ukenct06', 39, 9, 420000, '6.0', 1134000, 2646000),
('6v6akgh1', 39, 6, 420000, '4.0', 756000, 1764000);

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
  `inputDt` datetime NOT NULL,
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`idJual`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jual`
--

INSERT INTO `jual` (`idJual`, `tgl`, `nama`, `alamat`, `telp`, `berat`, `delivery`, `total`, `status`, `resi`, `inputDt`, `username`) VALUES
('0i8qgcq2', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '0.0', 0, 0, 'Pending', '', '2013-07-24 17:55:47', 'tonny'),
('13070001', '2013-07-10', 'dsad', 'asdad', 'sadasda', '0.0', 0, 0, 'Lunas', '', '2013-07-10 23:21:57', 'coba'),
('2qhc4h84', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '0.0', 0, 0, 'Pending', '', '2013-07-24 17:56:56', 'tonny'),
('3sigt9v2', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '7.0', 49000, 1602000, 'Pending', '', '2013-07-24 17:51:27', 'tonny'),
('4jpvpo52', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '7.0', 49000, 1602000, 'Pending', '', '2013-07-24 17:57:49', 'tonny'),
('4mv0e7k2', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '0.0', 0, 0, 'Pending', '', '2013-07-24 17:57:23', 'tonny'),
('6v6akgh1', '2013-11-22', 'cxzcxz', 'xcxz', 'xczcxzc', '4.0', 28000, 1764000, 'Pending', '', '2013-11-22 19:34:23', 'cxzcxz'),
('bu8nv671', '2013-08-12', 'Hendro purwoko', 'Jl banda', '031123878', '4.0', 28000, 546000, 'Pending', '', '2013-08-12 19:18:15', 'Hendro purwoko'),
('c86ldll7', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '7.0', 49000, 1602000, 'Pending', '', '2013-07-24 17:49:43', 'tonny'),
('ei2tnkv1', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '7.0', 49000, 1602000, 'Pending', '', '2013-07-24 17:58:51', 'tonny'),
('fsbk6064', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '5.9', 42000, 1602000, 'Pending', '', '2013-07-24 17:59:34', 'tonny'),
('lvglokd6', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '6.0', 42000, 1602000, 'Pending', '', '2013-07-24 17:59:54', 'tonny'),
('mum36gs5', '2013-07-24', 'Sutarjo', 'dvxvxcv', '987908', '6.0', 42000, 2169850, 'Pending', '', '2013-07-24 01:19:58', 'Sutarjo'),
('nh6rt6s7', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '7.0', 49000, 1602000, 'Pending', '', '2013-07-24 17:50:24', 'tonny'),
('ojv7v8r4', '2013-07-10', 'kendaro', 'lkjlkjk', 'jkljklj', '4.0', 28000, 1310000, 'Kirim', '43543543534534534', '2013-07-10 00:00:00', 'kendaro'),
('tnu6g727', '2013-07-10', 'fdgfdg', 'gdfg', 'dfgdf', '1.0', 7500, 2500000, 'Kirim', '0', '2013-07-10 00:00:00', 'fdgfdg'),
('ukenct06', '2013-09-11', 'xcvcxv', 'cvxc', 'vcxv', '6.0', 42000, 2646000, 'Pending', '', '2013-09-11 00:18:14', 'xcvcxv'),
('utqbcef3', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '0.0', 0, 0, 'Pending', '', '2013-07-24 17:57:41', 'tonny'),
('vvog1n82', '2013-07-24', 'tonny', 'Jl maggar 12 A', '02198789798', '6.0', 42000, 1602000, 'Pending', '', '2013-07-24 18:00:19', 'tonny');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`kategori`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori`) VALUES
('E SERIES'),
('EX SERIES'),
('HOME ENTERTAINMENT SERIES'),
('LINE WEIGHT SERIES'),
('PQ SERIES'),
('SPORT SERIES'),
('XB SERIES'),
('XBA SERIES'),
('ZX SERIES');

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
('PT Andalas ', '02198789798798', 'Jl magma 12A asdsad', '2013-07-09', 'coba');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE IF NOT EXISTS `tarif` (
  `idtarif` int(3) NOT NULL AUTO_INCREMENT,
  `kota` varchar(50) NOT NULL,
  `tarif` double NOT NULL,
  `inputdt` date NOT NULL,
  PRIMARY KEY (`idtarif`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`idtarif`, `kota`, `tarif`, `inputdt`) VALUES
(6, 'Jakarta, tangerang, bekasi', 7000, '2013-07-10');

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
