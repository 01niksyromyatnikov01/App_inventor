<?php

namespace Kernel\Repository;

class UserRepository {

    protected $DB;

    function __construct($DB)
    {
        $this->DB = $DB;
    }



    function auth($params) {

        return $this->DB->pushToArray($this->DB->SELECT(["table" => "users", "wts" => "`id`,`access`, `token`, `name`,`group`", "where" => "`login` = '".$params["login"]."' AND `password` = '".$params["password"]."'"]));

    }

    function create($params) {
       return $this->DB->INSERT(["table" => "users", "cells" => "(`token`)", "values" => "('".$params["token"]."')"]);
    }

    function checkIfExist($token) {
        return $this->DB->pushToArray($this->DB->SELECT(["table" => "users", "wts" => "`id`", "where" => "`token` = '".$token."'"]));
    }

    function updateCoords($coords,$u_id) {
        return $this->DB->INSERT(["table" => "coords", "cells" => "(`u_id`,`lat`,`long`,`alt`,`speed`)", "values" => "('".$u_id."','".$coords["lat"]."', '".$coords["long"]."', '".$coords["alt"]."', '".$coords["speed"]."')"]);

    }

    function getLastCoords($u_id) {
        return $this->DB->pushToArray($this->DB->SELECT(["table" => "coords", "wts" => "*", "where" => "`u_id` = '".$u_id."' ORDER BY `id` DESC LIMIT 1"]));
    }


    function addBalance($params) {
        if($this->DB->INSERT(["table" => "balance", "cells" => "(`u_id`,`desc`,`value`)", "values" => "('".$params["u_id"]."','".$params["desc"]."', '".$params["value"]."')"])) {
            $sum = 0;
            $balances =  $this->getBalance($params["u_id"]);
            foreach ($balances as $balance) {
                $sum += $balance["value"];
            }
            return $sum;
        }
        else return 0;
    }

    function getBalance($u_id) {
        $balance = [];
        $results = $this->DB->SELECT(["table" => "balance", "wts" => "*", "where" => "`u_id` = '".$u_id."' ORDER BY `id` DESC"]);
        while ($result = mysqli_fetch_assoc($results)) {
            $balance[] = $result;
        }
        return $balance;
    }


    function getTransport($tr_id) {
        return $this->DB->pushToArray($this->DB->SELECT(["table" => "`transport`,`transport_coords`", "wts" => "`transport`.id,`transport`.name,`transport`.price,`transport_coords`.A,`transport_coords`.B,`transport_coords`.C,`transport_coords`.D ", "where" => "`transport`.id = '".$tr_id."' AND `transport_coords`.transport_id =  '".$tr_id."'"]));

    }


    function setCurrentTransport($tr_id,$u_id)
    {
        return $this->DB->UPDATE(["table" => "users", "values" => "`transport_id` = '".$tr_id."'", "where" => "`id` = '".$u_id."'"]);

    }
}