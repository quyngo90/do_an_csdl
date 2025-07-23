<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container">
  <h2>Đăng ký Thành viên Thư viện</h2>
  <?php if(isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>
  
  <form action="/register" method="post">
    <div class="mb-3">
      <label class="form-label">Họ và tên</label>
      <input type="text" class="form-control" name="hoten" required>
    </div>
    
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" required>
    </div>
    
    <div class="mb-3">
      <label class="form-label">Mật khẩu</label>
      <input type="password" class="form-control" name="matkhau" required>
    </div>
    
    <div class="mb-3">
      <label class="form-label">Số điện thoại</label>
      <input type="text" class="form-control" name="sodienthoai">
    </div>
    
    <div class="mb-3">
      <label class="form-label">Địa chỉ</label>
      <input type="text" class="form-control" name="diachi">
    </div>
    
    <div class="mb-3">
      <label class="form-label">Ngày sinh</label>
      <input type="date" class="form-control" name="ngaysinh">
    </div>
    
    <button type="submit" class="btn btn-primary">Đăng ký</button>
  </form>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>