<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../vendor/autoload.php';
include_once '../config.php';
session_start();
use Core\Router;

$router = new Router();
$router->loadPage();

md5('password'.'salt');