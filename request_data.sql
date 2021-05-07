# Host: localhost:3308  (Version 5.5.5-10.4.14-MariaDB)
# Date: 2021-04-07 16:16:27
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "akses"
#

DROP TABLE IF EXISTS `akses`;
CREATE TABLE `akses` (
  `id_akses` varchar(50) NOT NULL DEFAULT '',
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `id_akuntan` varchar(255) DEFAULT NULL,
  `klien` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id_akses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "akses"
#

INSERT INTO `akses` VALUES ('2021032001','Maret','2021','2001','3001,3002'),('2021032002','Maret','2021','2002','3003,3004'),('2021032003','Maret','2021','2003','3002,3003'),('2021042001','April','2021','2001','3003,3004'),('2021042002','April','2021','2002','3001,3002'),('2021042003','April','2021','2003','3001,3004');

#
# Structure for table "bulan"
#

DROP TABLE IF EXISTS `bulan`;
CREATE TABLE `bulan` (
  `id_bulan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_bulan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_bulan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "bulan"
#

INSERT INTO `bulan` VALUES (1,'Januari'),(2,'Februari'),(3,'Maret'),(4,'April'),(5,'Mei'),(6,'Juni'),(7,'Juli'),(8,'Agustus'),(9,'September'),(10,'Oktober'),(11,'November'),(12,'Desember');

#
# Structure for table "jenis_data"
#

DROP TABLE IF EXISTS `jenis_data`;
CREATE TABLE `jenis_data` (
  `kode_jenis` varchar(20) NOT NULL DEFAULT '',
  `jenis_data` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kode_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "jenis_data"
#

INSERT INTO `jenis_data` VALUES ('101','Data Pembelian','Data Akuntansi'),('102','Data Penjualan','Data Akuntansi'),('103','Data Harga','Data Akuntansi'),('201','Data Gaji Bulanan','Data Perpajakan'),('202','Data Gaji Tahunan','Data Perpajakan'),('301','Akte Pendirian','Data Lainnya');

#
# Structure for table "klien"
#

DROP TABLE IF EXISTS `klien`;
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
  `email_counterpart` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_klien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "klien"
#

INSERT INTO `klien` VALUES ('3001','PT. Cahaya Terang Abadi',NULL,'001','Jakarta','02138483','pajak@cahaya.com','08231938137','234783924728347283','Accounting Service','Aru','08934823482384','aru@cahaya.com','CEO','Misca','93492374923','misca@cahaya.com'),('3002','PT. Kebaya Indonesia',NULL,'002','Jakarta','0213834983','kebaya.indonesia@gmail.com','0837423429379','4888888882849242','Review','Ayu','0897873837378','ayu.banget@gmail.com','CEO/Founder','Kiki','08989382382389','kiki.rahayu@gmail.com'),('3003','CV. Melia Indah',NULL,'003','Jakarta','02132823','meliaindah@gmail.com','08889384899','34674634593948','Semi Review','Melia','083474747839','meliasari@gmail.com','CEO/Founder','Fito','08377328247','fitolargo@gmail.com'),('3004','CV. Amaro Tech Indonesia',NULL,'005','Jakarta','02184389','amaro.techindo@gmail.com','083923749793','8348538383990','Accounting Service','Loco','08947758329','loco@gmail.com','Direktur','Dinggo','08934627328','dinggo.bingo@gmail.com');

#
# Structure for table "klu"
#

DROP TABLE IF EXISTS `klu`;
CREATE TABLE `klu` (
  `kode_klu` varchar(20) NOT NULL,
  `bentuk_usaha` varchar(255) DEFAULT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kode_klu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "klu"
#

INSERT INTO `klu` VALUES ('001','Dagang','Dagang Makanan'),('002','Dagang','Dagang Baju'),('003','Konsultan','Konsultan Kecantikan'),('004','Konsultan','Konsultan Keuangan'),('005','Dagang','Dagang Elektronik');

#
# Structure for table "pengiriman_akuntansi"
#

DROP TABLE IF EXISTS `pengiriman_akuntansi`;
CREATE TABLE `pengiriman_akuntansi` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pengiriman`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "pengiriman_akuntansi"
#

#
# Structure for table "pengiriman_lainnya"
#

DROP TABLE IF EXISTS `pengiriman_lainnya`;
CREATE TABLE `pengiriman_lainnya` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pengiriman`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

#
# Data for table "pengiriman_lainnya"
#


#
# Structure for table "pengiriman_perpajakan"
#

DROP TABLE IF EXISTS `pengiriman_perpajakan`;
CREATE TABLE `pengiriman_perpajakan` (
  `id_pengiriman` varchar(50) NOT NULL DEFAULT '',
  `tanggal_pengiriman` varchar(255) DEFAULT NULL,
  `pembetulan` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tanggal_ambil` varchar(255) DEFAULT NULL,
  `keterangan2` varchar(255) DEFAULT NULL,
  `id_permintaan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pengiriman`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

#
# Data for table "pengiriman_perpajakan"
#


#
# Structure for table "permintaan_akuntansi"
#

DROP TABLE IF EXISTS `permintaan_akuntansi`;
CREATE TABLE `permintaan_akuntansi` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "permintaan_akuntansi"
#

#
# Structure for table "permintaan_lainnya"
#

DROP TABLE IF EXISTS `permintaan_lainnya`;
CREATE TABLE `permintaan_lainnya` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

#
# Data for table "permintaan_lainnya"
#


#
# Structure for table "permintaan_perpajakan"
#

DROP TABLE IF EXISTS `permintaan_perpajakan`;
CREATE TABLE `permintaan_perpajakan` (
  `id_permintaan` varchar(50) NOT NULL DEFAULT '',
  `tanggal_permintaan` varchar(255) DEFAULT NULL,
  `masa` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `format_data` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `notifikasi` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  `id_klien` varchar(255) DEFAULT NULL,
  `id_pengirim` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

#
# Data for table "permintaan_perpajakan"
#


#
# Structure for table "proses_akuntansi"
#

DROP TABLE IF EXISTS `proses_akuntansi`;
CREATE TABLE `proses_akuntansi` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(50) DEFAULT NULL,
  `id_kirim` varchar(50) DEFAULT NULL,
  `id_akuntan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_proses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "proses_akuntansi"
#

#
# Structure for table "proses_lainnya"
#

DROP TABLE IF EXISTS `proses_lainnya`;
CREATE TABLE `proses_lainnya` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(255) DEFAULT NULL,
  `id_kirim` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_proses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

#
# Data for table "proses_lainnya"
#


#
# Structure for table "proses_perpajakan"
#

DROP TABLE IF EXISTS `proses_perpajakan`;
CREATE TABLE `proses_perpajakan` (
  `id_proses` varchar(50) NOT NULL DEFAULT '',
  `tanggal_mulai` varchar(255) DEFAULT NULL,
  `jam_mulai` varchar(255) DEFAULT NULL,
  `tanggal_selesai` varchar(255) DEFAULT NULL,
  `jam_selesai` varchar(255) DEFAULT NULL,
  `durasi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `id_tugas` varchar(255) DEFAULT NULL,
  `id_kirim` varchar(20) DEFAULT NULL,
  `id_akuntan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_proses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

#
# Data for table "proses_perpajakan"
#


#
# Structure for table "status_pekerjaan"
#

DROP TABLE IF EXISTS `status_pekerjaan`;
CREATE TABLE `status_pekerjaan` (
  `id_pekerjaan` varchar(10) NOT NULL DEFAULT '',
  `nama_pekerjaan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pekerjaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "status_pekerjaan"
#

INSERT INTO `status_pekerjaan` VALUES ('1','Accounting Service'),('2','Review'),('3','Semi Review');

#
# Structure for table "tugas"
#

DROP TABLE IF EXISTS `tugas`;
CREATE TABLE `tugas` (
  `id_tugas` varchar(50) NOT NULL DEFAULT '',
  `nama_tugas` varchar(255) DEFAULT NULL,
  `status_pekerjaan` varchar(255) DEFAULT NULL,
  `lama_pengerjaan` varchar(255) DEFAULT NULL,
  `kode_jenis` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tugas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "tugas"
#

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "user"
#

INSERT INTO `user` VALUES ('1001','adminzzz','admin123','admin','Administrator'),('1002','zuzuzuzu','zuzuzuzu','admin','Mealpops'),('1003','dodododo','dodododo','admin','dodo'),('2001','cahyono1','cahyo123','akuntan','Cahyo'),('2002','agustina','tina1234','akuntan','Agus'),('2003','dianmels','dian1234','akuntan','Dian'),('3001','ptcahaya','cahaya123','klien','PT. Cahaya Terang Abadi'),('3002','ptkebaya','kebayaindo','klien','PT. Kebaya Indonesia'),('3003','meliaindah','melia123','klien','CV. Melia Indah'),('3004','amarotech','amaro123','klien','CV. Amaro Tech Indonesia');
