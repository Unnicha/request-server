-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2021 at 12:11 PM
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
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(255) DEFAULT NULL,
  `klien` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`id_akses`, `masa`, `tahun`, `id_akuntan`, `klien`) VALUES
('202001', '5', '2020', '2001', '3002,3003'),
('212001', '5', '2021', '2001', '3001'),
('212002', '5', '2021', '2002', '3001,3002');

-- --------------------------------------------------------

--
-- Table structure for table `bulan`
--

CREATE TABLE `bulan` (
  `id_bulan` int(11) NOT NULL,
  `nama_bulan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bulan`
--

INSERT INTO `bulan` (`id_bulan`, `nama_bulan`) VALUES
(1, 'Januari'),
(2, 'Februari'),
(3, 'Maret'),
(4, 'April'),
(5, 'Mei'),
(6, 'Juni'),
(7, 'Juli'),
(8, 'Agustus'),
(9, 'September'),
(10, 'Oktober'),
(11, 'November'),
(12, 'Desember');

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
('104', 'sdaaxas', 'Data Akuntansi'),
('105', 'saxxaa', 'Data Akuntansi'),
('106', 'aaadcsaa', 'Data Akuntansi'),
('108', 'ssdas', 'Data Akuntansi'),
('109', 'sdaaxas', 'Data Akuntansi'),
('110', 'saxxaa', 'Data Akuntansi'),
('111', 'aaadcsaa', 'Data Akuntansi'),
('112', 'saxxaa', 'Data Akuntansi'),
('201', 'Data Gaji Bulanan', 'Data Perpajakan'),
('202', 'Data Gaji Tahunan', 'Data Perpajakan'),
('301', 'Perjanjian Kredit', 'Data Lainnya'),
('302', 'Perjanjian Leasing', 'Data Lainnya'),
('303', 'sdaaxas', 'Data Lainnya');

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
  `email` varchar(255) DEFAULT NULL,
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

INSERT INTO `klien` (`id_klien`, `nama_klien`, `nama_usaha`, `kode_klu`, `alamat`, `telp`, `email`, `no_hp`, `no_akte`, `status_pekerjaan`, `nama_pimpinan`, `no_hp_pimpinan`, `email_pimpinan`, `jabatan`, `nama_counterpart`, `no_hp_counterpart`, `email_counterpart`) VALUES
('3001', 'CV. Sedap Rasa', 'Rumah Makan Lezat', '101', 'Jakarta Selatan', '021562489', 'tax@citarasa.co.id', '085532448621', '97653456789007', 'Semi Review', 'Asih', '085123646248', 'asih@citarasa.co.id', 'CEO', 'Danu', '0897542578367', 'danudirja@citarasa.co.id'),
('3002', 'PT. Dermaga Baru', 'Toko Baju Dermaga', '102', 'Jakarta', '02147239', 'admin@dermaga.com', '08322396277', '4753489230393847', 'Review', 'Mandra', '088456829832', 'mandraguna@dermaga.com', 'Founder', 'Asih', '089324723779', 'kasihan@dermaga.com'),
('3003', 'PT. Apa Hayoo', 'Toko Apaya', '103', 'Jakarta', '0214839237', 'tax@apahayo.com', '08977779378338', '4056964532345', 'Accounting Service', 'Andra', '0833793019380', 'andra@apahayo.com', 'Founder', 'Mina', '0897785678967', 'mina@apahayo.com');

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
('309', 'Jasa', 'Jasa Membaca'),
('310', 'Jasa', 'Jasa Membaca'),
('311', 'Jasa', 'Jasa Membaca'),
('312', 'Jasa', 'Jasa Membaca');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_akuntansi`
--

CREATE TABLE `pengiriman_akuntansi` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengiriman_akuntansi`
--

INSERT INTO `pengiriman_akuntansi` (`id_pengiriman`, `tanggal_pengiriman`, `pembetulan`, `file`, `tanggal_ambil`, `keterangan2`, `id_permintaan`) VALUES
('21043003101010', '18-05-2021 15:41', '0', '', '19-05-2021', 'Bisa diambil jam 14.00', '2104300310101'),
('21053002102010', '18-05-2021 10:34', '0', 'data admin.xlsx', NULL, '', '2105300210201'),
('21053002102011', '20-05-2021 10:06', '1', 'KINERJA(2).xlsx', NULL, '', '2105300210201'),
('21053002102012', '20-05-2021 10:06', '2', 'KINERJA(3).xlsx', NULL, '', '2105300210201');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_lainnya`
--

CREATE TABLE `pengiriman_lainnya` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pengiriman_lainnya`
--

INSERT INTO `pengiriman_lainnya` (`id_pengiriman`, `tanggal_pengiriman`, `pembetulan`, `file`, `tanggal_ambil`, `keterangan2`, `id_permintaan`) VALUES
('21053002301010', '18-05-2021 10:38', '0', 'KINERJA(1).xlsx', NULL, '', '2105300230101'),
('21053002301011', '20-05-2021 11:31', '1', 'hitung jam(2).xlsx', NULL, '', '2105300230101');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_perpajakan`
--

CREATE TABLE `pengiriman_perpajakan` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pengiriman_perpajakan`
--

INSERT INTO `pengiriman_perpajakan` (`id_pengiriman`, `tanggal_pengiriman`, `pembetulan`, `file`, `tanggal_ambil`, `keterangan2`, `id_permintaan`) VALUES
('21053002201010', '18-05-2021 10:37', '0', 'data admin(1).xlsx', NULL, '', '2105300220101'),
('21053002201011', '20-05-2021 11:30', '1', 'KINERJA(4).xlsx', NULL, '', '2105300220101'),
('21053002201012', '20-05-2021 11:31', '2', 'KINERJA(5).xlsx', NULL, '', '2105300220101');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_akuntansi`
--

CREATE TABLE `permintaan_akuntansi` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `request` varchar(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permintaan_akuntansi`
--

INSERT INTO `permintaan_akuntansi` (`id_permintaan`, `tanggal_permintaan`, `masa`, `tahun`, `format_data`, `request`, `keterangan`, `notifikasi`, `kode_jenis`, `id_klien`, `id_pengirim`) VALUES
('2104300110101', '10-05-2021 17:22', 'April', '2021', 'Softcopy', '1', '', 'dikirim', '101', '3001', '2001'),
('2104300210101', '11-05-2021 10:06', 'April', '2021', 'Hardcopy', '1', '', 'dikirim', '101', '3002', '1001'),
('2104300310101', '18-05-2021 14:33', 'April', '2021', 'Hardcopy', '1', '', NULL, '101', '3003', '2001'),
('2104300310201', '18-05-2021 15:39', 'April', '2021', 'Hardcopy', '1', '', 'dikirim', '102', '3003', '2001'),
('2105300110101', '07-05-2021 11:12', 'Mei', '2021', 'Softcopy', '1', '', 'dikirim', '101', '3001', '1001'),
('2105300110102', '07-05-2021 11:21', 'Mei', '2021', 'Hardcopy', '2', '', 'dikirim', '101', '3001', '1001'),
('2105300110103', '20-05-2021 11:14', 'Mei', '2021', 'Softcopy', '3', '', 'dikirim', '101', '3001', '2001'),
('2105300210101', '07-05-2021 14:12', 'Mei', '2021', 'Hardcopy', '1', '', 'dikirim', '101', '3002', '1001'),
('2105300210102', '07-05-2021 14:39', 'Mei', '2021', 'Softcopy', '2', '', 'dikirim', '101', '3002', '2001'),
('2105300210201', '07-05-2021 14:13', 'Mei', '2021', 'Softcopy', '1', '', 'dikirim', '102', '3002', '1001');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_lainnya`
--

CREATE TABLE `permintaan_lainnya` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `request` varchar(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permintaan_lainnya`
--

INSERT INTO `permintaan_lainnya` (`id_permintaan`, `tanggal_permintaan`, `masa`, `tahun`, `format_data`, `request`, `keterangan`, `notifikasi`, `kode_jenis`, `id_klien`, `id_pengirim`) VALUES
('2104300230101', '11-05-2021 10:07', 'April', '2021', 'Hardcopy', '1', '', 'dikirim', '301', '3002', '1001'),
('2105300130101', '07-05-2021 11:30', 'Mei', '2021', 'Softcopy', '1', '', 'dikirim', '301', '3001', '1001'),
('2105300130102', '07-05-2021 11:34', 'Mei', '2021', 'Hardcopy', '2', '', 'dikirim', '301', '3001', '1001'),
('2105300230101', '07-05-2021 15:41', 'Mei', '2021', 'Softcopy', '1', '', 'dikirim', '301', '3002', '2001');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_perpajakan`
--

CREATE TABLE `permintaan_perpajakan` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `request` varchar(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permintaan_perpajakan`
--

INSERT INTO `permintaan_perpajakan` (`id_permintaan`, `tanggal_permintaan`, `masa`, `tahun`, `format_data`, `request`, `keterangan`, `notifikasi`, `kode_jenis`, `id_klien`, `id_pengirim`) VALUES
('2104300220101', '11-05-2021 10:07', 'April', '2021', 'Hardcopy', '1', '', 'dikirim', '201', '3002', '1001'),
('2105300120101', '07-05-2021 11:34', 'Mei', '2021', 'Softcopy', '1', '', 'dikirim', '201', '3001', '1001'),
('2105300120102', '07-05-2021 11:34', 'Mei', '2021', 'Softcopy', '2', '', 'dikirim', '201', '3001', '1001'),
('2105300120201', '07-05-2021 11:35', 'Mei', '2021', 'Hardcopy', '1', '', 'dikirim', '202', '3001', '1001'),
('2105300220101', '07-05-2021 11:35', 'Mei', '2021', 'Softcopy', '1', '', 'dikirim', '201', '3002', '1001');

-- --------------------------------------------------------

--
-- Table structure for table `proses_akuntansi`
--

CREATE TABLE `proses_akuntansi` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan3` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(50) DEFAULT NULL,
  `id_kirim` varchar(50) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proses_akuntansi`
--

INSERT INTO `proses_akuntansi` (`id_proses`, `tanggal_mulai`, `jam_mulai`, `tanggal_selesai`, `jam_selesai`, `durasi`, `keterangan3`, `id_tugas`, `id_kirim`, `id_akuntan`) VALUES
('210430031010101012001', '27/05/2021', '10:00', NULL, NULL, NULL, NULL, '101101', '21043003101010', '2001');

-- --------------------------------------------------------

--
-- Table structure for table `proses_lainnya`
--

CREATE TABLE `proses_lainnya` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan3` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(255) DEFAULT NULL,
  `id_kirim` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `proses_perpajakan`
--

CREATE TABLE `proses_perpajakan` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan3` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(255) DEFAULT NULL,
  `id_kirim` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

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
-- Table structure for table `trash_pengiriman_akuntansi`
--

CREATE TABLE `trash_pengiriman_akuntansi` (
  `idt_pengiriman` varchar(50) NOT NULL,
  `tanggal_hapus` varchar(255) DEFAULT NULL,
  `id_pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  `id_disposer2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trash_pengiriman_lainnya`
--

CREATE TABLE `trash_pengiriman_lainnya` (
  `idt_pengiriman` varchar(50) NOT NULL,
  `tanggal_hapus` varchar(255) DEFAULT NULL,
  `id_pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  `id_disposer2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trash_pengiriman_perpajakan`
--

CREATE TABLE `trash_pengiriman_perpajakan` (
  `idt_pengiriman` varchar(50) NOT NULL,
  `tanggal_hapus` varchar(255) DEFAULT NULL,
  `id_pengiriman` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  `id_disposer2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trash_permintaan_akuntansi`
--

CREATE TABLE `trash_permintaan_akuntansi` (
  `idt_permintaan` varchar(50) NOT NULL,
  `tanggal_hapus` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL,
  `id_disposer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trash_permintaan_lainnya`
--

CREATE TABLE `trash_permintaan_lainnya` (
  `idt_permintaan` varchar(50) NOT NULL,
  `tanggal_hapus` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL,
  `id_disposer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trash_permintaan_perpajakan`
--

CREATE TABLE `trash_permintaan_perpajakan` (
  `idt_permintaan` varchar(50) NOT NULL,
  `tanggal_hapus` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL,
  `id_disposer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trash_proses_akuntansi`
--

CREATE TABLE `trash_proses_akuntansi` (
  `idt_proses` varchar(50) NOT NULL,
  `tanggal_cancel` varchar(255) DEFAULT NULL,
  `id_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `keterangan3` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(255) DEFAULT NULL,
  `id_kirim` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(255) DEFAULT NULL,
  `id_disposer3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trash_proses_lainnya`
--

CREATE TABLE `trash_proses_lainnya` (
  `idt_proses` varchar(50) NOT NULL,
  `tanggal_cancel` varchar(255) DEFAULT NULL,
  `id_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `keterangan3` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(255) DEFAULT NULL,
  `id_kirim` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(255) DEFAULT NULL,
  `id_disposer3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trash_proses_perpajakan`
--

CREATE TABLE `trash_proses_perpajakan` (
  `idt_proses` varchar(50) NOT NULL,
  `tanggal_cancel` varchar(255) DEFAULT NULL,
  `id_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `keterangan3` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(255) DEFAULT NULL,
  `id_kirim` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(255) DEFAULT NULL,
  `id_disposer3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE `tugas` (
  `id_tugas` varchar(50) NOT NULL DEFAULT '',
  `nama_tugas` varchar(255) DEFAULT NULL,
  `status_pekerjaan` varchar(255) DEFAULT NULL,
  `lama_pengerjaan` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tugas`
--

INSERT INTO `tugas` (`id_tugas`, `nama_tugas`, `status_pekerjaan`, `lama_pengerjaan`, `kode_jenis`) VALUES
('101101', 'Kertas Kerja', 'Accounting Service', '105', '101'),
('102201', 'Kertas Kerja', 'Review', '85', '102');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`, `nama`, `email_user`) VALUES
('1001', 'adminzzz', '$2y$10$Iax0JAvy/DKzwurUt0E8de5B.bjimoZDDo8A5FCPFA2TDA865WC4W', 'admin', 'Administrator', 'admin@data.hrwconsulting.com'),
('1002', 'cacacaca', '$2y$10$PjjYlu4oKsdqsDkGBVmgQenQL75U7nTghZafrGAi6Xf4anudIfKky', 'admin', 'Khansa', 'unnicha23@gmail.com'),
('2001', 'ayularasati', '$2y$10$uq0LZMpg9ylrhkltn5gaLOE6DSQEiQym9udw/3xBiSheF2Vk8Mvwe', 'akuntan', 'Ayu', 'ayu@gmail.com'),
('2002', 'harigusman', '$2y$10$Vyhgo7AyEToDm5lunZp4HemmL1Ko8DoP3eD8uzPK2oayDkBSf5h8m', 'akuntan', 'Hari', 'hari@gmail.com'),
('2003', 'denicool', '$2y$10$s3UtGxffanpArgPV7TSJtOHeRdLiiBMY2hX/hyO4qLmqpmKqWl1.i', 'akuntan', 'Deni', 'deni@gmail.com'),
('3001', 'citarasa', 'citarasa123', 'klien', 'CV. Sedap Rasa', 'tax@citarasa.co.id'),
('3002', 'dermaga1', '$2y$10$I6/6TRvh0Di2jaSFtztmYukyHhu50VJT.s3DesrNSVljYUW1sRQBu', 'klien', 'PT. Dermaga Baru', 'PT. Dermaga Baru'),
('3003', 'ptapahayo', '$2y$10$6uXha38qQX/bIK.iEi2preSsRHgty7eDzxPRlaxdczM959Ex0WkIq', 'klien', 'PT. Apa Hayoo', 'tax@apahayo.com');

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
-- Indexes for table `trash_pengiriman_akuntansi`
--
ALTER TABLE `trash_pengiriman_akuntansi`
  ADD PRIMARY KEY (`idt_pengiriman`);

--
-- Indexes for table `trash_pengiriman_lainnya`
--
ALTER TABLE `trash_pengiriman_lainnya`
  ADD PRIMARY KEY (`idt_pengiriman`);

--
-- Indexes for table `trash_pengiriman_perpajakan`
--
ALTER TABLE `trash_pengiriman_perpajakan`
  ADD PRIMARY KEY (`idt_pengiriman`);

--
-- Indexes for table `trash_permintaan_akuntansi`
--
ALTER TABLE `trash_permintaan_akuntansi`
  ADD PRIMARY KEY (`idt_permintaan`);

--
-- Indexes for table `trash_permintaan_lainnya`
--
ALTER TABLE `trash_permintaan_lainnya`
  ADD PRIMARY KEY (`idt_permintaan`);

--
-- Indexes for table `trash_permintaan_perpajakan`
--
ALTER TABLE `trash_permintaan_perpajakan`
  ADD PRIMARY KEY (`idt_permintaan`);

--
-- Indexes for table `trash_proses_akuntansi`
--
ALTER TABLE `trash_proses_akuntansi`
  ADD PRIMARY KEY (`idt_proses`);

--
-- Indexes for table `trash_proses_lainnya`
--
ALTER TABLE `trash_proses_lainnya`
  ADD PRIMARY KEY (`idt_proses`);

--
-- Indexes for table `trash_proses_perpajakan`
--
ALTER TABLE `trash_proses_perpajakan`
  ADD PRIMARY KEY (`idt_proses`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id_tugas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulan`
--
ALTER TABLE `bulan`
  MODIFY `id_bulan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
