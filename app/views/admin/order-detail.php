<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      Chi tiết Đơn hàng #<?php echo $order->id; ?>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-6">
          <p><strong>Tên khách hàng:</strong> <?php echo htmlspecialchars($order->user_name); ?></p>
          <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order->user_phone); ?></p>
          <p><strong>Địa chỉ nhận hàng:</strong> <?php echo htmlspecialchars($order->shipping_address); ?></p>
          <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order->payment_method); ?></p>
        </div>
        <div class="col-md-6 text-md-end">
          <p><strong>Ngày đặt:</strong> <?php echo $order->created_at; ?></p>
          <p>
  <strong>Trạng thái hiện tại:</strong>
  <?php 
    $status = $order->status;
    // Sử dụng lớp bg-* của Bootstrap 5:
    $badgeClass = 'bg-warning'; // Mặc định "Đang duyệt" => màu vàng
    if ($status == 'Đã giao') {
        $badgeClass = 'bg-primary'; // màu xanh lam
    } elseif ($status == 'Đã hủy') {
        $badgeClass = 'bg-secondary'; // màu xám
    } elseif ($status == 'Giao thành công') {
        $badgeClass = 'bg-success'; // màu xanh lục
    }
  ?>
  <span class="badge <?php echo $badgeClass; ?> text-white"><?php echo $status; ?></span>
</p>

        </div>
      </div>

      <!-- Form cập nhật trạng thái đơn hàng của Admin -->
      <form action="/admin/update-order-status" method="post" class="mb-4">
        <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
        <div class="row align-items-center">
          <div class="col-md-4">
            <label for="status" class="form-label"><strong>Cập nhật trạng thái:</strong></label>
            <select name="status" id="status" class="form-select">
              <option value="Đang duyệt" <?php if($order->status=="Đang duyệt") echo "selected"; ?>>Đang duyệt</option>
              <option value="Đã giao" <?php if($order->status=="Đã giao") echo "selected"; ?>>Đã giao</option>
              <option value="Đã hủy" <?php if($order->status=="Đã hủy") echo "selected"; ?>>Đã hủy</option>
              <option value="Giao thành công" <?php if($order->status=="Giao thành công") echo "selected"; ?>>Giao thành công</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary mt-4">Cập nhật</button>
          </div>
        </div>
      </form>

      <!-- Hiển thị danh sách sản phẩm trong đơn hàng -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá (VNĐ)</th>
            <th>Thành tiền (VNĐ)</th>
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

      <a href="/admin/orders" class="btn btn-secondary">Quay lại</a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>