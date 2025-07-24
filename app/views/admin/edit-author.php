<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <h2 class="mb-4">Chỉnh sửa Tác Giả</h2>

  <form method="POST" action="/admin/authors/update">
    <input type="hidden" name="id" value="<?= $author['id'] ?>">

    <div class="mb-3">
      <label for="tentacgia" class="form-label">Tên tác giả</label>
      <input type="text" name="tentacgia" id="tentacgia" class="form-control" 
             value="<?= htmlspecialchars($author['tentacgia']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="tieusu" class="form-label">Tiểu sử</label>
      <textarea name="tieusu" id="tieusu" class="form-control" rows="5"><?= htmlspecialchars($author['tieusu']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="/admin/authors" class="btn btn-secondary">Quay lại</a>
  </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
