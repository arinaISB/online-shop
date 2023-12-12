<?php

print_r($_GET);

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];

$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");