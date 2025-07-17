<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">
  <h2 class="mb-4">Sách</h2>

  <!-- Nút lọc theo danh mục (giữ nguyên) -->
  <div class="row mb-4">
    <div class="col">
      <div class="d-flex flex-wrap">
        <a href="/products" class="btn btn-primary m-1">Tất cả</a>
        <a href="/products?category=phone" class="btn btn-primary m-1">Hư cấu</a>
        <a href="/products?category=laptop" class="btn btn-primary m-1">Tiểu thuyết</a>
        <a href="/products?category=accessory" class="btn btn-primary m-1">Kinh dị</a>
        <a href="/products?category=component" class="btn btn-primary m-1">Thiên nhiên và khoa học</a>
        <a href="/products?category=service" class="btn btn-primary m-1">Học tập</a>
      </div>
    </div>
  </div>

  <!-- Form lọc sản phẩm nâng cao: từ khóa, tag và khoảng giá -->
  <form action="/search" method="get" class="mb-4">
    <div class="row">
      <div class="col-md-3">
        <input type="text" name="q" class="form-control" placeholder="Từ khóa" value="<?php echo $_GET['q'] ?? ''; ?>">
      </div>
      <div class="col-md-3">
        <input type="text" name="tags" class="form-control" placeholder="Tag (cách nhau bởi dấu phẩy)" value="<?php echo $_GET['tags'] ?? ''; ?>">
      </div>
      <!--<div class="col-md-2">
        <input type="number" name="min_price" class="form-control" placeholder="Giá tối thiểu" value="<?php echo $_GET['min_price'] ?? ''; ?>">
      </div>
      <div class="col-md-2">
        <input type="number" name="max_price" class="form-control" placeholder="Giá tối đa" value="<?php echo $_GET['max_price'] ?? ''; ?>">
      </div> -->
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Lọc</button>
      </div>
    </div>
  </form>

  <!-- Hiển thị kết quả tìm kiếm nếu có -->
  <?php if(isset($_GET['q']) && $_GET['q'] != ''): ?>
    <div class="alert alert-info">
      Kết quả tìm kiếm cho: <strong><?php echo htmlspecialchars($_GET['q']); ?></strong>
    </div>
  <?php endif; ?>

  <!-- Lưới sản phẩm -->
  <div class="row">
    <?php if(!empty($products)): ?>
      <?php foreach($products as $product): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <?php if(!empty($product->image)): ?>
              <img src="/assets/images/<?php echo $product->image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product->name); ?>" style="height: 200px; object-fit: cover;">
            <?php else: ?>
              <img src="/assets/images/no-image.png" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?php echo htmlspecialchars($product->name); ?></h5>
              <p class="card-text text-muted"><?php echo number_format($product->price); ?> VND</p>
              <?php if(!empty($product->tags)): ?>
                <p class="card-text">
                  <?php 
                    $tagList = array_map('trim', explode(',', $product->tags));
                    foreach($tagList as $tag){
                        echo '<span class="badge bg-secondary me-1">' . htmlspecialchars($tag) . '</span>';
                    }
                  ?>
                </p>
              <?php endif; ?>
              <a href="/product-detail?id=<?php echo $product->id; ?>" class="btn btn-primary mt-auto">Xem chi tiết</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col">
        <p>Không có sách nào phù hợp.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
