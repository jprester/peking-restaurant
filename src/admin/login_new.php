<?php 
require_once('init.php');

use Peking\Admin\AuthController;

$controller = new AuthController();
$controller->login();
?>