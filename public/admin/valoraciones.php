<?php
require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Http/Controllers/AdminController.php';

use App\Http\Controllers\AdminController;

$controller = new AdminController();
$controller->valoraciones();
