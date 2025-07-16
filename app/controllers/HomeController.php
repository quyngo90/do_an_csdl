<?php

class HomeController {
    public function index() {
        include_once __DIR__ . '/../views/home.php';
    }

    public function about() {
        include_once __DIR__ . '/../views/about.php'; // Đúng với đường dẫn file
    }
}
?>
