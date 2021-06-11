-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2021 at 12:33 PM
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
  `status_kirim` mediumtext DEFAULT NULL,
  `file` mediumtext DEFAULT NULL,
  `keterangan` mediumtext DEFAULT NULL,
  `status` mediumtext DEFAULT NULL,
  `keterangan2` mediumtext DEFAULT NULL,
  `id_request` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengiriman_akuntansi`
--

INSERT INTO `pengiriman_akuntansi` (`id_pengiriman`, `tanggal_pengiriman`, `pembetulan`, `status_kirim`, `file`, `keterangan`, `status`, `keterangan2`, `id_request`) VALUES
('210630021010', '09-06-2021 10:52', '0', NULL, '24-06-2021|pph21 app history.rar|01-06-2021|15-06-2021', 'ada|revisi total||', 'lengkap|lengkap|belum|kurang', '|||', '21063002101');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_lainnya`
--

CREATE TABLE `pengiriman_lainnya` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` mediumtext DEFAULT NULL,
  `keterangan` mediumtext DEFAULT NULL,
  `status` mediumtext DEFAULT NULL,
  `keterangan2` mediumtext DEFAULT NULL,
  `id_request` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_perpajakan`
--

CREATE TABLE `pengiriman_perpajakan` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` mediumtext DEFAULT NULL,
  `keterangan` mediumtext DEFAULT NULL,
  `status` mediumtext DEFAULT NULL,
  `keterangan2` mediumtext DEFAULT NULL,
  `id_request` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

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
  `kode_jenis` mediumtext DEFAULT NULL,
  `format_data` mediumtext DEFAULT NULL,
  `detail` mediumtext DEFAULT NULL,
  `request` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permintaan_akuntansi`
--

INSERT INTO `permintaan_akuntansi` (`id_permintaan`, `tanggal_permintaan`, `id_klien`, `bulan`, `tahun`, `kode_jenis`, `format_data`, `detail`, `request`, `id_pengirim`) VALUES
('21063002101', '08-06-2021 11:07', '3002', '06', '2021', '101|102|104|105', 'Hardcopy|Softcopy|Hardcopy|Hardcopy', 'Mei|Mei|Mei|Mei', '01', '2002');

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
  `kode_jenis` mediumtext DEFAULT NULL,
  `format_data` mediumtext DEFAULT NULL,
  `detail` mediumtext DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permintaan_lainnya`
--

INSERT INTO `permintaan_lainnya` (`id_permintaan`, `tanggal_permintaan`, `id_klien`, `bulan`, `tahun`, `request`, `kode_jenis`, `format_data`, `detail`, `id_pengirim`) VALUES
('21063002301', '08-06-2021 10:08', '3002', '06', '2021', '01', '301|302|303', 'Softcopy|Hardcopy|Hardcopy', 'Mei|Mei|Jan - Mei 2021', '2002'),
('21063002302', '08-06-2021 10:44', '3002', '06', '2021', '02', '301|303', 'Hardcopy|Hardcopy', 'Mei|Mei', '2002');

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
  `kode_jenis` varchar(255) DEFAULT NULL,
  `detail` mediumtext DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `permintaan_perpajakan`
--

INSERT INTO `permintaan_perpajakan` (`id_permintaan`, `tanggal_permintaan`, `id_klien`, `bulan`, `tahun`, `request`, `kode_jenis`, `detail`, `format_data`, `id_pengirim`) VALUES
('21063002201', '08-06-2021 11:09', '3002', '06', '2021', '01', '201|202', 'Mei|Mei', 'Hardcopy|Softcopy', '2002');

-- --------------------------------------------------------

--
-- Table structure for table `proses_akuntansi`
--

CREATE TABLE `proses_akuntansi` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `keterangan3` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(50) DEFAULT NULL,
  `id_kirim` varchar(50) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proses_lainnya`
--

CREATE TABLE `proses_lainnya` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
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
  `tanggal_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
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
  `tanggal_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `keterangan3` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(255) DEFAULT NULL,
  `id_kirim` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(255) DEFAULT NULL,
  `id_disposer3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trash_proses_akuntansi`
