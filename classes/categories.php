<?php
    class categories{
        public static function add_category($name = null, $description = null, $image = null){
			$conn = categories::get_db_connection();
			$query = "INSERT INTO kategori (namakategori, keterangankategori, srckategori) VALUES ('{$name}', '{$description}', '{$image}')";
			$result = $conn->exec($query);
		}
        public static function get_category_name_by_name_rowcount($name = null){
			$conn = categories::get_db_connection();
			$query = "SELECT * FROM kategori where namakategori = '{$name}'";
			$result = $conn->query($query);
			return $result->rowCount();
		}
        public static function get_category_src_by_src($src = null){
			$conn = categories::get_db_connection();
			$query = "SELECT * FROM kategori where srckategori = '{$src}'";
			$result = $conn->query($query);
			return $result->rowCount();
		}
        public static function get_allcategory_rowcount(){
			$conn = categories::get_db_connection();
			$query = "SELECT * FROM kategori";
			$result = $conn->query($query);
			return $result->rowCount();
		}
        public static function get_allcategory(){
			$conn = categories::get_db_connection();
			$query = "SELECT * FROM kategori";
			$result = $conn->query($query);
			return $result->fetchAll();
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