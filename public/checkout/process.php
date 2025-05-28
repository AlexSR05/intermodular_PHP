<?php

require_once __DIR__ . '/../../bootstrap/bootstrap.php';
use App\Core\Auth;

// Verificar si el usuario está autenticado
if (Auth::check()) {
    redirect('/auth/login/index.php')->with('error', 'Debes iniciar sesión para realizar un pedido')->send();
}

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/checkout/index.php')->with('error', 'Método no permitido')->send();
}

// Obtener el carrito
$cart = new \App\Core\Cart();
$cartData = $cart->all();

// Verificar si el carrito está vacío
if (empty($cartData['items'])) {
    redirect('/carrito/index.php')->with('error', 'Tu carrito está vacío')->send();
}

// Validar datos del formulario
$required_fields = ['nombre', 'apellidos', 'email', 'direccion', 'ciudad', 'provincia', 'codigo_postal', 'telefono', 'metodo_pago', 'terminos'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        redirect('/checkout/index.php')->with('error', 'Por favor, completa todos los campos requeridos')->send();
    }
}

try {
    // Crear la venta
    $venta = new \App\Models\Venta();
    $venta->usuario_id = Auth::user()['id'];
    $venta->fecha_venta = date('Y-m-d H:i:s');
    $venta->total = $cartData['importeTotal'] * 1.21; // Incluir impuestos
    $venta->estado = 'pendiente';
    $venta->metodo_pago = $_POST['metodo_pago'];
    $venta->direccion_envio = $_POST['direccion'] . ', ' . $_POST['ciudad'] . ', ' . $_POST['provincia'] . ' ' . $_POST['codigo_postal'];
    $venta->save();
    
    $order_id = $venta->id;
    $error_occurred = false;
    
    // Crear los artículos de la venta
    foreach ($cartData['items'] as $key => $item) {
        $keyParts = \App\Core\Cart::parseKey($key);
        $articulo_id = $keyParts['articulo_id'];
        
        // Verificar stock antes de procesar
        $instrumental = \App\Models\Instrumental::find($articulo_id);
        if (!$instrumental || $instrumental->stock < $item['cantidad']) {
            $error_occurred = true;
            $error_message = 'No hay suficiente stock para ' . ($instrumental ? $instrumental->nombre : 'un producto');
            break;
        }
        
        $ventaArticulo = new \App\Models\VentaArticulo();
        $ventaArticulo->venta_id = $venta->id;
        $ventaArticulo->instrumental_id = $articulo_id;
        $ventaArticulo->cantidad = $item['cantidad'];
        $ventaArticulo->precio_unitario = $item['precio'];
        $ventaArticulo->save();
        
        // Actualizar stock del instrumental
        $instrumental->stock -= $item['cantidad'];
        $instrumental->save();
    }
    
    if ($error_occurred) {
        // Intentar eliminar la venta y sus artículos (limpieza manual)
        try {
            // Eliminar artículos de venta
            //$db = \App\Core\DB::getInstance();
            $db->delete('ventas_articulos', 'venta_id = ' . $venta->id);
            
            // Eliminar la venta
            $db->delete('ventas', 'id = ' . $venta->id);
        } catch (\Exception $cleanup_error) {
            // Si falla la limpieza, registrar el error pero continuar
            error_log('Error al limpiar venta fallida: ' . $cleanup_error->getMessage());
        }
        
        redirect('/checkout/index.php')->with('error', $error_message)->send();
    }
    
    // Vaciar el carrito solo si todo fue exitoso
    $cart->clear();
    
    // Redirigir a la página de confirmación
    redirect('/checkout/confirmation.php?order_id=' . $order_id)->with('success', 'Tu pedido ha sido procesado correctamente')->send();
    
} catch (\Exception $e) {
    // Redirigir con mensaje de error
    redirect('/checkout/index.php')->with('error', 'Ha ocurrido un error al procesar tu pedido: ' . $e->getMessage())->send();
}