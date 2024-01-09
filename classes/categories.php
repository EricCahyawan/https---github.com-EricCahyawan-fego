<?php
    class categories{
        protected static function get_db_connection()
        {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "fego";
            $conn = null;

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                die;
            }
        }
    }
?>