<?php

namespace App\controllers;

use App\services\Connect;

require "./vendor/autoload.php";

class StockRegisterController {
    private $connect;

    public function __construct() {
        $this->connect = new Connect();
    }

    /**
     ** GET DATA FROM DATABASE
     * 
     * @param { String } $tableName
     */
    public function getDevicesFromDb($tableName) {
        $sql = "SELECT `device_name`,`user_id`,`quality_condition`,`buying_at`,
        (SELECT `name` FROM `users` WHERE `id` = `devices`.`user_id`) kinelvan
        FROM $tableName";
        $stmt   = $this->connect->connect()->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            echo json_encode($result);
        } else {
            return false;
        }
    }
    /**
     ** SAVE DATA TO DATABASE
     *
     * @param { Object } $data
     */
    public function saveDataToDb($data) {
        $keys = [];
        $values = [];
        foreach($data as $key => $value) {
            array_push($keys, $key);
            array_push($values, $value);
        }
        array_shift($keys);
        array_shift($values);

        $valueString = "";
        for ($j=0, $l = count($keys); $j < $l; $j++ ) { $valueString .= "?,"; }
        $valueString    = substr($valueString, 0, -1);
        $keysString     = implode(", ", $keys);

        $insert = "INSERT INTO $data->tablename ($keysString) VALUES ($valueString)";
        $stmt   = $this->connect->connect()->prepare($insert);
        if ($stmt->execute($values)) return "DATA IS SAVED TO DATABASE!";
        else return "SAVE DATA TO DATABASE IS FAILED!";
    }
        
    public function updateDataToDb() {

    }

    public function deleteDataToDb() {

    }

}
