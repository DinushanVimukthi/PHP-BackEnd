<?php

namespace app\core;

class View
{
    public string $title='';
    public function renderView($view,$params=[],$subf='')
    {
        $viewContent=$this->renderOnlyView($view,$params,$subf);
        $layoutContent=$this->layoutContent();
        foreach ($params as $key=>$value)
        {
            $viewContent=str_replace('{{'.$key.'}}',$value,$viewContent);
        }
        return str_replace('{{content}}',$viewContent,$layoutContent);
//        return $layoutContent.$viewContent;
    }


    private function renderContent($viewContent)
    {
        $layoutContent=$this->layoutContent();
        return str_replace('{{content}}',$viewContent,$layoutContent);

    }


    protected function layoutContent()
    {
        $layout=Application::$app->layout;
        if(Application::$app->controller)
        {
            $layout=Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR ."/app/view/layout/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view,$params,$subf='')
    {
        foreach ($params as $key=>$value){
            $$key=$value;
        }
        ob_start();
        include_once Application::$ROOT_DIR ."/app/view/pages/$subf/$view.php";
        return ob_get_clean();
    }

}