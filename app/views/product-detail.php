<?php include __DIR__ . '/layouts/header.php'; ?>
<div class="row">
  <div class="col-md-6">
    <img src="/assets/images/<?php echo $product->image; ?>" class="img-fluid" alt="<?php echo $product->name; ?>">
  </div>
  <div class="col-md-6">
    <h2><?php echo $product->name; ?></h2>
    <p><?php echo $product->description; ?></p>
    <h4><?php echo number_format($product->price); ?> VND</h4>
    <p><strong>Số lượng còn lại:</strong> <?php echo $product->quantity; ?></p>
    <?php if ($product->quantity > 0): ?>
      <a href="/cart/add?id=<?php echo $product->id; ?>" class="btn btn-success">Thêm vào giỏ hàng</a>
    <?php else: ?>
      <div class="alert alert-warning">
        Sản phẩm này hiện đang hết hàng, quý khách vui lòng lựa chọn sản phẩm khác.
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/layouts/footer.php'; ?>
