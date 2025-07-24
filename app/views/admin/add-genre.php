<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Thêm Thể loại Mới</h2>

    <form method="POST" action="/admin/categories/store" class="col-md-6">
        <div class="mb-3">
            <label for="tentheloai" class="form-label">Tên thể loại</label>
            <input type="text" name="tentheloai" id="tentheloai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea name="mota" id="mota" class="form-control" rows="4" placeholder="Nhập mô tả ngắn..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="/admin/genres" class="btn btn-secondary ms-2">Quay lại</a>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
