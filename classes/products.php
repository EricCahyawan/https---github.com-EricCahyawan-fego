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
        public static function get_product_by_name($name = null){
			$conn = products::get_db_connection();
			$query = "SELECT * FROM listproduk where namaproduk = '{$name}'";
			$result = $conn->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
		}
        public static function get_product_src_by_src_rowcount($src = null){
			$conn = products::get_db_connection();
			$query = "SELECT * FROM listproduk where srcproduk = '{$src}'";
			$result = $conn->query($query);
			return $result->rowCount();
		}
        public static function delete_product_by_categoryname($categoryname = null){
			$conn = products::get_db_connection();
			$query = "DELETE FROM listproduk WHERE kategoriproduk = '{$categoryname}'";
			$result = $conn->exec($query);
		}
        public static function delete_product_by_productname($productname = null){
			$conn = products::get_db_connection();
			$query = "DELETE FROM listproduk WHERE namaproduk = '{$productname}'";
			$result = $conn->exec($query);
		}
        public static function get_all_products(){
			$conn = products::get_db_connection();
			$query = "SELECT * FROM listproduk";
			$result = $conn->query($query);
            return $result->fetchAll();
		}
        public static function edit_product($name = null, $description = null, $image = null, $radio = null){
			$conn = products::get_db_connection();
			$query = "UPDATE listproduk SET namaproduk = '{$name}', keteranganproduk = '{$description}', srcproduk = '{$image}' WHERE namaproduk = '{$radio}'";
			$result = $conn->exec($query);
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