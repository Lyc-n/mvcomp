<?php

namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;

class AdminController extends BaseController
{
    public function adminPanel()
    {
        $data = ['title' => 'Admin Panel'];
        $this->render('admin/index', $data);
    }

    public function adminDashboard()
    {
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function adminProducts()
    {
        include __DIR__ . '/../views/admin/products.php';
    }

    public function adminUsers()
    {
        include __DIR__ . '/../views/admin/users.php';
    }

    public function adminReports()
    {
        include __DIR__ . '/../views/admin/reports.php';
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
