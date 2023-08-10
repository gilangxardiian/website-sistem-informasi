-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2023 at 09:17 AM
-- Server version: 8.0.33-0ubuntu0.22.04.4
-- PHP Version: 8.1.2-1ubuntu2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mankas`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `idAnggota` int NOT NULL,
  `namaAnggota` varchar(150) NOT NULL,
  `jenisKelamin` enum('Laki-laki','Perempuan','Lainnya') NOT NULL,
  `tglLahir` date NOT NULL,
  `pekerjaan` varchar(50) NOT NULL,
  `telepon` varchar(13) NOT NULL,
  `email` varchar(150) NOT NULL,
  `alamat` text NOT NULL,
  `statusAktif` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `idKas` int NOT NULL,
  `idAnggota` int NOT NULL,
  `nominal` int NOT NULL,
  `bentuk` enum('Cash','Transfer') NOT NULL,
  `tglSetor` date NOT NULL,
  `statusAktif` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `idPengeluaran` int NOT NULL,
  `namaPengeluaran` varchar(150) NOT NULL,
  `nominal` int NOT NULL,
  `tglPengeluaran` date NOT NULL,
  `statusAktif` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `idPengguna` int NOT NULL,
  `namaPengguna` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`idPengguna`, `namaPengguna`, `username`, `password`, `gambar`) VALUES
(1, 'Admin', 'admin', '$2y$10$HsGFZdrcSrwqAoZZRZptFeQ7z94rEDppqBcYTCrKlxDi4KmN5jmC6', '64d3ace8445dd.png');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vwkas`
-- (See below for the actual view)
--
CREATE TABLE `vwkas` (
`bentuk` enum('Cash','Transfer')
,`idAnggota` int
,`idKas` int
,`namaAnggota` varchar(150)
,`nominal` int
,`statusAktif` enum('0','1')
,`statusAktifAnggota` enum('0','1')
,`tglSetor` date
);

-- --------------------------------------------------------

--
-- Structure for view `vwkas`
--
DROP TABLE IF EXISTS `vwkas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwkas`  AS SELECT `kas`.`idKas` AS `idKas`, `kas`.`idAnggota` AS `idAnggota`, `anggota`.`namaAnggota` AS `namaAnggota`, `anggota`.`statusAktif` AS `statusAktifAnggota`, `kas`.`nominal` AS `nominal`, `kas`.`bentuk` AS `bentuk`, `kas`.`tglSetor` AS `tglSetor`, `kas`.`statusAktif` AS `statusAktif` FROM (`kas` join `anggota` on((`kas`.`idAnggota` = `anggota`.`idAnggota`))) WHERE (`kas`.`statusAktif` = '1') ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`idAnggota`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`idKas`),
  ADD KEY `ambilIdAnggotaKas` (`idAnggota`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`idPengeluaran`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`idPengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `idAnggota` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `idKas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `idPengeluaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `idPengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kas`
--
ALTER TABLE `kas`
  ADD CONSTRAINT `ambilIdAnggotaKas` FOREIGN KEY (`idAnggota`) REFERENCES `anggota` (`idAnggota`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
