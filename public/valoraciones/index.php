<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";
require_once __DIR__ . "/../../app/Controllers/ValoracionController.php";

use App\Core\ErrorHandler;
use App\Controllers\ValoracionController;

ob_start();

try {
    (new ValoracionController())->getAll();
} catch (Exception $e) {
    ErrorHandler::handle($e);
}

ob_end_flush();