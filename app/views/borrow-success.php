<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container text-center my-5">
    <div class="card">
        <div class="card-body">
            <h1 class="text-success"><i class="bi bi-check-circle-fill"></i> Đã gửi yêu cầu mượn sách thành công</h1>
            <p class="lead">Thông tin phiếu mượn của bạn đã được ghi nhận và đang chờ xử lý</p>
            <p>Mã phiếu mượn: #<?= $_SESSION['last_borrow_id'] ?? '' ?></p>
            
            <div class="mt-4">
                <a href="/my-borrows" class="btn btn-primary">Xem danh sách mượn</a>
                <a href="/books" class="btn btn-outline-primary">Tiếp tục tìm sách</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>