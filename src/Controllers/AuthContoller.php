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
                    exit;
                }

                $success = $model->createUser($data);
                echo $success ? 'User berhasil dibuat' : 'Gagal membuat user';

                header('location: /mvcomp/');
                exit;
            default:
        }
    }
}
