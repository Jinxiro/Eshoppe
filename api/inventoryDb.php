<?php
require("./db.php");

$action = $_GET['action'] ?? null;

if ($action == 'read'){
    read();
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
    IINSERT INTO `eshop_inventory` (`id`, `productName`, `image`, `brand`, `price`, `stock`) VALUES (NULL, 'ERA UNISEX', 'https://www.footlocker.ph/media/catalog/product/cache/1384ea813c36abc3a773dd6494b9b881/0/8/0803-VAS000EWZBLK00506H-1.jpg', 'VANS', '7795', '20');
    ");
    $results = $query->fetch();
    print_r($results);
}