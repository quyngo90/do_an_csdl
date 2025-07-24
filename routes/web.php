<?php

session_start();

// Nạp controller & config DB
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../config/database.php';

// Lấy path không kèm query string
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Chỉ cho phép người có vai trò quản trị
if (strpos($request, '/admin') === 0) {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'quantri') {
        echo "Bạn không có quyền truy cập trang admin.";
        exit;
    }

    $controller = new AdminController();

    switch (true) {
        // ✅ Dashboard
        case ($request === '/admin' || $request === '/admin/dashboard'):
            $controller->dashboard();
            break;

        // ✅ Quản lý Sách
        case ($request === '/admin/manage-books'):
            $controller->manageBooks();
            break;

        case ($request === '/admin/add-book'):
            $controller->showAddBookForm();
            break;

        case ($request === '/admin/store-book' && $_SERVER['REQUEST_METHOD'] === 'POST'):
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

        // ✅ Quản lý Tác giả
        case ($request === '/admin/authors'):
            $controller->manageAuthors();
            break;

        case ($request === '/admin/authors/create'):
            $controller->showAddAuthorForm();
            break;

        case ($request === '/admin/authors/store' && $_SERVER['REQUEST_METHOD'] === 'POST'):
            $controller->storeAuthor();
            break;

        case (strpos($request, '/admin/authors/edit') === 0 && isset($_GET['id'])):
            $controller->showEditAuthorForm((int)$_GET['id']);
            break;

        case ($request === '/admin/authors/update' && $_SERVER['REQUEST_METHOD'] === 'POST'):
            $controller->updateAuthor((int)$_POST['id']);
            break;

        case (strpos($request, '/admin/authors/delete') === 0 && isset($_GET['id'])):
            $controller->deleteAuthor((int)$_GET['id']);
            break;
// ✅ Quản lý Thể loại
case ($request === '/admin/genres'):
    $controller->manageGenres();
    break;

case ($request === '/admin/genres/create'):
    $controller->showAddGenreForm();
    break;

case ($request === '/admin/genres/store' && $_SERVER['REQUEST_METHOD'] === 'POST'):
    $controller->storeGenre();
    break;

case (strpos($request, '/admin/genres/edit') === 0 && isset($_GET['id'])):
    $controller->showEditGenreForm((int)$_GET['id']);
    break;

case ($request === '/admin/genres/update' && $_SERVER['REQUEST_METHOD'] === 'POST'):
    $controller->updateGenre((int)$_POST['id']);
    break;

case (strpos($request, '/admin/genres/delete') === 0 && isset($_GET['id'])):
    $controller->deleteGenre((int)$_GET['id']);
    break;

        // ❌ Fallback: 404
        default:
            http_response_code(404);
            include_once __DIR__ . '/../app/views/404.php';
            break;
    }

} else {
    // Người dùng thường
    http_response_code(404);
    include_once __DIR__ . '/../app/views/404.php';
}
