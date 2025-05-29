<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Cart;
use App\Core\Request;
use App\Models\Instrumental;

class CartController
{
    private Cart $cart;

    public function __construct(?Cart $cart = null)
    {
        $this->cart = $cart ?? new Cart();
    }

    // Mostrar el contenido del carrito
    public function index(): void
    {
        $cartData = $this->cart->all();

        if ($cartData['hasChanges']) {
            session()->flash('messages', $cartData['messages']);
        }

        view('cart.index', compact('cartData'));
    }

    // Añadir un artículo al carrito
    public function add(Request $request): void
    {
        $articuloId = (int)$request->articulo_id;
        $returnUrl = $request->return_url ?? '/carrito/index.php';

        $instrumental = Instrumental::find($articuloId);
        if (!$instrumental) {
            back()->with('error', 'Instrumental no encontrado')->send();
        }

        // Para instrumentales, usamos el tipo "instrumental"
        $tipo = 'instrumental';
        
        // Para instrumentales, la variante es el mismo instrumental
        $variante = $instrumental;

        if (!$variante) {
            back()->with('error', 'Variante no disponible')->send();
        }
        
        // Verificar si el instrumental ya está en el carrito
        if ($this->cart->has($articuloId, $tipo, $variante->id)) {
            back()->with('warning', 'Este instrumental ya está en tu carrito')->send();
            return;
        }
        
        // En este caso, la cantidad siempre es 1 ya que cada instrumental es único
        $cantidad = 1;
        
        // Asegurarse de que el precio se pasa como float
        $precio = $variante->precio;
        
        $this->cart->add($articuloId, $tipo, $variante->id, $cantidad, $precio);
        
        // Redirigir de vuelta a la página anterior en lugar de ir al carrito
        back()->with('success', 'Instrumental añadido al carrito')->send();
    }

    // Actualizar la cantidad de un artículo
    public function update(Request $request)
    {
        $articulo_id = (int) $request->articulo_id;
        $articulo_tipo = $request->articulo_tipo;
        $variante_id = (int) $request->variante_id;
        $cantidad = (int) $request->cantidad;
 
        if($cantidad <= 0){
            back()->with('error', 'La cantidad debe ser mayor que cero.')->send();
        }

        if (!$this->cart->has($articulo_id, $articulo_tipo, $variante_id)) {
            back()->with('error', 'Artículo no encontrado en la cesta.')->send();
        }

        if ($articulo_tipo === 'instrumental') {
            $cantidad = 1;
        }

        $this->cart->update($articulo_id, $articulo_tipo, $variante_id, $cantidad);

        back()->with('success', "Cantidad actualizada.")->send();
    }

    // Eliminar un artículo del carrito
    public function remove(Request $request)
    {
        $articulo_id = (int) $request->articulo_id;
        $articulo_tipo = $request->articulo_tipo;
        $variante_id = (int) $request->variante_id;

        $this->cart->remove($articulo_id, $articulo_tipo, $variante_id);

        return redirect('/carrito')->with('success', 'El artículo fue eliminado de la cesta.');
    }

    // Vaciar el carrito
    public function clear()
    {
        $this->cart->clear();
        return redirect('/carrito')->with('success', 'Tu cesta está vacía');
    }
}
