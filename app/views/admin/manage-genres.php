<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Quản lý Thể loại</h2>

    <a href="/admin/genres/create" class="btn btn-success mb-3">+ Thêm Thể loại Mới</a>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên thể loại</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($genres as $genre): ?>
                    <tr>
                        <td><?= $genre['id'] ?></td>
                        <td class="text-start"><?= htmlspecialchars($genre['tentheloai']) ?></td>
                        <td class="text-start"><?= htmlspecialchars($genre['mota'] ?? '') ?></td>
                        <td>
                            <a href="/admin/genres/edit?id=<?= $genre['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="/admin/genres/delete?id=<?= $genre['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Bạn có chắc muốn xóa thể loại này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($genres)): ?>
                    <tr>
                        <td colspan="4" class="text-muted">Không có thể loại nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
