<?php
require_once __DIR__ . '/../bootstrap/bootstrap.php';

use App\Core\Request;
use App\Models\Articulo;

$request = Request::fake([
    'articulo_id' => 2,
    'color_id'    => 3
]);
$articulo = Articulo::find($request->articulo_id);

// Buscar variante dependiendo del tipo de artículo
if ($articulo->tipo === 'balon') {
    $color = $articulo->balon->colores()->where('color_id', $request->color_id)->first();
}
/*
Balón FIFA Quality
Color: Negro

Precio: 24.99

Stock: 9
*/
?>

<h1><?= $articulo->nombre; ?></h1>
<p><?= "Color: {$color->nombre}"; ?></p>
<p><?= "Precio: {$color->precio}"; ?></p>
<p><?= "Stock: {$color->stock}"; ?></p>



