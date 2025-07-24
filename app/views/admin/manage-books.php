<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Quản lý Sách</h2>
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
                    <td><?= htmlspecialchars($book->tacgia) ?></td>
                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($book->theloai) ?></span></td>
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
                        <td colspan="8" class="text-center text-muted">Chưa có sách nào trong hệ thống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
