<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models\User;
use Mvcomp\Posapp\Models\Product;
use DateTime;
use DateTimeZone;

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
                require_once __DIR__ . '/../views/admin/dashboard.php';
                exit;

            case $id === 'users':
                $id = 'users';
                $users = User::all()->toArray();
                $headers = [
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
                $rows = $users;
                $actions = ['actions'];
                require_once __DIR__ . '/../views/admin/users.php';
                exit;

            case $id === 'products':
                $id = 'products';
                $rows = Product::all()->toArray();
                $headers = [
                    ['label' => 'Name',        'key' => 'name'],
                    ['label' => 'Description', 'key' => 'description'],
                    [
                        'label'     => 'Price',
                        'key'       => 'price',
                        'class'     => 'text-right',
                        'formatter' => fn($v) => 'Rp ' . number_format((float)$v, 0, ',', '.')
                    ],
                ];
                $actions = ['actions'];
                require __DIR__ . '/../views/admin/products.php';
                exit;


            case $id === 'reports':
                require_once __DIR__ . '/../views/admin/reports.php';
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
                $data = [
                    'username' => trim($_POST['username'] ?? ''),
                    'password' => $_POST['password'] ?? '',
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
                    $headers = [
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
                    $actions = ['actions'];
                } else if (count($products) > 0) {
                    $rows = $products;
                    $headers = [
                        ['label' => 'Name',        'key' => 'name'],
                        ['label' => 'Description', 'key' => 'description'],
                        [
                            'label'     => 'Price',
                            'key'       => 'price',
                            'class'     => 'text-right',
                            'formatter' => fn($v) => 'Rp ' . number_format((float)$v, 0, ',', '.')
                        ],
                    ];
                    $actions = ['actions'];
                } else {
                    $rows = [];
                    $headers = [];
                    $actions = [];
                }

                include __DIR__ . '/../views/admin/components/table.php';
                exit;

            case isset($_POST['deleteItems']):
                $name = (string) $_POST['deleteItems'];

                if (!User::destroy($name)) {
                    http_response_code(500);
                    echo 'DELETE gagal';
                    exit;
                }

                header('HX-Refresh: true');
                exit;


            default:
                http_response_code(400);
                echo 'Bad Request';
                exit;
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
