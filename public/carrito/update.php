<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../App/Http/Controllers/CartController.php';

use App\Http\Controllers\CartController;
use App\Core\Request;

$request = new Request();
$controller = new CartController();
$controller->update($request);
