<?php

namespace Kernel;

class User {

    protected $UserRepository;
    protected $u_id;




    function __construct($token,$DB)
    {
        $this->UserRepository = new Repository\UserRepository($DB);
        $token = mb_convert_encoding($token,"unicode", "utf-8");
        $id = "1";//$this->checkIfExist($token);
        if(isset($id)) $this->u_id = $id;
        else {
            $this->create($token);
            $this->u_id = $this->checkIfExist($token);
        }
    }



    function auth($params) {
        return $this->UserRepository->auth($params) ?? false;
    }


    function create($token) {

        if($this->checkIfExist($token)) return false;

        $params["token"] = $token;
        return $this->UserRepository->create($params)? $params["token"] : false;
    }


    function checkIfExist($token) {
        $res =  $this->UserRepository->checkIfExist($token);
        return $res["id"];
    }



    function getAllUserResults($u_id) {
        return $this->UserRepository->getAllUserResults($u_id);
    }


    function getLastCoords() {
        return $this->UserRepository->getLastCoords($this->u_id);
    }

    function updateCoords($coords) {
        return $this->UserRepository->updateCoords($coords,$this->u_id);
    }


    function getBalance() {
     return $this->UserRepository->getBalance($this->u_id);
    }

    function addBalance($params) {
        $params["u_id"] = $this->u_id;
        return $this->UserRepository->addBalance($params);
    }

    function getTransport($tr_id = 25) {
        return $this->UserRepository->getTransport($tr_id);
    }

    function setCurrentTransport($id) {
        return $this->UserRepository->setCurrentTransport($id,$this->u_id);
    }



}