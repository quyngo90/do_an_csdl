<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Hóa đơn Đơn hàng #<?php echo $order->id; ?></h2>
  <div class="card">
    <div class="card-header bg-primary text-white">
      Thông tin đơn hàng
    </div>
    <div class="card-body">
      <div class="row mb-2">
        <div class="col-md-6">
          <p><strong>Tên khách hàng:</strong> <?php echo htmlspecialchars($order->user_name); ?></p>
          <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order->user_phone); ?></p>
          <p><strong>Địa chỉ nhận hàng:</strong> <?php echo htmlspecialchars($order->shipping_address); ?></p>
          <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order->payment_method); ?></p>
        </div>
        <div class="col-md-6 text-md-end">
          <p><strong>Ngày đặt:</strong> <?php echo $order->created_at; ?></p>
          <p>
            <strong>Trạng thái:</strong>
            <?php 
              $status = $order->status;
              $badgeClass = 'bg-warning'; // Đang duyệt: màu vàng
              if ($status == 'Đã giao') {
                  $badgeClass = 'bg-primary';
              } elseif ($status == 'Đã hủy') {
                  $badgeClass = 'bg-secondary';
              } elseif ($status == 'Giao thành công') {
                  $badgeClass = 'bg-success';
              }
            ?>
            <span class="badge <?php echo $badgeClass; ?> text-white"><?php echo $status; ?></span>
          </p>
        </div>
      </div>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá (VND)</th>
            <th>Thành tiền (VND)</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $totalAll = 0;
            foreach ($order->items as $item):
              $subtotal = $item['quantity'] * $item['price'];
              $totalAll += $subtotal;
          ?>
          <tr>
            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo number_format($item['price']); ?></td>
            <td><?php echo number_format($subtotal); ?></td>
          </tr>
          <?php endforeach; ?>
          <tr>
            <td colspan="3" class="text-end"><strong>Tổng đơn hàng:</strong></td>
            <td><strong><?php echo number_format($totalAll); ?></strong></td>
          </tr>
        </tbody>
      </table>
      <?php if ($order->status === "Đang duyệt"): ?>
        <a href="/cancel-order?id=<?php echo $order->id; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?');">Hủy đơn hàng</a>
      <?php endif; ?>
    </div>
  </div>

  <a href="/my-orders" class="btn btn-secondary mt-3">Quay lại danh sách đơn hàng</a>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
