<?php

$json["error"] = 1;

if($_POST["token"] && $_POST["lat"] && $_POST["long"] && $_POST["alt"]) {

    $coords = $_POST;

    $User = $Kernel->User($coords["token"]);

    $old_coords = $User->getLastCoords();

    if(isset($old_coords))  {
        $Coords = $Kernel->Coords();
        $distance = $Coords->distanceInKmBetweenEarthCoordinates($old_coords["lat"],$old_coords["long"],$coords["lat"],$coords["long"]);
        $coords["speed"] = $distance/$Kernel->request_interval * 60 * 60; // in hours
    }
    else $coords["speed"] = 0;


    if($User->updateCoords($coords)) {

        $json["error"] = 0;
        $json["result"]["speed"] = $coords["speed"];
    }
    else $json["error"] = 1;
}


echo json_encode($json);








