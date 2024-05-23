<?php
require_once './src/router/router.php';

$parts = explode('/', $_SERVER['REQUEST_URI']);
$router = new Router();

    // Indicate allowed methods
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Max-Age: 86400'); // Cache for 1 day


$router->route(explode('?', $parts[2])[0], isset(explode('?', $parts[2])[1]) ? explode('?', $parts[2])[1] : '');
//var_dump($rez->fetch_all());
//die();

