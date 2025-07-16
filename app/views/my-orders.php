<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Đơn hàng của bạn</h2>
  <?php if(!empty($orders)): ?>
    <div class="list-group">
      <?php foreach($orders as $order): ?>
        <a href="/my-order-detail?id=<?php echo $order->id; ?>" class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Đơn hàng #<?php echo $order->id; ?></h5>
            <?php 
              $status = $order->status;
              $badgeClass = 'bg-warning';
              if ($status == 'Đã giao') {
                  $badgeClass = 'bg-primary';
              } elseif ($status == 'Đã hủy') {
                  $badgeClass = 'bg-secondary';
              } elseif ($status == 'Giao thành công') {
                  $badgeClass = 'bg-success';
              }
            ?>
            <small><span class="badge <?php echo $badgeClass; ?> text-white"><?php echo $status; ?></span></small>
          </div>
          <p class="mb-1">Ngày đặt: <?php echo $order->created_at; ?></p>
          <small>Tổng tiền: <?php echo number_format($order->total); ?> VND</small>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>Bạn chưa có đơn hàng nào.</p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
