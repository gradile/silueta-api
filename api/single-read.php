<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/customer.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Customer($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleCustomer();

    if($item->first_name != null){
        // create array
        $customer_arr = array(
            'id' => $item->id,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'phone' => $item->phone,
            'street' => $item->street,
            'city' => $item->city,
            'zip_code' => $item->zip_code,
            'delivery_date' => $item->delivery_date,
            'price' => $item->price
        );
      
        http_response_code(200);
        echo json_encode($customer_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode('Customer not found.');
    }
?>