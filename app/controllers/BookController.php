<?php
class Book {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách sách kèm tên tác giả và thể loại
    public function getAllWithDetails() {
        $query = "
            SELECT 
                sach.*,
                theloai.tentheloai,
                tacgia.tentacgia
            FROM sach
            LEFT JOIN theloai ON sach.theloai_id = theloai.id
            LEFT JOIN tacgia ON sach.tacgia_id = tacgia.id
            ORDER BY sach.tensach ASC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 cuốn sách theo ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM sach WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sách mới
    public function create($data) {
        $query = "INSERT INTO sach (tensach, mota, theloai_id, soluong, tacgia_id, nhaxuatban, namxuatban, isbn, tags) 
                  VALUES (:tensach, :mota, :theloai_id, :soluong, :tacgia_id, :nhaxuatban, :namxuatban, :isbn, :tags)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    // Cập nhật sách
    public function update($id, $data) {
        $data['id'] = $id;
        $query = "UPDATE sach 
                  SET tensach = :tensach, mota = :mota, theloai_id = :theloai_id, soluong = :soluong, 
                      tacgia_id = :tacgia_id, nhaxuatban = :nhaxuatban, namxuatban = :namxuatban, 
                      isbn = :isbn, tags = :tags
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    // Xóa sách
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM sach WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
