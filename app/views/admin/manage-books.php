<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Quản lý Sách</h2>

    <form method="get" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control"
                   placeholder="Tìm tên sách..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <select name="tacgia_id" class="form-select">
                <option value="">-- Lọc theo tác giả --</option>
                <?php foreach ($authors as $author): ?>
                    <option value="<?= $author['id'] ?>" 
                        <?= isset($_GET['tacgia_id']) && $_GET['tacgia_id'] == $author['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($author['tentacgia']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="theloai_id" class="form-select">
                <option value="">-- Lọc theo thể loại --</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre['id'] ?>" 
                        <?= isset($_GET['theloai_id']) && $_GET['theloai_id'] == $genre['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre['tentheloai']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
    </form>

    <a href="/admin/add-book" class="btn btn-success mb-3">+ Thêm Sách Mới</a>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Thể loại</th>
                    <th>NXB</th>
                    <th>Năm XB</th>
                    <th>Số lượng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book->id ?></td>
                    <td class="text-start"><?= htmlspecialchars($book->tensach) ?></td>
                    <td><?= htmlspecialchars($book->tentacgia ?? 'Không rõ') ?></td>
                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($book->tentheloai ?? 'Không rõ') ?></span></td>
                    <td><?= htmlspecialchars($book->nhaxuatban) ?></td>
                    <td><?= $book->namxuatban ?></td>
                    <td><?= $book->soluong ?></td>
                    <td>
                        <a href="/admin/edit-book?id=<?= $book->id ?>" class="btn btn-sm btn-primary">Sửa</a>
                        <a href="/admin/delete-book?id=<?= $book->id ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Bạn có chắc muốn xóa sách này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($books)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">Không tìm thấy sách nào phù hợp.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
