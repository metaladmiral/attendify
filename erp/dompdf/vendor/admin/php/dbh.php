<?php
include 'define.php';

class db {

    protected $glob;

    public function __construct() {
        global $GLOBALS;
        $this->glob =& $GLOBALS;
    }

    public function mconnect() {
        // main database connection function
        try {
            $conn = new PDO("mysql:host=".$this->glob['host'].";dbname=mvmtnqxp_apartment_general", $this->glob['username'], $this->glob['password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }
    public function cconnect($dbname) {
        //custom database connection function
        try {
            $conn = new PDO("mysql:host=".$this->glob['host'].";dbname=".$dbname."", $this->glob['username'], $this->glob['password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }
}

