<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = User::authenticate($email, $password);
            if ($user) {
                $_SESSION['user_id']   = $user->id;
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_role'] = $user->role;
                
                if ($user->role === 'admin') {
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
                'name'     => trim($_POST['name']),
                'email'    => trim($_POST['email']),
                'password' => $_POST['password'],
                'phone'    => trim($_POST['phone']),
                'address'  => trim($_POST['address']),
                'birthday' => $_POST['birthday']
            ];
            $user = new User($data);
            if ($user->save()) {
                header('Location: /login');
                exit;
            } else {
                $error = "Đăng ký thất bại, vui lòng thử lại!";
            }
        }
        include_once __DIR__ . '/../views/register.php';
    }
}
?>
