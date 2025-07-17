<?php include __DIR__ . '/../layouts/header.php'; ?>

<h2>Quản lí sách</h2>
<a href="/admin/add-product" class="btn btn-success mb-3">Thêm sách</a>

<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tên sách</th>
      <th>Giá trị</th>
      <th>Số lượng (hiện chưa có truy vấn)</th>
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
             onclick="return confirm('Bạn có chắc muốn xóa thông tin sách này?');"
             class="btn btn-danger btn-sm">Xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
