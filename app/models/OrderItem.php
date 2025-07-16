<?php
require_once __DIR__ . '/../../config/database.php';

class OrderItem {
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->bindValue(':order_id', $data['order_id']);
        $stmt->bindValue(':product_id', $data['product_id']);
        $stmt->bindValue(':quantity', $data['quantity']);
        $stmt->bindValue(':price', $data['price']);
        return $stmt->execute();
    }
    
    public static function getByOrderId($order_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT oi.*, p.name AS product_name
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
