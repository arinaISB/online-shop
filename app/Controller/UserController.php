<?php

class UserController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres", "dbuser", "dbpwd");
    }

    public function getRegistration(): void
    {
        require_once './../View/registration.php';
    }

    public function registration(): void
    {
        $errors = $this->validateRegistrationForm($_POST);

        if(empty($errors))
        {
            $password = $_POST['password'];
            $name = $_POST['name'];
            $email = $_POST['email'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            $statement = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

            //после успешной регистрации перенаправляем на страницу авторизации
            header("Location: /login");

            //    $statement = $pdo->prepare('SELECT * FROM users WHERE name = :name');
            //    $statement->execute(['name' => $name]);
            //    $data = $statement->fetch();
            //
            //    echo "{$data['name']} is successfully registered";

        }

        require_once './../View/registration.php';
    }

    private function validateRegistrationForm(array $data): array
    {
        //print_r($_POST);

        $errors = [];

        $name = $data['name'];
        if (strlen($name) < 2)
        {
            $errors['name'] = "The name must be more than two characters";
        } elseif (!ctype_alpha($name))
        {
            $errors['name'] = "The name can only contain alphabetic characters";
        }

        $email = $data['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors['email'] = "Email is invalid";
        }

        $password = $data['psw'];
        $repeatPassword = $data['psw-repeat'];

        if (strlen($password) < 8)
        {
            $errors['psw'] = "The password must contain at least 8 characters";

        } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $password))
        {
            $errors['psw'] = "The password must contain at least one letter and one number";
        } elseif ($password !== $repeatPassword)
        {
            $errors['psw-repeat'] = "Password and repeat password do not match";
        }

        return $errors;
    }

    public function login(): void
    {
        $errors = $this->validateLoginForm($_POST);

        $password = $_POST['password'];
        $email = $_POST['email'];

        if(empty($errors))
        {
            $statement = $this->pdo->prepare(query: "SELECT * FROM users WHERE email = :email");
            $statement->execute(['email' => $email]);
            $data = $statement->fetch();

            if (empty($data))
            {
                $errors['email'] = 'You are not registered';
            } else
            {
                if(password_verify($password, $data['password']))
                {
                    //setcookie('user_id', $data['id']);  небезопасно!
                    session_start();
                    $_SESSION['user_id'] = $data['id'];
                    header("Location: /main");
                } else {
                    $errors['password'] = 'Invalid password or email';
                }
            }

        }

        require_once './../View/login.php';
    }

    private function validateLoginForm(array $data): array
    {
        //print_r($_POST);

        $errors = [];

        $email = $data['email'];
        $password = $data['password'];

        if (empty($email)) {
            $errors['email'] = 'Email is required';
        }
        if (empty($password)) {
            $errors['password'] = 'Password is required';
        }

        return $errors;
    }

    public function getLogin(): void
    {
        require_once './../View/login.php';
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header("Location: /login");

        //require_once '';
    }
}