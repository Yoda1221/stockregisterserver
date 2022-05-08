<?php

namespace App\services;

require __DIR__ . "/../config/config.php";

use PDO;

class Connect {
    private $host   = MYSQL_HOST;
    private $dbName = MYSQL_DB;
    private $user   = MYSQL_LOGIN;
    private $pwd    = MYSQL_PASSWORD;
	private $conn;
    public function connect() {
        $this->conn = null;
        try {
            $dns = 'mysql:host='. $this->host . ';dbname=' . $this->dbName . ';charset=utf8';
            $this->conn = new PDO($dns, $this->user, $this->pwd);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $this->conn;
        } catch (PDOException $e) {
            echo "Kapcsolódási hiba! " . $e->getMessage();
        }
    }
}
