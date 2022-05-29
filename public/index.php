<?php

use app\app\controller\APIController;
use app\app\controller\siteController;
 use app\core\Application;
 require_once __DIR__ . '/../vendor/autoload.php';
 $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
 $dotenv->load();
 $config=[
 //    'userClass' => app\models\User::class,
     'db'=>[
         'dsn'=>$_ENV['DB_DSN'],
         'user'=>$_ENV['DB_USER'],
         'password'=>$_ENV['DB_PASSWORD']
     ],
 ];
 $app =new Application(dirname(__DIR__), $config);
 $app->db->applyMigrations();
 $app->router->get('/', [siteController::class, 'home']);
 $app->router->get('/API', [APIController::class, 'API']);
 $app->router->post('/API', [APIController::class, 'API']);

 $app->router->get('/about', [siteController::class, 'about']);
 $app->router->post('/about', [siteController::class, 'about']);
 $app->run();
//$app->forbiddenRoute->setForbiddenRotes(
//    [
//        'admin'=>[],
//        'receiption'=>['admindash', 'superadmindash'],
//        'superadmin'=>[],
//        'student'=>['recdash', 'edstd', 'dltstd']
//    ]);



