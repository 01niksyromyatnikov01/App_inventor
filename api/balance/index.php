<?php

$json["error"] = 1;


if(isset($_POST["token"])) {

    $token = $_POST["token"];

    $User = $Kernel->User($token);


    if(isset($_POST["value"]) && isset($_POST["desc"])) {


        $value = doubleval($_POST['value']);
        $desc = $_POST["desc"];

        $balance = $User->addBalance(["value" => $value, "desc" => $desc]);
        if($balance) {
            $json["result"]["balance"] = $balance;
            $json["error"] = 0;
        }

    }

    else {
        $sum = 0;
       $balances =  $User->getBalance();
       foreach ($balances as $balance) {
           $sum += $balance["value"];
       }
       $json["error"] = 0;
       $json["result"]["operations"] = $balances;
       $json["result"]["sum"] = $sum;
    }

}


echo json_encode($json);








