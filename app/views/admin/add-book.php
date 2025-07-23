<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
    <h2>Thêm Sách Mới</h2>
    <form action="/admin/store-book" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Tên sách</label>
            <input type="text" name="tensach" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tác giả</label>
            <input type="text" name="tacgia" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Thể loại</label>
            <select name="theloai" class="form-control" required>
                <option value="tieu-thuyet">Tiểu thuyết</option>
                <option value="khoa-hoc">Khoa học</option>
                <option value="lap-trinh">Lập trình</option>
                <option value="lich-su">Lịch sử</option>
                <option value="van-hoc">Văn học</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nhà xuất bản</label>
            <input type="text" name="nhaxuatban" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Năm xuất bản</label>
            <input type="number" name="namxuatban" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="soluong" class="form-control" required min="0">
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="mota" class="form-control" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tags (cách nhau bằng dấu phẩy)</label>
            <input type="text" name="tags" class="form-control" placeholder="vd: bestseller, new, hot">
        </div>
        <div class="mb-3">
            <label class="form-label">Ảnh bìa</label>
            <input type="file" name="anhbia" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Thêm Sách</button>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>