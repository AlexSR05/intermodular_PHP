<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <?php

use App\Core\Auth;

 if ($instrumental->imagen): ?>
                <img src="<?= BASE_URL . '/' . $instrumental->imagen ?>" alt="<?= htmlspecialchars($instrumental->titulo) ?>" class="img-fluid rounded">
            <?php else: ?>
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                    <p class="text-muted">Sin imagen disponible</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h1 class="mb-3"><?= htmlspecialchars($instrumental->titulo) ?></h1>
            
            <div class="mb-3">
                <span class="badge bg-primary">
                    <?php 
                        $productor = $instrumental->productor();
                        echo $productor ? htmlspecialchars($productor->nombre) : 'Sin productor';
                    ?>
                </span>
                
                <?php foreach ($instrumental->generos() as $genero): ?>
                    <span class="badge bg-secondary"><?= htmlspecialchars($genero->nombre) ?></span>
                <?php endforeach; ?>
            </div>
            
            <p class="lead mb-4"><?= htmlspecialchars($instrumental->descripcion ?? 'Sin descripción') ?></p>
            
            <div class="d-flex align-items-center mb-4">
                <h3 class="fw-bold me-3"><?= number_format($instrumental->precio, 2) ?> €</h3>
                <?php if ($instrumental->stock > 0): ?>
                    <span class="badge bg-success">En stock (<?= $instrumental->stock ?>)</span>
                <?php else: ?>
                    <span class="badge bg-danger">Agotado</span>
                <?php endif; ?>
            </div>
            
            <?php if ($instrumental->stock > 0): ?>
                <form action="<?= BASE_URL ?>/carrito/add.php" method="POST" class="mb-4">
                    <input type="hidden" name="articulo_id" value="<?= $instrumental->id ?>">
                    
                    <div class="d-flex align-items-center mb-3">
                        <label for="cantidad" class="me-3">Cantidad:</label>
                        <div class="input-group" style="width: 150px;">
                            <button type="button" class="btn btn-outline-secondary quantity-decrease">-</button>
                            <input type="number" id="cantidad" name="cantidad" class="form-control text-center" value="1" min="1" max="<?= $instrumental->stock ?>">
                            <button type="button" class="btn btn-outline-secondary quantity-increase">+</button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-plus"></i> Añadir al carrito
                    </button>
                </form>
            <?php endif; ?>
            
            <?php if (Auth::check() && Auth::user()['id'] === $instrumental->usuario_id): ?>
                <div class="mt-4">
                    <a href="<?= BASE_URL ?>/instrumentales/edit.php?id=<?= $instrumental->id ?>" class="btn btn-outline-primary me-2">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <form action="<?= BASE_URL ?>/instrumentales/delete.php" method="POST" class="d-inline">
                        <input type="hidden" name="id" value="<?= $instrumental->id ?>">
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este instrumental?')">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Detalles del instrumental</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Especificaciones</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>BPM:</span>
                                    <span class="fw-bold"><?= $instrumental->bpm ?? 'No especificado' ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tonalidad:</span>
                                    <span class="fw-bold"><?= $instrumental->tonalidad ?? 'No especificado' ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Duración:</span>
                                    <span class="fw-bold"><?= $instrumental->duracion ?? 'No especificado' ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Fecha de creación:</span>
                                    <span class="fw-bold"><?= $instrumental->fecha_creacion ? date('d/m/Y', strtotime($instrumental->fecha_creacion)) : 'No especificado' ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Géneros Musicales</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($instrumental->generos())): ?>
                                <p class="text-muted">No hay géneros asociados a este instrumental.</p>
                            <?php else: ?>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($instrumental->generos() as $genero): ?>
                                        <span class="badge bg-secondary p-2"><?= htmlspecialchars($genero->nombre) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <h3 class="mb-4" id="valoraciones">Valoraciones</h3>
            
            <?php 
            $valoraciones = \App\Models\Valoracion::where('instrumental_id', $instrumental->id)->get();
            ?>
            
            <?php if (empty($valoraciones)): ?>
                <div class="alert alert-info">
                    <p class="mb-0">Este instrumental aún no tiene valoraciones. ¡Sé el primero en valorarlo!</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($valoraciones as $valoracion): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="card-title mb-0">
                                            <?php 
                                                $usuario = $valoracion->usuario();
                                                echo $usuario ? htmlspecialchars($usuario->nombre) : 'Usuario anónimo';
                                            ?>
                                        </h5>
                                        <div class="rating">
                                            <?php for ($i = 0; $i < $valoracion->num_valoracion; $i++): ?>
                                                <span class="star">⭐</span>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <p class="card-text"><?= htmlspecialchars($valoracion->comentario) ?></p>
                                    <div class="text-muted small">
                                        <?= $valoracion->fecha_valoracion ? date('d/m/Y', strtotime($valoracion->fecha_valoracion)) : 'Fecha desconocida' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php if (Auth::check()): ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Deja tu valoración</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= BASE_URL ?>/valoraciones/store.php" method="POST">
                            <input type="hidden" name="instrumental_id" value="<?= $instrumental->id ?>">
                            
                            <div class="mb-3">
                                <label for="rating" class="form-label">Puntuación</label>
                                <div class="rating-input">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="num_valoracion" id="rating1" value="1" required>
                                        <label class="form-check-label" for="rating1">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="num_valoracion" id="rating2" value="2">
                                        <label class="form-check-label" for="rating2">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="num_valoracion" id="rating3" value="3">
                                        <label class="form-check-label" for="rating3">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="num_valoracion" id="rating4" value="4">
                                        <label class="form-check-label" for="rating4">4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="num_valoracion" id="rating5" value="5">
                                        <label class="form-check-label" for="rating5">5</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="comentario" class="form-label">Tu comentario</label>
                                <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Enviar valoración</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning mt-4">
                    <p class="mb-0">Debes <a href="<?= BASE_URL ?>/auth/login/index.php" class="alert-link">iniciar sesión</a> para dejar una valoración.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity increase/decrease buttons
    const decreaseButton = document.querySelector('.quantity-decrease');
    const increaseButton = document.querySelector('.quantity-increase');
    const quantityInput = document.querySelector('#cantidad');
    
    if (decreaseButton && increaseButton && quantityInput) {
        decreaseButton.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        increaseButton.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.getAttribute('max'));
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        });
    }
});
</script>

<style>
.rating .star {
    color: #ffc107;
}
</style>
