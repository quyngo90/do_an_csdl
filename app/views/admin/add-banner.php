<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Thêm Banner</h2>
<form action="/admin/store-banner" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Tiêu đề</label>
    <input type="text" name="title" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Link</label>
    <input type="text" name="link" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Ảnh Banner</label>
    <input type="file" name="image" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Lưu Banner</button>
</form>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
