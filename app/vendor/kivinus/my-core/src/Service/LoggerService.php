<?php

namespace Core\src\Service;
use Throwable;

class LoggerService
{
    public static function error(Throwable $exception): void
    {
        $message = date('Y-m-d H:i:s') . ' ' .
            'Message: ' . $exception->getMessage() . ', ' .
            'Code: ' . $exception->getCode() . ', ' .
            'File: ' . $exception->getFile() . ', ' .
            'Line: ' . $exception->getLine()  . "\n";

        $fileName = './../Storage/Logs/errors';
        file_put_contents($fileName, $message, FILE_APPEND);
    }
}