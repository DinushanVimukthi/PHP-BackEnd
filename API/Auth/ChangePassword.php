<?php
//header('Access-Control-Allow-Origin: *');
header ( 'Content-Type: application/json' );

use app\app\model\UserAPI;

$email = $_REQUEST[ 'email' ];
$password = $_REQUEST[ 'password' ];
$newPassword = $_REQUEST[ 'newPassword' ];
require_once '../app/model/UserAPI.php';
$user = new UserAPI();
try {
    echo json_encode ( $user -> ChangePassword ( $email ,$password,$newPassword) );
} catch ( Exception $e ) {
    echo json_encode ( array(
        "error" => $e -> getMessage ()
    ) );
}
