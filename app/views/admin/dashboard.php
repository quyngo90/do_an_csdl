<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Quản lí thông tin</h2>
  <div class="row">
    <!-- Quản lý Sách -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">Quản lí sách</div>
        <div class="card-body">
          <p>Thêm, sửa, xoá sản phẩm, cập nhật thông tin sách.</p>
          <a href="/admin/manage-books" class="btn btn-primary">Quản lí sách</a>
        </div>
      </div>
    </div>

    <!-- Quản lý Người dùng -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">Quản lý Người dùng</div>
        <div class="card-body">
          <p>Xem danh sách, thêm, sửa, xoá tài khoản người dùng.</p>
          <a href="/admin/manage-members" class="btn btn-primary">Quản lí Người dùng</a>
        </div>
      </div>
    </div>

    <!-- Quản lý Hạn trả sách -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">Quản lí hạn trả sách</div>
        <div class="card-body">
          <p>Quản lý thông tin chi tiết lịch sử mượn sách của khách.</p>
          <a href="/admin/manage-borrows" class="btn btn-primary">Quản lí hạn trả sách</a>
        </div>
      </div>
    </div>

    <!-- Quản lý Tác giả -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header">Quản lý Tác giả</div>
        <div class="card-body">
          <p>Thêm, sửa, xoá, tìm kiếm tác giả trong hệ thống.</p>
          <a href="/admin/authors" class="btn btn-primary">Quản lí Tác giả</a>
        </div>
      </div>
    </div>

    <!-- ✅ Quản lý Thể loại -->
    <div class="col-md-3 mt-4">
      <div class="card">
        <div class="card-header">Quản lý Thể loại</div>
        <div class="card-body">
          <p>Thêm, sửa, xoá các thể loại sách trong thư viện.</p>
          <a href="/admin/genres" class="btn btn-primary">Quản lí Thể loại</a>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
