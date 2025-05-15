<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";
require_once __DIR__ . "/../../app/Http/Controllers/AuthController.php";

use App\Core\ErrorHandler;
use App\Http\Controllers\AuthController;

ob_start();

try {
    (new AuthController())->logout();
} catch (Exception $e) {
    ErrorHandler::handle($e);
}

ob_end_flush();