--

INSERT INTO `trash_proses_akuntansi` (`idt_proses`, `tanggal_cancel`, `id_proses`, `tanggal_proses`, `tanggal_mulai`, `tanggal_selesai`, `keterangan3`, `id_tugas`, `id_kirim`, `id_akuntan`, `id_disposer3`) VALUES
('2105300210201020120021', '31-05-2021 17:36', '210530021020102012002', '31-05-2021 17:29', '18/05/2021 13:00', '19/05/2021 12:30', '', '102201', '21053002102010', '2002', '1001'),
('21053002102010201200222', '02-06-2021 09:15', '210530021020102012002', '31-05-2021 17:29', '18/05/2021 13:00', '25/05/2021 09:13', '', '102201', '21053002102010', '2002', '1001'),
('21053002102010201200223', '02-06-2021 10:04', '210530021020102012002', '02-06-2021 09:30', '12/05/2021 13:00', '18/05/2021 17:40', '', '102201', '21053002102010', '2002', '1001'),
('2105300210201120120021', '31-05-2021 17:37', '210530021020112012002', '31-05-2021 17:30', '19/05/2021 13:00', NULL, '', '102201', '21053002102011', '2002', '1001'),
('21053002102011201200222', '02-06-2021 09:15', '210530021020112012002', '31-05-2021 17:30', '19/05/2021 13:00', NULL, '', '102201', '21053002102011', '2002', '1001'),
('21053002102011201200223', '02-06-2021 09:15', '210530021020112012002', '31-05-2021 17:30', '19/05/2021 13:00', NULL, '', '102201', '21053002102011', '2002', '1001'),
('2105300210201220120021', '02-06-2021 10:05', '210530021020122012002', '02-06-2021 09:32', '23/06/2021 09:00', NULL, '', '102201', '21053002102012', '2002', '1001');

-- --------------------------------------------------------

--
-- Table structure for table `trash_proses_lainnya`
--

CREATE TABLE `trash_proses_lainnya` (
  `idt_proses` varchar(50) NOT NULL,
  `tanggal_cancel` varchar(255) DEFAULT NULL,
  `id_proses` varchar(255) DEFAULT NULL,
  `tanggal_proses` varchar(255) DEFAULT NULL,
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
('1001', 'adminzzz', '$2y$10$PRPnNCJnb8oka2V8b7cR1uTWM6Lns1RW5VFCO8AYfKA3WUnW4OkCK', 'admin', 'Administrator', 'admin@data.hrwconsulting.com'),
('1002', 'cacacaca', '$2y$10$PjjYlu4oKsdqsDkGBVmgQenQL75U7nTghZafrGAi6Xf4anudIfKky', 'admin', 'Khansa', 'unnicha23@gmail.com'),
('2001', 'ayularasati', '$2y$10$uq0LZMpg9ylrhkltn5gaLOE6DSQEiQym9udw/3xBiSheF2Vk8Mvwe', 'akuntan', 'Ayu', 'ayu@gmail.com'),
('2002', 'harigusman', '$2y$10$pWWEtppezC/DDQGvxHwsZeTY.pnm6n/9OMVaJGJaFGGsmlJjeHis6', 'akuntan', 'Hari', 'hari@gmail.com'),
('2003', 'denicool', '$2y$10$s3UtGxffanpArgPV7TSJtOHeRdLiiBMY2hX/hyO4qLmqpmKqWl1.i', 'akuntan', 'Deni', 'deni@gmail.com'),
('3001', 'citarasa', 'citarasa123', 'klien', 'CV. Sedap Rasa', 'tax@citarasa.co.id'),
('3002', 'dermaga1', '$2y$10$BKJir0sjf942kLzGHQXcyOEddRW/zoc1APHpwdFTScwlGtXOvSZM6', 'klien', 'PT. Dermaga Baru', 'PT. Dermaga Baru'),
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
