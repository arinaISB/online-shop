<?php

print_r($_POST);

$errors = [];

$name = $_POST['name'];
if (strlen($name) < 2)
{
    $errors['name'] = "The name must be more than two characters";
}
if(!ctype_alpha($name)) {
    $errors['name'] = "The name can only contain alphabetic characters";

}

$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $errors['email'] = "Email is invalid";
}

$password = $_POST['psw'];
if (strlen($password) < 8)
{
    $errors['psw'] = "The password must contain at least 8 characters";

}
if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).+$/", $password))
{
    $errors['psw'] = "The password must contain at least one letter and one number";

}
$repeatPassword = $_POST['psw-repeat'];
if ($password !== $repeatPassword)
{
    $errors['psw-repeat'] = "Password and repeat password do not match";
}

if(empty($errors))
{
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres", "dbuser", "dbpwd");
    $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $statement = $pdo->prepare('SELECT * FROM users WHERE name = :name');
    $statement->execute(['name' => $name]);
    $data = $statement->fetch();
    var_dump($data);
} else
{
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}

?>

<form action="post_registrate.php" method="POST">
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <label style="color: red"><?php echo $errors['name'] ?? ''; ?></label>
        <input type="text" placeholder="Enter Name" name="name" id="name" required>

        <label for="email"><b>Email</b></label>
        <label style="color: red"><?php echo $errors['email'] ?? ''; ?></label>
        <input type="text" placeholder="Enter Email" name="email" id="email" required>

        <label for="psw"><b>Password</b></label>
        <label style="color: red"><?php echo $errors['psw'] ?? ''; ?></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <label style="color: red"><?php echo $errors['psw-repeat'] ?? ''; ?></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="#">Sign in</a>.</p>
    </div>
</form>

<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>