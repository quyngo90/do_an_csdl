<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Quản lý Thành viên</h2>
 

  <table class="table table-bordered">  
    <thead>
      <tr>
        <th>ID</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Số điện thoại</th>
        <th>Vai trò</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($members as $member): ?>
      <tr>
        <td><?php echo $member->id; ?></td>
        <td><?php echo htmlspecialchars($member->hoten); ?></td>
        <td><?php echo htmlspecialchars($member->email); ?></td>
        <td><?php echo htmlspecialchars($member->sodienthoai); ?></td>
        <td>
          <span class="badge <?php 
            echo $member->vaitro === 'quantri' ? 'bg-danger' : 'bg-primary';
          ?>">
            <?php echo ucfirst($member->vaitro); ?>
          </span>
        </td>
        <td>
          
          <a href="/admin/delete-member?id=<?php echo $member->id; ?>" 
             class="btn btn-danger btn-sm"
             onclick="return confirm('Xóa thành viên này?')">Xóa</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>