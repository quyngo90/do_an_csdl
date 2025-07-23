<?php
require_once __DIR__ . '/../../config/database.php';

class Member {
    public $id;
    public $hoten;
    public $email;
    public $matkhau;
    public $sodienthoai;
    public $diachi;
    public $ngaysinh;
    public $vaitro;
    public $mathe;
    public $ngaytao;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->hoten = $data['hoten'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->matkhau = $data['matkhau'] ?? '';
        $this->sodienthoai = $data['sodienthoai'] ?? '';
        $this->diachi = $data['diachi'] ?? '';
        $this->ngaysinh = $data['ngaysinh'] ?? null;
        $this->vaitro = $data['vaitro'] ?? 'docgia';
        $this->mathe = $data['mathe'] ?? $this->generateMemberCode();
        $this->ngaytao = $data['ngaytao'] ?? null;
    }

    private function generateMemberCode() {
        return 'MB' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        
        // Nếu là tạo mới, hash password
        if (!isset($this->id)) {
            $this->matkhau = password_hash($this->matkhau, PASSWORD_DEFAULT);
        }

        $stmt = $db->prepare("INSERT INTO thanhvien 
            (hoten, email, matkhau, sodienthoai, diachi, ngaysinh, vaitro, mathe) 
            VALUES (:hoten, :email, :matkhau, :sodienthoai, :diachi, :ngaysinh, :vaitro, :mathe)");
        
        $stmt->bindValue(':hoten', $this->hoten);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':matkhau', $this->matkhau);
        $stmt->bindValue(':sodienthoai', $this->sodienthoai);
        $stmt->bindValue(':diachi', $this->diachi);
        $stmt->bindValue(':ngaysinh', $this->ngaysinh);
        $stmt->bindValue(':vaitro', $this->vaitro);
        $stmt->bindValue(':mathe', $this->mathe);
        
        if ($stmt->execute()) {
            $this->id = $db->lastInsertId();
            return true;
        }
        return false;
    }

    public static function authenticate($email, $password) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM thanhvien WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row && password_verify($password, $row['matkhau'])) {
            return new Member($row);
        }
        return false;
    }

    public static function all() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM thanhvien ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $members = [];
        foreach ($rows as $row) {
            $members[] = new Member($row);
        }
        return $members;
    }

    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM thanhvien WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new Member($row);
        }
        return null;
    }

    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE thanhvien 
            SET hoten = :hoten, email = :email, sodienthoai = :sodienthoai, 
                diachi = :diachi, ngaysinh = :ngaysinh, vaitro = :vaitro 
            WHERE id = :id");
        
        $stmt->bindValue(':hoten', $data['hoten']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':sodienthoai', $data['sodienthoai']);
        $stmt->bindValue(':diachi', $data['diachi']);
        $stmt->bindValue(':ngaysinh', $data['ngaysinh']);
        $stmt->bindValue(':vaitro', $data['vaitro']);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM thanhvien WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}