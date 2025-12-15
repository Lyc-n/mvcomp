<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models\ProductModel;
use Mvcomp\Posapp\Models\UserModel;

class AdminController extends BaseController
{
    public function adminPanel()
    {
        $data = ['title' => 'Admin Panel'];
        $this->render('admin/index', $data);
    }

    public function adminPanelMenu()
    {
        $id = $_POST['id'] ?? '';
        switch (true) {
            case $id === 'dashboard':
                include __DIR__ . '/../views/admin/dashboard.php';
                exit;

            case $id === 'users':
                $model = new UserModel;
                $users = $model->getAllUsers();
                include __DIR__ . '/../views/admin/users.php';
                exit;

            case $id === 'products':
                $model = new ProductModel;
                $products = $model->getAllProducts();
                include __DIR__ . '/../views/admin/products.php';
                exit;

            case $id === 'reports':
                include __DIR__ . '/../views/admin/reports.php';
                exit;

            default:
                include __DIR__ . '/../views/except/404.php';
                exit;
        }
    }

    public function adminCRUDUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $model  = new UserModel();
        $search = trim($_POST['search'] ?? '');
        switch (true) {
            case isset($_POST['deleteUser']):
                $id = (int) $_POST['deleteUser'];

                if ($id <= 0) {
                    http_response_code(400);
                    echo 'ID tidak valid';
                    exit;
                }

                if (!$model->deleteUser($id)) {
                    http_response_code(500);
                    echo 'DELETE gagal';
                    exit;
                }

                $users = $model->getAllUsers();
                include __DIR__ . '/../views/admin/table.php';
                exit;

            case isset($_POST['addUser']):
                $data = [
                    'username' => trim($_POST['username'] ?? ''),
                    'password' => $_POST['password'] ?? '',
                    'email'    => trim($_POST['email'] ?? ''),
                    'role'     => $_POST['role'] ?? 'guest',
                ];

                if (!$data['username'] || !$data['email'] || !$data['password']) {
                    http_response_code(422);
                    echo 'Data tidak lengkap';
                    exit;
                }

                $success = $model->createUser($data);
                echo $success ? 'User berhasil dibuat' : 'Gagal membuat user';

                header('HX-Trigger: userAdded');
                header('HX-Redirect: /mvcomp/admin/panel');
                exit;

            case isset($_POST['searchButton']) && $search !== '':
                $users = $model->getUserByText('%' . $search . '%');
                include __DIR__ . '/../views/admin/table.php';
                exit;

            case isset($_POST['filterUser']):
                $users = $model->getUserByRole($_POST['filterUser']);
                include __DIR__ . '/../views/admin/table.php';
                exit;
            case isset($_POST['loadEditUser']):
                $id = (int) ($_POST['id'] ?? 0);
                if ($id <= 0) {
                    http_response_code(400);
                    exit;
                }

                $defaultValue = $model->getUserById($id);
                if (!$defaultValue) {
                    http_response_code(404);
                    exit;
                }

                // render modal saja (HTML)
                include __DIR__ . '/../views/admin/editUser.php';
                exit;

            case isset($_POST['editUser']):
                $id = (int) ($_POST['id'] ?? 0);
                if ($id <= 0) {
                    http_response_code(400);
                    exit;
                }

                $defaultValue = $model->getUserById($id);

                $data = [
                    'username' => trim($_POST['username'] ?? $defaultValue['username']),
                    'email'    => trim($_POST['email'] ?? $defaultValue['email']),
                    'password' => $_POST['password'] ?: null,
                    'role'     => $_POST['role'] ?? $defaultValue['role'],
                ];

                if (!$data['username'] || !$data['email']) {
                    http_response_code(422);
                    exit('Data tidak lengkap');
                }

                $model->updateUser($id, $data);

                header('HX-Redirect: /mvcomp/admin/panel');
                exit;

            default:
                $users = $model->getAllUsers();
                include __DIR__ . '/../views/admin/table.php';
                exit;
        }
    }

    public function adminCRUDProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $model  = new ProductModel();
        $search = trim($_POST['search'] ?? '');
        switch (true) {
            case isset($_POST['deleteProduct']):
                $id = (int) $_POST['deleteProduct'];

                if ($id <= 0) {
                    http_response_code(400);
                    echo 'ID tidak valid';
                    exit;
                }

                if (!$model->deleteProduct($id)) {
                    http_response_code(500);
                    echo 'DELETE gagal';
                    exit;
                }

                $products = $model->getAllProducts();
                include __DIR__ . '/../views/admin/tableP.php';
                exit;

            case isset($_POST['addProduct']):
                if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    http_response_code(422);
                    exit('Gambar wajib diupload');
                }

                $file = $_FILES['image'];
                $allowed = ['image/png', 'image/webp', 'image/jepg'];
                if (!in_array($file['type'], $allowed)) {
                    http_response_code(415);
                    exit('Format gambar tidak didukung');
                }

                if ($file['size'] > 5 * 1024 * 1024) {
                    http_response_code(413);
                    exit('Ukuran gambar maksimal 5MB');
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('product_', true) . '.' . $ext;

                $uploadPath = __DIR__ . '/../../public/img/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                var_dump($file);
                move_uploaded_file($file['tmp_name'], $uploadPath . $filename);

                $data = [
                    'name' => $_POST['productname'],
                    'price'       => $_POST['price'],
                    'description' => $_POST['description'],
                    'category'    => $_POST['category'],
                    'image'       => $filename
                ];

                $success = $model->createProduct($data);
                echo $success ? 'User berhasil dibuat' : 'Gagal membuat user';

                header('HX-Redirect: /mvcomp/admin/panel');
                exit;

            case isset($_POST['searchButton']) && $search !== '':
                $products = $model->getProductByText('%' . $search . '%');
                include __DIR__ . '/../views/admin/tableP.php';
                exit;

            case isset($_POST['filterProduct']):
                $products = $model->getProductByText($_POST['filterProduct']);
                include __DIR__ . '/../views/admin/tableP.php';
                exit;
            case isset($_POST['loadEditProduct']):
                $id = (int) ($_POST['id'] ?? 0);
                if ($id <= 0) {
                    http_response_code(400);
                    exit;
                }

                $defaultValue = $model->getProductById($id);
                if (!$defaultValue) {
                    http_response_code(404);
                    exit;
                }

                // render modal saja (HTML)
                include __DIR__ . '/../views/admin/editProduct.php';
                exit;

            case isset($_POST['editProduct']):
                $id = (int) ($_POST['id'] ?? 0);
                if ($id <= 0) {
                    http_response_code(400);
                    exit;
                }

                $defaultValue = $model->getProductById($id);

                $data = [
                    'name' => trim($_POST['name'] ?? $defaultValue['name']),
                    'category' => trim($_POST['category'] ?? $defaultValue['category']),
                    'price' => $_POST['price'] ?: null,
                    'description' => $_POST['description'] ?? $defaultValue['description'],
                ];

                if (!$data['name'] || !$data['price']) {
                    http_response_code(422);
                    exit('Data tidak lengkap');
                }

                $model->updateProduct($id, $data);

                header('HX-Redirect: /mvcomp/admin/panel');
                exit;

            default:
                $products = $model->getAllProducts();
                include __DIR__ . '/../views/admin/tableP.php';
                exit;
        }
    }

    public function adminLogin()
    {
        $data = ['title' => 'Admin Login'];
        $this->render('admin/login', $data);
    }

    public function adminAuthenticate()
    {
        // Authentication logic here
    }

    public function adminRegister()
    {
        $data = ['title' => 'Admin Register'];
        $this->render('admin/register', $data);
    }

    public function adminStoreRegister()
    {
        // Registration logic here
    }
}
