<?php

function conectar(){

    $host   = "localhost";
    $db     = "batchan_sushi";
    $user   = "root";
    $pass   ="";
    
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    return $pdo;
}
?>