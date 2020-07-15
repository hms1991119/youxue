<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;

class TestController extends Controller{
    private $user;
    
    /* function __construct(){
        parent::__constrct();
    } */
    
    public function index()
    {
        //echo 'index';exit;
        return view('test');
    }
    
    public function alias(){
        echo 'alias';exit;
    }
}