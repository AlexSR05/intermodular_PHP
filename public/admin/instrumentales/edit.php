<?php
require_once __DIR__ . '/../../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../../app/Http/Controllers/AdminController.php';

use App\Http\Controllers\AdminController;

$id = $_GET['id'] ?? 0;
$controller = new AdminController();
$controller->editInstrumental($id);