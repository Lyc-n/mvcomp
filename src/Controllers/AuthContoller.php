<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models\UserModel;

class AuthContoller extends BaseController
{
    public function login()
    {
        $data = ['title' => 'Login'];
        $this->render('auth/login', $data);
    }

    public function register()
    {
        $data = ['title' => 'Register'];
        $this->render('auth/register', $data);
    }

    public function CRUD()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $model  = new UserModel();
        switch (true) {
            case isset($_POST['register']):
                $data = [
                    'username' => trim($_POST['username'] ?? ''),
                    'password' => $_POST['password'] ?? '',
                    'email'    => trim($_POST['email'] ?? ''),
                    'role'     => 'guest',
                ];

                if (!$data['username'] || !$data['email'] || !$data['password']) {
                    http_response_code(422);
                    echo 'Data tidak lengkap';
                    header('location: /mvcomp/auth/register');
                    exit;
                }

                $success = $model->createUser($data);
                echo $success ? 'User berhasil dibuat' : 'Gagal membuat user';

                header('location: /mvcomp/auth/login');
                exit;
            case isset($_POST['login']):
                $data = [
                    'username' => trim($_POST['username'] ?? ''),
                    'password' => $_POST['password'] ?? '',
                    'email'    => trim($_POST['username'] ?? ''),
                    'role'     => 'guest',
                ];

                if (!$data['username'] || !$data['email'] || !$data['password']) {
                    http_response_code(422);
                    echo 'Data tidak lengkap';
                    header('location: /mvcomp/auth/login');
                    exit;
                }

                $user = $model->findByUsernameOrEmail($data['username']);

                if (!$user || !password_verify($data['password'], $user['password'])) {
                    http_response_code(401);
                    exit('Username atau password salah');
                }

                session_regenerate_id(true);

                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'permissions' => []
                ];

                if($user['role'] == 'guest' || $user['role'] == 'member'){
                    header('location: /mvcomp/');
                } else if($user['role'] == 'kasir') {
                    header('location: /mvcomp/kasir');
                } else{
                    header('location: /mvcomp/admin/panel');
                }
                exit;
            default:
                exit;
        }
    }

    public function logout()
    {
        // Pastikan session aktif
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Hapus semua data session
            $_SESSION = [];

            // Hapus cookie session (penting)
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }

            // Hancurkan session
            session_destroy();
        }

        // Redirect ke halaman login
        header('Location: /mvcomp/auth/login');
        exit;
    }
}
