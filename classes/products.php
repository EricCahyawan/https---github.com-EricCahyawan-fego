<?php
    class products{
        public static function add_product($name = null, $description = null, $image = null, $category = null){
			$conn = products :: get_db_connection();
			$query = "INSERT INTO listproduk (namaproduk, keteranganproduk, srcproduk, kategoriproduk) VALUES ('{$name}', '{$description}', '{$image}', '{$category}')";
			$result = $conn->exec($query);
		}
        public static function get_product_name_by_name_rowcount($name = null){
			$conn = products::get_db_connection();
			$query = "SELECT * FROM listproduk where namaproduk = '{$name}'";
			$result = $conn->query($query);
			return $result->rowCount();
		}
        public static function get_product_src_by_src_rowcount($src = null){
			$conn = products::get_db_connection();
			$query = "SELECT * FROM listproduk where srcproduk = '{$src}'";
			$result = $conn->query($query);
			return $result->rowCount();
		}
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