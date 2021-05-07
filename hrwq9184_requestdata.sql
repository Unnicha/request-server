-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 17, 2021 at 11:16 AM
-- Server version: 10.2.36-MariaDB-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrwq9184_requestdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses`
--

CREATE TABLE `akses` (
  `id_akses` varchar(20) NOT NULL DEFAULT '',
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(255) DEFAULT NULL,
  `klien` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`id_akses`, `masa`, `tahun`, `id_akuntan`, `klien`) VALUES
('202101A001', 'Januari', '2021', 'A001', NULL),
('202101A002', 'Januari', '2021', 'A002', 'K001,K002'),
('A2102001', 'Februari', '2021', 'A001', 'K001,K002'),
('A2102002', 'Februari', '2021', 'A002', 'K001,K002,K003,K004');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_data`
--

CREATE TABLE `jenis_data` (
  `kode_jenis` varchar(20) NOT NULL DEFAULT '',
  `jenis_data` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `lama_pengerjaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_data`
--

INSERT INTO `jenis_data` (`kode_jenis`, `jenis_data`, `kategori`, `lama_pengerjaan`) VALUES
('101', 'Data Pembelian', 'Data Akuntansi', '32'),
('102', 'Data Penjualan', 'Data Akuntansi', '32'),
('103', 'Data Harga', 'Data Akuntansi', '15'),
('201', 'Data Gaji', 'Data Perpajakan', '35'),
('202', 'Data Pegawai', 'Data Perpajakan', '35'),
('301', 'Data Bank', 'Data Lainnya', '25'),
('302', 'Data Rekening', 'Data Lainnya', '32');

-- --------------------------------------------------------

--
-- Table structure for table `klien`
--

CREATE TABLE `klien` (
  `id_klien` varchar(11) NOT NULL DEFAULT '',
  `nama_klien` varchar(255) DEFAULT NULL,
  `kode_klu` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `no_akte` varchar(255) DEFAULT NULL,
  `nama_pimpinan` varchar(255) DEFAULT NULL,
  `no_hp_pimpinan` varchar(255) DEFAULT NULL,
  `email_pimpinan` varchar(255) DEFAULT NULL,
  `nama_counterpart` varchar(255) DEFAULT NULL,
  `no_hp_counterpart` varchar(255) DEFAULT NULL,
  `email_counterpart` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klien`
--

INSERT INTO `klien` (`id_klien`, `nama_klien`, `kode_klu`, `alamat`, `telp`, `email`, `no_hp`, `no_akte`, `nama_pimpinan`, `no_hp_pimpinan`, `email_pimpinan`, `nama_counterpart`, `no_hp_counterpart`, `email_counterpart`) VALUES
('K001', 'PT. Baru', '002', 'Jakarta', '02184473', 'testaddress@data.hrwconsulting.id', '082937421742', '94394343757293', 'Biru', '0889848832782', 'testcc@data.hrwconsulting.id', 'Merah', '0883498843793', 'testbcc@data.hrwconsulting.id'),
('K002', 'PT. Nuansa Bening', '003', 'Jakarta', '02184473', 'testaddress@data.hrwconsulting.id', '082937421742', '94394343757293', 'Ungu', '0889848832782', 'testcc@data.hrwconsulting.id', 'Merah', '0883498843793', 'testbcc@data.hrwconsulting.id'),
('K003', 'PT. Megah Megalon Industries', '002', 'Jakarta', '0893676376372637', 'megah@gmail.com', '0899987867867687', '3784816413047031846', 'Pak Hendri', '086736326327327', 'hendri@gmail.com', 'Bu Maria', '08826373325463', 'maria@gmail.com'),
('K004', 'CV. Cahaya Hati', '003', 'Jakarta', '08763675453264', 'pajak@cahayahati.co.id', '08794637363776', '478941874010817084', 'Pak Heri', '0837346324322', 'heri@cahayahati.co.id', 'Bu Wulan', '089947374328478', 'wulan@cahayahati.co.id');

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
('001', 'Dagang', 'Dagang Makanan'),
('002', 'Dagang', 'Dagang Baju'),
('003', 'Konsultan', 'Konsultan Kecantikan'),
('004', 'Konsultan', 'Konsultan Keuangan'),
('005', 'Dagang', 'Dagang Elektronik');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_akuntansi`
--

CREATE TABLE `pengiriman_akuntansi` (
  `id_pengiriman` varchar(20) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengiriman_akuntansi`
--

INSERT INTO `pengiriman_akuntansi` (`id_pengiriman`, `tanggal_pengiriman`, `pembetulan`, `format_data`, `file`, `tanggal_ambil`, `keterangan2`, `id_permintaan`) VALUES
('210200110100', '16-02-2021 13:59', '00', 'Softcopy', 'KINERJA.xlsx', '', 'Sudah ya bu', '2102001101'),
('210200110101', '16-02-2021 14:02', '01', 'Softcopy', 'KINERJA(1).xlsx', '', 'Ini revisinya ya bu', '2102001101');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_lainnya`
--

CREATE TABLE `pengiriman_lainnya` (
  `id_pengiriman` varchar(20) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_perpajakan`
--

CREATE TABLE `pengiriman_perpajakan` (
  `id_pengiriman` varchar(20) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_akuntansi`
--

CREATE TABLE `permintaan_akuntansi` (
  `id_permintaan` varchar(20) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permintaan_akuntansi`
--

INSERT INTO `permintaan_akuntansi` (`id_permintaan`, `tanggal_permintaan`, `masa`, `tahun`, `keterangan`, `notifikasi`, `kode_jenis`, `id_klien`, `id_user`) VALUES
('2102001101', '16-02-2021 13:50', 'Februari', '2021', 'Segera ya', 'dikirim', '101', 'K001', NULL),
('2102001102', '09-02-2021 15:28', 'Februari', '2021', 'Segera ya', 'dikirim', '102', 'K001', NULL),
('2102001103', '09-02-2021 17:10', 'Februari', '2021', '', 'dikirim', '103', 'K001', NULL),
('2102002101', '08-02-2021 17:10', 'Februari', '2021', '', 'dikirim', '101', 'K002', NULL),
('2102002102', '09-02-2021 17:13', 'Februari', '2021', '', 'dikirim', '102', 'K002', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_lainnya`
--

CREATE TABLE `permintaan_lainnya` (
  `id_permintaan` varchar(20) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permintaan_lainnya`
--

INSERT INTO `permintaan_lainnya` (`id_permintaan`, `tanggal_permintaan`, `masa`, `tahun`, `keterangan`, `notifikasi`, `kode_jenis`, `id_klien`, `id_user`) VALUES
('2102001301', '07-02-2021 09:53', 'Februari', '2021', '', 'dikirim', '301', 'K001', NULL),
('2102001302', '08-02-2021 09:58', 'Februari', '2021', '', 'dikirim', '302', 'K001', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_perpajakan`
--

CREATE TABLE `permintaan_perpajakan` (
  `id_permintaan` varchar(20) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permintaan_perpajakan`
--

INSERT INTO `permintaan_perpajakan` (`id_permintaan`, `tanggal_permintaan`, `masa`, `tahun`, `keterangan`, `notifikasi`, `kode_jenis`, `id_klien`, `id_user`) VALUES
('2102001201', '10-02-2021 09:53', 'Februari', '2021', '', 'dikirim', '201', 'K001', NULL),
('2102001202', '07-02-2021 09:53', 'Februari', '2021', '', 'dikirim', '202', 'K001', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proses_akuntansi`
--

CREATE TABLE `proses_akuntansi` (
  `id_proses` varchar(20) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_pengiriman` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proses_lainnya`
--

CREATE TABLE `proses_lainnya` (
  `id_proses` varchar(20) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_pengiriman` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `proses_perpajakan`
--

CREATE TABLE `proses_perpajakan` (
  `id_proses` varchar(20) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_pengiriman` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`, `nama`) VALUES
('A001', 'adindaaa', 'dinda1234', 'akuntan', 'Dinda'),
('A002', 'adiadiadi', 'adiadi123', 'akuntan', 'Adi'),
('K001', 'buruburu', 'baru1234', 'klien', 'PT. Baru'),
('K002', 'nuansabening', 'bening123', 'klien', 'PT. Nuansa Bening'),
('K003', 'megah123', 'megah123', 'klien', 'PT. Megah Megalon Industries'),
('K004', 'cahayahati', 'cahaya123', 'klien', 'CV. Cahaya Hati'),
('S02', 'mimimimi', 'mimimimi', 'admin', 'Mimi'),
('S03', 'unnicha', 'unnichaa', 'admin', 'Khansa'),
('S04', 'admin', 'admin123', 'admin', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`id_akses`);

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
-- Indexes for table `pengiriman_lainnya`
--
ALTER TABLE `pengiriman_lainnya`
  ADD PRIMARY KEY (`id_pengiriman`);

--
-- Indexes for table `pengiriman_perpajakan`
--
ALTER TABLE `pengiriman_perpajakan`
  ADD PRIMARY KEY (`id_pengiriman`);

--
-- Indexes for table `permintaan_akuntansi`
--
ALTER TABLE `permintaan_akuntansi`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indexes for table `permintaan_lainnya`
--
ALTER TABLE `permintaan_lainnya`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indexes for table `permintaan_perpajakan`
--
ALTER TABLE `permintaan_perpajakan`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indexes for table `proses_akuntansi`
--
ALTER TABLE `proses_akuntansi`
  ADD PRIMARY KEY (`id_proses`);

--
-- Indexes for table `proses_lainnya`
--
ALTER TABLE `proses_lainnya`
  ADD PRIMARY KEY (`id_proses`);

--
-- Indexes for table `proses_perpajakan`
--
ALTER TABLE `proses_perpajakan`
  ADD PRIMARY KEY (`id_proses`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
