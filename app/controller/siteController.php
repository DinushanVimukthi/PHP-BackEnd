<?php

namespace app\app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;

class siteController extends Controller
{
    public function home()
    {
        $params=[
            'name'=>'PHP CODES',
            'Author'=>'Dinushan Vimukthi',

        ];
        return $this->render('home',$params);
    }

    public function about(Request $request,Response $response)
    {
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/CreateUser.php';
        }
        return $this->render('about');
    }

}