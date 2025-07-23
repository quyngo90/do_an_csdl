<?php
require_once __DIR__ . '/../models/Book.php';


class AdminController {

    // Hiển thị trang dashboard (các chức năng khác)
    public function dashboard() {
        include_once __DIR__ . '/../views/admin/dashboard.php';
    }
    
    // Hiển thị danh sách sản phẩm
public function manageBooks() {
    require_once __DIR__ . '/../models/Book.php'; // Đảm bảo bạn đã nạp model Book
    $books = Book::all(); // Gọi danh sách sách từ CSDL
    include_once __DIR__ . '/../views/admin/manage-books.php';
}
    
    // Hiển thị form thêm sản phẩm
public function showAddBookForm() {
    include_once __DIR__ . '/../views/admin/add-book.php';
}


public function addBook() {
    require_once __DIR__ . '/../models/Book.php';
    Book::create($_POST);
    header('Location: /admin/manage-books');
    exit;
}

public function showEditBookForm($id) {
    require_once __DIR__ . '/../models/Book.php';
    $book = Book::find($id);
    include_once __DIR__ . '/../views/admin/edit-book.php';
}

public function updateBook($id) {
    require_once __DIR__ . '/../models/Book.php';
    Book::update($id, $_POST);
    header('Location: /admin/manage-books');
    exit;
}

public function deleteBook($id) {
    require_once __DIR__ . '/../models/Book.php';
    Book::delete($id);
    header('Location: /admin/manage-books');
    exit;
}
    
