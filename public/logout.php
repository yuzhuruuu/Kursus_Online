<?php
// public/logout.php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../config/database.php';

$auth = new AuthController($conn);
$auth->logout(); // controller akan destroy session dan redirect
