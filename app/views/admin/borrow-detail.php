<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Chi tiết Phiếu Mượn #<?= $borrow->id ?></h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Thành viên:</strong> <?= htmlspecialchars($borrow->ten_thanhvien) ?></p>
                    <p><strong>Ngày mượn:</strong> <?= $borrow->ngaymuon ?></p>
                    <p><strong>Hạn trả:</strong> <?= $borrow->hantra ?></p>
                </div>
                <div class="col-md-6">
                    <form action="/admin/update-borrow-status" method="post">
                        <input type="hidden" name="id_phieumuon" value="<?= $borrow->id ?>">
                        <div class="form-group">
                            <label><strong>Trạng thái:</strong></label>
                            <select name="trangthai" class="form-control">
                                <option value="choduyet" <?= $borrow->trangthai == 'choduyet' ? 'selected' : '' ?>>Chờ duyệt</option>
                                <option value="dangmuon" <?= $borrow->trangthai == 'dangmuon' ? 'selected' : '' ?>>Đang mượn</option>
                                <option value="datra" <?= $borrow->trangthai == 'datra' ? 'selected' : '' ?>>Đã trả</option>
                                <option value="trathan" <?= $borrow->trangthai == 'trathan' ? 'selected' : '' ?>>Trả trễ</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                    </form>
                </div>
            </div>

            <h5>Danh sách sách mượn</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên sách</th>
                        <th>Số lượng</th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrow->chitiet as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['tensach']) ?></td>
                        <td><?= $item['soluong'] ?></td>
                        <td><?= $item['tinhtrangtra'] ?? 'Chưa trả' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="/admin/manage-borrows" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>