<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container">
    <h2>Danh sách Mượn Sách</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($cartItems)): ?>
        <form action="/checkout" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên sách</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['book']->tensach) ?></td>
                        <td>
                            <input type="number" name="quantity[<?= $item['book']->id ?>]" 
                                   value="<?= $item['quantity'] ?>" min="1" max="<?= $item['book']->soluong ?>">
                        </td>
                        <td>
                            <a href="/cart/remove?id=<?= $item['book']->id ?>" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-end">
                <button type="submit" name="update" class="btn btn-secondary">Cập nhật</button>
                <button type="submit" name="checkout" class="btn btn-primary">Xác nhận Mượn Sách</button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-info">Danh sách mượn sách trống</div>
        <a href="/books" class="btn btn-primary">Tìm sách để mượn</a>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>