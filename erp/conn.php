<?php

date_default_timezone_set("Asia/Kolkata");

class db {

    public function mconnect() {
        // main database connection function
        try {
            $conn = new PDO("mysql:host=localhost;dbname=attendify", "root", "");
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
            $conn = new PDO("mysql:host=localhost;dbname=$dbname", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            return $e->getMessage();
        }
    }
}

