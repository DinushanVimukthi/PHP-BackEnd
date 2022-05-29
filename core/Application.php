<?php

namespace app\core;

use Exception;

class Application
{
    public string $layout='main';
    public static $ROOT_DIR;
    public Router $router;
    private Request $request;
    private Response $response;
    public static Application $app;
    public Controller $controller;
    public Database $db;
    public View $view;
    private Session $session;

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this -> session;
    }

    /**
     * @var mixed
     */

    public function __construct($path,array $config)
    {
//        $this->forbiddenRoute=new ForbiddenRoute();

//        $this->userClass= $config['userClass'];
        self::$app = $this;
        $this->view=new View();
        self::$ROOT_DIR = $path;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db=new Database($config['db']);
        $primaryValue=$this->session->get('user');
    }

    public static function run()
    {
        try{
//            echo 'HI'   ;
            echo self::$app->router->resolve();
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }


}