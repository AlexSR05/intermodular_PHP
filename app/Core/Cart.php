<?php

declare(strict_types=1);

namespace App\Core;

class Cart
{
    // Instancia de la clase Session
    private Session $session;

    // Inicializamos el carrito al cargar la clase
    public function __construct(?Session $session = null)
    {
        $this->session = $session ?? session();

        if (!$this->session->get('cart')) {
            $this->session->set('cart', []);
        }
    }

    // Obtener la información del carrito actualizada
    public function all(): array
    {
        return $this->sync();
    }

    // Obtener todos los items del carrito
    public function getItems(): array
    {
        return $this->session->get('cart');
    }

    // Verificar si existe el item en el carrito
    public function has(int $articulo_id, string $articulo_tipo, int $variante_id): bool
    {
        $key = $this->makeKey($articulo_id, $articulo_tipo, $variante_id);
        return isset($this->session->get('cart')[$key]);
    }

    // Añadir artículo al carrito
    public function add(int $articulo_id, string $articulo_tipo, int $variante_id, int $cantidad, $precio): void
    {
        // Convertir el precio a float para asegurar compatibilidad
        $precio = (float) $precio;
        
        $key = $this->makeKey($articulo_id, $articulo_tipo, $variante_id);

        $cart = $this->session->get('cart');
        
        // Para instrumentales, siempre es cantidad 1 y no se acumula
        if ($articulo_tipo === 'instrumental') {
            $cart[$key] = [
                'articulo_id'   => $articulo_id,
                'articulo_tipo' => $articulo_tipo,
                'variante_id'   => $variante_id,
                'cantidad'      => 1,
                'precio'        => $precio
            ];
        } else {
            // Para otros tipos de productos (si se añaden en el futuro)
            if (isset($cart[$key])) {
                $cart[$key]['cantidad'] += $cantidad;
            } else {
                $cart[$key] = [
                    'articulo_id'   => $articulo_id,
                    'articulo_tipo' => $articulo_tipo,
                    'variante_id'   => $variante_id,
                    'cantidad'      => $cantidad,
                    'precio'        => $precio
                ];
            }
        }

        $this->session->set('cart', $cart);
    }

    public function update(int $articulo_id, string $articulo_tipo, int $variante_id, int $cantidad): void
    {
        $key = $this->makeKey($articulo_id, $articulo_tipo, $variante_id);
    
        $cart = $this->session->get('cart');
        
        // Para instrumentales, siempre es cantidad 1
        if ($articulo_tipo === 'instrumental') {
            $cart[$key]['cantidad'] = 1;
        } else {
            $cart[$key]['cantidad'] = $cantidad;
        }
    
        $this->session->set('cart', $cart);
    }

    // Sincronizar el carrito con la base de datos
    public function sync(): array
    {
        $items = $this->session->get('cart');

        $updatedCart = [];
        $models = [];
        $messages = [];
        $cantidadTotal = 0;
        $importeTotal = 0;

        foreach ($items as $key => $details) {
            $modelClass = $this->getStockable($details['articulo_tipo']);
            /** @var \App\Models\Instrumental|null $variante */
            $variante = $modelClass::find($details['variante_id']);

            if (!$variante) {
                // Error grave. No se añade el item al carrito actualizado
                $messages[$key][] = "Uno de los artículos de tu cesta ya no está disponible.";
                continue;
            }

            $updatedItem = $details; // Copia del item original para posibles ajustes

            // Para instrumentales, no verificamos stock ya que son productos únicos
            // y se eliminan después de la compra

            // Convertir ambos precios a float para comparación
            $variantePrecio = (float) $variante->precio;
            $detailsPrecio = (float) $details['precio'];
            
            if ($variantePrecio != $detailsPrecio) {
                $diff = $variantePrecio - $detailsPrecio;
                $updatedItem['precio'] = $variantePrecio;
                if ($diff > 0) {
                    $messages[$key][] = "El precio ha subido $diff euros";
                } else {
                    $messages[$key][] = "El precio ha bajado " . abs($diff) . " euros.";
                }
            }

            $updatedCart[$key] = $updatedItem;
            $models[$key] = $variante;
            $cantidadTotal += $updatedItem['cantidad'];
            $importeTotal += $updatedItem['cantidad'] * (float)$updatedItem['precio'];
        }

        // Solo actualizar la sesión si hubo cambios reales
        $hasChanges = !empty($messages);
        if ($hasChanges) {
            $this->session->set('cart', $updatedCart);
        }

        return [
            'items'         => $updatedCart,
            'models'        => $models,
            'messages'      => $messages,
            'cantidadTotal' => $cantidadTotal,
            'importeTotal'  => $importeTotal,
            'hasChanges'    => $hasChanges
        ];
    }

    // Eliminar un artículo del carrito
    public function remove(int $articulo_id, string $articulo_tipo, int $variante_id): void
    {
        $key = $this->makeKey($articulo_id, $articulo_tipo, $variante_id);
        $cart = $this->session->get('cart');
        unset($cart[$key]);

        $this->session->set('cart', $cart);
    }

    // Vaciar el carrito
    public function clear(): void
    {
        $this->session->set('cart', []);
    }

    // Obtener el total de artículos en el carrito
    public function cantidad_total(): int
    {
        $cart = $this->session->get('cart');
        return array_sum(array_column($cart, 'cantidad'));
    }

    public function importe_total(): float
    {
        $importe = 0;
        foreach ($this->all()['items'] as $item) {
            $importe += $item['cantidad'] * (float)$item['precio'];
        }
        return $importe;
    }

    // Generar la clave única para cada artículo en el carrito
    private function makeKey(int $articulo_id, string $articulo_tipo, int $variante_id): string
    {
        return "$articulo_id:$articulo_tipo:$variante_id";
    }

    public static function parseKey(string $key): array
    {
        [$articuloId, $tipo, $varianteId] = explode(':', $key);
        return [
            'articulo_id'   => (int) $articuloId,
            'articulo_tipo' => $tipo,
            'variante_id'   => (int) $varianteId,
        ];
    }

    public function getStockable(string $articulo_tipo): string
    {
        return match ($articulo_tipo) {
            'instrumental' => \App\Models\Instrumental::class,
            default     => throw new \Exception("Tipo de variante no reconocido: $articulo_tipo")
        };
    }
}
