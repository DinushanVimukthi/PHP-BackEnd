<?php
//header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
use app\app\model\UserAPI;
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

require_once '../app/model/UserAPI.php';
$user=new UserAPI();
echo json_encode($user->CreateUser($email,$password));
?>
