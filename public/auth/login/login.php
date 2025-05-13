<?php

require_once __DIR__ . "/../../../bootstrap/bootstrap.php";
require_once __DIR__ . "/../../../app/Http/Controllers/AuthController.php";

use App\Core\Request;
use App\Core\ErrorHandler;
use App\Http\Controllers\AuthController;

$request = new Request();
try{
    (new AuthController())->login($request);
} catch (Exception $e) {
    ErrorHandler::handle($e);
}