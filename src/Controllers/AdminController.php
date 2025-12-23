<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models\User;
use Mvcomp\Posapp\Models\Product;
use Mvcomp\Posapp\Models\Table;
use DateTimeZone;
use DateTime;

class AdminController extends BaseController
{

    public function adminPanel()
    {
        $data = ['title' => 'Admin Panel'];
        $this->render('admin/index', $data);
    }

    public function adminPanelMenu()
    {
        global $userHeader;
        global $productHeaders;
        $id = $_POST['id'] ?? '';
        switch (true) {
            case $id === 'dashboard':
                require_once __DIR__ . '/../views/admin/dashboard.php';
                exit;

            case $id === 'users':
                $id = 'users';
                $users = User::all()->toArray();
                $headers = TableConfig::userHeader();
                $rows = $users;
                $actions = ['actions'];
                require_once __DIR__ . '/../views/admin/users.php';
                exit;

            case $id === 'products':
                $id = 'products';
                $rows = Product::all()->toArray();
                $headers = TableConfig::productHeaders();
                // $actions = ['actions'];
                require __DIR__ . '/../views/admin/products.php';
                exit;


            case $id === 'qr_tokens':
                $id = 'qr_tokens';
                $rows = Table::all()->toArray();
                $headers = TableConfig::tableHeader();
                $actions = ['actions'];
                require_once __DIR__ . '/../views/admin/qr_tokens.php';
                exit;

            default:
                require_once __DIR__ . '/../views/except/404.php';
                exit;
        }
    }

    public function CRUD()
    {
        $search = trim($_POST['search'] ?? '');
        switch (true) {
            case isset($_POST['addUser']):
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $data = [
                    'username' => trim($_POST['username'] ?? ''),
                    'password' => $password,
                    'email'    => trim($_POST['email'] ?? ''),
                    'role'     => $_POST['role'] ?? 'guest',
                ];

                if (!$data['username'] || !$data['email'] || !$data['password']) {
                    http_response_code(422);
                    echo '<script>alert("Data tidak lengkap")</script>';
                    exit;
                }

                $success = User::create($data) ? true : false;
                echo $success ? 'User berhasil dibuat' : 'Gagal membuat user';

                header('HX-Trigger: userAdded');
                header('HX-Redirect: /admin/panel');
                exit;

            case isset($_POST['addTable']):
                $data = [
                    'name'     => trim($_POST['tablename'] ?? '-'),
                    'qr_token' => trim($_POST['qr_token'] ?? ''),
                    'status'   => 'available',
                ];

                if (!$data['name'] || !$data['qr_token']) {
                    http_response_code(422);
                    echo '<script>alert("Data tidak lengkap")</script>';
                    exit;
                }

                $success = Table::create($data) ? true : false;
                echo $success ? 'Table berhasil dibuat' : 'Gagal membuat table';

                header('HX-Redirect: /admin/panel');
                exit;

            case isset($_POST['addProduct']):
                if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    http_response_code(422);
                    exit('Gambar wajib diupload');
                }

                $file = $_FILES['image'];
                $allowed = ['image/png', 'image/webp', 'image/jepg', 'image/jpg'];
                if (!in_array($file['type'], $allowed)) {
                    http_response_code(415);
                    echo '<script>alert("Format gambar tidak didukung")</script>';
                    exit('Format gambar tidak didukung');
                }

                if ($file['size'] > 5 * 1024 * 1024) {
                    http_response_code(413);
                    echo '<script>alert("Ukuran gambar maksimal 5MB")</script>';
                    exit('Ukuran gambar maksimal 5MB');
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('product_', true) . '.' . $ext;

                $uploadPath = 'img/menu/';
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

                $success = Product::create($data) ? true : false;
                echo $success ? 'Product berhasil dibuat' : 'Gagal membuat product';

                header('HX-Redirect: /admin/panel');
                exit;

            case isset($_POST['searchButton']) && $search !== '':
                $users = User::where('username', 'LIKE', "%$search%")->orWhere('email', 'LIKE', "%$search%")->get()->toArray();
                $products = Product::where('name', 'LIKE', "%$search%")->orWhere('description', 'LIKE', "%$search%")->get()->toArray();
                if (count($users) > 0) {
                    $rows = $users;
                    $headers = TableConfig::userHeader();
                    $actions = ['actions'];
                } else if (count($products) > 0) {
                    $rows = $products;
                    $headers = TableConfig::productHeaders();
                    $actions = ['actions'];
                } else {
                    $rows = [];
                    $headers = [];
                    $actions = [];
                }

                include __DIR__ . '/../views/admin/components/table.php';
                exit;

            case isset($_POST['deleteItems']):
                $name = $_POST['deleteItems'];
                $user = User::where('username', $name)->first();
                $product = Product::where('name', $name)->first();

                if ($user) {
                    $success = $user->delete() ? true : false;
                    echo $success ? "<script>alert('User berhasil dihapus')</script>" : "<script>alert('Gagal menghapus user')</script>";
                } else if ($product) {
                    $success = $product->delete() ? true : false;
                    echo $success ? "<script>alert('Product berhasil dihapus')</script>" : "<script>alert('Gagal menghapus product')</script>";
                } else {
                    echo 'Data tidak ditemukan';
                }

                header('HX-Refresh: true');
                exit;

            case isset($_POST['filterUser']):
                $role = $_POST['filterUser'];
                $users = User::where('role', $role)->get()->toArray();
                $rows = $users;
                $headers = TableConfig::userHeader();
                $actions = ['actions'];
                include __DIR__ . '/../views/admin/components/table.php';
                exit;

            case isset($_POST['filterProduct']):
                $category = $_POST['filterProduct'];
                $products = Product::where('category', $category)->get()->toArray();
                $rows = $products;
                $headers = TableConfig::productHeaders();
                $actions = ['actions'];
                include __DIR__ . '/../views/admin/components/table.php';
                exit;

            case isset($_POST['loadEditItems']):
                $id = $_POST['id'];
                $user = User::where('username', $id)->first();
                $product = Product::where('name', $id)->first();

                if ($user) {
                    $defaultValue = $user->toArray();
                    $data = [
                        'id'       => $defaultValue['id'],
                        'username' => $defaultValue['username'],
                        'email'    => $defaultValue['email'],
                        'role'     => $defaultValue['role'],
                    ];
                    require __DIR__ . '/../views/admin/components/user.php';
                    exit;
                } else if ($product) {
                    $defaultValue = $product->toArray();
                    $data = [
                        'id'              => $defaultValue['id'],
                        'name'            => $defaultValue['name'],
                        'price'           => $defaultValue['price'],
                        'description'     => $defaultValue['description'],
                        'image'          => $defaultValue['image'],
                        'category'        => $defaultValue['category'],
                    ];
                    require __DIR__ . '/../views/admin/components/product.php';
                    exit;
                }

                exit;

            case isset($_POST['editUser']):
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $data = [
                    'username' => trim($_POST['username'] ?? ''),
                    'password' => $password,
                    'email'    => trim($_POST['email'] ?? ''),
                    'role'     => $_POST['role'] ?? 'guest',
                ];

                if (!$data['username'] || !$data['email'] || !$data['password']) {
                    http_response_code(422);
                    echo '<script>alert("Data tidak lengkap")</script>';
                    exit;
                }

                $success = User::where('id', $_POST['id'])->update($data);
                echo $success ? 'User berhasil diupdate' : 'Gagal membuat diupdate';

                header('HX-Trigger: userAdded');
                header('HX-Redirect: /admin/panel');
                exit;

            case isset($_POST['editProduct']):
                $file = $_FILES['image'];
                $allowed = ['image/png', 'image/webp', 'image/jepg', 'image/jpg'];
                if (!in_array($file['type'], $allowed)) {
                    http_response_code(415);
                    echo '<script>alert("Format gambar tidak didukung")</script>';
                    exit('Format gambar tidak didukung');
                }

                if ($file['size'] > 5 * 1024 * 1024) {
                    http_response_code(413);
                    echo '<script>alert("Ukuran gambar maksimal 5MB")</script>';
                    exit('Ukuran gambar maksimal 5MB');
                }

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('product_', true) . '.' . $ext;

                $uploadPath = 'img/menu/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                var_dump($file);
                move_uploaded_file($file['tmp_name'], $uploadPath . $filename);
                $data = [
                    'name'        => $_POST['name'],
                    'price'       => $_POST['price'],
                    'description' => $_POST['description'],
                    'image'       => $filename,
                    'category'    => $_POST['category'],
                ];

                $success = Product::where('id', $_POST['id'])->update($data);
                echo $success ? 'Product berhasil diupdate' : 'Gagal membuat diupdate';

                header('HX-Redirect: /admin/panel');
                exit;

            default:
                http_response_code(400);
                echo 'Bad Request';
                header('HX-Refresh: true');
                exit;
        }
    }

