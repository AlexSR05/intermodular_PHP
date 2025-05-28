<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
use App\Core\Auth;

if (Auth::check()) {
    redirect('/auth/login/index.php')->with('error', 'Debes iniciar sesión para ver esta página')->send();
}

// Verificar si se proporcionó un ID de pedido
if (empty($_GET['order_id'])) {
    redirect('/')->with('error', 'ID de pedido no válido')->send();
}

// Obtener el pedido
$order_id = (int) $_GET['order_id'];
$venta = \App\Models\Venta::find($order_id);

// Verificar si el pedido existe y pertenece al usuario actual
if (!$venta || $venta->usuario_id !== Auth::user()['id']) {
    redirect('/')->with('error', 'Pedido no encontrado')->send();
}

// Obtener los artículos del pedido
$ventaArticulos = \App\Models\VentaArticulo::where('venta_id', $venta->id)->get();

// Renderizar la vista de confirmación
view('checkout.confirmation', compact('venta', 'ventaArticulos'));
