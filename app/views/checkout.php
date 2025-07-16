<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container">
  <h2>Thanh toán</h2>
  <form action="/checkout" method="post">
    <div class="mb-3">
      <label class="form-label">Địa chỉ nhận hàng</label>
      <input type="text" name="shipping_address" class="form-control" required placeholder="Nhập địa chỉ nhận hàng">
    </div>
    <div class="mb-3">
      <label class="form-label">Phương thức thanh toán</label>
      <div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="payment_method" id="cod" value="Thanh toán khi nhận hàng" checked>
          <label class="form-check-label" for="cod">Thanh toán khi nhận hàng</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="payment_method" id="online" value="Thanh toán online" disabled>
          <label class="form-check-label" for="online">Thanh toán online</label>
        </div>
      </div>
    </div>
    <!-- Có thể hiển thị tóm tắt giỏ hàng tại đây nếu cần -->
    <button type="submit" class="btn btn-primary">Đặt hàng</button>
  </form>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
