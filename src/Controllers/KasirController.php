<?php
namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models\ProductModel;
use Mvcomp\Posapp\Models\UserModel;

class KasirController extends BaseController{
    public function index()
    {
        $modelu = new UserModel();
        $modelP = new ProductModel();
        $menus = $modelP->getAllProducts();
        $data = ['title' => 'Home Page', 'menus' => $menus];
        $this->render('kasir/index', $data);
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

            default:
                $menus = $modelP->getAllProducts();
                include __DIR__ . '/../views/home/listMenu.php';
                exit;
        }
    }
}