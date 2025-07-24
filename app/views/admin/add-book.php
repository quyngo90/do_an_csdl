<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <!-- HIỂN THỊ ERROR & SUCCESS -->
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $err): ?>
                <p><?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success']) ?></p>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <!-- /HIỂN THỊ ERROR & SUCCESS -->

    <h2>Thêm Sách Mới</h2>
    <form action="/admin/store-book" method="post">
        <div class="mb-3">
            <label class="form-label">Tên sách</label>
            <input type="text" name="tensach" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <select name="tacgia_id" class="form-control" required>
                <option value="">-- Chọn tác giả --</option>
                <?php foreach ($authors as $author): ?>
                    <option value="<?= $author['id'] ?>">
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
                    <option value="<?= $genre['id'] ?>">
                        <?= htmlspecialchars($genre['tentheloai']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nhà xuất bản</label>
            <input type="text" name="nhaxuatban" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Năm xuất bản</label>
            <input type="number" name="namxuatban" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="soluong" class="form-control" required min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="mota" class="form-control" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tags (cách nhau bằng dấu phẩy)</label>
            <input type="text" name="tags" class="form-control" placeholder="vd: bestseller, new, hot">
        </div>

        <button type="submit" class="btn btn-primary">Thêm Sách</button>
        <a href="/admin/manage-books" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
