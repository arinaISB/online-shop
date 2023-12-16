<?php

//print_r($_POST);

$errors = [];

$name = $_POST['name'];
if (strlen($name) < 2)
{
    $errors['name'] = "The name must be more than two characters";
} elseif (!ctype_alpha($name))
{
    $errors['name'] = "The name can only contain alphabetic characters";
}

$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $errors['email'] = "Email is invalid";
}

$password = $_POST['psw'];
$repeatPassword = $_POST['psw-repeat'];
if (strlen($password) < 8)
{
    $errors['psw'] = "The password must contain at least 8 characters";

} elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $password))
{
    $errors['psw'] = "The password must contain at least one letter and one number";
} elseif ($password !== $repeatPassword)
{
    $errors['psw-repeat'] = "Password and repeat password do not match";
} else
{
    $password = password_hash($password, PASSWORD_DEFAULT);
}

if(empty($errors))
{
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres", "dbuser", "dbpwd");
    $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $statement = $pdo->prepare('SELECT * FROM users WHERE name = :name');
    $statement->execute(['name' => $name]);
    $data = $statement->fetch();

    echo "You are successfully registered";

} //else
//{
//    foreach ($errors as $error) {
//        echo $error . "<br>";
//    }
//}

require_once './get_registrate.php';
?>
