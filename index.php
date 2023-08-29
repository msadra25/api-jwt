<?php

declare(strict_types=1);

use Controllers\LogController;
use Controllers\UserController;
require __DIR__ . '/vendor/autoload.php';
require_once 'Controllers/UserController.php';
require_once 'Controllers/LogController.php';

$dbh = new PDO("mysql:host=mysql;dbname=myDB", "root", "1234",
          array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


header('Content-Type: application/json; charset=utf-8');
$json = file_get_contents('php://input');
$data = json_decode($json);

$path = $_GET["path"];

try{
    if(strcmp($path,"register")== 0){
        echo json_encode(UserController::register());
    }elseif(strcmp($path,"login")== 0){
        echo json_encode(UserController::login());
    }elseif(strcmp($path, "test")== 0){
        echo json_encode(LogController::test());
    }elseif(strcmp($path, "log")== 0){
        echo LogController::log();
    }
}catch(Exception $e){
    echo json_encode($e->getMessage());
}


