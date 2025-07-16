<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
  <h2>Thêm sản phẩm</h2>
  <form action="/admin/store-product" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Tên sản phẩm</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Giá</label>
      <input type="number" name="price" class="form-control" required step="0.01">
    </div>
    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea name="description" class="form-control" rows="5"></textarea>
    </div>
    <!-- Dropdown chọn loại sản phẩm -->
    <div class="mb-3">
      <label class="form-label">Loại sản phẩm</label>
      <select name="category" class="form-control">
        <option value="phone">Điện thoại</option>
        <option value="laptop">Máy tính</option>
        <option value="accessory">Phụ kiện</option>
        <option value="component">Linh kiện điện tử</option>
        <option value="service">Dịch vụ</option>
      </select>
    </div>
    <!-- Trường nhập số lượng -->
    <div class="mb-3">
      <label class="form-label">Số lượng</label>
      <input type="number" name="quantity" class="form-control" required min="0">
    </div>
    <!-- Trường nhập tag -->
    <div class="mb-3">
      <label class="form-label">Tag (cách nhau bởi dấu phẩy)</label>
      <input type="text" name="tags" class="form-control" placeholder="vd: hot, sale, new">
    </div>
    <div class="mb-3">
      <label class="form-label">Ảnh sản phẩm</label>
      <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
  </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
