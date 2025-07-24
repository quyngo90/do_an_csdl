<?php
namespace App\Models;
use \PDO;
require_once __DIR__ . '/../../config/database.php';
use \Database; // <- thêm dòng này để gọi đúng class Database ngoài namespace

class Book {
    public $id;
    public $tensach;
    public $mota;
    public $soluong;
    public $theloai_id;
    public $tacgia_id;
    public $nhaxuatban;
    public $namxuatban;
    public $tags;
    public $ngaythem;

    public $tentheloai; // từ bảng theloai
    public $tentacgia;  // từ bảng tacgia

    public function __construct($id, $tensach, $mota, $soluong = 0, $theloai_id = null, $tacgia_id = null, $nhaxuatban = '', $namxuatban = null, $tags = '', $ngaythem = null, $tentheloai = null, $tentacgia = null) {
        $this->id = $id;
        $this->tensach = $tensach;
        $this->mota = $mota;
        $this->soluong = $soluong;
        $this->theloai_id = $theloai_id;
        $this->tacgia_id  = $tacgia_id;
        $this->nhaxuatban = $nhaxuatban;
        $this->namxuatban = $namxuatban;
        $this->tags = $tags;
        $this->ngaythem = $ngaythem;
        $this->tentheloai = $tentheloai;
        $this->tentacgia = $tentacgia;
    }

    public static function getWithDetails() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT sach.*, 
                   theloai.tentheloai, 
                   tacgia.tentacgia
            FROM sach
            LEFT JOIN theloai ON sach.theloai_id = theloai.id
            LEFT JOIN tacgia ON sach.tacgia_id = tacgia.id
            ORDER BY sach.id DESC
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        foreach ($rows as $row) {
            $books[] = new Book(
                $row['id'],
                $row['tensach'],
                $row['mota'],
                $row['soluong'] ?? 0,
                $row['theloai_id'] ?? null,
                $row['tacgia_id'] ?? null,
                $row['nhaxuatban'] ?? '',
                $row['namxuatban'] ?? null,
                $row['tags'] ?? '',
                $row['ngaythem'] ?? null,
                $row['tentheloai'] ?? null,
                $row['tentacgia'] ?? null
            );
        }
        return $books;
    }

    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT sach.*, theloai.tentheloai, tacgia.tentacgia
            FROM sach
            LEFT JOIN theloai ON sach.theloai_id = theloai.id
            LEFT JOIN tacgia ON sach.tacgia_id = tacgia.id
            WHERE sach.id = :id
        ");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Book(
                $row['id'],
                $row['tensach'],
                $row['mota'],
                $row['soluong'] ?? 0,
                $row['theloai_id'] ?? null,
                $row['tacgia_id'] ?? null,
                $row['nhaxuatban'] ?? '',
                $row['namxuatban'] ?? null,
                $row['tags'] ?? '',
                $row['ngaythem'] ?? null,
                $row['tentheloai'] ?? null,
                $row['tentacgia'] ?? null
            );
        }
        return null;
    }

    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO sach (tensach, mota, soluong, theloai_id, tacgia_id, nhaxuatban, namxuatban, tags)
            VALUES (:tensach, :mota, :soluong, :theloai_id, :tacgia_id, :nhaxuatban, :namxuatban, :tags)
        ");
        $stmt->bindValue(':tensach', $data['tensach']);
        $stmt->bindValue(':mota', $data['mota'] ?? '');
        $stmt->bindValue(':soluong', $data['soluong'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(':theloai_id', $data['theloai_id'] ?? null);
        $stmt->bindValue(':tacgia_id', $data['tacgia_id'] ?? null);
        $stmt->bindValue(':nhaxuatban', $data['nhaxuatban'] ?? '');
        $stmt->bindValue(':namxuatban', $data['namxuatban'] ?? null);
        $stmt->bindValue(':tags', $data['tags'] ?? '');
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            UPDATE sach SET 
                tensach = :tensach, mota = :mota, soluong = :soluong,
                theloai_id = :theloai_id, tacgia_id = :tacgia_id,
                nhaxuatban = :nhaxuatban, namxuatban = :namxuatban, tags = :tags
            WHERE id = :id
        ");
        $stmt->bindValue(':tensach', $data['tensach']);
        $stmt->bindValue(':mota', $data['mota'] ?? '');
        $stmt->bindValue(':soluong', $data['soluong'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(':theloai_id', $data['theloai_id'] ?? null);
        $stmt->bindValue(':tacgia_id', $data['tacgia_id'] ?? null);
        $stmt->bindValue(':nhaxuatban', $data['nhaxuatban'] ?? '');
        $stmt->bindValue(':namxuatban', $data['namxuatban'] ?? null);
        $stmt->bindValue(':tags', $data['tags'] ?? '');
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM sach WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function getByCategory($theloai_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM sach WHERE theloai_id = :theloai_id ORDER BY id DESC");
        $stmt->bindValue(':theloai_id', $theloai_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        foreach ($rows as $row) {
            $books[] = new Book(
                $row['id'],
                $row['tensach'],
                $row['mota'],
                $row['soluong'] ?? 0,
                $row['theloai_id'] ?? null,
                $row['tacgia_id'] ?? null,
                $row['nhaxuatban'] ?? '',
                $row['namxuatban'] ?? null,
                $row['tags'] ?? '',
                $row['ngaythem'] ?? null
            );
        }
        return $books;
    }

    public static function decreaseQuantity($id, $amount) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE sach SET soluong = soluong - :amount WHERE id = :id AND soluong >= :amount");
        $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
