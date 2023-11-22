<?php
namespace Models;

class Log{
    private $userId;
    private $ip;
    private $date_time;

    public function setUserId($userId){
        $this->userId;
    }

    public function setIp($ip){
        $this->ip;
    }

    public function setTime($date_time){
        $this->date_time;
    }


    
    public function getUserId(){
        return $this->userId;
    }

    public function getIP(){
        return $this->ip;
    }

    public function getTime(){
        return $this->date_time;
    }

}