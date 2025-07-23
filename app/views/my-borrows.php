<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Phiếu mượn sách</h2>
  
  <?php if (empty($selectedBooks)): ?>
    <div class="alert alert-info">Bạn chưa chọn sách nào để mượn.</div>
  <?php else: ?>
    <form action="/borrow/submit" method="POST" onsubmit="return validateReturnDate()">
      <div class="row">
        <!-- Bên trái: danh sách sách -->
        <div class="col-md-7">
          <h4>Sách đã chọn</h4>
          <ul class="list-group mb-3">
            <?php foreach ($selectedBooks as $book): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo htmlspecialchars($book->tensach); ?>
              </li>
            <?php endforeach; ?>
          </ul>

          <div class="mb-3">
            <label for="returnDate" class="form-label">Ngày trả dự kiến</label>
            <input type="date" id="returnDate" name="returnDate" class="form-control" 
                   min="<?php echo date('Y-m-d'); ?>" 
                   max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" 
                   required>
            <div class="form-text">Ngày trả tối đa cách ngày mượn 1 tháng.</div>
          </div>
        </div>

        <!-- Bên phải: thông tin người dùng -->
        <div class="col-md-5">
          <h4>Thông tin người mượn</h4>
          <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($user->hoten); ?></p>
          <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user->diachi); ?></p>
          <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user->sodienthoai); ?></p>
          <p><strong>Mã thẻ:</strong> <?php echo htmlspecialchars($user->mathe); ?></p>

          <button type="submit" class="btn btn-primary mt-4 w-100">MƯỢN</button>
        </div>
      </div>
    </form>
  <?php endif; ?>
</div>

<script>
  function validateReturnDate() {
    const returnDateInput = document.getElementById('returnDate');
    const minDate = new Date(returnDateInput.min);
    const maxDate = new Date(returnDateInput.max);
    const selectedDate = new Date(returnDateInput.value);

    if (selectedDate < minDate || selectedDate > maxDate) {
      alert('Ngày trả phải trong khoảng từ hôm nay đến tối đa 1 tháng.');
      return false;
    }
    return true;
  }
</script>

<?php include __DIR__ . '/layouts/footer.php'; ?>
