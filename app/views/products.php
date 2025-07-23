<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container mt-4">
  <h2 class="mb-4">Danh sách sách</h2>

  <!-- Bộ lọc -->
  <div class="row mb-4">
    <div class="col">
      <div class="d-flex flex-wrap">
        <a href="/products" class="btn btn-primary m-1">Tất cả</a>
        <a href="/products?theloai=tieu-thuyet" class="btn btn-primary m-1">Tiểu thuyết</a>
        <a href="/products?theloai=khoa-hoc" class="btn btn-primary m-1">Khoa học</a>
        <a href="/products?theloai=lap-trinh" class="btn btn-primary m-1">Lập trình</a>
      </div>
    </div>
  </div>

  <!-- Form tìm kiếm -->
  <form action="/search" method="get" class="mb-4">
    <div class="row">
      <div class="col-md-6">
        <input type="text" name="q" class="form-control" placeholder="Tìm theo tên sách..." 
               value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
      </div>
      <div class="col-md-4">
        <input type="text" name="tags" class="form-control" placeholder="Tags (cách nhau bằng dấu phẩy)"
               value="<?php echo htmlspecialchars($_GET['tags'] ?? ''); ?>">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
      </div>
    </div>
  </form>

  <!-- Kết quả -->
  <div class="row">
    <?php if(!empty($books)): ?>
      <?php foreach($books as $book): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <?php if(!empty($book->anhbia)): ?>
              <img src="/assets/images/<?php echo $book->anhbia; ?>" class="card-img-top" 
                   alt="<?php echo htmlspecialchars($book->tensach); ?>" style="height: 200px; object-fit: cover;">
            <?php else: ?>
              <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                <span>Không có ảnh</span>
              </div>
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?php echo htmlspecialchars($book->tensach); ?></h5>
              <p class="card-text text-muted">Tác giả: <?php echo htmlspecialchars($book->tacgia); ?></p>
              <p class="card-text">
                <?php if(!empty($book->tags)): ?>
                  <?php 
                    $tagList = array_map('trim', explode(',', $book->tags));
                    foreach($tagList as $tag):
                  ?>
                    <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($tag); ?></span>
                  <?php endforeach; ?>
                <?php endif; ?>
              </p>
              <a href="/product-detail?id=<?php echo $book->id; ?>" class="btn btn-primary mt-auto">Xem chi tiết</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col">
        <div class="alert alert-info">Không tìm thấy sách phù hợp</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>