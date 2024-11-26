<?php
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'controllers/AuthController.php';

$action = $_GET['action'] ?? 'login';
$authController = new AuthController();

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    default:
        // Handle 404
        break;
}
