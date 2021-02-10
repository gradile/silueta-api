<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/database.php';
    include_once '../class/customer.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Customer($db);

    $stmt = $items->getCustomers();
    $itemCount = $stmt->rowCount();


  //  echo json_encode($itemCount);

    if($itemCount > 0){
        
        $customerArr = array();
        // $customerArr["body"] = array();
        // $customerArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "phone" => $phone,
                "street" => $street,
                "city" => $city,
                "zip_code" => $zip_code,
                "delivery_date" => $delivery_date,
                "price" => $price
            );

            array_push($customerArr, $e);
        }
        echo json_encode($customerArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>