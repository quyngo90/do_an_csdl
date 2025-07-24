<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h2>Sửa Thông Tin Sách</h2>
    <?php if(isset($book) && $book): ?>
    <form action="/admin/update-book" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $book->id; ?>">
        <div class="mb-3">
            <label class="form-label">Tên sách</label>
            <div class="mb-3">
  <label class="form-label">Giá</label>
  <input type="number" 
         name="gia" 
         class="form-control" 
         value="<?php echo htmlspecialchars($book->gia); ?>" 
         required 
         min="0">
</div>

            <input type="text" name="tensach" class="form-control" value="<?php echo htmlspecialchars($book->tensach); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <input type="text" name="tacgia" class="form-control" value="<?php echo htmlspecialchars($book->tacgia); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Thể loại</label>
            <select name="theloai" class="form-control" required>
                <option value="tieu-thuyet" <?= $book->theloai == 'tieu-thuyet' ? 'selected' : '' ?>>Tiểu thuyết</option>
                <option value="khoa-hoc" <?= $book->theloai == 'khoa-hoc' ? 'selected' : '' ?>>Khoa học</option>
                <option value="lap-trinh" <?= $book->theloai == 'lap-trinh' ? 'selected' : '' ?>>Lập trình</option>
                <option value="lich-su" <?= $book->theloai == 'lich-su' ? 'selected' : '' ?>>Lịch sử</option>
                <option value="van-hoc" <?= $book->theloai == 'van-hoc' ? 'selected' : '' ?>>Văn học</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nhà xuất bản</label>
            <input type="text" name="nhaxuatban" class="form-control" value="<?php echo htmlspecialchars($book->nhaxuatban); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Năm xuất bản</label>
            <input type="number" name="namxuatban" class="form-control" value="<?php echo $book->namxuatban; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="soluong" class="form-control" value="<?php echo $book->soluong; ?>" required min="0">
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="mota" class="form-control" rows="5"><?php echo htmlspecialchars($book->mota); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tags (cách nhau bằng dấu phẩy)</label>
            <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($book->tags); ?>" placeholder="vd: bestseller, new, hot">
        </div>
        <div class="mb-3">
            <label class="form-label">Ảnh bìa hiện tại</label><br>
            <?php if($book->anhbia): ?>
                <img src="/assets/images/<?php echo $book->anhbia; ?>" alt="Ảnh bìa" width="120">
            <?php else: ?>
                <p>Chưa có ảnh bìa</p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Thay đổi ảnh bìa (nếu muốn)</label>
            <input type="file" name="anhbia" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    <?php else: ?>
    <p>Không tìm thấy sách!</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>