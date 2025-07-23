<?php
require_once __DIR__ . '/../models/Book.php';

class CartController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xem danh sách mượn sách";
            header('Location: /login');
            exit;
        }

        $cartItems = $this->getItems();
        include_once __DIR__ . '/../views/cart.php';
    }

    public function add($bookId) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thêm sách vào danh sách mượn";
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        
        // Kiểm tra số lượng sách còn lại
        $book = Book::find($bookId);
        if (!$book || $book->soluong <= 0) {
            $_SESSION['error'] = "Sách này hiện không có sẵn trong thư viện";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if (!isset($_SESSION['cart'][$userId])) {
            $_SESSION['cart'][$userId] = [];
        }

        if (isset($_SESSION['cart'][$userId][$bookId])) {
            $_SESSION['cart'][$userId][$bookId]++;
        } else {
            $_SESSION['cart'][$userId][$bookId] = 1;
        }

        $_SESSION['success'] = "Đã thêm sách vào danh sách mượn";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function remove($bookId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        if (isset($_SESSION['cart'][$userId][$bookId])) {
            unset($_SESSION['cart'][$userId][$bookId]);
            $_SESSION['success'] = "Đã xóa sách khỏi danh sách mượn";
        }

        header('Location: /cart');
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }

            $userId = $_SESSION['user_id'];
            $bookId = $_POST['book_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;

            if ($bookId && $quantity !== null) {
                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$userId][$bookId]);
                } else {
                    // Kiểm tra số lượng tồn kho
                    $book = Book::find($bookId);
                    if ($book && $quantity <= $book->soluong) {
                        $_SESSION['cart'][$userId][$bookId] = (int)$quantity;
                    } else {
                        $_SESSION['error'] = "Số lượng sách không đủ";
                    }
                }
            }

            header('Location: /cart');
            exit;
        }
    }

    public static function getItems() {
        if (!isset($_SESSION['user_id'])) {
            return [];
        }

        $userId = $_SESSION['user_id'];
        if (!isset($_SESSION['cart'][$userId]) || empty($_SESSION['cart'][$userId])) {
            return [];
        }

        $items = [];
        foreach ($_SESSION['cart'][$userId] as $bookId => $quantity) {
            $book = Book::find($bookId);
            if ($book) {
                $items[] = [
                    'book' => $book,
                    'quantity' => $quantity
                ];
            }
        }
        return $items;
    }

    public static function clear() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            unset($_SESSION['cart'][$userId]);
        }
        return true;
    }
}