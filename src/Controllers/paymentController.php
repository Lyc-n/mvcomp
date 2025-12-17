<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;
use Mvcomp\Posapp\Models;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends BaseController
{
    private \PDO $db;
    public function confirmPay()
    {
        // pastikan user login
        if (!isset($_SESSION['user'])) {
            header('HX-Redirect: /mvcomp/auth/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // pastikan ada session pay
        if (empty($_SESSION['pay'][$userId])) {
            http_response_code(400);
            echo "Tidak ada transaksi untuk user ini";
            exit;
        }

        $cartData = $_SESSION['pay'][$userId]['cart'];

        // Konfigurasi Midtrans
        Config::$serverKey = 'Mid-server-2ih_ywLSSuu8bBqBHieGynRh';  // ganti dengan server key Midtrans
        Config::$isProduction = false;           // true jika live
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat transaksi Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . time() . '-' . $userId,
                'gross_amount' => $cartData['total']
            ],
            'customer_details' => [
                'first_name' => $_SESSION['user']['username'],
            ],
            'item_details' => []
        ];

        // Tambahkan item dari cart
        foreach ($cartData['items'] as $item) {
            $params['item_details'][] = [
                'id' => uniqid(),
                'price' => $item['priceProduct'],
                'quantity' => $item['qty'],
                'name' => $item['nameProduct']
            ];
        }

        // Generate Snap token
        $snapToken = Snap::getSnapToken($params);

        // Return token ke view
        $data = [
            'snapToken' => $snapToken,
            'cart' => $cartData
        ];

        $this->render('payment/confirm', $data);
    }

    public function success()
    {
        $this->saveOrderHistory();
        $userId = $_SESSION['user']['id'];

        // Hapus session pay
        unset($_SESSION['pay'][$userId]);

        // Cart sudah dihapus sebelumnya saat checkout
        echo "<script>window.location.href = '/mvcomp/';</script>";
        exit;
    }

    private function saveOrderHistory()
    {
        if (!isset($_SESSION['user'])) {
            header('HX-Redirect: /mvcomp/auth/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // Pastikan ada order di session pay
        if (empty($_SESSION['pay'][$userId])) {
            http_response_code(400);
            echo "Tidak ada order untuk disimpan";
            exit;
        }

        $order = $_SESSION['pay'][$userId]['cart'];

        // Ambil cookie order history user, jika ada
        $cookieName = 'order_history_user_' . $userId;
        $orderHistory = [];

        if (isset($_COOKIE[$cookieName])) {
            $orderHistory = json_decode($_COOKIE[$cookieName], true);
        }

        // Tambahkan order baru
        $newOrder = [
            'order_id' => 'ORDER-' . time() . '-' . $userId,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'items' => $order['items'],
            'total' => $order['total']
        ];

        $orderHistory[] = $newOrder;

        // Simpan kembali ke cookie (expire 30 hari)
        setcookie($cookieName, json_encode($orderHistory), time() + 30 * 24 * 60 * 60, '/');

        foreach ($_COOKIE as $key => $value) {
            if (str_starts_with($key, 'order_history_user_')) {
                $orders = json_decode($value, true);

                foreach ($orders as $order) {
                    // Masukkan ke tabel orders
                    $stmtOrder = $this->db->prepare("INSERT INTO orders (order_id, user_id, table_id, status, total, created_at)
                                       VALUES (:order_id, :user_id, :table_id, :status, :total, :created_at)
                                       ON DUPLICATE KEY UPDATE status = :status");
                    $stmtOrder->execute([
                        ':order_id' => $order['order_id'],
                        ':user_id' => $order['user_id'] ?? null,
                        ':table_id' => $order['table_id'] ?? null,
                        ':status' => $order['status'],
                        ':total' => $order['total'],
                        ':created_at' => $order['created_at']
                    ]);

                    // Masukkan item ke order_items
                    foreach ($order['items'] as $item) {
                        $stmtItem = $this->db->prepare("INSERT INTO order_items (order_id, nameProduct, priceProduct, qty)
                                          VALUES (:order_id, :nameProduct, :priceProduct, :qty)");
                        $stmtItem->execute([
                            ':order_id' => $order['order_id'],
                            ':nameProduct' => $item['nameProduct'],
                            ':priceProduct' => $item['priceProduct'],
                            ':qty' => $item['qty']
                        ]);
                    }
                }
            }
        }


        // Hapus session pay karena sudah disimpan
        unset($_SESSION['pay'][$userId]);

        echo "Order berhasil disimpan di cookie!";
    }
}
