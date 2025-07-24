<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Quản lý Tác giả</h2>

    <!-- FORM TÌM KIẾM -->
    <form method="get" class="row g-3 mb-4" action="/admin/authors">
        <div class="col-md-10">
            <input type="text" name="q" class="form-control" placeholder="Tìm tên tác giả..."
                   value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
        </div>
    </form>

    <!-- NÚT THÊM MỚI -->
    <a href="/admin/authors/create" class="btn btn-success mb-3">+ Thêm Tác Giả Mới</a>

    <!-- THÔNG BÁO -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- DANH SÁCH -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên tác giả</th>
                    <th>Tiểu sử</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($authors)): ?>
                    <?php foreach ($authors as $a): ?>
                        <tr>
                            <td><?= $a['id'] ?></td>
                            <td class="text-start"><?= htmlspecialchars($a['tentacgia']) ?></td>
                            <td class="text-start"><?= nl2br(htmlspecialchars($a['tieusu'] ?? '')) ?></td>
                            <td>
                                <a href="/admin/authors/edit?id=<?= $a['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="/admin/authors/delete?id=<?= $a['id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-muted">Không có tác giả nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
