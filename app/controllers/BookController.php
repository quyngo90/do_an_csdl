<?php
require_once __DIR__ . '/../models/Book.php';

class BookController {
    public function index() {
        if (isset($_GET['theloai']) && !empty($_GET['theloai'])) {
            $theloai = $_GET['theloai'];
            $books = Book::getByCategory($theloai);
        } else {
            $books = Book::all();
        }
        include_once __DIR__ . '/../views/products.php';
    }
    
    public function detail($id) {
        $book = Book::find($id);
        include_once __DIR__ . '/../views/product-detail.php';
    }
    
    public function search() {
        $keyword = $_GET['q'] ?? '';
        $tags = [];
        if (isset($_GET['tags']) && !empty($_GET['tags'])) {
            $tags = is_array($_GET['tags']) ? $_GET['tags'] : explode(',', $_GET['tags']);
        }
        
        // Tạm thời giữ nguyên logic search cũ
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM sach WHERE tensach LIKE :keyword";
        $params = [':keyword' => "%$keyword%"];
        
        if (!empty($tags)) {
            foreach ($tags as $i => $tag) {
                if (!empty($tag)) {
                    $sql .= " AND tags LIKE :tag$i";
                    $params[":tag$i"] = "%$tag%";
                }
            }
        }
        
        $sql .= " ORDER BY id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
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
        include_once __DIR__ . '/../views/products.php';
    }
}
?>