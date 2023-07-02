<?php

date_default_timezone_set("Asia/Kolkata");

class db {

    public function mconnect() {
        // main database connection function
        try {
            $conn = new PDO("mysql:host=localhost;dbname=u586615155_lgs_erp_db", "u586615155_lgs_erp_db", "Prakhar8756");
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
            $conn = new PDO("mysql:host=localhost;dbname=$dbname", "u586615155_lgs_erp_db", "Prakhar8756");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }
}

