<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../App/Core/Auth.php';

use App\Core\Auth;
use App\Models\Productor;
use App\Models\Instrumental;

if (!Auth::check() || !Auth::user()['es_admin']) {
    redirect('/')->with('error', 'No tienes permisos para acceder a esta página')->send();
}

$productores = Productor::all();

$productorInstrumentales = [];
foreach ($productores as $productor) {
    $count = Instrumental::where('productor_id', $productor->id)->count();
    $productorInstrumentales[$productor->id] = $count;
}

view('admin/productores/index', [
    'title' => 'Gestión de Productores | Admin',
    'productores' => $productores,
    'productorInstrumentales' => $productorInstrumentales
]);
