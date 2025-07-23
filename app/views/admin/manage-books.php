<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h2>Quản lý Sách</h2>
    <a href="/admin/add-book" class="btn btn-success mb-3">Thêm Sách Mới</a>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sách</th>
                <th>Tác giả</th>
                <th>Thể loại</th>
                <th>Số lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= $book->id ?></td>
                <td><?= htmlspecialchars($book->tensach) ?></td>
                <td><?= htmlspecialchars($book->tacgia) ?></td>
                <td><?= htmlspecialchars($book->theloai) ?></td>
                <td><?= $book->soluong ?></td>
                <td>
                    <a href="/admin/edit-book?id=<?= $book->id ?>" class="btn btn-primary btn-sm">Sửa</a>
                    <a href="/admin/delete-book?id=<?= $book->id ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Xóa sách này?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>