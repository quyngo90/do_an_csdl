<?php
require_once __DIR__ . '/Book.php';

class Cart {
    // Lấy danh sách sản phẩm trong giỏ hàng của user hiện tại
    public static function getItems() {
        // Nếu chưa đăng nhập thì trả về mảng rỗng
        if (!isset($_SESSION['user_id'])) {
            return [];
        }

        $userId = $_SESSION['user_id'];
        // Nếu chưa có giỏ cho user này, trả về rỗng
        if (!isset($_SESSION['cart'][$userId]) || empty($_SESSION['cart'][$userId])) {
            return [];
        }

        $items = [];
        // $_SESSION['cart'][$userId] có dạng: [ productId => quantity, ... ]
        foreach ($_SESSION['cart'][$userId] as $productId => $quantity) {
            // Tìm sản phẩm trong DB
            $product = Product::find($productId);
            if ($product) {
                $items[] = [
                    'product'  => $product,
                    'quantity' => $quantity
                ];
            }
        }
        return $items;
    }

    // Thêm sản phẩm vào giỏ
    public static function addItem($productId) {
        // Nếu chưa đăng nhập thì không làm gì, có thể ném exception hoặc return false
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $userId = $_SESSION['user_id'];

        // Khởi tạo mảng giỏ cho user nếu chưa có
        if (!isset($_SESSION['cart'][$userId])) {
            $_SESSION['cart'][$userId] = [];
        }

        // Nếu đã có productId này, tăng số lượng
        if (isset($_SESSION['cart'][$userId][$productId])) {
            $_SESSION['cart'][$userId][$productId]++;
        } else {
            // Ngược lại, gán số lượng ban đầu = 1
            $_SESSION['cart'][$userId][$productId] = 1;
        }
        return true;
    }

    // Xóa hẳn 1 sản phẩm khỏi giỏ
    public static function removeItem($productId) {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $userId = $_SESSION['user_id'];

        if (isset($_SESSION['cart'][$userId][$productId])) {
            unset($_SESSION['cart'][$userId][$productId]);
        }
        return true;
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public static function updateItem($productId, $quantity) {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $userId = $_SESSION['user_id'];

        // Nếu số lượng <= 0, coi như xóa
        if ($quantity <= 0) {
            self::removeItem($productId);
        } else {
            $_SESSION['cart'][$userId][$productId] = $quantity;
        }
        return true;
    }

    // Xóa toàn bộ giỏ hàng của user
    public static function clear() {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $userId = $_SESSION['user_id'];
        unset($_SESSION['cart'][$userId]);
        return true;
    }
}
