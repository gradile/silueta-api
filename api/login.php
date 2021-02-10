<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/user.php';
    require "../vendor/autoload.php";
    use \Firebase\JWT\JWT;

    $database = new Database();
    $db = $database->getConnection();

    $item = new User($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->email = $data->email;
    $item->password = $data->password;
  
    $item->userLogin();

    if($item != null){
        // create array
        $user_arr = array(
            'id' => $item->id,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'email' => $item->email
        );
      
        http_response_code(200);
        // 
        $jwt = JWT::encode($token, $secret_key);
        echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "email" => $item->email,
                "expireAt" => $expire_claim
            ));
    }
      
    else{
        http_response_code(401);
        echo json_encode(array("message" => "Login failed.", "password" => $password));
    }
?>