    public function QR(){

    }
}

class checker {
    public static function isValidStatus(string $status)
    {
        if($status == 'available' || $status == 'occupied' || $status == 'reserved'){
            
        }
    }
}

class Formatter
{
    public static function date(
        ?string $value,
        string $format = 'd M Y',
        string $tz = 'Asia/Jakarta'
    ): string {
        if (!$value) return 'N/A';

        return (new DateTime($value))
            ->setTimezone(new DateTimeZone($tz))
            ->format($format);
    }
}

class TableConfig
{
    public static function userHeader(): array
    {
        return [
            ['label' => 'Full Name',   'key' => 'username'],
            ['label' => 'Email',       'key' => 'email'],
            ['label' => 'Role',        'key' => 'role'],
            [
                'label'     => 'Joined Date',
                'key'       => 'created_at',
                'class'     => 'text-nowrap',
                'formatter' => fn($v) => Formatter::date($v, 'd M Y')
            ]

        ];
    }

    public static function productHeaders(): array
    {
        return [
            ['label' => 'Name',        'key' => 'name'],
            [
                'label' => 'Description',
                'key' => 'description',
                'class' => ''
            ],
            [
                'label'     => 'Price',
                'key'       => 'price',
                'class'     => 'text-left text-nowrap',
                'formatter' => fn($v) => 'Rp ' . number_format((float)$v, 0, ',', '.')
            ],
        ];
    }

    public static function tableHeader(): array
    {
        return [
            ['label' => 'Id', 'key' => 'id'],
            ['label' => 'Name', 'key' => 'name'],
            ['label' => 'QR Token', 'key' => 'qr_token'],
            ['label' => 'Status', 'key' => 'status'],
        ];
    }
}
