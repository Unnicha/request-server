-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2021 at 05:24 AM
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
  `id_akuntan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `akuntansi` mediumtext DEFAULT NULL,
  `perpajakan` mediumtext DEFAULT NULL,
  `lainnya` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses`
--

INSERT INTO `akses` (`id_akses`, `id_akuntan`, `masa`, `tahun`, `akuntansi`, `perpajakan`, `lainnya`) VALUES
('202001', '2001', '05', '2020', '3002,3003', NULL, NULL),
('212001', '2001', '05', '2021', '3002,3004', '3003', '3002,3003,3004'),
('212002', '2002', '05', '2021', '3003,3004', '3002,3003', '3002,3003,3004');

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
  `format_data` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `ket_file` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `ket_status` varchar(255) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL,
  `id_kirim` varchar(50) DEFAULT NULL,
  `id_kerja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_akuntansi`
--

INSERT INTO `data_akuntansi` (`id_data`, `id_jenis`, `format_data`, `detail`, `tanggal_pengiriman`, `file`, `ket_file`, `status`, `ket_status`, `id_request`, `id_kirim`, `id_kerja`) VALUES
('210730021001', '101', 'Softcopy', 'Jan - Juni', NULL, NULL, NULL, NULL, NULL, '21073002101', NULL, NULL),
('210730021002', '102', 'Hardcopy', 'Juni', NULL, NULL, NULL, NULL, NULL, '21073002101', NULL, NULL),
('210730021003', '104', 'Softcopy', 'Jan - Juni', NULL, NULL, NULL, NULL, NULL, '21073002101', NULL, NULL),
('210730031001', '101', 'Softcopy', 'Juni', '09-07-2021 13:19', 'yosi.pdf', '', '3', '', '21073003101', '2107300310101', '210730031001'),
('210730031002', '102', 'Softcopy', 'Juni', NULL, NULL, NULL, NULL, NULL, '21073003101', NULL, NULL),
('210730031003', '104', 'Hardcopy', 'Juni', '09-07-2021 13:19', '12-07-2021', '', '1', NULL, '21073003101', '2107300310101', NULL);

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
  `status` varchar(255) DEFAULT NULL,
  `ket_status` varchar(255) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL,
  `id_kirim` varchar(50) DEFAULT NULL,
  `id_kerja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `status` varchar(255) DEFAULT NULL,
  `ket_status` varchar(255) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL,
  `id_kirim` varchar(50) DEFAULT NULL,
  `id_kerja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
('110', 'saxxaa', 'Data Akuntansi'),
('111', 'aaadcsaa', 'Data Akuntansi'),
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
('3002', 'PT. Dermaga Baru', 'Toko Baju Dermaga', '102', 'Jakarta', '02147239', 'admin@dermaga.com', '08322396277', '4753489230393847', 'Review', 'Mandra', '088456829832', 'mandraguna@dermaga.com', 'Founder', 'Asih', '089324723779', 'kasihan@dermaga.com'),
('3003', 'PT. Apa Hayoo', 'Toko Apaya', '103', 'Jakarta', '0214839237', 'tax@apahayo.com', '08977779378338', '4056964532345', 'Accounting Service', 'Andra', '0833793019380', 'andra@apahayo.com', 'Founder', 'Mina', '0897785678967', 'mina@apahayo.com'),
('3004', 'PT. Melawai Gemilang', 'Optik Melawai', '108', 'Jakarta Selatan', '0219837412', 'optikmelawai@gmail.com', '081237463890', '8937988126739', 'Accounting Service', 'Ratna', '081265735671', 'ratna@gmail.com', 'Founder & CEO', 'Melisa', '08217391764', 'melisa@gmail.com');

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
  `pembetulan` varchar(255) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengiriman_akuntansi`
--

INSERT INTO `pengiriman_akuntansi` (`id_pengiriman`, `pembetulan`, `id_request`) VALUES
('2107300310101', '01', '21073003101');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_lainnya`
--

CREATE TABLE `pengiriman_lainnya` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `pembetulan` varchar(255) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman_perpajakan`
--

CREATE TABLE `pengiriman_perpajakan` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `pembetulan` varchar(255) DEFAULT NULL,
  `id_request` varchar(50) DEFAULT NULL
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
  `request` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permintaan_akuntansi`
