<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Lịch sử mượn sách</h2>
  <?php if(!empty($orders)): ?>
    <div class="list-group">
      <?php foreach($orders as $order): ?>
        <a href="/my-order-detail?id=<?php echo $order->id; ?>" class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Lần #<?php echo $order->id; ?></h5>
            <?php 
              $status = $order->status;
              $badgeClass = 'bg-warning';
              if ($status == 'Đã mượn') {
                  $badgeClass = 'bg-primary';
              } elseif ($status == 'Đã trả') {
                  $badgeClass = 'bg-secondary';
              } elseif ($status == 'Trễ hạn trả') {
                  $badgeClass = 'bg-success';
              }
            ?>
            <small><span class="badge <?php echo $badgeClass; ?> text-white"><?php echo $status; ?></span></small>
          </div>
          <p class="mb-1">Ngày mượn: <?php echo $order->created_at; ?></p>
          <small>Tổng tiền: <?php echo number_format($order->total); ?> VND</small>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>Lịch sử trống.</p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
