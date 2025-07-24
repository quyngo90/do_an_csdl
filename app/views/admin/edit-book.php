<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h2>Sửa Thông Tin Sách</h2>

    <?php if (isset($book) && $book): ?>
        <form action="/admin/update-book" method="post">
            <input type="hidden" name="id" value="<?= $book->id ?>">

            <div class="mb-3">
                <label class="form-label">Tên sách</label>
                <input type="text" name="tensach" class="form-control"
                       value="<?= htmlspecialchars($book->tensach) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tác giả</label>
                <select name="tacgia_id" class="form-control" required>
                    <option value="">-- Chọn tác giả --</option>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author['id'] ?>" <?= $book->tacgia_id == $author['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($author['tentacgia']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Thể loại</label>
                <select name="theloai_id" class="form-control" required>
                    <option value="">-- Chọn thể loại --</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= $genre['id'] ?>" <?= $book->theloai_id == $genre['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($genre['tentheloai']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nhà xuất bản</label>
                <input type="text" name="nhaxuatban" class="form-control"
                       value="<?= htmlspecialchars($book->nhaxuatban) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Năm xuất bản</label>
                <input type="number" name="namxuatban" class="form-control"
                       value="<?= $book->namxuatban ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Số lượng</label>
                <input type="number" name="soluong" class="form-control"
                       value="<?= $book->soluong ?>" required min="0">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="mota" class="form-control" rows="5"><?= htmlspecialchars($book->mota) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tags (cách nhau bằng dấu phẩy)</label>
                <input type="text" name="tags" class="form-control"
                       value="<?= htmlspecialchars($book->tags) ?>" placeholder="vd: bestseller, new, hot">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="/admin/manage-books" class="btn btn-secondary">Quay lại</a>
        </form>
    <?php else: ?>
        <p class="text-danger">Không tìm thấy sách!</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
