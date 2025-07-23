DROP DATABASE IF EXISTS quanlythuvien;
CREATE DATABASE quanlythuvien;
USE quanlythuvien;

-- 1. BANG THANHVIEN (từ users)
CREATE TABLE `thanhvien` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `hoten` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `matkhau` VARCHAR(255) NOT NULL,
  `sodienthoai` VARCHAR(20),
  `diachi` VARCHAR(255),
  `ngaysinh` DATE,
  `vaitro` ENUM('docgia','thuthu','quantri') DEFAULT 'docgia',
  `mathe` VARCHAR(20) COMMENT 'Mã thẻ thư viện',
  `ngaytao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. BANG SACH (từ products)
CREATE TABLE `sach` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tensach` VARCHAR(255) NOT NULL,
  `gia` DECIMAL(10,2) DEFAULT 0 COMMENT 'Giá sách (nếu có)',
  `mota` TEXT,
  `anhbia` VARCHAR(255),
  `theloai` VARCHAR(50) COMMENT 'Giữ nguyên từ category cũ',
  `soluong` INT NOT NULL DEFAULT 0 COMMENT 'Số lượng sách hiện có',
  `tacgia` VARCHAR(100),
  `nhaxuatban` VARCHAR(100),
  `namxuatban` INT,
  `isbn` VARCHAR(20),
  `ngaythem` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `tags` TEXT COMMENT 'Giữ nguyên từ cũ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. BANG PHIEUMUON (từ orders)
CREATE TABLE `phieumuon` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_thanhvien` INT NOT NULL,
  `tongtienphat` DECIMAL(10,2) DEFAULT 0,
  `trangthai` ENUM('choduyet','dangmuon','datra','trathan','dahuy') DEFAULT 'choduyet',
  `phuongthucthanhtoan` VARCHAR(50),
  `ghichu` TEXT,
  `ngaymuon` DATE NOT NULL,
  `hantra` DATE NOT NULL,
  `ngaytra` DATE,
  `ngaytao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_thanhvien`) REFERENCES `thanhvien`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. BANG CHITIETMUON (từ order_items)
CREATE TABLE `chitietmuon` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_phieumuon` INT NOT NULL,
  `id_sach` INT NOT NULL,
  `soluong` INT NOT NULL DEFAULT 1,
  `giaphat` DECIMAL(10,2) DEFAULT 0 COMMENT 'Tiền phạt nếu có',
  `tinhtrangtra` VARCHAR(50) COMMENT 'Tình trạng sách khi trả',
  FOREIGN KEY (`id_phieumuon`) REFERENCES `phieumuon`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_sach`) REFERENCES `sach`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. BANG BANNER (giữ nguyên)
CREATE TABLE `banner` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tieude` VARCHAR(255) NOT NULL,
  `anh` VARCHAR(255) NOT NULL,
  `lienket` VARCHAR(255) NOT NULL,
  `ngaytao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. BANG THELOAI (mở rộng từ category cũ)
CREATE TABLE `theloai` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tentheloai` VARCHAR(50) NOT NULL,
  `slug` VARCHAR(50) NOT NULL,
  `mota` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. BANG TACGIA
CREATE TABLE `tacgia` (
`id` INT AUTO_INCREMENT PRIMARY KEY,
  `tentacgia` VARCHAR(100) NOT NULL,
  `tieusu` TEXT,
  `anh` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. BANG NHAXUATBAN
CREATE TABLE `nhaxuatban` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tennxb` VARCHAR(100) NOT NULL,
  `diachi` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu
INSERT INTO `thanhvien` (`id`, `hoten`, `email`, `matkhau`, `vaitro`, `mathe`) VALUES
(1, 'Quan tri vien', 'admin@thuvien.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'quantri', 'TV001'),
(2, 'Nguyen Van A', 'nguyenvana@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docgia', 'TV002');

INSERT INTO `theloai` (`id`, `tentheloai`, `slug`) VALUES
(1, 'Tieu thuyet', 'tieu-thuyet'),
(2, 'Khoa hoc', 'khoa-hoc'),
(3, 'Lap trinh', 'lap-trinh');

INSERT INTO `tacgia` (`id`, `tentacgia`) VALUES
(1, 'Nguyen Nhat Anh'),
(2, 'Stephen Hawking');

INSERT INTO `sach` (`id`, `tensach`, `mota`, `soluong`, `tacgia`, `nhaxuatban`, `namxuatban`, `theloai`) VALUES
(1, 'Cho toi xin mot ve di tuoi tho', 'Tac pham noi tieng cua Nguyen Nhat Anh', 5, 'Nguyen Nhat Anh', 'NXB Tre', 2008, 'tieu-thuyet'),
(2, 'Vu tru trong vo hat de', 'Gioi thieu ve vu tru hoc', 3, 'Stephen Hawking', 'NXB Khoa hoc', 2001, 'khoa-hoc');

-- Các stored procedure và function quan trọng
DELIMITER //

-- Function kiểm tra số sách còn lại
CREATE FUNCTION kiem_tra_sach_con(id_sach INT) 
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE soluong_con INT;
    SELECT soluong INTO soluong_con FROM sach WHERE id = id_sach;
    RETURN soluong_con;
END //

-- Trigger tính phạt trễ hạn
CREATE TRIGGER tinh_phat_tre
BEFORE UPDATE ON phieumuon
FOR EACH ROW
BEGIN
    IF NEW.trangthai = 'trathan' AND NEW.ngaytra > NEW.hantra THEN
        SET NEW.tongtienphat = DATEDIFF(NEW.ngaytra, NEW.hantra) * 5000; -- 5k/ngày
    END IF;
END //

-- Procedure thống kê sách mượn
CREATE PROCEDURE thong_ke_muon_trong_thang(IN thang INT, IN nam INT)
BEGIN
    SELECT s.tensach, COUNT(*) AS soluotmuon
    FROM chitietmuon cm
    JOIN sach s ON cm.id_sach = s.id
    JOIN phieumuon pm ON cm.id_phieumuon = pm.id
    WHERE MONTH(pm.ngaymuon) = thang AND YEAR(pm.ngaymuon) = nam
    GROUP BY s.id
    ORDER BY soluotmuon DESC;
END //



DELIMITER ;