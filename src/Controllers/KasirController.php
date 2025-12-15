<?php
namespace Mvcomp\Posapp\Controllers;

use Mvcomp\Posapp\App\BaseController;

class KasirController extends BaseController{
    public function index(){
        $data = ['title' => 'Cashier Page'];
        $this->render("kasir/index", $data);
    }
}