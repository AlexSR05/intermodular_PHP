<?php
require_once __DIR__ . '/../bootstrap/bootstrap.php';
use App\Models\Instrumental;
use App\Models\Generico;
use App\Models\Balon;
use App\Models\Zapatilla;
use App\Core\Cart;
use App\Http\Controllers\VentaController;


(new VentaController())->store();