--

INSERT INTO `permintaan_akuntansi` (`id_permintaan`, `tanggal_permintaan`, `id_klien`, `bulan`, `tahun`, `request`, `id_pengirim`) VALUES
('21073002101', '07-07-2021 14:11', '3002', '07', '2021', '01', '1001'),
('21073003101', '09-07-2021 12:10', '3003', '07', '2021', '01', '2002');

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

-- --------------------------------------------------------

--
-- Table structure for table `proses_akuntansi`
--

CREATE TABLE `proses_akuntansi` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(50) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `temp_mulai` varchar(50) DEFAULT NULL,
  `temp_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proses_akuntansi`
--

INSERT INTO `proses_akuntansi` (`id_proses`, `tanggal_proses`, `tanggal_mulai`, `tanggal_selesai`, `temp_mulai`, `temp_selesai`, `ket_proses`, `id_akuntan`) VALUES
('210730031001', '09-07-2021 14:27', '09/07/2021 10:30', NULL, NULL, NULL, '', '2002');

-- --------------------------------------------------------

--
-- Table structure for table `proses_lainnya`
--

CREATE TABLE `proses_lainnya` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `temp_mulai` varchar(50) DEFAULT NULL,
  `temp_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `proses_perpajakan`
--

CREATE TABLE `proses_perpajakan` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_proses` varchar(255) DEFAULT NULL,
  `tanggal_mulai` varchar(50) DEFAULT NULL,
  `tanggal_selesai` varchar(50) DEFAULT NULL,
  `temp_mulai` varchar(50) DEFAULT NULL,
  `temp_selesai` varchar(50) DEFAULT NULL,
  `ket_proses` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL
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
  `ket_proses` varchar(255) DEFAULT NULL,
  `id_data` varchar(50) DEFAULT NULL,
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
('10401', 'ada', '100', '88', '72', '104'),
('10501', 'a', '96', '64', '80', '105');

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
('1001', 'adminzzz', '$2y$10$Lf.jHlbeQMn.JakyBlWwD.Bqaaj/SL34aZY6aWWSgFenQr6MYvi9W', '8', 'admin', 'Admin', 'admin@gmail.com', NULL),
('1002', 'cacamerica', '$2y$10$9aADr4izFzt4IQVDUZ0D6u0KwG4jNGrOZ5GeVlcR72ScOHBr1Z8L.', '10', 'admin', 'Caca', 'caca2@gmail.com', NULL),
('2001', 'ayularasati', '$2y$10$uq0LZMpg9ylrhkltn5gaLOE6DSQEiQym9udw/3xBiSheF2Vk8Mvwe', '8', 'akuntan', 'Ayu Kartika Putri', 'ayukartika@gmail.com', ''),
('2002', 'iamjunet', '$2y$10$4Ob6y1I0PUhKaY9fRh6qdegxeMy85OG2OluCWhSGpwBU4sUnEcUpq', '11', 'akuntan', 'Adit Junaedi', 'junaedi.adit@gmail.com', ''),
('2003', 'denicool', '$2y$10$s3UtGxffanpArgPV7TSJtOHeRdLiiBMY2hX/hyO4qLmqpmKqWl1.i', '8', 'akuntan', 'Deni', 'deni@gmail.com', ''),
('3002', 'dermaga1', '$2y$10$BqMdiX95Ap/qkt9SdR2g5.1MF0SiXIFGlDFluxqCNnwxqLLlqXaCy', '8', 'klien', 'PT. Dermaga Jaya', 'admin@dermaga.com', ''),
('3003', 'apahayoo', '$2y$10$S23m20uHdSBcOiE3thSZAeKuq3467Ni83J1s/yYP77mQJ7Be/mRt.', '10', 'klien', 'PT. Apa Aja Bole', 'accounting@apahayoo.com', ''),
('3004', 'melawaigemilang', '$2y$10$ePhltG0wMk6xmZoVjhAmMO7UjI4vBRWvZPbYwuzJr2UyARDHh.GzO', '8', 'klien', 'PT. Melawai Gemilang', 'optikmelawai@gmail.com', '');

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
