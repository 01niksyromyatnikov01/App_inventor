<?php
/**
 * Created by PhpStorm.
 * User: niksy
 * Date: 04.10.2018
 * Time: 10:27
 */


spl_autoload_register(function ($class_name) {
    $class_name = str_replace("\\","/",$class_name);
    include $class_name . '.php';
});