<?php
require_once __DIR__ . '/../models/Borrow.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../../config/database.php';
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

            // Lấy kết nối PDO
            $db = Database::getInstance();
            $pdo = $db->getConnection();

            // Kiểm tra số lượng sách còn lại
            foreach ($cartItems as $item) {
                // $item['sach']->soluong là số lượng hiện tại của sách
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

    public function addToBorrow() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
        $bookId = intval($_POST['book_id']);
        $userId = $_SESSION['user_id'];

        // Tạo mới Borrow nếu chưa có (trạng thái 'dangmuon')
        $borrow = Borrow::findActiveByUser($userId);
        if (!$borrow) {
            $borrowId = Borrow::create([
                'user_id' => $userId,
                'status' => 'dangmuon',
                'borrow_date' => date('Y-m-d')
            ]);
        } else {
            $borrowId = $borrow['id'];
        }

        // Thêm sách vào bảng chi tiết
        BorrowDetail::create([
            'borrow_id' => $borrowId,
            'book_id' => $bookId,
            'quantity' => 1
        ]);

        $_SESSION['borrow_message'] = "Đã thêm vào phiếu mượn";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
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

    // Thêm sách đơn lẻ vào phiếu mượn mới
    public function addSingleBook($bookId)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $db = Database::getInstance();
        $pdo = $db->getConnection();

        // Kiểm tra số lượng sách còn lại
        $stmt = $pdo->prepare("SELECT soluong FROM sach WHERE id = ?");
        $stmt->execute([$bookId]);
        $soluong = $stmt->fetchColumn();

        if ($soluong === false) {
            echo "Sách không tồn tại!";
            exit;
        }

        if ($soluong <= 0) {
            echo "Sách hiện đã hết. Không thể mượn.";
            exit;
        }

        $userId = $_SESSION['user_id'];
        $today = date('Y-m-d');
        $hantra = date('Y-m-d', strtotime('+7 days'));

        // Tạo phiếu mượn mới
        $stmt = $pdo->prepare("INSERT INTO phieumuon (id_thanhvien, ngaymuon, hantra) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $today, $hantra]);

        $phieuMuonId = $pdo->lastInsertId();

        // Thêm chi tiết mượn cho sách này
        $stmt = $pdo->prepare("INSERT INTO chitietmuon (id_phieumuon, id_sach, soluong) VALUES (?, ?, 1)");
        $stmt->execute([$phieuMuonId, $bookId]);

        // Cập nhật số lượng sách
        $stmt = $pdo->prepare("UPDATE sach SET soluong = soluong - 1 WHERE id = ? AND soluong > 0");
        $stmt->execute([$bookId]);

        header('Location: /my-borrows');
        exit;
    }
}
?>
