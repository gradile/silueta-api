<?php
    class Customer{

        // Connection
        private $conn;

        // Table
        private $db_table = "customers";

        // Columns
        public $id;
        public $first_name;
        public $last_name;
        public $phone;
        public $street;
        public $city;
        public $zip_code;
        public $delivery_date;
        public $price;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getCustomers(){
            $sqlQuery = "SELECT id, first_name, last_name, phone, street, city, zip_code, delivery_date, price FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createCustomer(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        id=:id,
                        first_name=:first_name, 
                        last_name=:last_name, 
                        phone=:phone, 
                        street=:street, 
                        city=:city, 
                        zip_code=:zip_code, 
                        delivery_date=:delivery_date,
                        price=:price";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->street=htmlspecialchars(strip_tags($this->street));
            $this->city=htmlspecialchars(strip_tags($this->city));
            $this->zip_code=htmlspecialchars(strip_tags($this->zip_code));
            $this->delivery_date=htmlspecialchars(strip_tags($this->delivery_date));
            $this->price=htmlspecialchars(strip_tags($this->price));
        
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":street", $this->street);
            $stmt->bindParam(":city", $this->city);
            $stmt->bindParam(":zip_code", $this->zip_code);
            $stmt->bindParam(":delivery_date", $this->delivery_date);
            $stmt->bindParam(":price", $this->price);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleCustomer(){
            $sqlQuery = "SELECT
                        id, first_name, last_name, phone, street, city, zip_code, delivery_date, price
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id=:id
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->first_name = $dataRow['first_name'];
            $this->last_name = $dataRow['last_name'];
            $this->phone = $dataRow['phone'];
            $this->street = $dataRow['street'];
            $this->city = $dataRow['city'];
            $this->zip_code = $dataRow['zip_code'];
            $this->delivery_date = $dataRow['delivery_date'];
            $this->price = $dataRow['price'];
            $this->id = $dataRow['id'];
        }        

        // UPDATE
        public function updateCustomer(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        first_name=:first_name, 
                        last_name=:last_name, 
                        phone=:phone, 
                        street=:street, 
                        city=:city, 
                        zip_code=:zip_code, 
                        delivery_date=:delivery_date,
                        price=:price
                    WHERE 
                        id=:id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
             // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->street=htmlspecialchars(strip_tags($this->street));
            $this->city=htmlspecialchars(strip_tags($this->city));
            $this->zip_code=htmlspecialchars(strip_tags($this->zip_code));
            $this->delivery_date=htmlspecialchars(strip_tags($this->delivery_date));
            $this->price=htmlspecialchars(strip_tags($this->price));
        
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":street", $this->street);
            $stmt->bindParam(":city", $this->city);
            $stmt->bindParam(":zip_code", $this->zip_code);
            $stmt->bindParam(":delivery_date", $this->delivery_date);
            $stmt->bindParam(":price", $this->price);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteCustomer(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id=:id";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>