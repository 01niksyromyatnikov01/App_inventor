<?php

namespace Kernel;

class Kernel {

    protected $DB,$User,$Coords;

    public $request_interval = 10; // in seconds


    function __construct()
    {

    }


    function initDB() {
        return new Database();
    }


    function User($token) {
        if(empty($this->User)) {
            $this->User = new User($token,$this->DB);
        }
        return $this->User;
    }

    function Coords() {
        if(empty($this->Coords)) {
            $this->Coords = new Coords();
        }
        return $this->Coords;
    }


    function Run() {
        $this->DB = $this->initDB();
    }


    function checkAccess($token) {
        return $this->DB->pushToArray($this->DB->SELECT(["table" => "users","wts" => "`access`", "where" => "`token` = '".$token."'"]))["access"];
    }

    function getIdByToken($token) {
        return $this->DB->pushToArray($this->DB->SELECT(["table" => "users","wts" => "`id`", "where" => "`token` = '".$token."'"]))["id"];
    }

}