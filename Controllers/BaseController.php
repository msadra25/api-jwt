<?php
namespace Controllers;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require_once 'Models/User.php';
require_once './config.php';

class BaseController{

    static function confirmPass(){
        global $data;
        if($data->password == $data->repass){
            return true;
        }
    }


    static function checkExistence(){
        global $dbh;
        global $data;
        $sql = "SELECT * FROM User WHERE username = :username";
        $sth = $dbh->prepare($sql);
        $sth->execute(["username" => $data->username]);
        $result = $sth->fetchAll();
        if($result != NULL){
            return true;
        }else{
            return false;
        }
    }


    static function insertAll($firstName, $lastName, $username, $password){
        global $dbh;
        $sql = "INSERT INTO User (first_name, last_name, username, password)
        VALUES ('$firstName', '$lastName', '$username', '$password');";
        $sth = $dbh->prepare($sql);
        $sth->execute();
    }


    static function insertLog(){
        global $dbh;
        global $data;

        $sql = "SELECT id FROM User WHERE username = :username";
        $sth = $dbh->prepare($sql);
        $sth->execute(["username" => $data->username]);
        $result = $sth->fetchAll();

        $userId = $result[0]['id'];
        $date_time = date("Y-m-d H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO Logs (ip, userId, date_time)
        VALUES ('$ip', '$userId', '$date_time');";
        $sth = $dbh->prepare($sql);
        $sth->execute();
    }


    static function showLogs(){
        global $dbh;
        global $data;
        $offset = $data->page*25;
        $sql = "SELECT * FROM Logs LIMIT 25 OFFSET $offset;";
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);;
        echo json_encode(
            ["count" => count($result),
            "result" =>$result
        ]);
    }


    static function checkPass(){
        global $dbh;
        global $data;
        $sql = "SELECT password FROM User WHERE username = :username";
        $sth = $dbh->prepare($sql);
        $sth->execute(["username" => $data->username]);
        $result = $sth->fetchAll();
        $hash = $result[0]['password'];
        if(password_verify($data->password, $hash)){
            return true;
        }else{
            return false;
        }
    }


    static function generateToken(){
        global $JWT_KEY;
        global $data;

        $date = new \DateTimeImmutable();
        $expire_at = $date->modify('+3600 minutes')->getTimestamp();
        $payload = [
            'iat'  => $date->getTimestamp(),            // Issued at: time when the token was generated
            'iss'  => 'dall',                           // Issuer
            'nbf'  => $date->getTimestamp(),            // Not before
            'exp'  => $expire_at,                       // Expire
            'sub'  => $data->username                   // subject(user)
        ];

        $jwt = JWT::encode($payload, $JWT_KEY, 'HS256');

        return $jwt;        
    }
}