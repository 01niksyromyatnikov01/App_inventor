<?php
/**
 * Created by PhpStorm.
 * User: niksy
 * Date: 27.12.2017
 * Time: 18:27
 */

namespace Kernel;


interface Operations {
    function Connect();
    function SELECT($query);
    function Update($query);
    function Insert($query);
    function Delete($query);
}



class Database implements Operations
{
private $host,$login,$pass,$db,$con;

function __construct()
{
    $this->host = '127.0.0.1';
    $this->login = 'Nick01';
    $this->pass = '13ro06ma65';
    $this->db = 'transport';

    $this->Connect();
}

    function Connect() {
    $this->con = mysqli_connect($this->host,$this->login,$this->pass,$this->db) or die("Error connecting");
    }


    function StartTransaction() {
    $this->con->begin_transaction();
    }

    function Commit() {
    $this->con->commit();
    }

    function Rollback() {
    $this->con->rollback();
    }


    function SELECT($query) {
         $request = 'SELECT '.$query['wts'].' FROM '.$query['table'].' ';
         if(isset($query['where'])) {$request .= 'WHERE '.$query['where'];}
         $result = mysqli_query($this->con,$request) or  new \Exception("Error while SELECT");
         echo $request;
         return !empty($result) ? $result: null;
    }

    function INSERT($query,$execute = true) {
        $request = 'INSERT INTO  '.$query['table'].' ';
        if(isset($query['cells']) AND isset($query['values'])) {$request .= $query['cells'].' VALUES '.$query['values'];}
        else throw new \Exception("Null cells or values");

        if($execute) $result = mysqli_query($this->con,$request) or new \Exception("Error while INSERT");
        else $result = $request;
        return $result;
    }

    function UPDATE($query) {
        $request = 'UPDATE  '.$query['table'].' SET ';
        if(isset($query['values'])) {$request .= $query['values'];}
        else throw new \Exception("Null cells or values");
        if(isset($query['where'])) {$request .= ' WHERE '.$query['where'];}
        $result = mysqli_query($this->con,$request) or new \Exception("Error while UPDATE");
        return $result;
    }

    function DELETE($query) {
        $request = 'DELETE  FROM '.$query['table'].' ';
        if(isset($query['where'])) {$request .= 'WHERE '.$query['where'];}
        else throw new \Exception("No WHERE case were found");
        $result = mysqli_query($this->con,$request) or  new \Exception("Error while DELETE");
        return $result;
    }

    function pushToArray($query) {
        if($query) { $result = mysqli_fetch_assoc($query); return $result; }
        else {throw new \Exception("Result is not TRUE"); }
    }


    function getLastId() {
    return mysqli_insert_id($this->con);
    }

    function getLastAffectedId() {
    return mysqli_affected_rows($this->con);
    }

}