<?php

//print_r($_POST);

//валидацию написать

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email)) {
    $errors['email'] = 'Email is required';
}
if (empty($password)) {
    $errors['password'] = 'Password is required';
}

$errors = [];

if(empty($errors))
{
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres", "dbuser", "dbpwd");

    $statement = $pdo->prepare(query: "SELECT * FROM users WHERE email = :email");
    $statement->execute(['email' => $email]);
    $data = $statement->fetch();

    if(password_verify($password, $data['password']))
    {
        session_start();
        $_SESSION['user_id'] = $data['id'];

        header("Location: /main.php");
    } else {
        // если пользователь не найден или пароль неверный
        $errors['login'] = 'Invalid email or password';
    }
}