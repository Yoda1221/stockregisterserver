<?php

namespace App\services;

use App\services\Connect;

require "./vendor/autoload.php";

class AppInit {
    private $connect;
    private string $usertable;
    private string $deviceTable;
    
    public function __construct() {
        $this->connect = new Connect();
    }
    
    /**
     ** CREATE TABLE IN NOT EXISTS
     */
    public function createTable($tablename, $params) {
        $this->deviceTable = "CREATE TABLE IF NOT EXISTS $tablename ($params) 
            ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci";
        $stmt = $this->connect->connect()->prepare($this->deviceTable);
        if ($stmt->execute()) echo 'TABLE IS CREATED!';
        else echo "CREATE TABLE IS FAILED";
    }

    /**
     ** INSERT DATA TO  TABLE
     */
    public function insertData($tableName, $data) {
        for ($i=0, $length = $tableName == "users" ? 5 : count($data) ; $i < $length ; ++$i) {
            $keys = [];
            $values = [];
            foreach($data[$i] as $key => $value) {
                array_push($keys, $key);
                array_push($values, $value);
            }

            $valueString = "";
            for ($j=0, $l = count($keys); $j < $l; $j++ ) { $valueString .= "?,"; }
            $valueString = substr($valueString, 0, -1);

            $inDb = self::checkDataInDb($tableName, $keys, $values);
            if ($inDb == 0) {
                $keysString = implode(",", $keys);
                $insert = "INSERT INTO $tableName ($keysString) VALUES ($valueString)";
                $stmt   = $this->connect->connect()->prepare($insert);
                if (!$stmt->execute($values)) return true;
            }  else {
                echo "DATA IS EXISTS!<br />";
            }   
        }
        echo "<br />INSERT DATA TO $tableName TABLE IS READY!<br />";
        
    }
    /**
     ** INSERT DATA TO DATABASE
     */
    public function checkDataInDb($tableName, $keys, $values) {
        $whereParams = "";
        if ( count($keys) == count($values) ) {
            for ($i=0, $length = count($keys); $i < $length ; $i++) {
                $whereParams .= "`" . $keys[$i] . "`='" . $values[$i] . "' AND " ;
            }
            $whereParams = substr($whereParams, 0, -5);

            $query  = "SELECT COUNT(*) darab FROM $tableName WHERE $whereParams";
            $stmt   = $this->connect->connect()->prepare($query);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll();
                return $result[0]->darab;
            } else {
                return false;
            }
        }

    }

    public function countData($tablename) {
        $query  = "SELECT COUNT(*) darab FROM $tableName";
        $stmt   = $this->connect->connect()->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result[0]->darab;
        } else {
            return false;
        }
    }

}
