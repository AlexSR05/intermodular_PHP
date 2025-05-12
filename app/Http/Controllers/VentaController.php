<?php

namespace App\Http\Controllers;

require_once __DIR__ . '/../../Models/Venta.php';
require_once __DIR__ . '/../../Models/VentaArticulo.php';

use App\Models\Venta;
use App\Models\VentaArticulo;
use App\Core\Request;
use App\Core\DB;
use App\Core\Auth;
use App\Core\Cart;

class VentaController
{
    public function index()
    {
        $ventas = Venta::all();
        view('ventas/index', compact('ventas'));
    }

    public function show(string $id)
    {
        $venta = Venta::findOrFail($id);
        view('ventas/show', compact('venta'));
    }

    public function store()
    {
        // Sincronizar el carrito con la base de datos
        $cart = new Cart();
        $cartData = $cart->all();

        // Si hubo cambios en el carrito, redirigir con los mensajes
        if($cartData['hasChanges']){
            //redirect('/carrito/index.php')->with('messages', $cartData['messages']);
            echo "CAMBIOS"; exit;
        }

        $items = $cartData['items'];
        $models = $cartData['models'];

        if(empty($items)){
            //redirect('/carrito/index.php')->with('error', 'No se realizó la compra. El carrito está vacío.')->send();
            echo "VACIO"; exit;
        }

        /*
        // Mostrar info en modo debug
        if (defined('DEBUG') && DEBUG) {
            echo '<pre>';
            print_r($cartData);
            echo '</pre>';
            exit;
        }*/
        
        // Intentar realizar la venta
        try {
            $con = DB::connection();
            $con->beginTransaction();
        
            // Crear la venta
            $venta = new Venta();
            $venta->fecha = date('Y-m-d H:i:s');
            $venta->usuario_id = 1;//Auth::id();
            $venta->cantidad_total = $cartData['cantidadTotal'];
            $venta->importe_total = $cartData['importeTotal'];
            $venta->save();

            // Procesar cada item del carrito
            foreach ($models as $key => $model) {
                // Actualizar el stock de la variante
                $model->decrementStock($items[$key]['cantidad']);

                // Crear el detalle de la venta
                $detalle = new VentaArticulo();
                $detalle->venta_id = $venta->id;
                $detalle->articulo_id = $items[$key]['articulo_id'];
                $detalle->articulo_tipo = $items[$key]['articulo_tipo'];
                $detalle->variante_id = $items[$key]['variante_id'];
                $detalle->variante_sku = $model->sku;
                $detalle->cantidad = $items[$key]['cantidad'];
                $detalle->precio_ud = $model->precio;
                $detalle->save();
            }

            $con->commit();

        } catch (\PDOException $e) {
            $con->rollBack();
            echo "<pre>{$e->getMessage()}</pre>"; exit;
            //redirect('/carrito/index.php')->with('error', 'No se pudo completar la compra. Por favor, inténtalo de nuevo.')->send();
        }

        // Limpiar el carrito después de la compra
        $cart->clear();

        // Redirigir al resumen de la venta
        //redirect('/ventas/resumen.php')->send();
    }
}
