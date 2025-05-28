<?php
require_once __DIR__ . '/../../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../../app/Http/Controllers/AdminController.php';

use App\Http\Controllers\AdminController;
use App\Core\Request;

$controller = new AdminController();
$controller->storeInstrumental(new Request());