<?php include __DIR__ . '/../layouts/header.php'; ?>

<h2>Quản lý Đơn hàng</h2>
<table class="table">
  <thead>
    <tr>
      <th>ID Đơn hàng</th>
      <th>Tên khách hàng</th>
      <th>Số điện thoại</th>
      <th>Tổng tiền</th>
      <th>Ngày tạo</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($orders as $order): ?>
      <tr>
        <td><?php echo $order->id; ?></td>
        <td><?php echo htmlspecialchars($order->user_name); ?></td>
        <td><?php echo htmlspecialchars($order->user_phone); ?></td>
        <td><?php echo number_format($order->total); ?> VND</td>
        <td><?php echo $order->created_at; ?></td>
        <td>
          <a href="/admin/orders/view?id=<?php echo $order->id; ?>" class="btn btn-info btn-sm">Xem chi tiết</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
