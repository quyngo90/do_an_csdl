<?php
session_start();

// Nạp các Controller cần thiết
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/CartController.php';
require_once __DIR__ . '/../app/controllers/OrderController.php';
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
// 2. TRANG SẢN PHẨM
elseif (strpos($request, '/products') === 0) {
    $controller = new ProductController();
    if (isset($_GET['id'])) {
        // Nếu có ?id=..., hiển thị chi tiết
        $controller->detail($_GET['id']);
    } else {
        // Nếu chỉ /products, hiển thị danh sách
        $controller->index();
    }
}
// 3. CHI TIẾT SẢN PHẨM
elseif (strpos($request, '/product-detail') === 0) {
    if (isset($_GET['id'])) {
        $controller = new ProductController();
        $controller->detail($_GET['id']);
    } else {
        echo "ID sản phẩm không hợp lệ!";
    }
}
// 4. GIỎ HÀNG
elseif (strpos($request, '/cart') === 0) {
    $controller = new CartController();
    if (isset($_GET['id']) && strpos($request, 'add') !== false) {
        $controller->add($_GET['id']);
    } elseif (isset($_GET['id']) && strpos($request, 'remove') !== false) {
        $controller->remove($_GET['id']);
    } elseif (strpos($request, '/cart/update') === 0 && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->update();
    } else {
        $controller->index();
    }
}
// 4.1. CHECKOUT
elseif (strpos($request, '/checkout') === 0) {

    $controller = new OrderController();
    $controller->checkout();
}
// 4.2. TRANG THÔNG BÁO ĐẶT HÀNG THÀNH CÔNG
elseif ($request == '/order-success') {
    include_once __DIR__ . '/../app/views/order-success.php';
}
// 5. LIÊN HỆ
elseif (strpos($request, '/contact') === 0) {
    $controller = new ContactController();
    $controller->index();
}
// 6. ĐĂNG NHẬP
elseif (strpos($request, '/login') === 0) {
    $controller = new AuthController();
    $controller->login();
}
// 6.1. ĐĂNG XUẤT
elseif ($request == '/logout') {
    session_destroy();
    header('Location: /');
    exit;
}
// 7. ĐĂNG KÝ
elseif (strpos($request, '/register') === 0) {
    $controller = new AuthController();
    $controller->register();
}
// 8. ADMIN
elseif (strpos($request, '/admin') === 0) {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        echo "Bạn không có quyền truy cập trang admin.";
        exit;
    }
    $controller = new AdminController();
    if ($request == '/admin' || $request == '/admin/dashboard') {
        $controller->dashboard();
    } elseif ($request == '/admin/manage-products') {
        $controller->manageProducts();
    } elseif ($request == '/admin/add-product') {
        $controller->addProduct();
    } elseif ($request == '/admin/store-product') {
        $controller->storeProduct();
    } elseif (strpos($request, '/admin/edit-product') === 0) {
        $controller->editProduct();
    } elseif (strpos($request, '/admin/update-product') === 0) {
        $controller->updateProduct();
    } elseif (strpos($request, '/admin/delete-product') === 0) {
        $controller->deleteProduct();
    }
    // 8.3. Quản lý người dùng
    elseif ($request == '/admin/manage-users') {
        $controller->manageUsers();
    }
    elseif ($request == '/admin/add-user') {
        $controller->addUser();
    }
    elseif ($request == '/admin/store-user') {
        $controller->storeUser();
    }
    elseif (strpos($request, '/admin/edit-user') === 0) {
        $controller->editUser();
    }
    elseif (strpos($request, '/admin/update-user') === 0) {
        $controller->updateUser();
    }
    elseif (strpos($request, '/admin/delete-user') === 0) {
        $controller->deleteUser();
    }
    // 8.4. Quản lý đơn hàng
    elseif (strpos($request, '/admin/orders') === 0) {
        if (strpos($request, '/admin/orders/view') === 0 && isset($_GET['id'])) {
            $controller->viewOrder();
        } else {
            $controller->orders();
        }
    }
    // 8.5. Quản lý Banner
    elseif ($request == '/admin/manage-banners') {
        $controller->manageBanners();
    }
    elseif ($request == '/admin/add-banner') {
        $controller->addBanner();
    }
    elseif ($request == '/admin/store-banner') {
        $controller->storeBanner();
    }
    elseif (strpos($request, '/admin/edit-banner') === 0) {
        $controller->editBanner();
    }
    elseif (strpos($request, '/admin/update-banner') === 0) {
        $controller->updateBanner();
    }
    elseif (strpos($request, '/admin/delete-banner') === 0) {
        $controller->deleteBanner();
    }
    // Dành cho Admin: cập nhật trạng thái đơn hàng
    elseif (strpos($request, '/admin/update-order-status') === 0) {
        $orderController = new OrderController();
        $orderController->updateOrderStatus();
    }
    else {
        echo "404 Not Found (Admin Panel)";
    }
}
// 9. TÌM KIẾM
elseif (strpos($request, '/search') === 0) {
    $controller = new ProductController();
    $controller->search();
}
// 10. ĐƠN HÀNG CỦA NGƯỜI DÙNG
elseif (strpos($request, '/my-order-detail') === 0) {
    $controller = new OrderController();
    $controller->myOrderDetail();
}
elseif (strpos($request, '/my-orders') === 0) {
    $controller = new OrderController();
    $controller->myOrders();
}
// 11. HỦY ĐƠN HÀNG (dành cho người dùng)
elseif (strpos($request, '/cancel-order') === 0) {
    $controller = new OrderController();
    $controller->cancelOrder();
}
// 12. Route không khớp
else {
    echo "404 Not Found";
}
?>
