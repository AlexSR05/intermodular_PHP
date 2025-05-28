<?php

use App\Core\Auth;

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
require_once __DIR__ . '/../../app/Core/Auth.php';


if (!Auth::check()) {
    redirect('/auth/login/index.php')->with('error', 'Debes iniciar sesión para realizar un pedido')->send();
}

$cart = new \App\Core\Cart();
$cartData = $cart->all();

if (empty($cartData['items'])) {
    redirect('/carrito/index.php')->with('error', 'Tu carrito está vacío')->send();
}

view('checkout.index', compact('cartData'));
