-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: quanlythuvien
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tieude` varchar(255) NOT NULL,
  `anh` varchar(255) NOT NULL,
  `lienket` varchar(255) NOT NULL,
  `ngaytao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner`
--

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chitietmuon`
--

DROP TABLE IF EXISTS `chitietmuon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitietmuon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_phieumuon` int(11) NOT NULL,
  `id_sach` int(11) NOT NULL,
  `soluong` int(11) NOT NULL DEFAULT 1,
  `giaphat` decimal(10,2) DEFAULT 0.00 COMMENT 'Tiền phạt nếu có',
  `tinhtrangtra` varchar(50) DEFAULT NULL COMMENT 'Tình trạng sách khi trả',
  PRIMARY KEY (`id`),
  KEY `id_phieumuon` (`id_phieumuon`),
  KEY `id_sach` (`id_sach`),
  CONSTRAINT `chitietmuon_ibfk_1` FOREIGN KEY (`id_phieumuon`) REFERENCES `phieumuon` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chitietmuon_ibfk_2` FOREIGN KEY (`id_sach`) REFERENCES `sach` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitietmuon`
--

LOCK TABLES `chitietmuon` WRITE;
/*!40000 ALTER TABLE `chitietmuon` DISABLE KEYS */;
INSERT INTO `chitietmuon` VALUES (1,1,9,1,0.00,NULL),(2,2,9,1,0.00,NULL);
/*!40000 ALTER TABLE `chitietmuon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nhaxuatban`
--

DROP TABLE IF EXISTS `nhaxuatban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nhaxuatban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tennxb` varchar(100) NOT NULL,
  `diachi` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nhaxuatban`
--

LOCK TABLES `nhaxuatban` WRITE;
/*!40000 ALTER TABLE `nhaxuatban` DISABLE KEYS */;
/*!40000 ALTER TABLE `nhaxuatban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phieumuon`
--

DROP TABLE IF EXISTS `phieumuon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phieumuon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_thanhvien` int(11) NOT NULL,
  `tongtienphat` decimal(10,2) DEFAULT 0.00,
  `trangthai` enum('choduyet','dangmuon','datra','trathan','dahuy') DEFAULT 'choduyet',
  `phuongthucthanhtoan` varchar(50) DEFAULT NULL,
  `ghichu` text DEFAULT NULL,
  `ngaymuon` date NOT NULL,
  `hantra` date NOT NULL,
  `ngaytra` date DEFAULT NULL,
  `ngaytao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_thanhvien` (`id_thanhvien`),
  CONSTRAINT `phieumuon_ibfk_1` FOREIGN KEY (`id_thanhvien`) REFERENCES `thanhvien` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phieumuon`
--

LOCK TABLES `phieumuon` WRITE;
/*!40000 ALTER TABLE `phieumuon` DISABLE KEYS */;
INSERT INTO `phieumuon` VALUES (1,5,0.00,'choduyet',NULL,NULL,'2025-07-23','2025-07-30',NULL,'2025-07-23 10:27:26'),(2,5,0.00,'choduyet',NULL,NULL,'2025-07-23','2025-07-30',NULL,'2025-07-23 10:28:02');
/*!40000 ALTER TABLE `phieumuon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sach`
--

DROP TABLE IF EXISTS `sach`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tensach` varchar(255) NOT NULL,
  `gia` decimal(10,2) DEFAULT 0.00 COMMENT 'Giá sách (nếu có)',
  `mota` text DEFAULT NULL,
  `anhbia` varchar(255) DEFAULT NULL,
  `theloai` varchar(50) DEFAULT NULL COMMENT 'Giữ nguyên từ category cũ',
  `soluong` int(11) NOT NULL DEFAULT 0 COMMENT 'Số lượng sách hiện có',
  `tacgia` varchar(100) DEFAULT NULL,
  `nhaxuatban` varchar(100) DEFAULT NULL,
  `namxuatban` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `ngaythem` timestamp NOT NULL DEFAULT current_timestamp(),
  `tags` text DEFAULT NULL COMMENT 'Giữ nguyên từ cũ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sach`
--

LOCK TABLES `sach` WRITE;
/*!40000 ALTER TABLE `sach` DISABLE KEYS */;
INSERT INTO `sach` VALUES (9,'QuÃ½ dep trai',0.00,'khong co','1753268180_6880bfd47b228.png','tieu-thuyet',8,'PHi ThÆ°á»ng','KimDoong',2002,NULL,'2025-07-23 10:13:53','hot');
/*!40000 ALTER TABLE `sach` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tacgia`
--

DROP TABLE IF EXISTS `tacgia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tacgia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tentacgia` varchar(100) NOT NULL,
  `tieusu` text DEFAULT NULL,
  `anh` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tacgia`
--

LOCK TABLES `tacgia` WRITE;
/*!40000 ALTER TABLE `tacgia` DISABLE KEYS */;
INSERT INTO `tacgia` VALUES (1,'Nguyen Nhat Anh',NULL,NULL),(2,'Stephen Hawking',NULL,NULL);
/*!40000 ALTER TABLE `tacgia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thanhvien`
--

DROP TABLE IF EXISTS `thanhvien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thanhvien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hoten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `sodienthoai` varchar(20) DEFAULT NULL,
  `diachi` varchar(255) DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `vaitro` enum('docgia','thuthu','quantri') DEFAULT 'docgia',
  `mathe` varchar(20) DEFAULT NULL COMMENT 'Mã thẻ thư viện',
  `ngaytao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thanhvien`
--

LOCK TABLES `thanhvien` WRITE;
/*!40000 ALTER TABLE `thanhvien` DISABLE KEYS */;
INSERT INTO `thanhvien` VALUES (1,'Quan tri vien','admin@thuvien.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',NULL,NULL,NULL,'quantri','TV001','2025-07-23 04:04:02'),(4,'Admin 2','admin2@thuvien.com','$2y$10$kL0UJYhfl0sWiBp8s.lWNePxMv.RKCeHPiWdrLuYrPDTS1Z5fb2VK',NULL,NULL,NULL,'quantri','TV003','2025-07-23 07:31:01'),(5,'Admin','admin123@gmail.com','$2y$10$0ML4NRXJyr2HrqXMi51imesvtpWOZGzrqUJbNzuKCGJvUqyvSCCQS',NULL,NULL,NULL,'quantri',NULL,'2025-07-23 07:42:45'),(7,'khanhgay','khanhgay@gmail.com','$2y$10$WeIyEt.oyR7a/YkRr8GEH.lCrrAOnRanJXOKRHXDdlYaR89ggYGIG','111111111','KiÃªnGiang','2025-07-08','docgia','MB1532','2025-07-23 10:10:18');
/*!40000 ALTER TABLE `thanhvien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `theloai`
--

DROP TABLE IF EXISTS `theloai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `theloai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tentheloai` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `mota` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theloai`
--

LOCK TABLES `theloai` WRITE;
/*!40000 ALTER TABLE `theloai` DISABLE KEYS */;
INSERT INTO `theloai` VALUES (1,'Tieu thuyet','tieu-thuyet',NULL),(2,'Khoa hoc','khoa-hoc',NULL),(3,'Lap trinh','lap-trinh',NULL);
/*!40000 ALTER TABLE `theloai` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-24 12:27:15
