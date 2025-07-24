<?php
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Member.php';
require_once __DIR__ . '/../models/Borrow.php';
require_once __DIR__ . '/../models/BorrowDetail.php';
use App\Models\Book;
class AdminController
{
    /**
     * Hiển thị trang dashboard
     */
    public function dashboard()
    {
        include_once __DIR__ . '/../views/admin/dashboard.php';
    }

public function manageBooks()
{
    $db = Database::getInstance()->getConnection();

    // Lấy danh sách tất cả thể loại và tác giả (dùng cho dropdown lọc)
    $genres = $db->query("SELECT * FROM theloai")->fetchAll(PDO::FETCH_ASSOC);
    $authors = $db->query("SELECT * FROM tacgia")->fetchAll(PDO::FETCH_ASSOC);

    // Xử lý tìm kiếm và lọc
    $keyword     = trim($_GET['keyword'] ?? '');
    $tacgia_id   = intval($_GET['tacgia_id'] ?? 0);
    $theloai_id  = intval($_GET['theloai_id'] ?? 0);

    $conditions = [];
    if ($keyword !== '') {
        $conditions[] = "CONVERT(LOWER(s.tensach) USING utf8mb4) LIKE CONVERT(LOWER(:keyword) USING utf8mb4)";
    }
    if ($tacgia_id > 0) {
        $conditions[] = "s.tacgia_id = :tacgia_id";
    }
    if ($theloai_id > 0) {
        $conditions[] = "s.theloai_id = :theloai_id";
    }

    $sql = "
        SELECT s.*, tg.tentacgia, tl.tentheloai
        FROM sach s
        LEFT JOIN tacgia tg ON s.tacgia_id = tg.id
        LEFT JOIN theloai tl ON s.theloai_id = tl.id
    ";

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $db->prepare($sql);
    if ($keyword !== '') {
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
    }
    if ($tacgia_id > 0) {
        $stmt->bindValue(':tacgia_id', $tacgia_id, PDO::PARAM_INT);
    }
    if ($theloai_id > 0) {
        $stmt->bindValue(':theloai_id', $theloai_id, PDO::PARAM_INT);
    }
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_OBJ);

    include_once __DIR__ . '/../views/admin/manage-books.php';
}


public function showAddBookForm()
{
    $db = Database::getInstance()->getConnection();
    $genres = $db->query("SELECT * FROM theloai")->fetchAll(PDO::FETCH_ASSOC);
    $authors = $db->query("SELECT * FROM tacgia")->fetchAll(PDO::FETCH_ASSOC);

    include_once __DIR__ . '/../views/admin/add-book.php';
}

public function addBook()
{
    $tensach     = trim($_POST['tensach'] ?? '');
    $tacgia_id   = intval($_POST['tacgia_id'] ?? 0);
    $theloai_id  = intval($_POST['theloai_id'] ?? 0);
    $nhaxuatban  = trim($_POST['nhaxuatban'] ?? '');
    $namxuatban  = intval($_POST['namxuatban'] ?? 0);
    $soluong     = intval($_POST['soluong'] ?? 0);
    $mota        = trim($_POST['mota'] ?? '');
    $tags        = trim($_POST['tags'] ?? '');

    $errors = [];
    if ($tensach === '') $errors[] = 'Tên sách không được để trống.';
    if ($tacgia_id <= 0) $errors[] = 'Bạn phải chọn tác giả.';
    if ($theloai_id <= 0) $errors[] = 'Bạn phải chọn thể loại.';

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: /admin/add-book');
        exit;
    }

    Book::create([
        'tensach'     => $tensach,
        'mota'        => $mota,
        'soluong'     => $soluong,
        'theloai_id'  => $theloai_id,
        'tacgia_id'   => $tacgia_id,
        'nhaxuatban'  => $nhaxuatban,
        'namxuatban'  => $namxuatban,
        'tags'        => $tags
    ]);

    $_SESSION['success'] = 'Thêm sách thành công!';
    header('Location: /admin/manage-books');
    exit;
}

public function showEditBookForm($id)
{
    $book = Book::find($id);

    $db = Database::getInstance()->getConnection();
    $genres = $db->query("SELECT * FROM theloai")->fetchAll(PDO::FETCH_ASSOC);
    $authors = $db->query("SELECT * FROM tacgia")->fetchAll(PDO::FETCH_ASSOC);

    include_once __DIR__ . '/../views/admin/edit-book.php';
}

public function updateBook($id)
{
    $data = [
        'tensach'     => trim($_POST['tensach'] ?? ''),
        'mota'        => trim($_POST['mota'] ?? ''),
        'soluong'     => intval($_POST['soluong'] ?? 0),
        'theloai_id'  => intval($_POST['theloai_id'] ?? 0),
        'tacgia_id'   => intval($_POST['tacgia_id'] ?? 0),
        'nhaxuatban'  => trim($_POST['nhaxuatban'] ?? ''),
        'namxuatban'  => intval($_POST['namxuatban'] ?? 0),
        'tags'        => trim($_POST['tags'] ?? '')
    ];

    Book::update($id, $data);
    $_SESSION['success'] = 'Cập nhật sách thành công!';
    header('Location: /admin/manage-books');
    exit;
}

public function deleteBook($id)
{
    Book::delete($id);
    $_SESSION['success'] = 'Đã xóa sách thành công!';
    header('Location: /admin/manage-books');
    exit;
}

}
?>
