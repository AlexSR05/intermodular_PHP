<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">¡Pedido Confirmado!</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>
                        <h4>Gracias por tu compra</h4>
                        <p class="lead">Tu pedido ha sido procesado correctamente.</p>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Detalles del Pedido</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="mb-0"><strong>Número de Pedido:</strong></p>
                                    <p><?= $venta->id ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-0"><strong>Fecha:</strong></p>
                                    <p><?= date('d/m/Y H:i', strtotime($venta->fecha_venta)) ?></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="mb-0"><strong>Estado:</strong></p>
                                    <p>
                                        <span class="badge bg-<?= $venta->estado === 'completado' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($venta->estado) ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-0"><strong>Método de Pago:</strong></p>
                                    <p><?= ucfirst($venta->metodo_pago) ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"><strong>Dirección de Envío:</strong></p>
                                    <p><?= htmlspecialchars($venta->direccion_envio) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Artículos</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ventaArticulos as $articulo): ?>
                                            <?php 
                                                $instrumental = \App\Models\Instrumental::find($articulo->instrumental_id);
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if ($instrumental && $instrumental->imagen): ?>
                                                            <img src="<?= BASE_URL . '/' . $instrumental->imagen ?>" alt="<?= $instrumental ? htmlspecialchars($instrumental->titulo) : 'Producto' ?>" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                        <?php endif; ?>
                                                        <div>
                                                            <p class="mb-0"><?= $instrumental ? htmlspecialchars($instrumental->titulo) : 'Producto' ?></p>
                                                            <small class="text-muted">
                                                                <?php 
                                                                    if ($instrumental && $instrumental->productor()) {
                                                                        echo htmlspecialchars($instrumental->productor()->nombre);
                                                                    }
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center"><?= $articulo->cantidad ?></td>
                                                <td class="text-end"><?= number_format($articulo->precio_unitario, 2) ?> €</td>
                                                <td class="text-end"><?= number_format($articulo->cantidad * $articulo->precio_unitario, 2) ?> €</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                            <td class="text-end"><?= number_format($venta->total / 1.21, 2) ?> €</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>IVA (21%):</strong></td>
                                            <td class="text-end"><?= number_format($venta->total - ($venta->total / 1.21), 2) ?> €</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td class="text-end"><strong><?= number_format($venta->total, 2) ?> €</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mb-4">
                        <p>Recibirás un correo electrónico con los detalles de tu pedido.</p>
                        <p>Si tienes alguna pregunta, no dudes en <a href="<?= BASE_URL ?>/contacts/index.php">contactarnos</a>.</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?= BASE_URL ?>/" class="btn btn-outline-primary">
                            <i class="bi bi-house"></i> Volver al inicio
                        </a>
                        <a href="<?= BASE_URL ?>/usuarios/profile.php" class="btn btn-primary">
                            <i class="bi bi-person"></i> Mi cuenta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-header {
    font-weight: 500;
}
</style>
