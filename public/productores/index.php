<?php
require_once __DIR__ . '/../../bootstrap/bootstrap.php';

use App\Models\Productor;
use App\Models\Instrumental;

$productores = Productor::all();

$productorInstrumentales = [];
foreach ($productores as $productor) {
    $instrumentales = Instrumental::where('id_productor', $productor->id)->limit(5)->get();
    $productorInstrumentales[$productor->id] = $instrumentales;
    
    $totalInstrumentales = Instrumental::where('id_productor', $productor->id)->count();
    $productorTotalInstrumentales[$productor->id] = $totalInstrumentales;
}
