<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Quản lí thông tin</h2>
  <div class="row">
    <!-- Quản lý Banner -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          Quản lý Banner
        </div>
        <div class="card-body">
          <p>Cập nhật hoặc thêm mới banner quảng cáo.</p>
          <a href="/admin/manage-banners" class="btn btn-primary">Quản lý Banner</a>
        </div>
      </div>
    </div>
    <!-- Quản lý Sản phẩm -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          Quản lí sách
        </div>
        <div class="card-body">
          <p>Thêm, sửa, xoá sản phẩm, cập nhật thông tin sách.</p>
          <a href="/admin/manage-products" class="btn btn-primary">Quản lí sách</a>
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
          <a href="/admin/manage-users" class="btn btn-primary">Quản lí Người dùng</a>
        </div>
      </div>
    </div>
    <!-- Quản lý Đơn hàng -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          Quản lí hạn trả sách
        </div>
        <div class="card-body">
          <p>Quản lý thông tin chi tiết lịch sử mượn sách của khách.</p>
          <a href="/admin/orders" class="btn btn-primary">Quản lí hạn trả sách</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
