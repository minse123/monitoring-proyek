-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_aghajaya
CREATE DATABASE IF NOT EXISTS `db_aghajaya` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_aghajaya`;

-- Dumping structure for table db_aghajaya.evaluasi_kinerja
CREATE TABLE IF NOT EXISTS `evaluasi_kinerja` (
  `id_evaluasi` int NOT NULL AUTO_INCREMENT,
  `id_pekerja` int NOT NULL,
  `bulan_tahun` varchar(7) NOT NULL,
  `nilai_kedisiplinan` int NOT NULL,
  `nilai_kualitas_kerja` int NOT NULL,
  `total_nilai` decimal(5,2) NOT NULL,
  `catatan_manajer` text,
  `tanggal_evaluasi` date NOT NULL,
  PRIMARY KEY (`id_evaluasi`),
  KEY `id_pekerja` (`id_pekerja`),
  CONSTRAINT `evaluasi_kinerja_ibfk_1` FOREIGN KEY (`id_pekerja`) REFERENCES `pekerja` (`id_pekerja`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_aghajaya.jadwal_pekerjaan
CREATE TABLE IF NOT EXISTS `jadwal_pekerjaan` (
  `id_jadwal` int NOT NULL AUTO_INCREMENT,
  `id_proyek` int NOT NULL,
  `nama_pekerjaan` varchar(255) NOT NULL,
  `target_kuantitas` decimal(10,2) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `tanggal_target` date NOT NULL,
  `status_pekerjaan` enum('Belum Mulai','Sedang Dikerjakan','Selesai') NOT NULL DEFAULT 'Belum Mulai',
  PRIMARY KEY (`id_jadwal`),
  KEY `id_proyek` (`id_proyek`),
  CONSTRAINT `jadwal_pekerjaan_ibfk_1` FOREIGN KEY (`id_proyek`) REFERENCES `proyek` (`id_proyek`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_aghajaya.pekerja
CREATE TABLE IF NOT EXISTS `pekerja` (
  `id_pekerja` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) DEFAULT NULL,
  `nama_pekerja` varchar(150) NOT NULL,
  `posisi` varchar(100) NOT NULL,
  `nomor_telp` varchar(15) DEFAULT NULL,
  `alamat` text,
  `tanggal_bergabung` date NOT NULL,
  PRIMARY KEY (`id_pekerja`),
  UNIQUE KEY `nik` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_aghajaya.progress_proyek
CREATE TABLE IF NOT EXISTS `progress_proyek` (
  `id_progress` int NOT NULL AUTO_INCREMENT,
  `id_proyek` int NOT NULL,
  `id_pekerja` int NOT NULL,
  `id_jadwal` int NOT NULL,
  `tanggal_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `realisasi_kuantitas` decimal(10,2) NOT NULL,
  `persentase_progress_saat_ini` decimal(5,2) NOT NULL,
  `deskripsi_update` text,
  PRIMARY KEY (`id_progress`),
  KEY `id_proyek` (`id_proyek`),
  KEY `id_pekerja` (`id_pekerja`),
  KEY `id_jadwal` (`id_jadwal`),
  CONSTRAINT `progress_proyek_ibfk_1` FOREIGN KEY (`id_proyek`) REFERENCES `proyek` (`id_proyek`) ON DELETE CASCADE,
  CONSTRAINT `progress_proyek_ibfk_2` FOREIGN KEY (`id_pekerja`) REFERENCES `pekerja` (`id_pekerja`) ON DELETE CASCADE,
  CONSTRAINT `progress_proyek_ibfk_3` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_pekerjaan` (`id_jadwal`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_aghajaya.proyek
CREATE TABLE IF NOT EXISTS `proyek` (
  `id_proyek` int NOT NULL AUTO_INCREMENT,
  `kode_proyek` varchar(20) NOT NULL,
  `nama_proyek` varchar(255) NOT NULL,
  `nilai_kontrak` decimal(15,2) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_target_selesai` date NOT NULL,
  `deskripsi` text,
  `status` enum('Perencanaan','Berjalan','Tertunda','Selesai') NOT NULL DEFAULT 'Perencanaan',
  PRIMARY KEY (`id_proyek`),
  UNIQUE KEY `kode_proyek` (`kode_proyek`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_aghajaya.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','manager') NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
