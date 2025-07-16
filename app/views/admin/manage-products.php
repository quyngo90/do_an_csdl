<?php include __DIR__ . '/../layouts/header.php'; ?>

<h2>Quản lý Sản phẩm</h2>
<a href="/admin/add-product" class="btn btn-success mb-3">Thêm sản phẩm</a>

<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tên sản phẩm</th>
      <th>Giá (VNĐ)</th>
      <th>Ảnh</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($products as $product): ?>
      <tr>
        <td><?php echo $product->id; ?></td>
        <td><?php echo $product->name; ?></td>
        <td><?php echo number_format($product->price); ?></td>
        <td>
          <?php if($product->image): ?>
            <img src="/assets/images/<?php echo $product->image; ?>" alt="" width="60">
          <?php else: ?>
            <span>Chưa có ảnh</span>
          <?php endif; ?>
        </td>
        <td>
          <a href="/admin/edit-product?id=<?php echo $product->id; ?>" class="btn btn-primary btn-sm">Sửa</a>
          <a href="/admin/delete-product?id=<?php echo $product->id; ?>"
             onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
             class="btn btn-danger btn-sm">Xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
