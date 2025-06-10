-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 02:44 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id_anggaran` int(11) NOT NULL,
  `id_sub_kategori` int(11) NOT NULL,
  `uraian` varchar(70) NOT NULL,
  `realisasi_keuangan` bigint(15) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggaran`
--

INSERT INTO `anggaran` (`id_anggaran`, `id_sub_kategori`, `uraian`, `realisasi_keuangan`, `waktu`) VALUES
(1, 1, 'Pengadaan Seminar', 10, '2025-02-05 23:18:59'),
(2, 3, 'Pengadaan Meubelair', 0, '2025-02-05 23:18:42'),
(3, 2, 'Pengadaan Peralatan Personal Komputer', 0, '2025-02-05 22:56:53');

-- --------------------------------------------------------

--
-- Table structure for table `detail_anggaran`
--

CREATE TABLE `detail_anggaran` (
  `id_detail_anggaran` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_anggaran` int(11) NOT NULL,
  `rekanan` text NOT NULL,
  `uraian` text NOT NULL,
  `total` bigint(15) NOT NULL,
  `bukti` text NOT NULL,
  `tgl_pesan` date NOT NULL,
  `tgl_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_anggaran`
--

INSERT INTO `detail_anggaran` (`id_detail_anggaran`, `id_pengguna`, `id_anggaran`, `rekanan`, `uraian`, `total`, `bukti`, `tgl_pesan`, `tgl_update`) VALUES
(1, 1, 1, 'pt. makmur jawa', '<ol>\r\n<li>Gergaji ortho</li>\r\n<li>palu ortho</li>\r\n</ol>', 2929854000, 'contoh.pdf', '2024-12-19', '2025-02-05 13:36:23'),
(2, 1, 2, 'pt. jayawijaya', '<p>apa coba</p>', 202066812, 'Pengumuman (1).pdf', '2024-12-19', '2025-01-29 08:43:56'),
(5, 1, 3, 'Sumber Rejo', '<p>DFSD</p>', 392000000, 'contoh.pdf', '2025-02-06', '2025-02-05 23:17:16'),
(6, 1, 1, 'Sumber Rejo', '<p>ngeprint</p>', 2120000, 'contoh.pdf', '2025-02-08', '2025-02-08 10:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `jns_kategori` varchar(50) NOT NULL,
  `nm_kategori` varchar(60) NOT NULL,
  `target` bigint(20) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `jns_kategori`, `nm_kategori`, `target`, `waktu`) VALUES
(1, 'OPERASI', 'BELANJA PEGAWAI', 10113200000, '2025-01-29 08:44:04'),
(2, 'OPERASI', 'BELANJA BARANG DAN JASA', 18636746719, '2025-01-29 08:44:08'),
(3, 'MODAL', 'Belanja Modal Peralatan dan Mesin', 7957925187, '2025-01-29 08:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `username`, `password`, `role`, `foto`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'images.jpg'),
(2, 'pengguna', 'pengguna', '8b097b8a86f9d6a991357d40d3d58634', 'Pelanggan', 'image.jpg'),
(4, 'anon', 'anon', '2ae66f90b7788ab8950e8f81b829c947', 'Pelanggan', 'GPEDWzyWoAEnIJK.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kategori`
--

CREATE TABLE `sub_kategori` (
  `id_sub_kategori` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nm_sub_kategori` varchar(100) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_kategori`
--

INSERT INTO `sub_kategori` (`id_sub_kategori`, `id_kategori`, `nm_sub_kategori`, `waktu`) VALUES
(1, 1, 'Honorarium Tim / Pengelola Keuangan', '2024-11-26 15:13:22'),
(2, 3, 'Pengadaan Komputer', '2025-02-05 22:56:33'),
(3, 3, 'Pengadaan Alat Rumah Tangga', '2024-12-26 00:39:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id_anggaran`),
  ADD KEY `id_sub_kategori` (`id_sub_kategori`);

--
-- Indexes for table `detail_anggaran`
--
ALTER TABLE `detail_anggaran`
  ADD PRIMARY KEY (`id_detail_anggaran`),
  ADD KEY `id_anggaran` (`id_anggaran`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `sub_kategori`
--
ALTER TABLE `sub_kategori`
  ADD PRIMARY KEY (`id_sub_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id_anggaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detail_anggaran`
--
ALTER TABLE `detail_anggaran`
  MODIFY `id_detail_anggaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_kategori`
--
ALTER TABLE `sub_kategori`
  MODIFY `id_sub_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD CONSTRAINT `anggaran_ibfk_1` FOREIGN KEY (`id_sub_kategori`) REFERENCES `sub_kategori` (`id_sub_kategori`);

--
-- Constraints for table `detail_anggaran`
--
ALTER TABLE `detail_anggaran`
  ADD CONSTRAINT `detail_anggaran_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `detail_anggaran_ibfk_2` FOREIGN KEY (`id_anggaran`) REFERENCES `anggaran` (`id_anggaran`);

--
-- Constraints for table `sub_kategori`
--
ALTER TABLE `sub_kategori`
  ADD CONSTRAINT `sub_kategori_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
