-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2021 at 05:58 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `request_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

CREATE TABLE `akses` (
  `id_akses` varchar(50) NOT NULL DEFAULT '',
  `kode_klien` varchar(20) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `akuntansi` varchar(50) DEFAULT NULL,
  `perpajakan` varchar(50) DEFAULT NULL,
  `lainnya` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`id_akses`, `kode_klien`, `masa`, `tahun`, `akuntansi`, `perpajakan`, `lainnya`) VALUES
('213002', '3002', '04', '2021', '2002', '2001', '2002'),
('213003', '3003', '04', '2021', '2001', '2002', '2002,2003');

-- --------------------------------------------------------

--
-- Table structure for table `bulan`
--

CREATE TABLE `bulan` (
  `id_bulan` varchar(10) NOT NULL,
  `nama_bulan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bulan`
--

INSERT INTO `bulan` (`id_bulan`, `nama_bulan`) VALUES
('01', 'Januari'),
('02', 'Februari'),
('03', 'Maret'),
('04', 'April'),
('05', 'Mei'),
('06', 'Juni'),
('07', 'Juli'),
('08', 'Agustus'),
('09', 'September'),
('10', 'Oktober'),
('11', 'November'),
('12', 'Desember');

-- --------------------------------------------------------

--
-- Table structure for table `data_akuntansi`
--

CREATE TABLE `data_akuntansi` (
  `id_data` varchar(50) NOT NULL,
  `id_jenis` varchar(50) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `status_kirim` varchar(20) DEFAULT NULL,
  `status_proses` varchar(20) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL,
  `id_kerja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_akuntansi`
--

INSERT INTO `data_akuntansi` (`id_data`, `id_jenis`, `detail`, `format_data`, `status_kirim`, `status_proses`, `id_request`, `id_kerja`) VALUES
('2109300210101', '101', 'Agustus', 'Softcopy', 'yes', NULL, '21093002101', NULL),
('2109300210102', '102', 'Agustus', 'Hardcopy', 'yes', 'done', '21093002101', NULL),
('2109300210103', '104', 'Agustus', 'Hardcopy', 'yes', NULL, '21093002101', NULL),
('2109300510101', '101', 'Jan - Juni', 'Softcopy', NULL, NULL, '21093005101', NULL),
('2109300210201', '101', 'Jan - Juni', 'Softcopy', 'no', NULL, '21093002102', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_lainnya`
--

