<?php

include 'vendor/autoload.php';

define('APP_BASE_PATH', __DIR__ . '/app');

// Step 1: Boot application
\Intass\Container::getInstance()->boot();
