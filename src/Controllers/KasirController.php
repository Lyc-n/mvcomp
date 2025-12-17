<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models\ProductModel;
use Mvcomp\Posapp\Models\UserModel;

class KasirController extends BaseController
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = \Mvcomp\Posapp\App\Database::getConnection();
    }

    public function index($params)
    {
        if ($_SESSION['user']['role'] != 'kasir') {
            header('location: /mvcomp/');
            exit;
        }

        $param = $params['meja'] ?? '6';
        $modelP = new ProductModel();
        $menus = $modelP->getAllProducts();

        $data = [
            'title' => 'Kasir Page',
            'menus' => $menus,
            'param' => $param
        ];

        $this->render('kasir/index', $data);
    }

    public function pesanan()
    {
        if ($_SESSION['user']['role'] != 'kasir') {
            header('location: /mvcomp/');
            exit;
        }

        $allOrders = [];

        // Ambil semua order dari cookie
        foreach ($_COOKIE as $key => $value) {
            if (str_starts_with($key, 'order_history_user_')) {
                $orders = json_decode($value, true);
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        $allOrders[] = $order;
                    }
                }
            }
        }

        // Ambil order dari database agar sinkron
        $stmtOrders = $this->db->query("SELECT * FROM orders ORDER BY created_at DESC");
        $ordersDB = $stmtOrders->fetchAll(\PDO::FETCH_ASSOC);

        $orderHistory = [];
        foreach ($ordersDB as $order) {
            $stmtItems = $this->db->prepare("SELECT nameProduct, priceProduct, qty FROM order_items WHERE order_id = :order_id");
            $stmtItems->execute([':order_id' => $order['order_id']]);
            $items = $stmtItems->fetchAll(\PDO::FETCH_ASSOC);

            $orderHistory[] = [
                'order_id' => $order['order_id'],
                'user_id' => $order['user_id'],
                'table_id' => $order['table_id'],
                'status' => $order['status'],
                'total' => $order['total'],
                'created_at' => $order['created_at'],
                'items' => $items
            ];
        }

        $data = [
            'title' => 'Pesanan',
            'orderHistory' => $allOrders ?: $orderHistory
        ];

        $this->render('kasir/pesanan', $data);
    }

    public function updateOrderStatus()
    {
        if ($_SESSION['user']['role'] !== 'kasir') {
            http_response_code(403);
            exit(json_encode(['error' => 'Forbidden']));
        }

        $orderId = $_POST['order_id'] ?? null;
        $newStatus = $_POST['status'] ?? null;

        if (!$orderId || !$newStatus) {
            http_response_code(400);
            exit(json_encode(['error' => 'Invalid request']));
        }

        // Update cookie
        $updated = false;
        foreach ($_COOKIE as $key => $value) {
            if (str_starts_with($key, 'order_history_user_')) {
                $orders = json_decode($value, true);

                foreach ($orders as &$order) {
                    if ($order['order_id'] === $orderId) {
                        $order['status'] = $newStatus;
                        $updated = true;
                        break;
                    }
                }
                unset($order);

                if ($updated) {
                    setcookie($key, json_encode($orders), time() + 30 * 24 * 60 * 60, '/');
                    echo json_encode(['success' => true]);
                    return;
                }
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Order not found']);
    }

    public function CRUD()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $modelP = new ProductModel();
        $search = trim($_POST['search'] ?? '');

        switch (true) {
            case isset($_POST['addCart']):
                $this->addCart($_POST);
                break;

            case isset($_POST['bayar']):
                $this->checkout();
                break;

            default:
                $menus = $modelP->getAllProducts();
                include __DIR__ . '/../views/home/listMenu.php';
                exit;
        }
    }

    private function addCart($post)
    {
        $modelP = new ProductModel();
        $idP = (int) $post['idProduct'];
        $idT = (int) ($post['idTable'] ?? 6);
        $idU = (int) ($post['idUser'] ?? 10);

        $get = $modelP->getProductById($idP);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [
                'TableId' => $idT,
                'UserId' => $idU,
                'items' => [],
                'total' => 0
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
                'nameProduct' => $get['name'],
                'priceProduct' => (float) $get['price'],
                'qty' => 1
            ];
        }

        // hitung total
        $_SESSION['cart']['total'] = array_reduce($_SESSION['cart']['items'], function ($sum, $item) {
            return $sum + ($item['priceProduct'] * $item['qty']);
        }, 0);

        header('HX-Redirect: /mvcomp/kasir');
        exit;
    }

    private function checkout()
    {
        if (!isset($_SESSION['user'])) {
            header('HX-Redirect: /mvcomp/auth/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        if (empty($_SESSION['cart']) || $_SESSION['cart']['UserId'] != $userId) {
            http_response_code(400);
            echo "Cart kosong atau bukan milik user ini";
            exit;
        }

        $_SESSION['pay'][$userId] = [
            'cart' => $_SESSION['cart'],
            'created_at' => time()
        ];

        unset($_SESSION['cart']);

        header('HX-Redirect: /mvcomp/payment');
        exit;
    }
}
