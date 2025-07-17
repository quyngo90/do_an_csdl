<?php include __DIR__ . '/../layouts/header.php'; ?>
<div class="container">
  <h2>Sửa thông tin sách</h2>
  <?php if(isset($product) && $product): ?>
    <form action="/admin/update-product" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $product->id; ?>">
      <div class="mb-3">
        <label class="form-label">Tên sách</label>
        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Giá trị</label>
        <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($product->price); ?>" required step="0.01">
      </div>
      <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="5"><?php echo htmlspecialchars($product->description); ?></textarea>
      </div>
      <!-- Dropdown chọn loại sản phẩm -->
      <div class="mb-3">
        <label class="form-label">Loại sách</label>
        <select name="category" class="form-control">
          <option value="phone" <?php if($product->category == 'phone') echo 'selected'; ?>>Tiểu thuyết</option>
          <option value="laptop" <?php if($product->category == 'laptop') echo 'selected'; ?>>Hư cấu</option>
          <option value="accessory" <?php if($product->category == 'accessory') echo 'selected'; ?>>Kinh dị</option>
          <option value="component" <?php if($product->category == 'component') echo 'selected'; ?>>Thiên nhiên và khoa học</option>
          <option value="service" <?php if($product->category == 'service') echo 'selected'; ?>>Học tập</option>
        </select>
      </div>
      <!-- Trường nhập số lượng -->
      <div class="mb-3">
        <label class="form-label">Số lượng</label>
        <input type="number" name="quantity" class="form-control" value="<?php echo htmlspecialchars($product->quantity); ?>" required min="0">
      </div>
      <!-- Trường nhập tag -->
      <div class="mb-3">
        <label class="form-label">Tag (cách nhau bởi dấu phẩy)</label>
        <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($product->tags); ?>" placeholder="vd: hot, new">
      </div>
      <div class="mb-3">
        <label class="form-label">Ảnh hiện tại</label><br>
        <?php if($product->image): ?>
          <img src="/assets/images/<?php echo $product->image; ?>" alt="Ảnh sách" width="120">
        <?php else: ?>
          <p>Chưa có ảnh</p>
        <?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Thay đổi ảnh (nếu muốn)</label>
        <input type="file" name="image" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
  <?php else: ?>
    <p>Không tìm thấy sách!</p>
  <?php endif; ?>
</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
