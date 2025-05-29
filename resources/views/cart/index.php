<div class="container cart-container">
    <h1 class="cart-title">Tu Carrito de Compra</h1>
    
    <?php if (empty($cartData['items'])): ?>
        <div class="cart-empty">
            <i class="bi bi-cart-x"></i>
            <p>Tu carrito está vacío.</p>
            <a href="<?= BASE_URL ?>/instrumentales/instrumentales_index.php" class="btn btn-primary">
                Explorar instrumentales
            </a>
        </div>
    <?php else: ?>
        
        <?php if (!empty($cartData['messages'])): ?>
            <?php foreach ($cartData['messages'] as $key => $messageList): ?>
                <?php foreach ($messageList as $message): ?>
                    <div class="alert alert-warning">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Artículos en tu carrito</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartData['items'] as $key => $item): ?>
                                        <?php 
                                            $model = $cartData['models'][$key] ?? null;
                                            if (!$model) continue;
                                            
                                            $keyParts = \App\Core\Cart::parseKey($key);
                                            $articulo_id = $keyParts['articulo_id'];
                                            $articulo_tipo = $keyParts['articulo_tipo'];
                                            $variante_id = $keyParts['variante_id'];
                                            
                                            $instrumental = \App\Models\Instrumental::find($articulo_id);
                                        ?>
                                        <tr>
                                            <td data-label="Producto">
                                                <div class="d-flex align-items-center">
                                                    <?php if ($instrumental && $instrumental->imagen): ?>
                                                        <img src="<?= BASE_URL . '/' . $instrumental->imagen ?>" alt="<?= $instrumental ? htmlspecialchars($instrumental->titulo) : 'Producto' ?>" class="cart-product-img me-3">
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="cart-product-title"><?= $instrumental ? htmlspecialchars($instrumental->titulo) : 'Producto' ?></h6>
                                                        <small class="cart-product-meta">
                                                            <?php 
                                                                if ($instrumental && $instrumental->productor()) {
                                                                    echo htmlspecialchars($instrumental->productor()->nombre);
                                                                }
                                                            ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Precio" class="cart-price"><?= number_format($item['precio'], 2) ?> €</td>
                                            <td data-label="Acciones">
                                                <form action="<?= BASE_URL ?>/carrito/remove.php" method="POST">
                                                    <input type="hidden" name="articulo_id" value="<?= $articulo_id ?>">
                                                    <input type="hidden" name="articulo_tipo" value="<?= $articulo_tipo ?>">
                                                    <input type="hidden" name="variante_id" value="<?= $variante_id ?>">
                                                    <button type="submit" class="cart-remove" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="cart-actions">
                            <a href="<?= BASE_URL ?>/instrumentales/instrumentales_index.php" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Seguir comprando
                            </a>
                            <form action="<?= BASE_URL ?>/carrito/clear.php" method="POST">
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="bi bi-trash"></i> Vaciar carrito
                                </button>
                            </form>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h5 class="cart-summary-title">Resumen del pedido</h5>
                    
                    <div class="cart-summary-row">
                        <span class="cart-summary-label">Envío:</span>
                        <span class="cart-summary-value">Gratis</span>
                    </div>
                    
                    <div class="cart-summary-row">
                        <span class="cart-summary-label">Total:</span>
                        <span class="cart-summary-total"><?= number_format($cartData['importeTotal'], 2) ?> €</span>
                    </div>
                    
                    <br>
                    <a href="<?= BASE_URL ?>/checkout/index.php" class="btn btn-outline-primary">
                        Proceder al pago <i class="bi bi-arrow-right"></i>
                    </a>
                    <br><br>
                </div>
                
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Métodos de pago aceptados</h5>
                        <div class="d-flex justify-content-between mt-3">
                            <i class="bi bi-credit-card fs-2"></i>
                            <i class="bi bi-paypal fs-2"></i>
                            <i class="bi bi-bank fs-2"></i>
                            <i class="bi bi-wallet2 fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
