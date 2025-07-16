<?php
require_once __DIR__ . '/../../config/database.php'; // Đảm bảo đã nạp file Database.php

class User {
    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $phone;     // Thêm
    public $address;   // Thêm
    public $birthday;  // Thêm

    public function __construct($data) {
        if (is_array($data)) {
            $this->id       = $data['id']       ?? null;
            $this->name     = $data['name']     ?? '';
            $this->email    = $data['email']    ?? '';
            // Nếu dữ liệu đến từ form (không có id), băm mật khẩu
            if (!isset($data['id'])) {
                $this->password = password_hash($data['password'] ?? '', PASSWORD_DEFAULT);
            } else {
                $this->password = $data['password'];
            }
            $this->role     = $data['role']     ?? 'customer';
            $this->phone    = $data['phone']    ?? '';
            $this->address  = $data['address']  ?? '';
            $this->birthday = $data['birthday'] ?? '';
        }
    }
    

    public function save() {
        $db = Database::getInstance()->getConnection();
        // Chèn đủ cột: name, email, password, phone, address, birthday, role
        $stmt = $db->prepare("
            INSERT INTO users (name, email, password, role, phone, address, birthday)
            VALUES (:name, :email, :password, :role, :phone, :address, :birthday)
        ");
        $stmt->bindValue(':name',     $this->name);
        $stmt->bindValue(':email',    $this->email);
        $stmt->bindValue(':password', $this->password);
        $stmt->bindValue(':role',     $this->role);
        $stmt->bindValue(':phone',    $this->phone);
        $stmt->bindValue(':address',  $this->address);
        $stmt->bindValue(':birthday', $this->birthday);
        if ($stmt->execute()) {
            $this->id = $db->lastInsertId();
            return true;
        }
        return false;
    }

    public static function authenticate($email, $password) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($password, $row['password'])) {
            // Trả về đối tượng User với đầy đủ thông tin
            return new User($row);
        }
        return false;
    }

    // Sửa hàm all() để lấy dữ liệu thật từ bảng users thay vì trả về mảng tĩnh
    public static function all() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM users ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $row) {
            $users[] = new User($row);
        }
        return $users;
    }
    // Thêm phương thức này vào file Models/User.php, bên trong lớp User
public static function delete($id) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    return $stmt->execute();
}

}
