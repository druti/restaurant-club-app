<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../inc/');
$dotenv->load();

//connection variables
$host = getenv('HOST');
$user = getenv('SQL_USER');
$password = getenv('SQL_PASS');

//create mysql connection
$mysqli = new mysqli($host,$user,$password);
if ($mysqli->connect_errno) {
  printf("Connection failed: %s\n", $mysqli->connect_error);
  die();
}

//create the database
if ( !$mysqli->query('CREATE DATABASE spoonity') ) {
  printf("Errormessage: %s\n", $mysqli->error);
}

//create restaurants table
$mysqli->query('
CREATE TABLE `spoonity`.`restaurants`
(
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` LONGTEXT NOT NULL,
  `owner_id` INTEGER UNSIGNED,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);') or die($mysqli->error);

//create users table
$mysqli->query('
CREATE TABLE `spoonity`.`users`
(
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `role_id` INTEGER UNSIGNED,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);') or die($mysqli->error);

//create users table
$mysqli->query('
CREATE TABLE `spoonity`.`votes`
(
  `restaurant_id` INTEGER,
  `user_id` INTEGER,
  `value` FLOAT NOT NULL
);') or die($mysqli->error);

$adminEmail = getenv('ADMIN_EMAIL');
$adminName = getenv('ADMIN_NAME');
$adminPass = password_hash(getenv('ADMIN_PASS'), PASSWORD_DEFAULT);

$mysqli->query("
INSERT INTO `spoonity`.`users` (email, name, password, role_id) VALUES ('$adminEmail', '$adminName', '$adminPass', 1)") or die($mysqli->error);

?>
