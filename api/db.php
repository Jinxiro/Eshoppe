<?php

function getDb(){
    $host = "localhost";
    $dbname = "eshopdb";
    $user = "eshopdb";
    $password = "cvHCQy*.v/UB/UqK"; 
    
    $dsn = "mysql:
            host=$host;
            dbname=$dbname;
            user=$user;
            password=$password;
    ";

    $conn = new PDO($dsn);
    return $conn;
}

getDb();