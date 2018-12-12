<?php
/**
 * Created by PhpStorm.
 * User: niksy
 * Date: 19.07.2018
 * Time: 23:43
 */
include_once "index.php";


define('MAIN_DIR', dirname(__FILE__));





$url = explode("/",$_SERVER["REQUEST_URI"]);


if($url[1] === "api") {

    if($url[2] === "coords") {

        if($url[3] === "update") {
            require_once "api/coords/index.php";
        }

    }
    if($url[2] === "balance") {
        require_once "api/balance/index.php";
    }

    if($url[2] === "transport") {
        require_once "api/transport/index.php";
    }

}





