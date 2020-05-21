<?php
namespace Core;

class DB {
    private static $_instance = null;
    private $dbh;


    private function __construct() {
        try {
            $this->dbh = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_ENCODE, DB_USER, DB_PASSWORD);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function dbh()
    {
        return $this->dbh;
    }

}