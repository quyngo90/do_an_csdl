<?php
require_once __DIR__ . '/../models/Borrow.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Cart.php';

class BorrowController {
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn cần đăng nhập để mượn sách";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItems = Cart::getItems();
            if (empty($cartItems)) {
                echo "Không có sách nào để mượn!";
                return;
            }

            // Kiểm tra số lượng sách còn lại
            foreach ($cartItems as $item) {
                if ($item['sach']->soluong < $item['soluong']) {
                    echo "Sách '{$item['sach']->tensach}' không đủ số lượng!";
                    return;
                }
            }

            $borrowData = [
                'id_thanhvien' => $_SESSION['user_id'],
                'trangthai' => 'choduyet',
                'ghichu' => $_POST['ghichu'] ?? '',
                'chitiet' => $cartItems
            ];

            $borrow = new Borrow($borrowData);
            if ($borrow->save()) {
                Cart::clear();
                header("Location: /order-success");
                exit;
            } else {
                echo "Đã xảy ra lỗi khi tạo phiếu mượn!";
            }
        } else {
            include_once __DIR__ . '/../views/checkout.php';
        }
    }

    public function viewBorrow($id) {
        $borrow = Borrow::find($id);
        if (!$borrow) {
            echo "Không tìm thấy phiếu mượn!";
            return;
        }
        include_once __DIR__ . '/../views/borrow-detail.php';
    }

    public function myBorrows() {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn cần đăng nhập để xem danh sách mượn";
            return;
        }
        $borrows = Borrow::getByMemberId($_SESSION['user_id']);
        include_once __DIR__ . '/../views/my-borrows.php';
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_phieumuon'] ?? 0;
            $newStatus = $_POST['trangthai'] ?? '';
            
            if (Borrow::updateStatus($id, $newStatus)) {
                header("Location: /admin/borrows/view?id=" . $id);
                exit;
            } else {
                echo "Cập nhật trạng thái thất bại!";
            }
        }
    }
}
?>