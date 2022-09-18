<?php // front controller

// start session
session_start();

// composer autoloader
require_once '../vendor/autoload.php';

// routing
$router   = new App\Components\Router();
$response = $router->run();

// send response
echo $response;
