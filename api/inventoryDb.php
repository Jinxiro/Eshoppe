<?php
require("./db.php");

$action = $_GET['action'] ?? null;

if ($action == 'read'){
    read();
}
else if ($action == 'create'){
    create();
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
    IINSERT INTO `eshop_inventory` (`id`, `productName`, `image`, `brand`, `price`, `stock`) VALUES (NULL, '$payload->productName', '$payload->imagelink', '$payload->brand', '$payload->price', '$payload->stock');
    ");
    $results = $query->fetch();
    print_r($results);
}