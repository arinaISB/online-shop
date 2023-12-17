<?php

//print_r($_POST);

$errors = [];

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email)) {
    $errors['email'] = 'Email is required';
}
if (empty($password)) {
    $errors['password'] = 'Password is required';
}


if(empty($errors))
{
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres", "dbuser", "dbpwd");

    $statement = $pdo->prepare(query: "SELECT * FROM users WHERE email = :email");
    $statement->execute(['email' => $email]);
    $data = $statement->fetch();

    if ($data == 0)
    {
        $errors['email'] = 'You are not registred';
    } else
    {
        if(password_verify($password, $data['password']))
        {
            session_start();
            $_SESSION['user_id'] = $data['id'];
            header("Location: /main.php");
        } else {
            $errors['password'] = 'Invalid password';
        }
    }

}

require_once './get_login.php';