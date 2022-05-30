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

        if(strtolower ($Path[0])=='/api')
        {

            $Path=array_slice($Path,1);
            if(strtolower ($Path[0])=='/auth')
            {
            $Path=array_slice($Path,1);
            $this->Auth ($request,$Path);
            }
            else{
                throw new Exception('API Method (GET/Auth) not found');
            }
        }

//        echo '<pre>';
//        print_r($Path);
//        echo '</pre>';

    }

    private function Auth($request,$Path)
    {
        if(count($Path)==0)
        {
            throw new Exception('API Method Auth Request not found');
        }
        if(count($Path)>1)
        {
            throw new  Exception('API Method Auth Request not found');
        }
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/Auth'.$Path[0].'.php';
        }
        if($request->isGet()){
            require_once Application::$ROOT_DIR.'/API/Auth'.$Path[0].'.php';
        }
    }
}