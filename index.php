<?php
require_once './src/router/router.php';
$parts = explode('/', $_SERVER['REQUEST_URI']);
$router = new Router();
$router->route($parts[2], array_slice($parts,2));
//var_dump($rez->fetch_all());
//die();

