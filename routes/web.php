<?php
session_start();

// Nạp Controller Admin
require_once __DIR__ . '/../app/controllers/AdminController.php';

// ✅ Lấy đúng phần path, bỏ query string
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ✅ Kiểm tra quyền admin
if (strpos($request, '/admin') === 0) {

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

        // 404 fallback
        default:
            http_response_code(404);
            include_once __DIR__ . '/../app/views/404.php';
            break;
    }

} else {
    // Không phải route admin
    http_response_code(404);
    include_once __DIR__ . '/../app/views/404.php';
}