CREATE TABLE `data_lainnya` (
  `id_data` varchar(50) NOT NULL,
  `id_jenis` varchar(50) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_file` varchar(255) DEFAULT NULL,
  `status_kirim` varchar(20) DEFAULT NULL,
  `status_proses` varchar(20) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL,
  `id_kirim` varchar(50) DEFAULT NULL,
  `id_kerja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_lainnya`
--

INSERT INTO `data_lainnya` (`id_data`, `id_jenis`, `format_data`, `detail`, `tanggal_pengiriman`, `file`, `ket_file`, `status_kirim`, `status_proses`, `id_request`, `id_kirim`, `id_kerja`) VALUES
('2109300210101', '301', 'Hardcopy', '2020', NULL, NULL, NULL, NULL, NULL, '21093002101', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `data_perpajakan`
--

CREATE TABLE `data_perpajakan` (
  `id_data` varchar(50) NOT NULL,
  `id_jenis` varchar(50) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_file` varchar(255) DEFAULT NULL,
  `status_kirim` varchar(20) DEFAULT NULL,
  `status_proses` varchar(20) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL,
  `id_kirim` varchar(50) DEFAULT NULL,
  `id_kerja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_perpajakan`
--

INSERT INTO `data_perpajakan` (`id_data`, `id_jenis`, `format_data`, `detail`, `tanggal_pengiriman`, `file`, `ket_file`, `status_kirim`, `status_proses`, `id_request`, `id_kirim`, `id_kerja`) VALUES
('2108300210101', '201', 'Hardcopy', 'Juli', NULL, NULL, NULL, NULL, NULL, '21083002101', NULL, NULL),
('2108300210102', '203', 'Hardcopy', 'Juli', NULL, NULL, NULL, NULL, NULL, '21083002101', NULL, NULL),
('2109300310101', '201', 'Softcopy', 'Agustus', NULL, NULL, NULL, NULL, NULL, '21093003101', NULL, NULL),
('2109300310102', '203', 'Hardcopy', 'Agustus', NULL, NULL, NULL, NULL, NULL, '21093003101', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_data`
--

CREATE TABLE `jenis_data` (
  `kode_jenis` varchar(20) NOT NULL DEFAULT '',
  `jenis_data` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_data`
--

INSERT INTO `jenis_data` (`kode_jenis`, `jenis_data`, `kategori`) VALUES
('101', 'Data Pembelian', 'Data Akuntansi'),
('102', 'Data Penjualan', 'Data Akuntansi'),
('104', 'Kas', 'Data Akuntansi'),
('105', 'saxxaa', 'Data Akuntansi'),
('106', 'aaadcsaa', 'Data Akuntansi'),
('108', 'ssdas', 'Data Akuntansi'),
('201', 'Data Gaji Bulanan', 'Data Perpajakan'),
('202', 'Data Gaji Tahunan', 'Data Perpajakan'),
('203', 'BPJS', 'Data Perpajakan'),
('301', 'Perjanjian Kredit', 'Data Lainnya'),
('302', 'Perjanjian Leasing', 'Data Lainnya'),
('303', 'Rekening Koran', 'Data Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `klien`
--

CREATE TABLE `klien` (
  `id_klien` varchar(20) NOT NULL DEFAULT '',
  `nama_klien` varchar(255) DEFAULT NULL,
  `nama_usaha` varchar(255) DEFAULT NULL,
  `kode_klu` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `email_klien` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `no_akte` varchar(255) DEFAULT NULL,
  `status_pekerjaan` varchar(255) DEFAULT NULL,
  `nama_pimpinan` varchar(255) DEFAULT NULL,
  `no_hp_pimpinan` varchar(255) DEFAULT NULL,
  `email_pimpinan` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `nama_counterpart` varchar(255) DEFAULT NULL,
  `no_hp_counterpart` varchar(255) DEFAULT NULL,
  `email_counterpart` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klien`
--

INSERT INTO `klien` (`id_klien`, `nama_klien`, `nama_usaha`, `kode_klu`, `alamat`, `telp`, `email_klien`, `no_hp`, `no_akte`, `status_pekerjaan`, `nama_pimpinan`, `no_hp_pimpinan`, `email_pimpinan`, `jabatan`, `nama_counterpart`, `no_hp_counterpart`, `email_counterpart`) VALUES
('3002', 'PT. Dermaga Asia', 'Toko Baju Dermaga', '102', 'Jakarta', '02147239', 'admin@dermagasia.com', '08322396277', '4753489230393847', 'Review', 'Mandra', '088456829832', 'mandraguna@dermaga.com', 'Founder', 'Asih', '089324723779', 'kasihan@dermaga.com'),
('3003', 'PT. Apa Hayoo', 'Toko Apaya', '103', 'Jakarta', '0214839237', 'tax@apahayo.com', '08977779378338', '4056964532345', 'Accounting Service', 'Andra', '0833793019380', 'andra@apahayo.com', 'Founder', 'Mina', '0897785678967', 'mina@apahayo.com'),
('3004', 'PT. Melawai Gemilang', 'Optik Melawai', '108', 'Jakarta Selatan', '0219837412', 'optikmelawai@gmail.com', '081237463890', '8937988126739', 'Accounting Service', 'Ratna', '081265735671', 'ratna@gmail.com', 'Founder & CEO', 'Melisa', '08217391764', 'melisa@gmail.com'),
('3005', 'CV. Rekayasa', 'Toko Rekayasa', '101', 'Jakarta Barat', '021983741232', 'admin.rekayasa@gmail.com', '081237463890', '8937988126739', 'Review', 'Reka', '081265735671', 'reka@gmail.com', 'Founder & CEO', 'Yasa', '08217391764', 'yasa@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `klu`
--

CREATE TABLE `klu` (
  `kode_klu` varchar(20) NOT NULL,
  `bentuk_usaha` varchar(255) DEFAULT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klu`
--

INSERT INTO `klu` (`kode_klu`, `bentuk_usaha`, `jenis_usaha`) VALUES
('101', 'Dagang', 'Dagang Makanan'),
('102', 'Dagang', 'Dagang Pakaian'),
('103', 'Dagang', 'Dagang Furniture'),
('104', 'Dagang', 'Dagang Elektronik'),
('105', 'Dagang', 'Dagang Alat Berat'),
('106', 'Dagang', 'Dagang Motor'),
('107', 'Dagang', 'Dagang Mobil'),
('108', 'Dagang', 'Dagang Obat'),
('201', 'Konsultan', 'Konsultan Keuangan'),
('202', 'Konsultan', 'Konsultan Pajak'),
('203', 'Konsultan', 'Konsultan Kecantikan'),
('204', 'Konsultan', 'Konsultan Hukum'),
('301', 'Jasa', 'Jasa Membaca'),
('302', 'Jasa', 'Jasa Membaca'),
('303', 'Jasa', 'Jasa Membaca'),
('304', 'Jasa', 'Jasa Membaca'),
('305', 'Jasa', 'Jasa Membaca'),
('306', 'Jasa', 'Jasa Membaca'),
('307', 'Jasa', 'Jasa Membaca'),
('308', 'Jasa', 'Jasa Membaca'),
('309', 'Jasa', 'Jasa Membaca');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_akuntansi`
--

CREATE TABLE `pengiriman_akuntansi` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_pengiriman` varchar(255) DEFAULT NULL,
  `kode_data` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengiriman_akuntansi`
--

INSERT INTO `pengiriman_akuntansi` (`id_pengiriman`, `pengiriman`, `tanggal_pengiriman`, `file`, `ket_pengiriman`, `kode_data`) VALUES
('210930021010101', '01', '02-09-2021 09:36', 'ESTIMASI PER DES 2019 - 24.04.2020.xlsx', 'tanggal 1-15', '2109300210101'),
('210930021010102', '02', '02-09-2021 09:36', 'data admin(3).xlsx', 'sisanya', '2109300210101'),
('210930021010201', '01', '02-09-2021 09:37', '06-09-2021', '', '2109300210102'),
('210930021010202', '02', '02-09-2021 09:37', '08-09-2021', '', '2109300210102'),
('210930021010301', '01', '02-09-2021 17:24', '02-09-2021', '', '2109300210103'),
('210930021020101', '01', '13-09-2021 15:10', 'Permintaan Data Perpajakan April 2021 (1).xlsx', '', '2109300210201');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_lainnya`
--

CREATE TABLE `pengiriman_lainnya` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_pengiriman` varchar(255) DEFAULT NULL,
  `kode_data` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_perpajakan`
--

CREATE TABLE `pengiriman_perpajakan` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_pengiriman` varchar(255) DEFAULT NULL,
  `kode_data` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_akuntansi`
--

CREATE TABLE `permintaan_akuntansi` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `bulan` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `jum_data` varchar(10) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permintaan_akuntansi`
--

INSERT INTO `permintaan_akuntansi` (`id_permintaan`, `tanggal_permintaan`, `id_klien`, `bulan`, `tahun`, `request`, `jum_data`, `id_pengirim`) VALUES
('21093002101', '02-09-2021 09:33', '3002', '09', '2021', '01', NULL, '2002'),
('21093002102', '09-09-2021 16:53', '3002', '09', '2021', '02', NULL, '2002'),
('21093005101', '09-09-2021 10:16', '3005', '09', '2021', '01', NULL, '1001');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_lainnya`
--

CREATE TABLE `permintaan_lainnya` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `bulan` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permintaan_lainnya`
--

INSERT INTO `permintaan_lainnya` (`id_permintaan`, `tanggal_permintaan`, `id_klien`, `bulan`, `tahun`, `request`, `id_pengirim`) VALUES
('21093002101', '09-09-2021 17:00', '3002', '09', '2021', '01', '2002');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_perpajakan`
--

CREATE TABLE `permintaan_perpajakan` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `bulan` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permintaan_perpajakan`
--

INSERT INTO `permintaan_perpajakan` (`id_permintaan`, `tanggal_permintaan`, `id_klien`, `bulan`, `tahun`, `request`, `id_pengirim`) VALUES
('21083002101', '23-08-2021 11:41', '3002', '08', '2021', '01', '2002'),
('21093003101', '01-09-2021 17:07', '3003', '09', '2021', '01', '2002');

-- --------------------------------------------------------

--
-- Table structure for table `proses_akuntansi`
--

CREATE TABLE `proses_akuntansi` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(50) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `kode_data` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proses_akuntansi`
--

INSERT INTO `proses_akuntansi` (`id_proses`, `tanggal_proses`, `tanggal_mulai`, `tanggal_selesai`, `ket_proses`, `kode_data`, `id_akuntan`) VALUES
('210930021010101', '02-09-2021 10:16', '02/09/2021 10:00', '06/09/2021 17:00', NULL, '2109300210101', '2002'),
('210930021010102', '06-09-2021 10:01', '06/09/2021 09:00', '06/09/2021 15:25', NULL, '2109300210101', '2002'),
('210930021010201', '02-09-2021 16:40', '02/09/2021 13:00', '06/09/2021 09:23', NULL, '2109300210102', '2002'),
('210930021010202', '06-09-2021 10:35', '06/09/2021 10:35', '10/09/2021 09:15', NULL, '2109300210102', '2002');

-- --------------------------------------------------------

--
-- Table structure for table `proses_lainnya`
--

CREATE TABLE `proses_lainnya` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(50) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `kode_data` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proses_perpajakan`
--

CREATE TABLE `proses_perpajakan` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(50) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `kode_data` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `status_pekerjaan`
--

CREATE TABLE `status_pekerjaan` (
  `id_pekerjaan` varchar(10) NOT NULL DEFAULT '',
  `nama_pekerjaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status_pekerjaan`
--

INSERT INTO `status_pekerjaan` (`id_pekerjaan`, `nama_pekerjaan`) VALUES
('1', 'Accounting Service'),
('2', 'Review'),
('3', 'Semi Review');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `token` varchar(300) NOT NULL DEFAULT '',
  `id_user` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `kode_tugas` varchar(50) NOT NULL DEFAULT '',
  `nama_tugas` varchar(255) DEFAULT NULL,
  `accounting_service` varchar(20) DEFAULT NULL,
  `review` varchar(20) DEFAULT NULL,
  `semi_review` varchar(20) DEFAULT NULL,
  `id_jenis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`kode_tugas`, `nama_tugas`, `accounting_service`, `review`, `semi_review`, `id_jenis`) VALUES
('10101', 'Pengeluaran', '100', '64', '82', '101'),
('10201', 'Pemasukan', '160', '112', '136', '102'),
('10401', 'ada', '100', '88', '72', '104');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `passlength` varchar(10) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL,
  `confirmed` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `passlength`, `level`, `nama`, `email_user`, `confirmed`) VALUES
('1001', 'admin_data', '$2y$10$rdHqMJE8/qTWvQs6ZwMBGOWwxuTBTz8a3152JfnpdN3H3VqRU6Qlm', '9', 'admin', 'Administrator', 'admin-data@gmail.com', NULL),
('1002', 'unnicha23', '$2y$10$3TzGnvqv7YpFEz3U6vDRseOTqmwAKell5ap.AtYCXj4znuPkACY7S', '10', 'admin', 'Khansa', 'unnicha23@gmail.com', NULL),
('2001', 'ayularasati', '$2y$10$uq0LZMpg9ylrhkltn5gaLOE6DSQEiQym9udw/3xBiSheF2Vk8Mvwe', '8', 'akuntan', 'Ayu Kartika Putri', 'ayukartika@gmail.com', ''),
('2002', 'hanalestarii', '$2y$10$yvW8VeAUMcGIHGYTeT38FePlMci8FZmpf5z4g2Cd/x1ZrQAt7kzpO', '9', 'akuntan', 'Hana Lestari', 'hanalestari@gmail.com', ''),
('2003', 'denicool', '$2y$10$/JtEhxMy6WruyVtL.x5dT.5lAFTNgjKozawkhINWkOrfnb8nSljMa', '8', 'akuntan', 'Deni', 'deni@gmail.com', ''),
('3002', 'dermagajaya', '$2y$10$uLPpG13MhbFsyqRi7BKXSOlgtlQClpXV4iTOr7CQ1qyq2WnqyH.zy', '11', 'klien', 'PT. Dermaga Asia', 'admin@dermagasia.com', ''),
('3003', 'apahayoo', '$2y$10$S23m20uHdSBcOiE3thSZAeKuq3467Ni83J1s/yYP77mQJ7Be/mRt.', '10', 'klien', 'PT. Apa Aja Bole', 'accounting@apahayoo.com', ''),
('3004', 'melawaigemilang', '$2y$10$ePhltG0wMk6xmZoVjhAmMO7UjI4vBRWvZPbYwuzJr2UyARDHh.GzO', '8', 'klien', 'PT. Melawai Gemilang', 'optikmelawai@gmail.com', ''),
('3005', 'yasareka', '$2y$10$pS5OakHjF698fEoIw2/WU.xZxCDFhae/kbjkxzcUjG9qbztSYytCm', '8', 'klien', 'CV. Rekayasa', 'admin.rekayasa@gmail.com', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`id_bulan`);

--
-- Indexes for table `jenis_data`
--
ALTER TABLE `jenis_data`
  ADD PRIMARY KEY (`kode_jenis`);

--
-- Indexes for table `klien`
--
ALTER TABLE `klien`
  ADD PRIMARY KEY (`id_klien`);

--
-- Indexes for table `klu`
--
ALTER TABLE `klu`
  ADD PRIMARY KEY (`kode_klu`);

--
-- Indexes for table `pengiriman_akuntansi`
--
ALTER TABLE `pengiriman_akuntansi`
  ADD PRIMARY KEY (`id_pengiriman`);

--
-- Indexes for table `permintaan_akuntansi`
--
ALTER TABLE `permintaan_akuntansi`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indexes for table `proses_akuntansi`
--
ALTER TABLE `proses_akuntansi`
  ADD PRIMARY KEY (`id_proses`);

--
-- Indexes for table `status_pekerjaan`
--
ALTER TABLE `status_pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`kode_tugas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
