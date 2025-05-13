<?php

require_once __DIR__ . "/../../bootstrap/bootstrap.php";
require_once __DIR__ . "/../../app/Http/Controllers/ContactController.php";

use App\Core\Request;
use App\Controllers\ContactController;
use App\Core\ErrorHandler;

$request = new Request();
try{
    (new ContactController())->store($request);
} catch (Exception $e) {
    ErrorHandler::handle($e);
}