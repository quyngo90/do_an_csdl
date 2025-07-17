<?php include __DIR__ . '/layouts/header.php'; ?>

<h2>Sách đã mượn</h2>

<?php if(!empty($cartItems)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá (VNĐ)</th>
                <th>Thành tiền</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $totalAll = 0; 
                foreach($cartItems as $item):
                    $product      = $item['product'];
                    $quantity     = $item['quantity'];
                    $price        = $product->price;
                    $subtotal     = $price * $quantity;
                    $totalAll    += $subtotal;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($product->name); ?></td>
                <td>
                    <!-- Form cập nhật số lượng -->
                    <form action="/cart/update" method="post" style="display:inline-block;">
                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                        <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" style="width:60px;">
                        <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                    </form>
                </td>
                <td><?php echo number_format($price); ?></td>
                <td><?php echo number_format($subtotal); ?></td>
                <td>
                    <a href="/cart/remove?id=<?php echo $product->id; ?>" class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>

            <!-- Dòng hiển thị tổng cộng -->
            <tr>
                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                <td><strong><?php echo number_format($totalAll); ?></strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <form action="/checkout" method="get">
  <button type="submit" class="btn btn-primary">Thanh toán</button>
</form>
<?php else: ?>
    <p>Giỏ hàng trống!</p>
<?php endif; ?>

<?php include __DIR__ . '/layouts/footer.php'; ?>
