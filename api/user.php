<?php
require("./db.php");

$action = $_GET['action'] ?? null;

if ($action == 'login'){
    login();
}
if ($action == 'check'){
    check();
}
if ($action == 'reset'){
    resetPass();
}
if ($action == 'profile'){
    displayProfile();
}

function displayProfile(){
    $payload = file_get_contents("php://input");
    $payload = json_decode($payload);
    
    $conn = getDb();
    $query = $conn->query("SELECT * FROM `user` 
    WHERE 
    `token` LIKE '$payload->token'
    ");

    $results = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($results);

}

function generateToken($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*?\+';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}

function login() {
    $payload = file_get_contents("php://input");
    $payload = json_decode($payload);

    $conn = getDb();
    $query = $conn->query("SELECT * FROM `user`
    WHERE 
    `username` LIKE '$payload->username' AND
    `password` LIKE '$payload->password'
    ");

     $results = $query->fetch(PDO::FETCH_ASSOC);
     
     
     if($results) {
         http_response_code(200);
         $token = generateToken();

         $updateQuery = $conn->query("UPDATE `user` SET `token` = '$token' 
         WHERE `username` = '$payload->username'");
        
         echo $token;

     }else{
         http_response_code(400);
         echo "invalid credential";
     }
     
    }

function check() {
    $payload = file_get_contents("php://input");
    $payload = json_decode($payload);
    
    $conn = getDb();
    $query = $conn->query("SELECT * FROM `user` 
    WHERE 
    `token` LIKE '$payload->token'
    ");

    $results = $query->fetch(PDO::FETCH_ASSOC);

if($results){
    http_response_code(200);
    echo "Valid";
}else{
    http_response_code(400);
    echo "Invalid"; 
}
}

function resetPass() {
    $payload = file_get_contents("php://input");
    $payload = json_decode($payload);
    
    $conn = getDb();
    $query = $conn->query("SELECT * FROM `user` 
    WHERE 
    `email` LIKE '$payload->email'
    ");

    $results = $query->fetch(PDO::FETCH_ASSOC);

if($results){
    http_response_code(200);
    $conn->query("UPDATE `user` SET `password` = '$payload->passwordInput' WHERE `user`.`email` = '$payload->email';");
}else{
    http_response_code(400);
    echo "Invalid"; 
}
}
