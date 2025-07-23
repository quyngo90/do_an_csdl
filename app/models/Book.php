<?php
require_once __DIR__ . '/../../config/database.php';

class Book {
    public $id;
    public $tensach;
    public $gia;
    public $mota;
    public $anhbia;
    public $soluong;
    public $theloai;
    public $tacgia;
    public $nhaxuatban;
    public $namxuatban;
    public $tags;
    public $ngaythem;

    public function __construct($id, $tensach, $gia, $mota, $anhbia, $soluong = 0, $theloai = null, $tacgia = '', $nhaxuatban = '', $namxuatban = null, $tags = '', $ngaythem = null) {
        $this->id = $id;
        $this->tensach = $tensach;
        $this->gia = $gia;
        $this->mota = $mota;
        $this->anhbia = $anhbia;
        $this->soluong = $soluong;
        $this->theloai = $theloai;
        $this->tacgia = $tacgia;
        $this->nhaxuatban = $nhaxuatban;
        $this->namxuatban = $namxuatban;
        $this->tags = $tags;
        $this->ngaythem = $ngaythem;
    }

    public static function all() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM sach ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        foreach ($rows as $row) {
            $books[] = new Book(
                $row['id'],
                $row['tensach'],
                $row['gia'],
                $row['mota'],
                $row['anhbia'],
                $row['soluong'],
                $row['theloai'],
                $row['tacgia'],
                $row['nhaxuatban'],
                $row['namxuatban'],
                $row['tags'] ?? '',
                $row['ngaythem'] ?? null
            );
        }
        return $books;
    }

    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM sach WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Book(
                $row['id'],
                $row['tensach'],
                $row['gia'],
                $row['mota'],
                $row['anhbia'],
                $row['soluong'],
                $row['theloai'],
                $row['tacgia'],
                $row['nhaxuatban'],
                $row['namxuatban'],
                $row['tags'] ?? '',
                $row['ngaythem'] ?? null
            );
        }
        return null;
    }

    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO sach (tensach, gia, mota, anhbia, soluong, theloai, tacgia, nhaxuatban, namxuatban, tags) 
                              VALUES (:tensach, :gia, :mota, :anhbia, :soluong, :theloai, :tacgia, :nhaxuatban, :namxuatban, :tags)");
        $stmt->bindValue(':tensach', $data['tensach']);
        $stmt->bindValue(':gia', $data['gia'] ?? 0);
        $stmt->bindValue(':mota', $data['mota'] ?? '');
        $stmt->bindValue(':anhbia', $data['anhbia'] ?? '');
        $stmt->bindValue(':soluong', $data['soluong'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(':theloai', $data['theloai'] ?? null);
        $stmt->bindValue(':tacgia', $data['tacgia'] ?? '');
        $stmt->bindValue(':nhaxuatban', $data['nhaxuatban'] ?? '');
        $stmt->bindValue(':namxuatban', $data['namxuatban'] ?? null);
        $stmt->bindValue(':tags', $data['tags'] ?? '');
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE sach 
                              SET tensach = :tensach, gia = :gia, mota = :mota, anhbia = :anhbia, 
                                  soluong = :soluong, theloai = :theloai, tacgia = :tacgia, 
                                  nhaxuatban = :nhaxuatban, namxuatban = :namxuatban, tags = :tags
                              WHERE id = :id");
        $stmt->bindValue(':tensach', $data['tensach']);
        $stmt->bindValue(':gia', $data['gia'] ?? 0);
        $stmt->bindValue(':mota', $data['mota'] ?? '');
        $stmt->bindValue(':anhbia', $data['anhbia'] ?? '');
        $stmt->bindValue(':soluong', $data['soluong'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(':theloai', $data['theloai'] ?? null);
        $stmt->bindValue(':tacgia', $data['tacgia'] ?? '');
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

    public static function getByCategory($theloai) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM sach WHERE theloai = :theloai ORDER BY id DESC");
        $stmt->bindValue(':theloai', $theloai, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $books = [];
        foreach ($rows as $row) {
            $books[] = new Book(
                $row['id'],
                $row['tensach'],
                $row['gia'],
                $row['mota'],
                $row['anhbia'],
                $row['soluong'],
                $row['theloai'],
                $row['tacgia'],
                $row['nhaxuatban'],
                $row['namxuatban'],
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
?>