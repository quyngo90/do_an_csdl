<?php
// /app/models/Banner.php
require_once __DIR__ . '/../../config/database.php';

class Banner {
    public $id;
    public $title;
    public $image;
    public $link;
    public $created_at;

    public function __construct($data) {
        $this->id         = $data['id'] ?? null;
        $this->title      = $data['title'] ?? '';
        $this->image      = $data['image'] ?? '';
        $this->link       = $data['link'] ?? '';
        $this->created_at = $data['created_at'] ?? null;
    }

    // Lấy tất cả banner
    public static function all() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM banners ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $banners = [];
        foreach ($rows as $row) {
            $banners[] = new Banner($row);
        }
        return $banners;
    }

    // Tìm banner theo ID
    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM banners WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Banner($row);
        }
        return null;
    }

    // Tạo mới banner
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO banners (title, image, link) VALUES (:title, :image, :link)");
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':image', $data['image']);
        $stmt->bindValue(':link', $data['link']);
        $stmt->execute();
        return $db->lastInsertId();
    }

    // Cập nhật banner
    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE banners SET title = :title, image = :image, link = :link WHERE id = :id");
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':image', $data['image']);
        $stmt->bindValue(':link', $data['link']);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xoá banner
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM banners WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
