<?php

require_once './../Autoloader.php';

Autoloader::registrate(dirname(__DIR__));

$app = new App();
$app->run();