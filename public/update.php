<?php
require_once __DIR__ . '/../bootstrap/bootstrap.php';
use App\Models\Articulo;
use App\Models\Generico;
use App\Models\Balon;
use App\Models\Zapatilla;

// Voy a modificar los datos de MUNEQUERA-TENIS-TU
$articulo = Articulo::find(4);
$articulo->nombre = "Muñequera tenis T/única 2025";

$derivado = $articulo->details(); // $derivado es una instancia de Generico en este caso
$derivado->articulo = $articulo;
$derivado->precio = 7.96;
$derivado->stock = 0;
$derivado->sku = "MUNEQUERA-TENIS-T/U";

$derivado->save();

/*
$articulo = Articulo::find(4);
$articulo->nombre = "Muñequera tenis T/única 2025"; // 2025

$munequera = Generico::find(4);
$munequera->articulo = $articulo;
$munequera->precio = 7.96;
$munequera->stock = 0;
$munequera->sku = "MUNEQUERA-TENIS-T/U";

$munequera->save();
*/



// Voy a modificar los datos del BALON-FIFA-ROJ
$articulo = Articulo::find(2);
$articulo->nombre = "Balón FIFA BAD Quality"; // BAD

$derivado = $articulo->details; // $derivado es una instancia de Balon en este caso
$derivado->articulo = $articulo;
$derivado->color_id = 1; // voy a modificar el rojo
$derivado->precio = 25.01;
$derivado->stock = 0;
$derivado->sku = "BALON-FIFA-RED"; // RED

$derivado->save();

/*
$articulo = Articulo::find(2);
$articulo->nombre = "Balón FIFA BAD Quality"; // BAD

$balon = $articulo->balon;
$balon->articulo = $articulo;
$balon->color_id = 1; // voy a modificar el rojo
$balon->precio = 25.01;
$balon->stock = 0;
$balon->sku = "BALON-FIFA-RED"; // RED

$balon->save();
*/

// Voy a modificar ZAPATILLA-RUN-38-ROJ (id 1)

$articulo = Articulo::find(1);
$articulo->nombre = "Zapatilla Runner Pro X"; // Anterior: Zapatilla Runner Pro

$derivado = $articulo->details; // $derivado es una instancia de Zapatilla
$derivado->articulo = $articulo; 
$derivado->cierre = "velcro"; // Anterior: cordones
$derivado->talla_id = 1; // Vamos a modificar la zapatilla de T38
$derivado->color_id = 1; // y color rojo
$derivado->precio = 60.01;
$derivado->stock = 0;
$derivado->sku = "ZAPATILLA-RUNNER-38-ROJ"; // Anterior ZAPATILLA-RUN-38-ROJ

$derivado->save();

/*
$articulo = Articulo::find(1);
$articulo->nombre = "Zapatilla Runner Pro X"; // Anterior: Zapatilla Runner Pro

$zapatilla = $articulo->zapatilla;
$zapatilla->articulo = $articulo;
$zapatilla->cierre = "velcro"; // Anterior: cordones
$zapatilla->talla_id = 1; // Vamos a modificar la zapatilla de T38
$zapatilla->color_id = 1; // y color rojo
$zapatilla->precio = 60.01;
$zapatilla->stock = 0;
$zapatilla->sku = "ZAPATILLA-RUNNER-38-ROJ"; // Anterior ZAPATILLA-RUN-38-ROJ

$zapatilla->save();
*/

