/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 5.7.32 : Database - silaki
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `silaki_m_berita` */

DROP TABLE IF EXISTS `silaki_m_berita`;

CREATE TABLE `silaki_m_berita` (
  `brtId` int(11) NOT NULL,
  `brtJudul` varchar(100) DEFAULT NULL,
  `brtTanggal` datetime DEFAULT NULL,
  `brtKonten` text,
  `brtGambar` text,
  `brtCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `brtUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `brtDeleteddAt` datetime DEFAULT NULL,
  PRIMARY KEY (`brtId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_berita` */

/*Table structure for table `silaki_m_jadwal_khusus` */

DROP TABLE IF EXISTS `silaki_m_jadwal_khusus`;

CREATE TABLE `silaki_m_jadwal_khusus` (
  `jdkId` int(11) NOT NULL AUTO_INCREMENT,
  `jdkTanggal` date DEFAULT NULL,
  `jdkJamMulai` time DEFAULT NULL,
  `jdkJamSelesai` time DEFAULT NULL,
  `jdkKeterangan` varchar(200) DEFAULT NULL,
  `jdkCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `jdkUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `jdkDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`jdkId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_jadwal_khusus` */

insert  into `silaki_m_jadwal_khusus`(`jdkId`,`jdkTanggal`,`jdkJamMulai`,`jdkJamSelesai`,`jdkKeterangan`,`jdkCreatedAt`,`jdkUpdatedAt`,`jdkDeletedAt`) values 
(1,'2021-04-16','12:00:00','15:00:00','Hari raya','2021-04-16 14:22:01','2021-04-16 14:26:33',NULL);

/*Table structure for table `silaki_m_jadwal_umum` */

DROP TABLE IF EXISTS `silaki_m_jadwal_umum`;

CREATE TABLE `silaki_m_jadwal_umum` (
  `jduId` int(11) NOT NULL AUTO_INCREMENT,
  `jduNamaHari` varchar(10) DEFAULT NULL,
  `jduJamMulai` time DEFAULT NULL,
  `jduJamSelesai` time DEFAULT NULL,
  `jduCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `jduUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `jduDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`jduId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_jadwal_umum` */

insert  into `silaki_m_jadwal_umum`(`jduId`,`jduNamaHari`,`jduJamMulai`,`jduJamSelesai`,`jduCreatedAt`,`jduUpdatedAt`,`jduDeletedAt`) values 
(1,'Senin','02:09:00','05:09:00','2021-04-16 23:09:14','2021-04-16 14:16:25','2021-04-16 14:16:25'),
(2,'Selasa','20:09:14','23:09:14','2021-04-16 23:09:36','2021-04-17 02:50:38',NULL),
(3,'Jumat','12:00:00','16:00:00','2021-04-16 13:57:51','2021-04-16 13:58:29',NULL),
(4,'Kamis','12:00:00','17:00:00','2021-04-16 13:58:14','2021-04-16 13:58:14',NULL);

/*Table structure for table `silaki_m_layanan_pengaduan` */

DROP TABLE IF EXISTS `silaki_m_layanan_pengaduan`;

CREATE TABLE `silaki_m_layanan_pengaduan` (
  `pgdId` int(11) NOT NULL AUTO_INCREMENT,
  `pgdNama` varchar(50) DEFAULT NULL,
  `pgdLink` text,
  `pgdIcon` varchar(50) DEFAULT NULL,
  `pgdCreatedAt` datetime DEFAULT NULL,
  `pgdUpdatedAt` datetime DEFAULT NULL,
  `pgdDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`pgdId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_layanan_pengaduan` */

insert  into `silaki_m_layanan_pengaduan`(`pgdId`,`pgdNama`,`pgdLink`,`pgdIcon`,`pgdCreatedAt`,`pgdUpdatedAt`,`pgdDeletedAt`) values 
(1,'Mantap','http://appstarter.wai/sampleTheme/view/icons-font-awesome','fa-500px','2021-04-16 15:15:56','2021-04-16 15:17:49','2021-04-16 15:17:49');

/*Table structure for table `silaki_m_pegawai` */

DROP TABLE IF EXISTS `silaki_m_pegawai`;

CREATE TABLE `silaki_m_pegawai` (
  `pgwNip` varchar(30) NOT NULL,
  `pgwNik` varchar(30) NOT NULL,
  `pgwNama` varchar(100) DEFAULT NULL,
  `pgwStatus` varchar(15) DEFAULT NULL,
  `pgwJk` enum('L','P') DEFAULT NULL,
  `pgwFoto` varchar(100) DEFAULT NULL,
  `pgwCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `pgwUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pgwDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`pgwNip`,`pgwNik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_pegawai` */

/*Table structure for table `silaki_m_pengunjung` */

DROP TABLE IF EXISTS `silaki_m_pengunjung`;

CREATE TABLE `silaki_m_pengunjung` (
  `pjgNik` varchar(20) NOT NULL,
  `pjgNama` varchar(50) DEFAULT NULL,
  `pjgNamaWbp` varchar(50) DEFAULT NULL,
  `pjgNamaAyah` varchar(50) DEFAULT NULL,
  `pjgCreatedAt` datetime DEFAULT NULL,
  `pjgUpdatedAt` datetime DEFAULT NULL,
  `pjgDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`pjgNik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_pengunjung` */

insert  into `silaki_m_pengunjung`(`pjgNik`,`pjgNama`,`pjgNamaWbp`,`pjgNamaAyah`,`pjgCreatedAt`,`pjgUpdatedAt`,`pjgDeletedAt`) values 
('6306061608980002','Muhammad Bawaihi 123','Ahmad Juhdi Y','Abdullah',NULL,'2021-04-16 09:42:24',NULL);

/*Table structure for table `silaki_m_profil` */

DROP TABLE IF EXISTS `silaki_m_profil`;

CREATE TABLE `silaki_m_profil` (
  `prfId` int(11) NOT NULL,
  `prfKonten` text,
  `prfGambar` text,
  `prfCretedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `prfUpdatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `prfDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`prfId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_profil` */

/*Table structure for table `silaki_m_role` */

DROP TABLE IF EXISTS `silaki_m_role`;

CREATE TABLE `silaki_m_role` (
  `rolUsername` varchar(50) NOT NULL,
  `rolAplikasi` varchar(50) NOT NULL,
  `rolRole` varchar(50) NOT NULL,
  `rolCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `rolUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rolDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`rolUsername`,`rolAplikasi`,`rolRole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_role` */

insert  into `silaki_m_role`(`rolUsername`,`rolAplikasi`,`rolRole`,`rolCreatedAt`,`rolUpdatedAt`,`rolDeletedAt`) values 
('bawaihi','silaki','admin','2021-04-14 22:03:23','2021-04-14 22:31:53',NULL);

/*Table structure for table `silaki_m_sosmed` */

DROP TABLE IF EXISTS `silaki_m_sosmed`;

CREATE TABLE `silaki_m_sosmed` (
  `sosId` int(11) NOT NULL,
  `sosNama` varchar(20) DEFAULT NULL,
  `sosLink` varchar(500) DEFAULT NULL,
  `sosIcon` varchar(20) DEFAULT NULL,
  `sosKeterangan` varchar(200) DEFAULT NULL,
  `sosCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `sosUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sosDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`sosId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_sosmed` */

/*Table structure for table `silaki_m_user` */

DROP TABLE IF EXISTS `silaki_m_user`;

CREATE TABLE `silaki_m_user` (
  `usrUsername` varchar(50) NOT NULL,
  `usrPassword` varchar(50) NOT NULL,
  `usrNama` varchar(100) DEFAULT NULL,
  `usrCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `usrUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usrDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`usrUsername`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `silaki_m_user` */

insert  into `silaki_m_user`(`usrUsername`,`usrPassword`,`usrNama`,`usrCreatedAt`,`usrUpdatedAt`,`usrDeletedAt`) values 
('2','2',NULL,'2021-04-14 21:26:31','2021-04-14 21:26:31',NULL),
('bawaihi','31481573634640367849ecf9ee4373e6','Muhammad Bawaihi','2021-04-14 21:26:23','2021-04-15 00:27:35',NULL);

/*Table structure for table `silaki_r_agama` */

DROP TABLE IF EXISTS `silaki_r_agama`;

CREATE TABLE `silaki_r_agama` (
  `agmrId` smallint(6) NOT NULL DEFAULT '0',
  `agmrNama` varchar(20) NOT NULL DEFAULT '',
  `agmrIdFeeder` varchar(45) DEFAULT NULL,
  `agmrCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `agmrUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`agmrId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `silaki_r_agama` */

insert  into `silaki_r_agama`(`agmrId`,`agmrNama`,`agmrIdFeeder`,`agmrCreatedAt`,`agmrUpdatedAt`) values 
(1,'Islam','1','2020-02-19 19:29:36','2020-02-19 19:29:36'),
(2,'Katolik','3','2020-02-19 19:29:36','2020-02-19 19:29:36'),
(3,'Protestan','2','2020-02-19 19:29:36','2020-02-19 19:29:36'),
(4,'Hindu','4','2020-02-19 19:29:36','2020-02-19 19:29:36'),
(5,'Budha','5','2020-02-19 19:29:36','2020-02-19 19:29:36'),
(6,'Konghuchu','6','2020-02-19 19:29:36','2020-02-19 19:29:36'),
(99,'Lainnya','99','2020-02-19 19:29:36','2020-02-19 19:29:36');

/*Table structure for table `silaki_t_antrian` */

DROP TABLE IF EXISTS `silaki_t_antrian`;

CREATE TABLE `silaki_t_antrian` (
  `antId` int(11) NOT NULL AUTO_INCREMENT,
  `antNo` int(11) DEFAULT NULL,
  `antNik` varchar(20) DEFAULT NULL,
  `antTanggal` datetime DEFAULT NULL,
  `antJenis` enum('Kunjungan','Penitipan') DEFAULT NULL,
  `antCreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `antUpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `antDeletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`antId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `silaki_t_antrian` */

insert  into `silaki_t_antrian`(`antId`,`antNo`,`antNik`,`antTanggal`,`antJenis`,`antCreatedAt`,`antUpdatedAt`,`antDeletedAt`) values 
(2,1,'6306061608980002','2021-04-16 00:14:07','Kunjungan','2021-04-15 22:45:10','2021-04-17 22:38:47',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
