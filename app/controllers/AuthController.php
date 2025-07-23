<?php
require_once __DIR__ . '/../models/Member.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $member = Member::authenticate($email, $password);
            
            if ($member) {
                $_SESSION['user_id'] = $member->id;
                $_SESSION['user_name'] = $member->hoten;
                $_SESSION['user_role'] = $member->vaitro;
                
                    if ($member->vaitro === 'quantri') {
                        header('Location: /admin/dashboard');
                } else {
                    header('Location: /');
                }
                exit;
            } else {
                $error = "Sai thông tin đăng nhập!";
            }
        }
        include_once __DIR__ . '/../views/login.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'hoten' => trim($_POST['hoten']),
                'email' => trim($_POST['email']),
                'matkhau' => $_POST['matkhau'],
                'sodienthoai' => trim($_POST['sodienthoai']),
                'diachi' => trim($_POST['diachi']),
                'ngaysinh' => $_POST['ngaysinh'],
                'vaitro' => 'docgia'
            ];
            
            $member = new Member($data);
            if ($member->save()) {
                header('Location: /login');
                exit;
            } else {
                $error = "Đăng ký thất bại, vui lòng thử lại!";
            }
        }
        include_once __DIR__ . '/../views/register.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }
}