<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="row mt-4">

  <?php if (isset($_GET['added'])): ?>
    <div class="alert alert-success w-100">Đã thêm vào phiếu mượn</div>
  <?php endif; ?>

  <div class="col-md-5">
    <img src="/assets/images/<?php echo htmlspecialchars($book->anhbia); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($book->tensach); ?>">
  </div>

  <div class="col-md-7">
    <h2><?php echo htmlspecialchars($book->tensach); ?></h2>
    <p><strong>Tác giả:</strong> <?php echo htmlspecialchars($book->tacgia); ?></p>
    <p><strong>Nhà xuất bản:</strong> <?php echo htmlspecialchars($book->nhaxuatban); ?></p>
    <p><strong>Năm xuất bản:</strong> <?php echo htmlspecialchars($book->namxuatban); ?></p>
    <p><strong>Thể loại:</strong> <?php echo htmlspecialchars($book->theloai); ?></p>

    <p class="mt-3"><?php echo nl2br(htmlspecialchars($book->mota)); ?></p>

    <h4 class="mt-3">
      <?php if ($book->gia > 0): ?>
        <?php echo number_format($book->gia); ?> VND
      <?php else: ?>
        <span class="text-success">Miễn phí</span>
      <?php endif; ?>
    </h4>

    <p><strong>Số lượng còn lại:</strong> <?php echo $book->soluong; ?></p>

    <?php if ($book->soluong > 0): ?>
      <a href="/borrow/add?id=<?php echo $book->id; ?>" class="btn btn-success">Mượn sách</a>
    <?php else: ?>
      <div class="alert alert-warning mt-2">
        Sách hiện đã hết. Vui lòng quay lại sau.
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
