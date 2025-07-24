<?php
session_start();

// Nạp Controller Admin
require_once __DIR__ . '/../app/controllers/AdminController.php';

// ✅ Fix: Chỉ lấy phần path, bỏ phần ?query để định tuyến chính xác
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Chỉ cho phép truy cập admin
if (strpos($request, '/admin') === 0) {

    // Kiểm tra quyền truy cập admin
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'quantri') {
        echo "Bạn không có quyền truy cập trang admin.";
        exit;
    }

    $controller = new AdminController();

    switch (true) {
        // DASHBOARD
        case ($request === '/admin' || $request === '/admin/dashboard'):
            $controller->dashboard();
            break;

        // QUẢN LÝ SÁCH
        case ($request === '/admin/manage-books'):
            $controller->manageBooks();
            break;
        case ($request === '/admin/add-book'):
            $controller->showAddBookForm();
            break;
        case ($request === '/admin/store-book'):
            $controller->addBook();
            break;
        case (strpos($request, '/admin/edit-book') === 0 && isset($_GET['id'])):
            $controller->showEditBookForm((int)$_GET['id']);
            break;
        case ($request === '/admin/update-book' && $_SERVER['REQUEST_METHOD'] === 'POST'):
            $controller->updateBook((int)$_POST['id']);
            break;
        case (strpos($request, '/admin/delete-book') === 0 && isset($_GET['id'])):
            $controller->deleteBook((int)$_GET['id']);
            break;

        // QUẢN LÝ PHIẾU MƯỢN
        case (strpos($request, '/admin/manage-borrows') === 0):
            if (strpos($request, '/admin/manage-borrows/view') === 0 && isset($_GET['id'])) {
                $controller->viewBorrow();
            } else {
                $controller->manageBorrows();
            }
            break;
        case (strpos($request, '/admin/update-borrow-status') === 0):
            $controller->updateBorrowStatus();
            break;

        // QUẢN LÝ THÀNH VIÊN
        case ($request === '/admin/manage-members'):
            $controller->manageMembers();
            break;
        case ($request === '/admin/add-member'):
            $controller->addMember();
            break;
        case ($request === '/admin/store-member'):
            $controller->storeMember();
            break;
        case (strpos($request, '/admin/edit-member') === 0):
            $controller->editMember();
            break;
        case ($request === '/admin/update-member'):
            $controller->updateMember();
            break;
        case (strpos($request, '/admin/delete-member') === 0):
            $controller->deleteMember();
            break;

        // QUẢN LÝ TÁC GIẢ & THỂ LOẠI
        case ($request === '/admin/manage-authors'):
            $controller->manageAuthors();
            break;
        case ($request === '/admin/manage-categories'):
            $controller->manageCategories();
            break;

        // 404 fallback
        default:
            http_response_code(404);
            include_once __DIR__ . '/../app/views/404.php';
            break;
    }

} else {
    // Không phải admin route -> 404
    http_response_code(404);
    include_once __DIR__ . '/../app/views/404.php';
}
