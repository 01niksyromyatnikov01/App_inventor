<?php

$json["error"] = 1;


if(isset($_POST["token"])) {
    $token = $_POST["token"];
    $User = $Kernel->User($token);


    if ($url[3] === "inside") {


        $old_coords = $User->getLastCoords();

        $transport = $User->getTransport();
        if (isset($old_coords)) {
            $Coords = $Kernel->Coords();
            $points = array($old_coords["lat"] . " " . $old_coords["long"]);


            $polygon = array($transport["A"], $transport["B"], $transport["C"], $transport["D"], $transport["A"]);
// The last point's coordinates must be the same as the first one's, to "close the loop"

            $result = $Coords->pointInPolygon($points[0], $polygon);
            if ($result === "inside") {
                if ($User->setCurrentTransport($transport["id"])) {
                    $balance = $User->addBalance(["desc" => $transport["name"], "value" => "-" . $transport["price"]]);
                    $json["result"]["transport"] = $transport["id"];
                    $json["result"]["balance"] = $balance;
                    $json["error"] = 0;
                }
            } else {
                $User->setCurrentTransport(0);
                $json["result"]["transport"] = 0;
                $json["error"] = 0;
            }
        }
    }
    else if($url[3] === "leave") {
            $User->setCurrentTransport(0);
            $json["result"]["transport"] = 0;
            $json["error"] = 0;

    }
    else {
        $json["error"] = 1;
    }
}


echo json_encode($json);








