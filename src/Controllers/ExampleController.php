<?php
namespace Mvcomp\Posapp\Controllers;
use Mvcomp\Posapp\Models\UserModel;
use Mvcomp\Posapp\App\BaseController;

class ExampleController extends BaseController{

    public function index(){
        $data = ['title' => 'Example Page'];
        $this->render('example/index', $data);
    }

    public function hello(){
        $data = ['title' => 'Hello Page'];
        $this->render('example/hello', $data);
    }

    public function world($params = []){
        $data = ['title' => 'World Page', 'params' => $params];
        $this->render('example/world', $data);
    }

}