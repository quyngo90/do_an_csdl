	drop database if exists quanlythuvien;
	CREATE DATABASE quanlythuvien;
	USE quanlythuvien;

	-- 1. BANG THANHVIEN (từ users)
	DROP TABLE IF EXISTS `thanhvien`;
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
	DROP TABLE IF EXISTS `sach`;

	CREATE TABLE `sach` (
	  `id` INT AUTO_INCREMENT PRIMARY KEY,
	  `tensach` VARCHAR(255) NOT NULL,
	  `mota` TEXT,
	  `theloai_id` INT,       -- KHÓA NGOẠI TỚI bảng theloai
	  `soluong` INT NOT NULL DEFAULT 0 COMMENT 'Số lượng sách hiện có',
	  `tacgia_id` INT,        -- KHÓA NGOẠI TỚI bảng tacgia
	  `nhaxuatban` VARCHAR(100),
	  `namxuatban` INT,
	  `isbn` VARCHAR(20),
	  `ngaythem` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	  `tags` TEXT COMMENT 'Giữ nguyên từ cũ',
	  
	  CONSTRAINT fk_sach_theloai FOREIGN KEY (`theloai_id`) REFERENCES `theloai`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	  CONSTRAINT fk_sach_tacgia FOREIGN KEY (`tacgia_id`) REFERENCES `tacgia`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


	-- 3. BANG PHIEUMUON (từ orders)
	DROP TABLE IF EXISTS `phieumuon`;
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
	DROP TABLE IF EXISTS `chitietmuon`;
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
	DROP TABLE IF EXISTS `banner`;
	CREATE TABLE `banner` (
	  `id` INT AUTO_INCREMENT PRIMARY KEY,
	  `tieude` VARCHAR(255) NOT NULL,
	  `anh` VARCHAR(255) NOT NULL,
	  `lienket` VARCHAR(255) NOT NULL,
	  `ngaytao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

	-- 6. BANG THELOAI (mở rộng từ category cũ)
	DROP TABLE IF EXISTS `theloai`;
	CREATE TABLE `theloai` (
	  `id` INT AUTO_INCREMENT PRIMARY KEY,
	  `tentheloai` VARCHAR(50) NOT NULL,
	  `slug` VARCHAR(50) NOT NULL,
	  `mota` TEXT
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

	-- 7. BANG TACGIA
	DROP TABLE IF EXISTS `tacgia`;
	CREATE TABLE `tacgia` (
	  `id` INT AUTO_INCREMENT PRIMARY KEY,
	  `tentacgia` VARCHAR(100) NOT NULL,
	  `tieusu` TEXT,
	  `anh` VARCHAR(255)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


	-- Thêm dữ liệu mẫu
	INSERT INTO `thanhvien` (`id`, `hoten`, `email`, `matkhau`, `vaitro`, `mathe`) VALUES
	(1, 'Quan tri vien', 'admin@thuvien.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'quantri', 'TV001'),
	(2, 'Nguyen Van A', 'nguyenvana@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docgia', 'TV002');

	INSERT INTO `theloai` (`id`, `tentheloai`, `slug`) VALUES
	(1, 'Tieu thuyet', 'tieu-thuyet'),
	(2, 'Khoa hoc', 'khoa-hoc'),
	(3, 'Lap trinh', 'lap-trinh'),
	(4, 'Giao duc', 'giao-duc'),
	(5, 'Van hoc', 'van-hoc'),
	(6, 'Thieu nhi', 'thieu-nhi'),
	(7, 'Kinh doanh', 'kinh-doanh'),
	(8, 'Trinh tham', 'trinh-tham'),
	(9, 'Co dien', 'co-dien');

	INSERT INTO `tacgia` (`id`, `tentacgia`) VALUES
	(1, 'Nguyen Nhat Anh'),
	(2, 'Stephen Hawking'),
	(3, 'J.K. Rowling'),
	(4, 'Agatha Christie'),
	(5, 'Mark Twain'),
	(6, 'Jane Austen'),
	(7, 'George Orwell'),
	(8, 'Ernest Hemingway'),
	(9, 'F. Scott Fitzgerald');

	INSERT INTO `sach`
	(`id`, `tensach`, `mota`, `theloai_id`, `soluong`, `tacgia_id`, `nhaxuatban`, `namxuatban`, `isbn`, `ngaythem`, `tags`) VALUES
	(15, 'Step forward.', 'Stories of love, loss, and redemption.', 1, 23, 1, 'NXB Tre', 2008, '7703598170386', '2025-07-24 05:48:16', 'hot'),
	(16, 'Shadow light.', 'A thrilling mystery full of twists.', 2, 2, 2, 'NXB Van Hoc', 2004, '3142415575163', '2025-07-24 05:48:16', 'moi'),
	(17, 'Step forward.', 'Insights into the human condition.', 1, 29, 3, 'NXB Giao Duc', 1991, '6085660952650', '2025-07-24 05:48:16', 'moi'),
	(18, 'Mind open.', 'Discovering hidden truths of the universe.', 3, 25, 4, 'NXB Kim Dong', 1994, '6239911999223', '2025-07-24 05:48:16', 'hot'),
	(19, 'Step forward.', 'Stories of love, loss, and redemption.', 2, 1, 5, 'NXB Kim Dong', 2010, '0261568636982', '2025-07-24 05:48:16', 'hot'),
	(20, 'Heart secret.', 'Thoughts and reflections on modern life.', 1, 18, 6, 'NXB Van Hoc', 1994, '4669839723477', '2025-07-24 05:48:16', 'moi'),
	(21, 'Sky limit.', 'Thoughts and reflections on modern life.', 4, 18, 7, 'NXB Giao Duc', 2007, '0578483686258', '2025-07-24 05:48:16', 'hot'),
	(22, 'Shadow light.', 'Insights into the human condition.', 5, 6, 2, 'NXB Kim Dong', 2023, '9270064422347', '2025-07-24 05:48:16', 'hot'),
	(23, 'Mind open.', 'A journey through unknown paths.', 1, 16, 7, 'NXB Giao Duc', 2006, '6845683965752', '2025-07-24 05:48:16', 'hot'),
	(24, 'Mind open.', 'Thoughts and reflections on modern life.', 2, 1, 1, 'NXB Tre', 1989, '6181159719982', '2025-07-24 05:48:16', 'moi');
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

	INSERT INTO thanhvien (email, matkhau, hoten, vaitro)
	VALUES (
		'admin111@gmail.com',
		'$2y$10$hms6lmotn2t4D7PADAXtZefMNEuoUhMLiWAU678oNYdrl1poHJc7S',
		'Admin',
		'quantri'
	);	