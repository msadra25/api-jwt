<?php

namespace Controllers;

use Exception;
use Models\User;
require_once 'BaseController.php';
require_once 'Models/User.php';

class UserController{

    static function register(){
        global $dbh;
        global $data;

        $user = new User;

        if(BaseController::confirmPass()){
            $user->setUsername($data->username);
            $user->setPassword(password_hash($data->password, PASSWORD_DEFAULT));
            $user->setFirstName($data->firstName);
            $user->setLastName($data->lastName);
        }else{
            return ["message" => "check your password"];
        }

        if(BaseController::checkExistence()){
            return ["status" => false,
                    "message" => "the username exists"];  

        }else{
            BaseController::insertAll($user->getFirstName(), $user->getLastName(),
                                      $user->getUsername(), $user->getPassword());
            return ["status" => true,
                    "message" => "user registered"];
        }
    }


    static function login(){
        global $dbh;
        global $data;

        if(!BaseController::checkExistence()){
            throw new Exception("invalid information");
        }    
        if(!BaseController::checkPass()){
            throw new Exception("invalid information");
        }

        $token = BaseController::generateToken();

        return ["status" => true,
                "Token" => $token];
    }


    static function delete(){

    }
}