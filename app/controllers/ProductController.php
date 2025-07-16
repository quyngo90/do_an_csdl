<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    public function index() {
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $category = $_GET['category'];
            $products = Product::getByCategory($category);
        } else {
            $products = Product::all();
        }
        include_once __DIR__ . '/../views/products.php';
    }
    
    public function detail($id) {
        $product = Product::find($id);
        include_once __DIR__ . '/../views/product-detail.php';
    }
    
    // Phương thức xử lý tìm kiếm nâng cao
    public function search() {
        $keyword = $_GET['q'] ?? '';
        $tags = [];
        if (isset($_GET['tags']) && !empty($_GET['tags'])) {
            if (is_array($_GET['tags'])) {
                $tags = $_GET['tags'];
            } else {
                $tags = array_map('trim', explode(',', $_GET['tags']));
            }
        }
        $minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
        $maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 100000000;
        $products = Product::searchAdvanced($keyword, $tags, $minPrice, $maxPrice);
        include_once __DIR__ . '/../views/products.php';
    }
}
?>
