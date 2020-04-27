<?php

include 'vendor/autoload.php';

define('APP_BASE_PATH', __DIR__ . '/app');
//
//function exception_handler($exception) {
//    echo "Uncaught exception: " , $exception->getMessage(), "\n";
//}
//
//set_exception_handler('exception_handler');

// Step 1: Boot application
\Intass\Container::getInstance()->boot();
