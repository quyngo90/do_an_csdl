<?php include __DIR__ . '/layouts/header.php'; ?>

<h2>Liên hệ</h2>
<?php if(isset($success) && $success): ?>
  <div class="alert alert-success">Cảm ơn bạn đã liên hệ với chúng tôi!</div>
<?php endif; ?>
<form action="/contact" method="post">
  <div class="mb-3">
    <label for="name" class="form-label">Họ và tên</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="message" class="form-label">Nội dung</label>
    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Gửi</button>
</form>

<?php include __DIR__ . '/layouts/footer.php'; ?>
