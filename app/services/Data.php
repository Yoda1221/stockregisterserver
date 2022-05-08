<?php

namespace App\services;

require "./vendor/autoload.php";

class Data {

    public function tableData() {
        $deviceTable = "`id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `device_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
            `user_id` int(11) NOT NULL DEFAULT 0,
            `quality_condition` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1: rossz,\r\n2: használható,\r\n3: közepes,\r\n4: jó,\r\n5: kiváló',
            `lang_code` varchar(4) NOT NULL DEFAULT 'hu',
            `buying_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()";

        $usersTable = "`id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
            `username` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
            `email` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
            `phone` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `updataed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()";

        $langTable = "
            `lang_code` varchar(4) NOT NULL PRIMARY KEY,
            `lang_name` varchar(50) NOT NULL DEFAULT ''";
            
        $deviceNames = "
            `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `lang_code` varchar(4) NOT NULL ,
            `device_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL";

        return $databaseSetup = [
            [
                "tablename" => "devices",
                "params" => $deviceTable
            ],[
                "tablename" => "users",
                "params" => $usersTable
            ],[
                "tablename" => "langs",
                "params" => $langTable
            ],[
                "tablename" => "deviceNames",
                "params" => $deviceNames
            ]
        ];
    }

    /**
     ** INIT DUMMY USERS
     */
    public function initDummyUsers() {
        $usersN = [];
        $uObj   = [];
        $url    = 'https://jsonplaceholder.typicode.com/users';
        $json   = file_get_contents($url);
        $usersO = json_decode($json);
        for ($i=0; $i < 5; ++$i) { 
            $uObj["name"]       = $usersO[$i]->name;
            $uObj["username"]   = $usersO[$i]->username;
            $uObj["email"]      = $usersO[$i]->email;
            $uObj["phone"]      = $usersO[$i]->phone;
            array_push($usersN, $uObj);
        }
        $users = json_encode($usersN);
        return json_decode($users);
    }

    /**
     ** INIT DUMMY DEVICES
     */
    public function deviceSetup() {
        $devices = [
            [ "device_name" => "akkus kézi fúró", "user_id" => 1, "quality_condition" => 2, "buying_at" => "2020-03-29 08:00:00" ],
            [ "device_name" => "kézi fúró", "user_id" => 0, "quality_condition" => 3, "buying_at" => "2021-04-29 08:00:00" ],
            [ "device_name" => "akkus ütvefúró", "user_id" => 3, "quality_condition" => 4, "buying_at" => "2022-01-29 08:00:00" ],
            [ "device_name" => "ütvefúró", "user_id" => 4, "quality_condition" => 4, "buying_at" => "2022-03-29 08:00:00" ],
            [ "device_name" => "akkus fúró kalapács", "user_id" => 4, "quality_condition" => 5, "buying_at" => "2022-04-29 08:00:00" ],
            [ "device_name" => "fúró kalapács", "user_id" => 3, "quality_condition" => 5, "buying_at" => "2022-05-29 08:00:00" ],
            [ "device_name" => "akkus sarokcsiszoló", "user_id" => 5, "quality_condition" => 5, "buying_at" => "2022-07-29 08:00:00" ],
            [ "device_name" => "sarokcsiszoló", "user_id" => 5, "quality_condition" => 1, "buying_at" => "2019-01-29 08:00:00" ],
            [ "device_name" => "szegecsanya húzó", "user_id" => 5, "quality_condition" => 1, "buying_at" => "2019-03-29 08:00:00" ],
            [ "device_name" => "akkumulátor", "user_id" => 0, "quality_condition" => 1, "buying_at" => "2019-06-29 08:00:00" ],
            [ "device_name" => "akkumulátor", "user_id" => 1, "quality_condition" => 2, "buying_at" => "2020-04-29 08:00:00" ],
            [ "device_name" => "akkumulátor", "user_id" => 1, "quality_condition" => 2, "buying_at" => "2020-06-29 08:00:00" ],
            [ "device_name" => "akkumulátor", "user_id" => 2, "quality_condition" => 3, "buying_at" => "2021-05-29 08:00:00" ],
            [ "device_name" => "akku töltő", "user_id" => 2, "quality_condition" => 3, "buying_at" => "2021-09-29 08:00:00" ],
            [ "device_name" => "akku töltő", "user_id" => 3, "quality_condition" => 2, "buying_at" => "2020-07-29 08:00:00" ],
            [ "device_name" => "akku töltő", "user_id" => 2, "quality_condition" => 4, "buying_at" => "2022-05-29 08:00:00" ],
            [ "device_name" => "4x4-es Alu létra", "user_id" => 1, "quality_condition" => 5, "buying_at" => "2022-11-29 08:00:00" ],
            [ "device_name" => "4x4-es Alu létra", "user_id" => 0, "quality_condition" => 4, "buying_at" => "2022-09-29 08:00:00" ],
            [ "device_name" => "feggesztő trafó", "user_id" => 1, "quality_condition" => 4, "buying_at" => "2022-10-29 08:00:00" ],
            [ "device_name" => "feggesztő trafó", "user_id" => 0, "quality_condition" => 2, "buying_at" => "2020-09-29 08:00:00" ],
            [ "device_name" => "kézi szalagcsiszoló", "user_id" => 4, "quality_condition" => 1, "buying_at" => "2019-09-29 08:00:00" ],
            [ "device_name" => "asztali szalagcsiszoló", "user_id" => 5, "quality_condition" => 1, "buying_at" => "2019-11-29 08:00:00" ],
            [ "device_name" => "állványos köszörű", "user_id" => 5, "quality_condition" => 1, "buying_at" => "2019-12-29 08:00:00" ],
            [ "device_name" => "állványos fúrógép", "user_id" => 3, "quality_condition" => 2, "buying_at" => "2020-10-29 08:00:00" ],
            [ "device_name" => "ezsterga pad", "user_id" => 1, "quality_condition" => 4, "buying_at" => "2022-11-29 08:00:00" ]
        ];
        $devices = json_encode($devices);
        return json_decode($devices);
    }

    public function langSetup() {
        $langs = [
            ["lang_code" => "hu", "lang_name" => "Magyar"],
            ["lang_code" => "en", "lang_name" => "English"],
            ["lang_code" => "de", "lang_name" => "Deutsch"]
        ];
        $langs = json_encode($langs);
        return json_decode($langs);
    }

}
