<?php

require_once __DIR__ . "/../../bootstrap/bootstrap.php";
require_once __DIR__ . "/../../app/Http/Controllers/InstrumentalController.php";

use App\Controllers\InstrumentalController;
use App\Core\ErrorHandler;

try{
    (new InstrumentalController())->showAll();
} catch (Exception $e) {
    ErrorHandler::handle($e);
}