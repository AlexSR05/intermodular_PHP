<div class="container checkout-container">
    <h1 class="checkout-title">Finalizar Compra</h1>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información de Envío</h5>
                </div>
                <div class="card-body">
                    <form id="checkout-form" action="<?= BASE_URL ?>/checkout/process.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label><br>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= \App\Core\Auth::user()['nombre'] ?? '' ?>" required>
                            </div>
                            <br>
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label><br>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= \App\Core\Auth::user()['apellidos'] ?? '' ?>" required>
                            </div>
                            <br>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label><br>
                            <input type="email" class="form-control" id="email" name="email" value="<?= \App\Core\Auth::user()['email'] ?? '' ?>" required>
                            <br>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label><br>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                            <br>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label><br>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            <br>
                        </div>
                        
                        <h5 class="mb-3">Método de Pago</h5>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" checked>
                                <label class="form-check-label" for="tarjeta">
                                    Tarjeta de Crédito/Débito
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    PayPal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia">
                                <label class="form-check-label" for="transferencia">
                                    Transferencia Bancaria
                                </label>
                            </div>
                        </div>
                        
                        <div id="tarjeta-details" class="payment-details">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tarjeta_numero" class="form-label">Número de Tarjeta</label><br>
                                    <input type="text" class="form-control" id="tarjeta_numero" name="tarjeta_numero" placeholder="XXXX XXXX XXXX XXXX">
                                </div>
                                <br>
                                <div class="col-md-3 mb-3">
                                    <label for="tarjeta_expiracion" class="form-label">Fecha Exp.</label><br>
                                    <input type="text" class="form-control" id="tarjeta_expiracion" name="tarjeta_expiracion" placeholder="MM/AA">
                                </div>
                                <br>
                                <div class="col-md-3 mb-3">
                                    <label for="tarjeta_cvv" class="form-label">CVV</label><br>
                                    <input type="text" class="form-control" id="tarjeta_cvv" name="tarjeta_cvv" placeholder="XXX">
                                </div>
                                <br>
                            </div>
                        </div>
                        
                        <div id="transferencia-details" class="payment-details d-none">
                            <div class="alert alert-info">
                                <p class="mb-1">Realiza una transferencia a la siguiente cuenta bancaria:</p>
                                <p class="mb-1"><strong>Banco:</strong> Banco Ejemplo</p>
                                <p class="mb-1"><strong>IBAN:</strong> ES12 3456 7890 1234 5678 9012</p>
                                <p class="mb-1"><strong>Beneficiario:</strong> LoopLab</p>
                                <p class="mb-0"><strong>Concepto:</strong> Tu número de pedido (se generará al confirmar)</p>
                            </div>
                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terminos" name="terminos" required>
                            <label class="form-check-label" for="terminos">
                                Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#terminosModal">términos y condiciones</a> y la <a href="#" data-bs-toggle="modal" data-bs-target="#privacidadModal">política de privacidad</a>
                            </label>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-lg">Confirmar Pedido</button>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <div class="col-lg-4">
            <div class="cart-summary">
                <h5 class="cart-summary-title">Resumen del Pedido</h5>
                
                <div class="mb-3">
                    <h6 class="mb-3">Artículos</h6>
                    
                    <?php foreach ($cartData['items'] as $key => $item): ?>
                        <?php 
                            $model = $cartData['models'][$key] ?? null;
                            if (!$model) continue;
                            
                            $keyParts = \App\Core\Cart::parseKey($key);
                            $articulo_id = $keyParts['articulo_id'];
                            
                            // Get the instrumental details
                            $instrumental = \App\Models\Instrumental::find($articulo_id);
                        ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <?php if ($instrumental && $instrumental->imagen): ?>
                                    <img src="<?= BASE_URL . '/' . $instrumental->imagen ?>" alt="<?= $instrumental ? htmlspecialchars($instrumental->titulo) : 'Producto' ?>" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                <?php endif; ?>
                                <div>
                                    <p class="mb-0 small"><?= $instrumental ? htmlspecialchars($instrumental->titulo) : 'Producto' ?></p>
                                    <small class="text-muted">
                                        <?php 
                                            if ($instrumental && $instrumental->productor()) {
                                                echo htmlspecialchars($instrumental->productor()->nombre);
                                            }
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <span class="fw-bold"><?= number_format($item['precio'], 2) ?> €</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <hr>
                
                <div class="cart-summary-row">
                    <span class="cart-summary-label">Subtotal:</span>
                    <span class="cart-summary-value"><?= number_format($cartData['importeTotal'], 2) ?> €</span>
                </div>
                
                <div class="cart-summary-row">
                    <span class="cart-summary-label">Envío:</span>
                    <span class="cart-summary-value">Gratis</span>
                </div>
                
                <div class="cart-summary-row">
                    <span class="cart-summary-label">Total:</span>
                    <span class="cart-summary-total"><?= number_format($cartData['importeTotal'], 2) ?> €</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar detalles de pago según el método seleccionado
    const metodoPagoInputs = document.querySelectorAll('input[name="metodo_pago"]');
    const paymentDetails = document.querySelectorAll('.payment-details');
    
    metodoPagoInputs.forEach(input => {
        input.addEventListener('change', function() {
            paymentDetails.forEach(detail => {
                detail.classList.add('d-none');
            });
            
            document.getElementById(`${this.value}-details`).classList.remove('d-none');
        });
    });
    
    // Validación básica del formulario
    const checkoutForm = document.getElementById('checkout-form');
    
    checkoutForm.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Validar campos requeridos
        const requiredInputs = checkoutForm.querySelectorAll('[required]');
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        // Validar método de pago seleccionado
        const metodoPago = checkoutForm.querySelector('input[name="metodo_pago"]:checked');
        if (!metodoPago) {
            isValid = false;
            alert('Por favor, selecciona un método de pago.');
        }
        
        // Validar términos y condiciones
        const terminos = document.getElementById('terminos');
        if (!terminos.checked) {
            terminos.classList.add('is-invalid');
            isValid = false;
        } else {
            terminos.classList.remove('is-invalid');
        }
        
        if (!isValid) {
            event.preventDefault();
            alert('Por favor, completa todos los campos requeridos.');
        }
    });
});
</script>
