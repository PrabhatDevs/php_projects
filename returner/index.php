<?php
// Initialize Router
use Core\Router;
// Start the session
session_start();
// Include helper functions
require_once 'app/helpers.php';
// Include the router, controllers, and other necessary files
require_once 'core/Router.php';
require_once 'vendor/autoload.php';
// require_once 'app/controllers/HomeController.php';
// require_once 'app/middleware/AuthMiddleware.php';
require_once 'config/routes.php';
$router = new Router();
routes($router);

$router->handleRequest();