<?php
session_start();

// Nạp các Controller cần thiết
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/BookController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/controllers/BorrowController.php';
require_once __DIR__ . '/../app/controllers/ContactController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

// Lấy đường dẫn request
$request = $_SERVER['REQUEST_URI'];

// 1. TRANG CHỦ
if ($request == '/' || $request == '/index.php') {
    $controller = new HomeController();
    $controller->index();
}
// 1.1. TRANG GIỚI THIỆU
elseif ($request == '/about') {
    $controller = new HomeController();
    $controller->about();
}
// 2. TRANG SÁCH (đổi từ products)
elseif (strpos($request, '/books') === 0 || strpos($request, '/products') === 0) {
    $controller = new BookController();
    if (isset($_GET['id'])) {
        $controller->detail($_GET['id']);
    } else {
        $controller->index();
    }
}
// 3. CHI TIẾT SÁCH (đổi từ product-detail)
elseif (strpos($request, '/book-detail') === 0 || strpos($request, '/product-detail') === 0) {
    if (isset($_GET['id'])) {
        $controller = new BookController();
        $controller->detail($_GET['id']);
    } else {
        echo "ID sách không hợp lệ!";
    }
}

// 4.1. CHECKOUT (đổi thành Xác nhận mượn sách)

elseif (strpos($request, '/borrow/add') === 0 && isset($_GET['id'])) {
    $controller = new BorrowController();
    $controller->addSingleBook(intval($_GET['id']));
}

elseif (strpos($request, '/checkout') === 0) {
    $controller = new BorrowController();
    $controller->checkout();
}
// 4.2. TRANG THÔNG BÁO MƯỢN SÁCH THÀNH CÔNG
elseif ($request == '/borrow-success' || $request == '/order-success') {
    include_once __DIR__ . '/../app/views/borrow-success.php';
}
// 5. LIÊN HỆ (giữ nguyên)
elseif (strpos($request, '/contact') === 0) {
    $controller = new ContactController();
    $controller->index();
}
// 6. ĐĂNG NHẬP (giữ nguyên)
elseif (strpos($request, '/login') === 0) {
    $controller = new AuthController();
    $controller->login();
}
// 6.1. ĐĂNG XUẤT (giữ nguyên)
elseif ($request == '/logout') {
    session_destroy();
    header('Location: /');
    exit;
}
// 7. ĐĂNG KÝ (giữ nguyên)
elseif (strpos($request, '/register') === 0) {
    $controller = new AuthController();
    $controller->register();
}
// 8. ADMIN (cập nhật các route quản lý)
elseif (strpos($request, '/admin') === 0) {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'quantri') {
        echo "Bạn không có quyền truy cập trang admin.";
        exit;
    }
    $controller = new AdminController();
    
    // Dashboard
    if ($request == '/admin' || $request == '/admin/dashboard') {
        $controller->dashboard();
    }
    // Quản lý sách
    elseif ($request == '/admin/manage-books') {
        $controller->manageBooks();  
    }
    // Hiển thị form Thêm sách
    elseif ($request == '/admin/add-book') {
        // Nếu bạn đã có sẵn method showAddBookForm(), gọi luôn:
        // $controller->showAddBookForm();
        // hoặc đơn giản include the view:
        include_once __DIR__ . '/../app/views/admin/add-book.php';
    }
    // Xử lý lưu sách mới
    elseif ($request == '/admin/store-book') {
        $controller->addBook();
    }
    // Sửa sách
    elseif (strpos($request, '/admin/edit-book') === 0 && isset($_GET['id'])) {
        $controller->showEditBookForm(intval($_GET['id']));
    }
    // Xử lý cập nhật sách
    elseif (strpos($request, '/admin/update-book') === 0 && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->updateBook(intval($_POST['id']));
    }
    // Xóa sách
    elseif (strpos($request, '/admin/delete-book') === 0 && isset($_GET['id'])) {
        $controller->deleteBook(intval($_GET['id']));
    }
    // Quản lý phiếu mượn
    elseif (strpos($request, '/admin/manage-borrows') === 0) {
        if (strpos($request, '/admin/manage-borrows/view') === 0 && isset($_GET['id'])) {
            $controller->viewBorrow();
        } else {
            $controller->manageBorrows();
        }
    }
    elseif ($request == '/borrow/add') {
    $controller = new BorrowController();
    $controller->addToBorrow();
}
    // Admin routes
    if ($request == '/admin/manage-members') {
        $controller->manageMembers();
    } elseif ($request == '/admin/add-member') {
        $controller->addMember();
    } elseif ($request == '/admin/store-member') {
        $controller->storeMember();
    } elseif (strpos($request, '/admin/edit-member') === 0) {
        $controller->editMember();
    } elseif ($request == '/admin/update-member') {
        $controller->updateMember();
    } elseif (strpos($request, '/admin/delete-member') === 0) {
        $controller->deleteMember();
    }
    // Quản lý thành viên
    elseif ($request == '/admin/manage-members') {
        $controller->manageMembers();
    }
    // Quản lý tác giả
    elseif ($request == '/admin/manage-authors') {
        $controller->manageAuthors();
    }
    // Quản lý thể loại
    elseif ($request == '/admin/manage-categories') {
        $controller->manageCategories();
    }
    // Cập nhật trạng thái phiếu mượn
    elseif (strpos($request, '/admin/update-borrow-status') === 0) {
        $controller->updateBorrowStatus();
    }

}
// 9. TÌM KIẾM
elseif (strpos($request, '/search') === 0) {
    $controller = new BookController();
    $controller->search();
}
// 10. PHIẾU MƯỢN CỦA THÀNH VIÊN
elseif (strpos($request, '/my-borrows') === 0) {
    $controller = new BorrowController();
    $controller->myBorrows();
}
// 11. CHI TIẾT PHIẾU MƯỢN
elseif (strpos($request, '/borrow-detail') === 0) {
    $controller = new BorrowController();
    $controller->viewBorrow($_GET['id']);
}
// 12. HỦY PHIẾU MƯỢN
elseif (strpos($request, '/cancel-borrow') === 0) {
    $controller = new BorrowController();
    $controller->cancelBorrow();
}
// 13. Route không khớp
else {
    http_response_code(404);
    include_once __DIR__ . '/../app/views/404.php';
}