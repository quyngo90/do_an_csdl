<?php
require_once __DIR__ . '/../models/Cart.php';

class CartController {
    public function index() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn chưa đăng nhập. Vui lòng <a href='/login'>đăng nhập</a> trước.";
            return; // Hoặc exit
        }

        // Lấy dữ liệu giỏ hàng của user
        $cartItems = Cart::getItems();

        // Tính tổng tiền
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['product']->price * $item['quantity'];
        }

        // Truyền $total sang view nếu muốn hiển thị
        include_once __DIR__ . '/../views/cart.php';
    }

    public function add($productId) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn chưa đăng nhập. Vui lòng <a href='/login'>đăng nhập</a> trước.";
            return;
        }

        // Thêm sản phẩm vào giỏ
        Cart::addItem($productId);
        header('Location: /cart');
    }

    public function remove($productId) {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn chưa đăng nhập. Vui lòng <a href='/login'>đăng nhập</a> trước.";
            return;
        }

        Cart::removeItem($productId);
        header('Location: /cart');
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn chưa đăng nhập. Vui lòng <a href='/login'>đăng nhập</a> trước.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity  = $_POST['quantity']  ?? null;
            if ($productId && $quantity !== null) {
                Cart::updateItem($productId, (int)$quantity);
            }
        }
        header('Location: /cart');
        exit;
    }
}
