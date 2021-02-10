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

    $data = json_decode(file_get_contents("php://input"));

    $item->first_name = $data->first_name;
    $item->last_name = $data->last_name;
    $item->phone = $data->phone;
    $item->street = $data->street;
    $item->city = $data->city;
    $item->zip_code = $data->zip_code;
    $item->delivery_date = $data->delivery_date;
    $item->price = $data->price;
    
    if($item->createCustomer()){
        echo 'Customer created successfully.';
    } else{
        echo 'Customer could not be created.';
    }
?>