<?php
class ContactController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý gửi liên hệ (demo: chỉ đánh dấu thành công)
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            // Ví dụ: gửi email hoặc lưu vào cơ sở dữ liệu
            $success = true;
        }
        include_once __DIR__ . '/../views/contact.php';
    }
}
?>
