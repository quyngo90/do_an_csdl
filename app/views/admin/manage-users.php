<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Quản lý Người dùng</h2>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Họ tên</th>
        <th>Số điện thoại</th>
        <th>Email</th>
        <th>Địa chỉ</th>
        <th>Ngày sinh</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($users as $user): ?>
      <tr>
        <td><?php echo $user->id; ?></td>
        <td><?php echo htmlspecialchars($user->name); ?></td>
        <td><?php echo htmlspecialchars($user->phone); ?></td>
        <td><?php echo htmlspecialchars($user->email); ?></td>
        <td><?php echo htmlspecialchars($user->address); ?></td>
        <td><?php echo htmlspecialchars($user->birthday); ?></td>
        <td>
          
          <a href="/admin/delete-user?id=<?php echo $user->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');">Xóa</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
