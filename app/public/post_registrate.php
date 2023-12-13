<?php

print_r($_POST);
$flag= true;

$name = $_POST['name'];
if (strlen($name) < 2)
{
    echo "The name must be more than two characters\n";
    $flag = false;
}
if(!ctype_alpha($name)) {
    echo "The name can only contain alphabetic characters\n";
    $flag = false;
}

$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    echo "Email is invalid\n";
    $flag = false;
}

$password = $_POST['psw'];
if (strlen($password) < 8)
{
    echo "The password must contain at least 8 characters\n";
    $flag = false;
}
if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $password))
{
    echo "The password must contain at least one letter and one number\n";
    $flag = false;
}
$repeatPassword = $_POST['psw-repeat'];
if ($password !== $repeatPassword)
{
    echo "Password and repeat password do not match\n";
    $flag = false;
}

if($flag)
{
    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $statement = $pdo->prepare('SELECT * FROM users WHERE name = :name');
    $statement->execute(['name' => $name]);
    $data = $statement->fetch();
    var_dump($data);
}
