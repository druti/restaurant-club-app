<?php

//connection variables
$host = getenv('HOST');
$user = getenv('SQL_USER');
$password = getenv('SQL_PASS');

try {
    $db = new PDO('mysql:host=localhost;dbname=spoonity;charset=utf8mb4',  $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $e) {
    echo 'Error connecting to the Database: ' . $e->getMessage();
    exit;
}
