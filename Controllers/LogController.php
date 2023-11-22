<?php
namespace Controllers;

use Models\Log;
require_once 'BaseController.php';

class LogController{

    static function test(){
        if(BaseController::checkExistence()){
            BaseController::insertLog();
        }else{
            return ["status" => false,
                    "message" => "user not found!"];
        }
    }

    static function log(){
        BaseController::showLogs();
    }
}