<?php 

class User {

// Connection
    private $conn;

    // Table
    private $db_table = "users";

    // Columns
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_hash;

    // Db connection
    public function __construct($db){
        $this->conn = $db;
    }

    // CREATE
    public function createUser(){
        $sqlQuery = "INSERT INTO
                    ". $this->db_table ."
                SET
                    id=:id,
                    first_name=:first_name, 
                    last_name=:last_name, 
                    email=:email, 
                    password=:password";
    
        $stmt = $this->conn->prepare($sqlQuery);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->email=htmlspecialchars(strip_tags($this->email));

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // bind data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $password_hash);
    
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function userLogin() {
        $sqlQuery = "SELECT
                    id, first_name, last_name, email, password
                    FROM
                    ". $this->db_table ."
                WHERE 
                    email=:email
                LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(':email', $this->email);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num > 0) {
            $datarow = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $dataRow['id'];
            $this->first_name = $dataRow['first_name'];
            $this->last_name = $dataRow['last_name'];
            $this->email = $dataRow['email'];
            $this->password2 = $dataRow['password'];

            if(password_verify($password, $password2))
            {
                $secret_key = "YOUR_SECRET_KEY";
                $issuer_claim = "THE_ISSUER"; // this can be the servername
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time(); // issued at
                $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                $expire_claim = $issuedat_claim + 180; // expire time in seconds
                $token = array(
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $id,
                        "firstname" => $firstname,
                        "lastname" => $lastname,
                        "email" => $email
                        ));
            }
        }
    }       
}        
