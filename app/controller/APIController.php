<?php

namespace app\app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use Exception;

class APIController extends Controller
{
    /**
     * @throws Exception
     */
    public function API(Request $request)
    {
        $Path=$request->getPath();

        if($Path[0]=='/api' || $Path[0]=='/API')
        {

            $Path=array_slice($Path,1);
            if($Path[0]=='/POST' || $Path[0]=='/post' ||$Path[0]=='/GET' || $Path[0]=='/get' )
            {
            $Path=array_slice($Path,1);
            }
            else{
                throw new Exception('API Method (GET/POST) not found');
            }
        }

//        echo '<pre>';
//        print_r($Path);
//        echo '</pre>';
        if(count($Path)==0)
        {
            throw new Exception('API Method (GET/POST) Request not found');
        }
        if(count($Path)>1)
        {
            throw new  Exception('API Method (GET/POST) Request is invalid!. Please check your request');
        }
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/POST'.$Path[0].'.php';
        }
        if($request->isGet()){
            require_once Application::$ROOT_DIR.'/API/GET'.$Path[0].'.php';
        }
    }
}