    // Xử lý thêm sản phẩm (CRUD - Create)
    public function storeProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'        => trim($_POST['name']),
                'price'       => floatval($_POST['price']),
                'description' => trim($_POST['description']),
                'image'       => '',
                'category'    => trim($_POST['category']),
                'quantity'    => intval($_POST['quantity'])
            ];
            
            // Xử lý upload ảnh (nếu có)
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = __DIR__ . '/../../public/assets/images/';
                $imageName  = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $imageName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $data['image'] = $imageName;
                }
            }
            
            // Tạo sản phẩm qua Model
            $insertId = Product::create($data);
            if ($insertId) {
                header("Location: /admin/manage-products");
                exit;
            } else {
                echo "Lỗi khi thêm sản phẩm!";
            }
        }
    }
    
    // Hiển thị form sửa sản phẩm
    public function editProduct() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $product = Product::find($id);
            if ($product) {
                include_once __DIR__ . '/../views/admin/edit-product.php';
                return;
            }
        }
        echo "Không tìm thấy sản phẩm!";
    }
    
    // Xử lý cập nhật sản phẩm (CRUD - Update)
    public function updateProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            // Lấy sản phẩm cũ để giữ lại ảnh nếu không cập nhật ảnh mới
            $oldProduct = Product::find($id);
            if (!$oldProduct) {
                echo "Sản phẩm không tồn tại!";
                return;
            }
            
            $data = [
                'name'        => trim($_POST['name']),
                'price'       => floatval($_POST['price']),
                'description' => trim($_POST['description']),
                'image'       => $oldProduct->image,
                'category'    => trim($_POST['category']),
                'quantity'    => intval($_POST['quantity'])
            ];
            
            // Nếu có file ảnh mới được upload, xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = __DIR__ . '/../../public/assets/images/';
                $imageName  = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $imageName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $data['image'] = $imageName;
                }
            }
            
            $result = Product::update($id, $data);
            if ($result) {
                header("Location: /admin/manage-products");
                exit;
            } else {
                echo "Cập nhật sản phẩm thất bại!";
            }
        }
    }
    
    // Xử lý xóa sản phẩm (CRUD - Delete)
    public function deleteProduct() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            Product::delete($id);
        }
        header("Location: /admin/manage-products");
        exit;
    }
    
    // Phương thức hiển thị danh sách đơn hàng
    public function orders() {
        require_once __DIR__ . '/../models/Order.php';
        $orders = Order::all();
        include_once __DIR__ . '/../views/admin/orders.php';
    }

    // Phương thức hiển thị chi tiết đơn hàng
    public function viewOrder() {
        if (!isset($_GET['id'])) {
            echo "Thiếu ID đơn hàng";
            return;
        }
        $id = intval($_GET['id']);
        require_once __DIR__ . '/../models/Order.php';
        $order = Order::find($id);
        if (!$order) {
            echo "Đơn hàng không tồn tại!";
            return;
        }
        include_once __DIR__ . '/../views/admin/order-detail.php';
    }

    // Quản lý người dùng
    public function manageUsers() {
        require_once __DIR__ . '/../models/User.php';
        $users = User::all();
        include_once __DIR__ . '/../views/admin/manage-users.php';
    }

    // Các hàm thêm, sửa, xoá người dùng
    public function addUser() {
        include_once __DIR__ . '/../views/admin/add-user.php';
    }

    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'     => trim($_POST['name']),
                'email'    => trim($_POST['email']),
                'password' => $_POST['password'],
                'role'     => $_POST['role'] ?? 'customer'
            ];
            $user = new User($data);
            if ($user->save()) {
                header("Location: /admin/manage-users");
                exit;
            } else {
                echo "Lỗi khi thêm người dùng!";
            }
        }
    }

    public function editUser() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $user = User::find($id);
            if ($user) {
                include_once __DIR__ . '/../views/admin/edit-user.php';
                return;
            }
        }
        echo "Không tìm thấy người dùng!";
    }

    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $oldUser = User::find($id);
            if (!$oldUser) {
                echo "Người dùng không tồn tại!";
                return;
            }
            $data = [
                'name'  => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'role'  => $_POST['role'] ?? $oldUser->role
            ];
            if (User::update($id, $data)) {
                header("Location: /admin/manage-users");
                exit;
            } else {
                echo "Cập nhật người dùng thất bại!";
            }
        }
    }

    public function deleteUser() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            User::delete($id);
        }
        header("Location: /admin/manage-users");
        exit;
    }

    // Quản lý Banner

    // Hiển thị danh sách banner
    public function manageBanners() {
        $banners = Banner::all();
        include_once __DIR__ . '/../views/admin/manage-banners.php';
    }

    // Hiển thị form thêm banner
    public function addBanner() {
        include_once __DIR__ . '/../views/admin/add-banner.php';
    }

    // Xử lý thêm banner
    public function storeBanner() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'link'  => trim($_POST['link']),
                'image' => ''
            ];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = __DIR__ . '/../../public/assets/images/';
                $imageName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $imageName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $data['image'] = $imageName;
                }
            }
            $insertId = Banner::create($data);
            if ($insertId) {
                header("Location: /admin/manage-banners");
                exit;
            } else {
                echo "Lỗi khi thêm banner!";
            }
        }
    }

    // Hiển thị form chỉnh sửa banner
    public function editBanner() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $banner = Banner::find($id);
            if ($banner) {
                include_once __DIR__ . '/../views/admin/edit-banner.php';
                return;
            }
        }
        echo "Không tìm thấy banner!";
    }

    // Xử lý cập nhật banner
    public function updateBanner() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $oldBanner = Banner::find($id);
            if (!$oldBanner) {
                echo "Banner không tồn tại!";
                return;
            }
            $data = [
                'title' => trim($_POST['title']),
                'link'  => trim($_POST['link']),
                'image' => $oldBanner->image
            ];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = __DIR__ . '/../../public/assets/images/';
                $imageName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $imageName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $data['image'] = $imageName;
                }
            }
            if (Banner::update($id, $data)) {
                header("Location: /admin/manage-banners");
                exit;
            } else {
                echo "Cập nhật banner thất bại!";
            }
        }
    }


    // Xử lý xóa banner
    public function deleteBanner() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            Banner::delete($id);
        }
        header("Location: /admin/manage-banners");
        exit;
    }
}
?>
