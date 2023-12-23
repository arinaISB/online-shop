<?php

$controllerAutoloader = function (string $className)
{
    if (file_exists("./../Controller/$className.php"))
    {
        require_once "./../Controller/$className.php";
        return true;//необязательно
    }

    return false;
};

$modelAutoloader = function (string $className)
{
    if (file_exists("./../Model/$className.php"))
    {
        require_once "./../Model/$className.php";
        return true;//необязательно
    }

    return false;
};

$appAutoloader = function (string $className)
{
    if (file_exists("./../$className.php"))
    {
        require_once "./../$className.php";
        return true;
    }

    return false;
};


spl_autoload_register($controllerAutoloader);
spl_autoload_register($modelAutoloader);
spl_autoload_register($appAutoloader);

$app = new App();
$app->run();