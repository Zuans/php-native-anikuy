<?php


class Database {
    private $DB_HOST = DB_HOST,
            $DB_NAME = DB_NAME,
            $DB_USER = DB_USER,
            $DB_PASS = DB_PASS,
            $dbh,
            $stmt;

    public function __construct() {
        $dsn =  "mysql:host=$this->DB_HOST;dbname=$this->DB_NAME";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => TRUE,
        ];
        try {
            $this->dbh = new PDO($dsn,$this->DB_USER,$this->DB_PASS);
        } catch(PDOException $e ) {
            die($e->getMessage);
        }
    }


    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($key,$value,$type = null ) {
        if(is_null($type)) {
            if(is_int($value)) {
                $type = PDO::PARAM_INT;
            } else if(is_bool($value)) {
                $type = PDO::PARAM_BOOl;
            } else {
                $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($key,$value,$type);
    }

    public function execute() {
        $this->stmt->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function lastId() {
        return $this->dbh->lastInsertId();
    }
}





?>