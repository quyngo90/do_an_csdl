<?php include __DIR__ . '/layouts/header.php'; ?>

<h2>Đăng nhập</h2>
<?php if(isset($error)): ?>
  <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form action="/login" method="post">
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Mật khẩu</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <button type="submit" class="btn btn-primary">Đăng nhập</button>
</form>

<?php include __DIR__ . '/layouts/footer.php'; ?>
