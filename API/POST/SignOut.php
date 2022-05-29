<?php
header ( 'Content-Type: application/json' );

use app\app\model\UserAPI;
require_once '../app/model/UserAPI.php';
$user = new UserAPI();
try {
    echo json_encode ( $user -> SignOut() );
} catch ( Exception $e ) {
    echo json_encode ( array(
        "error" => $e -> getMessage ()
    ) );
}