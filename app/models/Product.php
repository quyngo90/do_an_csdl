<?php
require_once __DIR__ . '/../../config/database.php';

class Product {
    public $id;
    public $name;
    public $price;
    public $description;
    public $image;
    public $quantity;
    public $category;
    public $created_at;
    public $tags; // Lưu các tag dưới dạng chuỗi, ví dụ: "hot, sale, new"

    // Cập nhật constructor để bao gồm tags (mặc định là chuỗi rỗng)
    public function __construct($id, $name, $price, $description, $image, $quantity = 0, $category = null, $created_at = null, $tags = '') {
        $this->id          = $id;
        $this->name        = $name;
        $this->price       = $price;
        $this->description = $description;
        $this->image       = $image;
        $this->quantity    = $quantity;
        $this->category    = $category;
        $this->created_at  = $created_at;
        $this->tags        = $tags;
    }

    // Lấy tất cả sản phẩm
    public static function all() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM products ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($rows as $row) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'],
                $row['image'],
                $row['quantity'],
                $row['category'] ?? null,
                $row['created_at'] ?? null,
                $row['tags'] ?? ''
            );
        }
        return $products;
    }

    // Tìm sản phẩm theo ID
    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'],
                $row['image'],
                $row['quantity'],
                $row['category'] ?? null,
                $row['created_at'] ?? null,
                $row['tags'] ?? ''
            );
        }
        return null;
    }

    // Tạo mới sản phẩm (Create)
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO products (name, price, description, image, category, quantity, tags) 
                              VALUES (:name, :price, :description, :image, :category, :quantity, :tags)");
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':image', $data['image']);
        $stmt->bindValue(':category', $data['category'] ?? null);
        $stmt->bindValue(':quantity', $data['quantity'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(':tags', $data['tags'] ?? '');
        $stmt->execute();
        return $db->lastInsertId();
    }

    // Cập nhật sản phẩm (Update)
    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE products 
                              SET name = :name, price = :price, description = :description, image = :image, category = :category, quantity = :quantity, tags = :tags
                              WHERE id = :id");
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':image', $data['image']);
        $stmt->bindValue(':category', $data['category'] ?? null);
        $stmt->bindValue(':quantity', $data['quantity'] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(':tags', $data['tags'] ?? '');
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa sản phẩm (Delete)
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Tìm sản phẩm theo tên
    public static function searchByName($keyword) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM products WHERE name LIKE :keyword ORDER BY id DESC");
        $stmt->bindValue(':keyword', "%{$keyword}%", PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($rows as $row) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'],
                $row['image'],
                $row['quantity'],
                $row['category'] ?? null,
                $row['created_at'] ?? null,
                $row['tags'] ?? ''
            );
        }
        return $products;
    }

    // Lấy sản phẩm theo danh mục (vẫn giữ nguyên)
    public static function getByCategory($category) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM products WHERE category = :category ORDER BY id DESC");
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($rows as $row) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'],
                $row['image'],
                $row['quantity'],
                $row['category'] ?? null,
                $row['created_at'] ?? null,
                $row['tags'] ?? ''
            );
        }
        return $products;
    }

    // Phương thức tìm kiếm nâng cao: theo từ khóa, tag và khoảng giá
    public static function searchAdvanced($keyword, $tags, $minPrice, $maxPrice) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM products WHERE 1=1 ";
        $params = [];
        if ($keyword != '') {
            $sql .= " AND name LIKE :keyword ";
            $params[':keyword'] = "%$keyword%";
        }
        if (!empty($tags)) {
            // Với mỗi tag, thêm điều kiện tìm kiếm
            foreach ($tags as $i => $tag) {
                if (!empty($tag)) {
                    $sql .= " AND tags LIKE :tag$i ";
                    $params[":tag$i"] = "%$tag%";
                }
            }
        }
        $sql .= " AND price BETWEEN :minPrice AND :maxPrice ";
        $params[':minPrice'] = $minPrice;
        $params[':maxPrice'] = $maxPrice;
        $sql .= " ORDER BY id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($rows as $row) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['price'],
                $row['description'],
                $row['image'],
                $row['quantity'],
                $row['category'] ?? null,
                $row['created_at'] ?? null,
                $row['tags'] ?? ''
            );
        }
        return $products;
    }

    // Giảm số lượng sản phẩm khi đặt hàng thành công
    public static function decreaseQuantity($id, $amount) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE products SET quantity = quantity - :amount WHERE id = :id AND quantity >= :amount");
        $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
