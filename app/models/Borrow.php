<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/BorrowDetail.php'; 

class Borrow {      
    public $id;
    public $id_thanhvien;
    public $tongtienphat;
    public $trangthai;
    public $ghichu;
    public $ngaymuon;
    public $hantra;
    public $ngaytra;
    public $ngaytao;
    public $chitiet = [];

    public function __construct($data) {
        $this->id_thanhvien = $data['id_thanhvien'] ?? null;
        $this->tongtienphat = $data['tongtienphat'] ?? 0;
        $this->trangthai = $data['trangthai'] ?? 'choduyet';
        $this->ghichu = $data['ghichu'] ?? '';
        $this->ngaymuon = $data['ngaymuon'] ?? date('Y-m-d');
        $this->hantra = $data['hantra'] ?? date('Y-m-d', strtotime('+14 days'));
        $this->chitiet = $data['chitiet'] ?? [];
    }

    public static function findActiveByUser($userId) {
    $conn = Connection::getInstance();
    $stmt = $conn->prepare("SELECT * FROM borrows WHERE user_id = ? AND status = 'dangmuon' LIMIT 1");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    // Thêm vào Borrow.php
public static function getAll($status = null) {
    $db = Database::getInstance()->getConnection();
    $sql = "SELECT pm.*, tv.hoten as ten_thanhvien 
            FROM phieumuon pm
            JOIN thanhvien tv ON pm.id_thanhvien = tv.id";
    
    if ($status) {
        $sql .= " WHERE pm.trangthai = :trangthai";
    }
    
    $sql .= " ORDER BY pm.ngaymuon DESC";
    
    $stmt = $db->prepare($sql);
    if ($status) {
        $stmt->bindValue(':trangthai', $status);
    }
    $stmt->execute();
    
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $borrows = [];
    foreach ($rows as $row) {
        $row['chitiet'] = BorrowDetail::getByBorrowId($row['id']);
        $borrow = new Borrow($row);
        $borrow->id = $row['id'];
        $borrow->ngaytao = $row['ngaytao'];
        $borrows[] = $borrow;
    }
    return $borrows;
}
    public function save() {
        $db = Database::getInstance()->getConnection();
        try {
            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO phieumuon 
                (id_thanhvien, tongtienphat, trangthai, ghichu, ngaymuon, hantra) 
                VALUES (:id_thanhvien, :tongtienphat, :trangthai, :ghichu, :ngaymuon, :hantra)");
            
            $stmt->bindValue(':id_thanhvien', $this->id_thanhvien);
            $stmt->bindValue(':tongtienphat', $this->tongtienphat);
            $stmt->bindValue(':trangthai', $this->trangthai);
            $stmt->bindValue(':ghichu', $this->ghichu);
            $stmt->bindValue(':ngaymuon', $this->ngaymuon);
            $stmt->bindValue(':hantra', $this->hantra);
            
            $stmt->execute();
            $this->id = $db->lastInsertId();

            foreach ($this->chitiet as $item) {
                BorrowDetail::create([
                    'id_phieumuon' => $this->id,
                    'id_sach' => $item['sach']->id,
                    'soluong' => $item['soluong'],
                    'giaphat' => 0
                ]);
                
                Book::decreaseQuantity($item['sach']->id, $item['soluong']);
            }

            $db->commit();
            return true;
        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Lỗi khi lưu phiếu mượn: " . $e->getMessage());
            return false;
        }
    }

    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT pm.*, tv.hoten as ten_thanhvien 
                FROM phieumuon pm
                JOIN thanhvien tv ON pm.id_thanhvien = tv.id
                WHERE pm.id = ? LIMIT 1";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        
        $borrowData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($borrowData) {
            $borrowData['chitiet'] = BorrowDetail::getByBorrowId($borrowData['id']);
            $borrow = new Borrow($borrowData);
            $borrow->id = $borrowData['id'];
            $borrow->ngaytao = $borrowData['ngaytao'];
            return $borrow;
        }
        return null;
    }

    public static function getByMemberId($memberId) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT pm.* FROM phieumuon pm 
                WHERE pm.id_thanhvien = ? 
                ORDER BY pm.ngaymuon DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$memberId]);
        
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $borrows = [];
        foreach ($rows as $row) {
            $row['chitiet'] = BorrowDetail::getByBorrowId($row['id']);
            $borrow = new Borrow($row);
            $borrow->id = $row['id'];
            $borrow->ngaytao = $row['ngaytao'];
            $borrows[] = $borrow;
        }
        return $borrows;
    }

    public static function updateStatus($id, $status) {
        $allowedStatuses = ["choduyet", "dangmuon", "datra", "trathan", "dahuy"];
        if (!in_array($status, $allowedStatuses)) {
            return false;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE phieumuon SET trangthai = :trangthai WHERE id = :id");
        $stmt->bindValue(':trangthai', $status);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>