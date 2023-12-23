<?php

class Autoloader
{
    public static function registrate (string $dir)
    {
        $autoload = function (string $className) use ($dir)
        {
            //Controller\UserController
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $className); //Controller/UserController

            //echo __DIR__; /var/www/html/app/public нынешняя директория
            //echo dirname(__DIR__); /var/www/html/app родителькая директория

            $path = $dir . '/' . $path . '.php';
            __DIR__;
            if (file_exists($path))
            {
                require_once $path;
                return true;
            }

            return false;
        };

        spl_autoload_register($autoload);
    }
}