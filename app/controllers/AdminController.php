<?php
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Member.php';
require_once __DIR__ . '/../models/Borrow.php';
require_once __DIR__ . '/../models/BorrowDetail.php';

class AdminController
{
    /**
     * Hiển thị trang dashboard
     */
    public function dashboard()
    {
        include_once __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Quản lý sách: danh sách
     */
    public function manageBooks()
    {
        $books = Book::all();
        include_once __DIR__ . '/../views/admin/manage-books.php';
    }

    /**
     * Hiển thị form thêm sách
     */
    public function showAddBookForm()
    {
        include_once __DIR__ . '/../views/admin/add-book.php';
    }

    /**
     * Xử lý thêm sách mới, upload ảnh và lưu vào DB với trường tương ứng của Book::create()
     */
    public function addBook()
{
    // 1. Lấy dữ liệu từ form (tên trường khớp với add-book.php)
    $tensach    = trim($_POST['tensach']    ?? '');
    $tacgia     = trim($_POST['tacgia']     ?? '');
    $theloai    = trim($_POST['theloai']    ?? '');
    $nhaxuatban = trim($_POST['nhaxuatban'] ?? '');
    $namxuatban = intval($_POST['namxuatban'] ?? 0);
    $soluong    = intval($_POST['soluong']    ?? 0);
    $mota       = trim($_POST['mota']       ?? '');
    $tags       = trim($_POST['tags']       ?? '');

    // 2. Validate cơ bản
    $errors = [];
    if ($tensach === '')    $errors[] = 'Tên sách không được để trống.';
    if ($tacgia === '')     $errors[] = 'Bạn phải nhập tác giả.';
    if ($theloai === '')    $errors[] = 'Bạn phải chọn thể loại.';
    if ($soluong < 0)       $errors[] = 'Số lượng không hợp lệ.';
    if ($namxuatban <= 0)   $errors[] = 'Năm xuất bản không hợp lệ.';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: /admin/add-book');
        exit;
    }

    // 3. Upload ảnh
    $imageName = null;
    if (!empty($_FILES['anhbia']['tmp_name']) && $_FILES['anhbia']['error'] === UPLOAD_ERR_OK) {
        $ext       = pathinfo($_FILES['anhbia']['name'], PATHINFO_EXTENSION);
        $imageName = time() . '_' . uniqid() . '.' . $ext;
        $uploadDir = __DIR__ . '/../../public/assets/images/';

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        move_uploaded_file($_FILES['anhbia']['tmp_name'], $uploadDir . $imageName);
    }

    // 4. Lưu vào CSDL (Book::create() đã sẵn sàng nhận các field này) :contentReference[oaicite:0]{index=0}
    Book::create([
        'tensach'    => $tensach,
        'gia'        => 0,           // form chưa có giá, mặc định 0
        'mota'       => $mota,
        'anhbia'     => $imageName,
        'soluong'    => $soluong,
        'theloai'    => $theloai,
        'tacgia'     => $tacgia,
        'nhaxuatban' => $nhaxuatban,
        'namxuatban' => $namxuatban,
        'tags'       => $tags,
    ]);

    $_SESSION['success'] = 'Thêm sách mới thành công!';
    header('Location: /admin/manage-books');
    exit;
}


    /**
     * Hiển thị form sửa sách
     */
    public function showEditBookForm($id)
    {
        $book = Book::find($id);
        include_once __DIR__ . '/../views/admin/edit-book.php';
    }

    /**
     * Xử lý cập nhật sách
     */
    public function updateBook($id)
{
    // 1. Lấy dữ liệu đúng tên trường
    $data = [
        'tensach'    => trim($_POST['tensach']    ?? ''),
        'gia'        => floatval($_POST['gia']    ?? 0),
        'mota'       => trim($_POST['mota']       ?? ''),
        'soluong'    => intval($_POST['soluong']  ?? 0),
        'theloai'    => trim($_POST['theloai']    ?? ''),
        'tacgia'     => trim($_POST['tacgia']     ?? ''),
        'nhaxuatban' => trim($_POST['nhaxuatban'] ?? ''),
        'namxuatban' => intval($_POST['namxuatban'] ?? 0),
        'tags'       => trim($_POST['tags']       ?? ''),
    ];

    // 2. Ảnh bìa mới (nếu có), ngược lại giữ lại giá trị cũ
    if (!empty($_FILES['anhbia']['tmp_name'])
        && $_FILES['anhbia']['error'] === UPLOAD_ERR_OK) {
        $ext       = pathinfo($_FILES['anhbia']['name'], PATHINFO_EXTENSION);
        $imageName = time() . '_' . uniqid() . '.' . $ext;
        $uploadDir = __DIR__ . '/../../public/assets/images/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        move_uploaded_file($_FILES['anhbia']['tmp_name'], $uploadDir . $imageName);
        $data['anhbia'] = $imageName;
    } else {
        // Nếu không upload mới, bạn có thể giữ lại ảnh cũ:
        $data['anhbia'] = $_POST['old_anhbia'] ?? '';
    }

    // 3. Cập nhật vào DB
    Book::update($id, $data);
    $_SESSION['success'] = 'Cập nhật sách thành công!';
    header('Location: /admin/manage-books');
    exit;
}

    /**
     * Xử lý xóa sách
     */
    public function deleteBook($id)
    {
        Book::delete($id);
        header('Location: /admin/manage-books');
        exit;
    }

    /**
     * Quản lý thành viên
     */
    public function manageMembers()
    {
        $members = Member::all();
        include_once __DIR__ . '/../views/admin/manage-members.php';
    }

    /**
     * Xử lý xóa thành viên
     */
    public function deleteMember()
    {
        if (isset($_GET['id'])) {
            Member::delete(intval($_GET['id']));
        }
        header('Location: /admin/manage-members');
        exit;
    }

    /**
     * Quản lý phiếu mượn
     */
    public function manageBorrows()
    {
        $status  = $_GET['status'] ?? null;
        $borrows = Borrow::getAll($status);
        include_once __DIR__ . '/../views/admin/manage-borrows.php';
    }

    /**
     * Hiển thị chi tiết phiếu mượn
     */
    public function showBorrowDetail($id)
    {
        $borrow  = Borrow::find($id);
        $details = BorrowDetail::findByBorrow($id);
        include_once __DIR__ . '/../views/admin/borrow-detail.php';
    }

    /**
     * Xử lý xóa phiếu mượn
     */
    public function deleteBorrow($id)
    {
        Borrow::delete($id);
        header('Location: /admin/manage-borrows');
        exit;
    }
}
?>
