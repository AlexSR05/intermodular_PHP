<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";
require_once __DIR__ . "/../../app/Http/Controllers/ValoracionController.php";

use App\Controllers\ValoracionController;

$controller = new ValoracionController();
$controller->store();