<?php

namespace app\core;

use Exception;

class Router
{
    protected array $route= [];
    private Request $request;
    private Response $response;
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    public function get($path,$callback)
    {
        $this->route['get'][$path] = $callback;
    }
    public function post($path,$callback)
    {
        $this->route['post'][$path] = $callback;
    }


    /**
     * @throws Exception
     */
    public function resolve()
    {
        $path=$this->request->getPath();
        $method=$this->request->method();
        if(is_array($path))
        {
        $callback=$this->route[$method][$path[0]] ?? false;
        }
        else
        {
            $callback=$this->route[$method][$path] ?? false;
        }

        if(!$callback){
            $this->response->setStatusCode(404);
            throw new Exception();
        }
        if (is_string($callback)) {
            Application::$app->view->renderView($callback);
        }
        if(is_array($callback)){
            /** @var Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller=$controller;
            $controller->action =$callback[1];
            $callback[0]= $controller;
//            foreach ($controller->getMiddlewares() as $middleware){
//                $middleware->execute();
//            }
        }
        return call_user_func($callback,$this->request,$this->response);

    }
}