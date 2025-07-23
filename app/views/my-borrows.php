<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">
  <h2>Danh sách mượn sách</h2>
  <?php if(!empty($borrows)): ?>
    <div class="list-group">
      <?php foreach($borrows as $borrow): ?>
        <a href="/borrow-detail?id=<?php echo $borrow->id; ?>" class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Phiếu #<?php echo $borrow->id; ?></h5>
            <small>
              <span class="badge <?php 
                echo [
                  'choduyet' => 'bg-warning',
                  'dangmuon' => 'bg-info',
                  'datra' => 'bg-success',
                  'trathan' => 'bg-danger',
                  'dahuy' => 'bg-secondary'
                ][$borrow->trangthai];
              ?>">
                <?php echo ucfirst($borrow->trangthai); ?>
              </span>
            </small>
          </div>
          <p class="mb-1">Ngày mượn: <?php echo $borrow->ngaymuon; ?></p>
          <small>Hạn trả: <?php echo $borrow->hantra; ?></small>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Bạn chưa mượn sách nào</div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>