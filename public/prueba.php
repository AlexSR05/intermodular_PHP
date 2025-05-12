<?php

require_once __DIR__ . "/../bootstrap/bootstrap.php";
require_once __DIR__ . "/../app/Http/Controllers/InstrumentalController.php";
require_once __DIR__ . "/../app/Models/Instrumental.php";

use App\Core\ErrorHandler;
use App\Models\Instrumental;

try{
    $instrumental = Instrumental::find(15);
    $productor = $instrumental->productor();
    echo "<pre>";
    print_r($instrumental);
    echo "</pre>";
} catch (Exception $e) {
    ErrorHandler::handle($e);
}