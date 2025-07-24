<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Chỉnh sửa Thể loại</h2>

    <div class="row">
        <div class="col-md-6">
            <form method="POST" action="/admin/categories/update">
                <input type="hidden" name="id" value="<?= $genre['id'] ?>">

                <div class="mb-3">
                    <label for="tentheloai" class="form-label">Tên thể loại</label>
                    <input type="text" name="tentheloai" id="tentheloai" class="form-control"
                           value="<?= htmlspecialchars($genre['tentheloai']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="mota" class="form-label">Mô tả</label>
                    <textarea name="mota" id="mota" class="form-control" rows="4"
                              placeholder="Nhập mô tả"><?= htmlspecialchars($genre['mota'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="/admin/genres" class="btn btn-secondary ms-2">Hủy</a>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
