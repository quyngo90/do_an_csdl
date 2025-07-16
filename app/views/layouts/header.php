<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Topzone - Trang chủ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Topzone</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
          <li class="nav-item"><a class="nav-link" href="/products">Sản phẩm</a></li>
          <li class="nav-item"><a class="nav-link" href="/cart">Giỏ hàng</a></li>
          <li class="nav-item"><a class="nav-link" href="/about">Giới thiệu</a></li>
          <li class="nav-item"><a class="nav-link" href="/contact">Liên hệ</a></li>
          
          <!-- Nếu đã đăng nhập -->
          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Nếu là admin, hiển thị nút “Chỉnh sửa” chuyển đến trang dashboard -->
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
              <li class="nav-item">
                <a class="nav-link" href="/admin/dashboard">Chỉnh sửa</a>
              </li>
            <?php else: ?>
              <!-- Nếu là khách hàng, hiển thị mục Đơn hàng của bạn -->
              <li class="nav-item">
                <a class="nav-link" href="/my-orders">Đơn hàng của bạn</a>
              </li>
            <?php endif; ?>
            
            <!-- Lời chào và nút Đăng xuất -->
            <li class="nav-item">
              <span class="nav-link">Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/logout">Đăng xuất</a>
            </li>
          <?php else: ?>
            <!-- Nếu chưa đăng nhập, hiển thị Đăng nhập và Đăng ký -->
            <li class="nav-item"><a class="nav-link" href="/login">Đăng nhập</a></li>
            <li class="nav-item"><a class="nav-link" href="/register">Đăng ký</a></li>
          <?php endif; ?>
        </ul>
        
        <!-- Form tìm kiếm -->
        <form action="/search" method="get" class="d-flex ms-3">
          <input class="form-control me-2" type="search" name="q" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Tìm</button>
        </form>
      </div>
    </div>
  </nav>
  <div class="container mt-4">
