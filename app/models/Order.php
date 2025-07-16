<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/OrderItem.php';

class Order {
    public $id;
    public $user_id;
    public $total;
    public $created_at;
    public $items;            // Mảng các order items
    public $user_name;        // Tên người dùng (được JOIN từ bảng users)
    public $user_phone;       // Số điện thoại người dùng (được JOIN từ bảng users)
    public $shipping_address; // Địa chỉ nhận hàng
    public $status;           // Trạng thái đơn hàng
    public $payment_method;   // Phương thức thanh toán

    public function __construct($data) {
        $this->user_id          = $data['user_id'] ?? null;
        $this->total            = $data['total'] ?? 0;
        $this->items            = $data['items'] ?? [];
        $this->user_name        = $data['user_name'] ?? '';
        $this->user_phone       = $data['user_phone'] ?? '';
        $this->shipping_address = $data['shipping_address'] ?? '';
        $this->status           = $data['status'] ?? 'Đang duyệt';
        $this->payment_method   = $data['payment_method'] ?? 'Thanh toán khi nhận hàng';
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        // Chèn thêm cột payment_method vào câu lệnh INSERT
        $stmt = $db->prepare("INSERT INTO orders (user_id, total, shipping_address, status, payment_method) VALUES (:user_id, :total, :shipping_address, :status, :payment_method)");
        $stmt->bindValue(':user_id', $this->user_id);
        $stmt->bindValue(':total', $this->total);
        $stmt->bindValue(':shipping_address', $this->shipping_address);
        $stmt->bindValue(':status', $this->status);
        $stmt->bindValue(':payment_method', $this->payment_method);
        if ($stmt->execute()) {
            $this->id = $db->lastInsertId();
            foreach ($this->items as $item) {
                OrderItem::create([
                    'order_id'   => $this->id,
                    'product_id' => $item['product']->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['product']->price
                ]);
            }
            return true;
        }
        return false;
    }

    public static function all() {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT o.*, u.name AS user_name, u.phone AS user_phone
                FROM orders o
                JOIN users u ON o.user_id = u.id
                ORDER BY o.created_at DESC";
        $stmt = $db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];
        foreach ($rows as $row) {
            $order = new Order($row);
            $order->id = $row['id'];
            $order->created_at = $row['created_at'];
            $orders[] = $order;
        }
        return $orders;
    }

    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT o.*, u.name AS user_name, u.phone AS user_phone
                FROM orders o
                JOIN users u ON o.user_id = u.id
                WHERE o.id = ? LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $orderData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($orderData) {
            $orderData['items'] = OrderItem::getByOrderId($orderData['id']);
            $order = new Order($orderData);
            $order->id = $orderData['id'];
            $order->created_at = $orderData['created_at'];
            return $order;
        }
        return null;
    }

    public static function getByUserId($userId) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT o.*, u.name AS user_name, u.phone AS user_phone
                FROM orders o
                JOIN users u ON o.user_id = u.id
                WHERE o.user_id = ?
                ORDER BY o.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];
        foreach ($rows as $row) {
            $orderData = $row;
            $orderData['items'] = OrderItem::getByOrderId($row['id']);
            $order = new Order($orderData);
            $order->id = $row['id'];
            $order->created_at = $row['created_at'];
            $orders[] = $order;
        }
        return $orders;
    }

    // Phương thức cập nhật trạng thái đơn hàng (vẫn giữ nguyên cho các thao tác khác)
    public static function updateStatus($id, $status) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE orders SET status = :status WHERE id = :id");
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
