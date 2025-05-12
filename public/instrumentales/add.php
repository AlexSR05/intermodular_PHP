<?php
require_once __DIR__ . '/../bootstrap/bootstrap.php';

use App\Core\Cart;

$cart = new Cart();
$cart->clear();

$cart->add(3, 'generico', 3, 1, 9.99); // BOTELLA-750-ALU (stock 9)
$cart->add(5, 'balon', 3, 2, 94.99);    // BALON-ACB-ROJ (stock 10)
$cart->add(6, 'zapatilla', 4, 3, 159.95);    // ZAPATILLA-TENIS-NADAL-NEG-T40 (stock 10)

echo "<pre>";
print_r($cart->getItems());
echo "</pre>";