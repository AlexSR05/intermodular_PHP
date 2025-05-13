<?php

require_once __DIR__ . "/../../bootstrap/bootstrap.php";
require_once __DIR__ . "/../../app/Http/Controllers/ContactController.php";

use App\Controllers\ContactController;
use App\Core\ErrorHandler;

try{
    (new ContactController())->index();
} catch (Exception $e) {
    ErrorHandler::handle($e);
}