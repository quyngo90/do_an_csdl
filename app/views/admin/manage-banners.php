<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Quản lý Banner</h2>
<a href="/admin/add-banner" class="btn btn-success mb-3">Thêm Banner</a>

<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tiêu đề</th>
      <th>Ảnh</th>
      <th>Link</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($banners as $banner): ?>
    <tr>
      <td><?php echo $banner->id; ?></td>
      <td><?php echo htmlspecialchars($banner->title); ?></td>
      <td>
        <?php if($banner->image): ?>
          <img src="/assets/images/<?php echo $banner->image; ?>" alt="" width="60">
        <?php else: ?>
          <span>Chưa có ảnh</span>
        <?php endif; ?>
      </td>
      <td><?php echo htmlspecialchars($banner->link); ?></td>
      <td>
        <a href="/admin/edit-banner?id=<?php echo $banner->id; ?>" class="btn btn-primary btn-sm">Sửa</a>
        <a href="/admin/delete-banner?id=<?php echo $banner->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa banner này?');">Xóa</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>
