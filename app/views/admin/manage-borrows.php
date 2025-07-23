<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h2>Quản lý Phiếu Mượn</h2>

    <div class="mb-3">
        <form method="get" class="form-inline">
            <select name="status" class="form-control mr-2">
                <option value="">Tất cả trạng thái</option>
                <option value="choduyet" <?= ($_GET['status'] ?? '') == 'choduyet' ? 'selected' : '' ?>>Chờ duyệt</option>
                <option value="dangmuon" <?= ($_GET['status'] ?? '') == 'dangmuon' ? 'selected' : '' ?>>Đang mượn</option>
                <option value="datra" <?= ($_GET['status'] ?? '') == 'datra' ? 'selected' : '' ?>>Đã trả</option>
                <option value="trathan" <?= ($_GET['status'] ?? '') == 'trathan' ? 'selected' : '' ?>>Trả trễ</option>
            </select>
            <button type="submit" class="btn btn-primary">Lọc</button>
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Thành viên</th>
                <th>Ngày mượn</th>
                <th>Hạn trả</th>
                <th>Số sách</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($borrows as $borrow): ?>
            <tr>
                <td><?= $borrow->id ?></td>
                <td><?= htmlspecialchars($borrow->ten_thanhvien) ?></td>
                <td><?= $borrow->ngaymuon ?></td>
                <td><?= $borrow->hantra ?></td>
                <td><?= count($borrow->chitiet) ?></td>
                <td>
                    <span class="badge <?= [
                        'choduyet' => 'bg-warning',
                        'dangmuon' => 'bg-info',
                        'datra' => 'bg-success',
                        'trathan' => 'bg-danger'
                    ][$borrow->trangthai] ?? 'bg-secondary' ?>">
                        <?= ucfirst($borrow->trangthai) ?>
                    </span>
                </td>
                <td>
                    <a href="/admin/manage-borrows/view?id=<?= $borrow->id ?>" class="btn btn-info btn-sm">Xem</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>