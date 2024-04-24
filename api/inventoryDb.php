<?php
require("./db.php");

$action = $_GET['action'] ?? null;

if ($action == 'read'){
    read();
}
if ($action == 'create'){
    create();
}
if ($action == 'delete'){
    delete();
}
if ($action == 'update'){
    update();
}

function read(){
    $conn = getDb();
    $query = $conn->query("SELECT * FROM `eshop_inventory`;");
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
}
function create() {
    $payload = file_get_contents("php://input");
    $payload = json_decode($payload);

    $conn = getDb();
    $query = $conn->query("
    INSERT INTO `eshop_inventory` (`id`, `productName`, `image`, `brand`, `price`, `stock`) VALUES (NULL, '$payload->productName', '$payload->image', '$payload->brand', '$payload->price', '$payload->stock');
    ");
    $results = $query->fetch();
    print_r($results);
}
function update(){
    $payload = file_get_contents("php://input");
    $payload = json_decode($payload);
    $conn = getDb();
    $query = $conn->query("
    UPDATE `eshop_inventory` SET `productName`='$payload->productName',`image`='$payload->image',`brand`='$payload->brand',`price`='$payload->price',`stock`='$payload->stock' WHERE `eshop_inventory`.`id` = '$payload->id'");
    $results = $query->fetch();
    print_r($results);
}

function delete(){
    $payload = file_get_contents("php://input");
    $payload = json_decode($payload);

    $conn = getDb();
    $query = $conn->query("
    DELETE FROM `eshop_inventory` WHERE `eshop_inventory`.`id` = '$payload->id'");
    $results = $query->fetchAll();  
    print_r($results);
}