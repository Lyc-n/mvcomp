<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models\Product;
use Mvcomp\Posapp\Models\Table;

class HomeController extends BaseController
{
    public function index()
    {
        $products = Product::all()->toArray();
        $tables = Table::all();
        $data = [
            'title' => 'Home Page',
            'menus' => $products,
            'tables' => $tables
        ];

        $this->render('home/index', $data);
    }

    public function CRUD()
    {
        if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
            http_response_code(405);
            exit;
        }
        $search = $_POST['search'] ?? '';

        switch (true) {
            case isset($search) && !empty($search):
                $menus = Product::where('name', 'LIKE', "%$search%")->get()->toArray();
                require_once __DIR__ . '/../views/components/listMenu.php';
                break;

            case isset($_POST['category']):
                $id = $_POST['id'] ?? '';
                $menus = match (true) {
                    in_array($id, ['makanan', 'minuman', 'kudapan']) => Product::where('category', $id)->get()->toArray(),
                    default => Product::all()->toArray(),
                };
                require_once __DIR__ . '/../views/components/listMenu.php';
                break;

            case isset($_POST['id']):
                $id = (int) ($_POST['id'] ?? 0);
                if ($id <= 0) {
                    http_response_code(400);
                    exit;
                }
                $detailMenu = Product::find($id);
                require_once __DIR__ . '/../views/components/detail.php';
                exit;

            case isset($_POST['idCheck']):
                $id = $_POST['idCheck'];
                if ($id == 'keranjang') {
                    require_once __DIR__ . '/../views/components/cart.php';
                    exit;
                }
                break;

            case isset($_POST['addCart']):
                $idP = (int) $_POST['idProduct'];
                $idT = (int) ($_POST['idTable'] ?? 6);
                $idU = (int) ($_POST['idUser'] ?? 10);

                $get = Product::find($idP);

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
                $menus = Product::all()->toArray();
                require_once __DIR__ . '/../views/components/listMenu.php';
                break;
        }
    }
}
