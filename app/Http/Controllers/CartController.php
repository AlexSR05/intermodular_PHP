<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Cart;
use App\Core\Request;
use App\Models\Articulo;
use App\Models\Generico;
use App\Models\BalonColor;
use App\Models\ZapatillaTallaColor;

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
        $articuloId = $request->articulo_id;

        $articulo = Articulo::find($articuloId);
        if (!$articulo) {
            back()->with('error', 'Artículo no encontrado')->send();
        }

        $tipo = $articulo->tipo;

        match ($tipo) {
            'balon' => $variante = BalonColor::where('balon_id', $articuloId)
                ->where('color_id', $request->color_id)
                ->first(),

            'zapatilla' => $variante = ZapatillaTallaColor::where('zapatilla_id', $articuloId)
                ->where('color_id', $request->color_id)
                ->where('talla_id', $request->talla_id)
                ->first(),

            'generico' => $variante = Generico::find($articuloId),

            default => throw new \Exception("Tipo de artículo no reconocido: $tipo")
        };

        if (!$variante) {
            back()->with('error', 'Variante no disponible')->send();
        }

        if ($variante->stock <= 0) {
            back()->with('error', 'Este artículo está agotado')->send();
        }
        
        $cantidad = min($request->cantidad, $variante->stock);
        $this->cart->add($articuloId, $tipo, $variante->id, $cantidad, $variante->precio);

        if ($cantidad < $request->cantidad) {
            redirect('/carrito/index.php')->with('warning', "Solo se añadieron $cantidad unidades por falta de stock")->send();
        }
        print_r($this->cart->getItems()); exit;
        redirect('/carrito/index.php')->with('success', 'Artículo añadido al carrito')->send();
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

        $this->cart->update($articulo_id, $articulo_tipo, $variante_id, $cantidad);

        back()->with('success', "Cantidad actualizada a $cantidad.")->send();
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
