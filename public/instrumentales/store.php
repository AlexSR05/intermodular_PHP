<?php
require_once __DIR__ . '/../bootstrap/bootstrap.php';
use App\Models\Articulo;
use App\Models\Generico;
use App\Models\Balon;
use App\Models\Zapatilla;


$articulo = new Articulo();
$articulo->nombre = "Muñequera tenis T/única";

$munequera = new Generico();
$munequera->articulo = $articulo;
$munequera->sku = "MUNEQUERA-TENIS-TU";
$munequera->stock = 10;
$munequera->precio = 7.95;
$munequera->save();


$articulo = new Articulo();
$articulo->nombre = "Balón Wilson ACB";

$balon = new Balon();
$balon->articulo = $articulo;
$balon->color_id = 1; // El id del color
$balon->sku = "BALON-ACB-ROJ";
$balon->stock = 10;
$balon->precio = 94.99;
$balon->save();


$articulo = new Articulo();
$articulo->nombre = "Zapatilla tenis Rafa Nadal";

$zapatilla = new Zapatilla();
$zapatilla->articulo = $articulo;
$zapatilla->cierre = "cordones";
$zapatilla->talla_id = 3; // Talla 40
$zapatilla->color_id = 3; // Color negro
$zapatilla->sku = "ZAPATILLA-TENIS-NADAL-NEG-T40";
$zapatilla->stock = 10;
$zapatilla->precio = 159.95;
$zapatilla->save();
