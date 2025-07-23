<?php
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Banner.php'; // Đã thêm để nạp lớp Banner

class AdminController {

    // Hiển thị trang dashboard (các chức năng khác)
    public function dashboard() {
        include_once __DIR__ . '/../views/admin/dashboard.php';
    }
    
    // Hiển thị danh sách sản phẩm
    public function manageProducts() {
        $products = Product::all();
        include_once __DIR__ . '/../views/admin/manage-products.php';
    }
    
    // Hiển thị form thêm sản phẩm
    public function addProduct() {
        include_once __DIR__ . '/../views/admin/add-product.php';
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
    public function manageMembers() {
        $members = Member::all();
        include_once __DIR__ . '/../views/admin/manage-members.php';
    }

    public function addMember() {
        include_once __DIR__ . '/../views/admin/add-member.php';
    }

    public function storeMember() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'hoten' => trim($_POST['hoten']),
                'email' => trim($_POST['email']),
                'matkhau' => $_POST['matkhau'],
                'sodienthoai' => trim($_POST['sodienthoai']),
                'diachi' => trim($_POST['diachi']),
                'ngaysinh' => $_POST['ngaysinh'],
                'vaitro' => $_POST['vaitro'] ?? 'docgia'
            ];
            
            $member = new Member($data);
            if ($member->save()) {
                header("Location: /admin/manage-members");
                exit;
            } else {
                echo "Lỗi khi thêm thành viên!";
            }
        }
    }

    public function editMember() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $member = Member::find($id);
            if ($member) {
                include_once __DIR__ . '/../views/admin/edit-member.php';
                return;
            }
        }
        echo "Không tìm thấy thành viên!";
    }

    public function updateMember() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $data = [
                'hoten' => trim($_POST['hoten']),
                'email' => trim($_POST['email']),
                'sodienthoai' => trim($_POST['sodienthoai']),
                'diachi' => trim($_POST['diachi']),
                'ngaysinh' => $_POST['ngaysinh'],
                'vaitro' => $_POST['vaitro']
            ];
            
            if (Member::update($id, $data)) {
                header("Location: /admin/manage-members");
                exit;
            } else {
                echo "Cập nhật thông tin thất bại!";
            }
        }
    }

    public function deleteMember() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            Member::delete($id);
        }
        header("Location: /admin/manage-members");
        exit;
    }
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
