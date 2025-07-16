<?php 
include_once __DIR__ . '/layouts/header.php'; 
require_once __DIR__ . '/../models/Banner.php';

$banners = Banner::all(); 
?>

<style>
  /* Thay mũi tên mặc định bằng SVG màu đen */
  .carousel-control-prev-icon {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='black' viewBox='0 0 8 8'%3E%3Cpath d='M4.146 0.146a.5.5 0 0 1 .708 0l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 1 1-.708-.708L7.293 4 3.146.854a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
  }
  .carousel-control-next-icon {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='black' viewBox='0 0 8 8'%3E%3Cpath d='M3.854 0.146a.5.5 0 0 0-.708 0L-.354 3.646a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L.707 4l3.147-3.146a.5.5 0 0 0 0-.708z'/%3E%3C/svg%3E");
  }
  
  /* Điều chỉnh carousel: tăng chiều cao, giảm chiều rộng và căn giữa ảnh */
  #carouselExampleIndicators,
  .carousel,
  .carousel-inner,
  .carousel-item,
  .carousel-item img {
      max-height: 450px;  /* tăng chiều cao lên 450px */
      object-fit: cover;
      width: 95%;         /* giảm chiều rộng xuống 95% */
      margin: 0 auto;     /* căn giữa */
  }
  
  /* Dời carousel xuống một chút */
  #carouselExampleIndicators {
      margin-top: 20px;
  }
</style>

<!-- Carousel Banner -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
  <!-- Indicators -->
  <div class="carousel-indicators">
    <?php if (!empty($banners)): ?>
      <?php foreach ($banners as $index => $banner): ?>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $index; ?>"
          class="<?php echo ($index === 0) ? 'active' : ''; ?>"
          aria-current="<?php echo ($index === 0) ? 'true' : 'false'; ?>"
          aria-label="Slide <?php echo $index + 1; ?>">
        </button>
      <?php endforeach; ?>
    <?php else: ?>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <?php endif; ?>
  </div>

  <!-- Carousel Items -->
  <div class="carousel-inner">
    <?php if (!empty($banners)): ?>
      <?php foreach ($banners as $index => $banner): ?>
        <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
          <a href="<?php echo htmlspecialchars($banner->link); ?>">
            <img src="/assets/images/<?php echo $banner->image; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($banner->title); ?>">
          </a>
          <div class="carousel-caption d-none d-md-block">
            <h5><?php echo htmlspecialchars($banner->title); ?></h5>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="carousel-item active">
        <img src="/assets/images/bn1.jpg" class="d-block w-100" alt="Banner 1">
      </div>
      <div class="carousel-item">
        <img src="/assets/images/bn2.png" class="d-block w-100" alt="Banner 2">
      </div>
      <div class="carousel-item">
        <img src="/assets/images/bn3.jpg" class="d-block w-100" alt="Banner 3">
      </div>
    <?php endif; ?>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Phần giới thiệu bên dưới carousel (giữ nguyên giao diện cũ) -->
<div class="row mt-4 text-center">
  <div class="col">
    <h1>Chào mừng đến với Topzone</h1>
    <p>Trang web bán thiết bị điện tử hàng đầu.</p>
  </div>
</div>

<?php include_once __DIR__ . '/layouts/footer.php'; ?>
