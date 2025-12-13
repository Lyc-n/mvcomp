<?php
namespace Mvcomp\Posapp\Controllers;
use Mvcomp\Posapp\App\BaseController;

class HomeControlller extends BaseController {
    public function index(){
        $data = ['title' => 'Home Page'];
        $this->render('home/index', $data);
    }
}