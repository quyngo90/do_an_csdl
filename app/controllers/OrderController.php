<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Product.php';

class OrderController {
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn chưa đăng nhập. Vui lòng <a href='/login'>đăng nhập</a> để đặt hàng.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItems = Cart::getItems();
            if (empty($cartItems)) {
                echo "Giỏ hàng trống!";
                return;
            }

            // Kiểm tra số lượng tồn kho của từng sản phẩm
            foreach ($cartItems as $item) {
                $product = $item['product'];
                $orderQuantity = $item['quantity'];
                if ($product->quantity < $orderQuantity) {
                    echo "Sản phẩm '{$product->name}' hiện đang hết hàng, quý khách vui lòng lựa chọn sản phẩm khác.";
                    return;
                }
            }

            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item['product']->price * $item['quantity'];
            }

            // Lấy thông tin từ form checkout
            $shipping_address = trim($_POST['shipping_address']);
            // Lấy phương thức thanh toán; hiện tại chỉ cho phép "Thanh toán khi nhận hàng"
            $payment_method = $_POST['payment_method'] ?? 'Thanh toán khi nhận hàng';

            $orderData = [
                'user_id'          => $_SESSION['user_id'],
                'total'            => $total,
                'items'            => $cartItems,
                'shipping_address' => $shipping_address,
                'status'           => 'Đang duyệt',
                'payment_method'   => $payment_method
            ];
            $order = new Order($orderData);

            if ($order->save()) {
                // Giảm số lượng tồn kho của sản phẩm
                foreach ($cartItems as $item) {
                    $productId = $item['product']->id;
                    $orderQuantity = $item['quantity'];
                    Product::decreaseQuantity($productId, $orderQuantity);
                }
                Cart::clear();
                header("Location: /order-success");
                exit;
            } else {
                echo "Đặt hàng thất bại, vui lòng thử lại!";
            }
        } else {
            include_once __DIR__ . '/../views/checkout.php';
        }
    }

    // Dành cho Admin: hiển thị chi tiết đơn hàng
    public function viewOrder() {
        if (!isset($_GET['id'])) {
            echo "Thiếu ID đơn hàng";
            return;
        }
        $id = intval($_GET['id']);
        $order = Order::find($id);
        if (!$order) {
            echo "Đơn hàng không tồn tại!";
            return;
        }
        include_once __DIR__ . '/../views/order-detail.php';
    }

    // Dành cho người dùng: hiển thị chi tiết đơn hàng (hóa đơn)
    public function myOrderDetail() {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn chưa đăng nhập.";
            return;
        }
        if (!isset($_GET['id'])) {
            echo "Thiếu ID đơn hàng";
            return;
        }
        $id = intval($_GET['id']);
        $order = Order::find($id);
        if (!$order || $order->user_id != $_SESSION['user_id']) {
            echo "Đơn hàng không tồn tại hoặc không thuộc về bạn!";
            return;
        }
        include_once __DIR__ . '/../views/order-detail-user.php';
    }

    // Hiển thị danh sách đơn hàng của người dùng
    public function myOrders() {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn chưa đăng nhập.";
            return;
        }
        $orders = Order::getByUserId($_SESSION['user_id']);
        include_once __DIR__ . '/../views/my-orders.php';
    }

    // Dành cho Admin: cập nhật trạng thái đơn hàng
    public function updateOrderStatus() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            echo "Bạn không có quyền thực hiện thao tác này.";
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['order_id'] ?? 0);
            $newStatus = $_POST['status'] ?? '';
            $allowedStatuses = ["Đang duyệt", "Đã giao", "Đã hủy", "Giao thành công"];
            if (!in_array($newStatus, $allowedStatuses)) {
                echo "Trạng thái không hợp lệ.";
                return;
            }
            if (Order::updateStatus($id, $newStatus)) {
                header("Location: /admin/orders/view?id=" . $id);
                exit;
            } else {
                echo "Cập nhật trạng thái thất bại!";
            }
        }
    }

    // Dành cho người dùng: hủy đơn hàng (chỉ khi trạng thái là Đang duyệt)
    public function cancelOrder() {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn chưa đăng nhập.";
            return;
        }
        if (!isset($_GET['id'])) {
            echo "Thiếu ID đơn hàng";
            return;
        }
        $id = intval($_GET['id']);
        $order = Order::find($id);
        if (!$order || $order->user_id != $_SESSION['user_id']) {
            echo "Đơn hàng không tồn tại hoặc không thuộc về bạn!";
            return;
        }
        if ($order->status !== "Đang duyệt") {
            echo "Đơn hàng đã được xử lý, không thể hủy.";
            return;
        }
        if (Order::updateStatus($id, "Đã hủy")) {
            header("Location: /my-order-detail?id=" . $id);
            exit;
        } else {
            echo "Hủy đơn hàng thất bại!";
        }
    }
}
?>
