<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Dashboard Admin</h2>
  <div class="row">
    <!-- Quản lý Banner -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          Quản lý Banner
        </div>
        <div class="card-body">
          <p>Cập nhật hoặc thêm mới banner quảng cáo hiển thị trên trang chủ.</p>
          <a href="/admin/manage-banners" class="btn btn-primary">Quản lý Banner</a>
        </div>
      </div>
    </div>
    <!-- Quản lý Sản phẩm -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          Quản lý Sản phẩm
        </div>
        <div class="card-body">
          <p>Thêm, sửa, xoá sản phẩm, cập nhật thông tin sản phẩm sale & hot.</p>
          <a href="/admin/manage-products" class="btn btn-primary">Quản lý Sản phẩm</a>
        </div>
      </div>
    </div>
    <!-- Quản lý Người dùng -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          Quản lý Người dùng
        </div>
        <div class="card-body">
          <p>Xem danh sách, thêm, sửa, xoá tài khoản người dùng.</p>
          <a href="/admin/manage-users" class="btn btn-primary">Quản lý Người dùng</a>
        </div>
      </div>
    </div>
    <!-- Quản lý Đơn hàng -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          Quản lý Đơn hàng
        </div>
        <div class="card-body">
          <p>Quản lý thông tin chi tiết đơn hàng của khách hàng.</p>
          <a href="/admin/orders" class="btn btn-primary">Quản lý Đơn hàng</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
