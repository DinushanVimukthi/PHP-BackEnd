<?php

namespace app\core;

class Controller
{
    public string $action='';
    public string $layout = 'main';
    protected array $middlewares = [];
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public static function render($view, $params = [],$subf='')
    {
        return Application::$app->view->renderView($view, $params,$subf);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[]=$middleware;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


}