<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models\ProductModel;
use Mvcomp\Posapp\Models\UserModel;

class HomeControlller extends BaseController
{
    public function index($params)
    {
        $param = ($params['meja'] ?? '6');
        $modelu = new UserModel();
        $modelP = new ProductModel();
        $menus = $modelP->getAllProducts();

        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = [
                'id' => '10',
                'username' => 'guest',
                'role' => 'guest',
                'permissions' => []
            ];
        } else if ($_SESSION['user']['role'] == 'kasir') {
            echo "<script>window.location.href = '/mvcomp/kasir';</script>";
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cookieName = 'order_history_user_' . $userId;
        $orderHistory = [];

        if (isset($_COOKIE[$cookieName])) {
            $orderHistory = json_decode($_COOKIE[$cookieName], true);
        }

        $data = ['title' => 'Home Page', 'menus' => $menus, 'param' => $param, 'orderHistory' => $orderHistory];
        $this->render('home/index', $data);
    }

    public function CRUD()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        $modelu = new UserModel();
        $modelP = new ProductModel();
        $search = trim($_POST['search'] ?? '');

        switch (true) {
            case isset($_POST['category']):
                $id = ($_POST['id'] ?? '');
                if ($id == 'makanan') {
                    $menus = $modelP->getProductByText($id);
                    include __DIR__ . '/../views/home/listMenu.php';
                    exit;
                } else if ($id == 'minuman') {
                    $menus = $modelP->getProductByText($id);
                    include __DIR__ . '/../views/home/listMenu.php';
                    exit;
                } else if ($id == 'kudapan') {
                    $menus = $modelP->getProductByText($id);
                    include __DIR__ . '/../views/home/listMenu.php';
                    exit;
                } else {
                    $menus = $modelP->getAllProducts();
                    include __DIR__ . '/../views/home/listMenu.php';
                    exit;
                }
                exit;

            case isset($_POST['searchButton']) && $search !== '':
                $menus = $modelP->getProductByText('%' . $search . '%');
                include __DIR__ . '/../views/home/listMenu.php';
                exit;

            case isset($_POST['id']):
                $id = (int) ($_POST['id'] ?? 0);
                if ($id <= 0) {
                    http_response_code(400);
                    exit;
                }
                $detailMenu = $modelP->getProductById($id);
                include __DIR__ . '/../views/home/detail.php';
                exit;

            case isset($_POST['idCheck']):
                $id = $_POST['idCheck'];
                if ($id == 'keranjang') {
                    include __DIR__ . '/../views/home/cart.php';
                    exit;
                }
                break;

            case isset($_POST['addCart']):
                $idP = (int) $_POST['idProduct'];
                $idT = (int) ($_POST['idTable'] ?? 6);
                $idU = (int) ($_POST['idUser'] ?? 10);

                $get = $modelP->getProductById($idP);

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [
                        'TableId' => $idT,
                        'UserId'  => $idU,
                        'items'   => [],
                        'total'   => 0
                    ];
                }
                $found = false;
                foreach ($_SESSION['cart']['items'] as &$item) {
                    if ($item['nameProduct'] === $get['name']) {
                        $item['qty']++;
                        $found = true;
                        break;
                    }
                }
                unset($item);
                if (!$found) {
                    $_SESSION['cart']['items'][] = [
                        'nameProduct'  => $get['name'],
                        'priceProduct' => (float) $get['price'],
                        'qty'          => 1
                    ];
                }
                // hitung ulang total
                $_SESSION['cart']['total'] = 0;
                foreach ($_SESSION['cart']['items'] as $item) {
                    $_SESSION['cart']['total'] += $item['priceProduct'] * $item['qty'];
                }
                break;

            default:
                $menus = $modelP->getAllProducts();
                include __DIR__ . '/../views/home/listMenu.php';
                exit;
        }
    }
}
