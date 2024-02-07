<?php

namespace Kivinus\MyCore;

class Autoloader
{
    public static function registrate(string $dir): void
    {
        $autoloader = function (string $className) use ($dir) {
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $className); //Controller/UserController

            //echo __DIR__;  нынешняя директория
            //echo dirname(__DIR__); родителькая директория

            $path = $dir . '/' . $path . '.php';

            if (file_exists($path)) {
                require_once $path;
                return true;
            }

            return false;
        };

        spl_autoload_register($autoloader);
    }
}