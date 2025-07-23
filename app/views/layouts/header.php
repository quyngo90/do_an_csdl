<?php
// Nếu chưa có, nhớ gọi session_start() ở đầu file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bí Ngô – <?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Trang chủ' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <div class="container-fluid"> 
      <a class="navbar-brand" href="/">Thư viện Bí Ngô</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <form action="/search" method="get" class="d-flex ms-3">
          <input class="form-control me-3" type="search" name="q" placeholder="Tìm kiếm sách..." aria-label="Search">
          <button class="btn btn-light" type="submit">Tìm</button>
        </form>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
          <li class="nav-item"><a class="nav-link" href="/products">Sách</a></li>
          <li class="nav-item"><a class="nav-link" href="/contact">Liên hệ</a></li>

          <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'quantri'): ?>
              <li class="nav-item">
                <a class="nav-link" href="/admin/dashboard">Quản lí</a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="/my-orders">Lịch sử mượn sách</a>
              </li>
            <?php endif; ?>

            <li class="nav-item">
              <span class="nav-link">Xin chào, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/logout">Đăng xuất</a>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/login">Đăng nhập</a></li>
            <li class="nav-item"><a class="nav-link" href="/register">Đăng ký</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-4">
