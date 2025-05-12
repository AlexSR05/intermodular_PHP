<div class="container mt-4">
    <h1>Mis votos</h1>

    <?php if (empty($votos)): ?>
        <p>Aún no has votado ninguna película.</p>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($votos as $voto): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?= BASE_URL . '/peliculas/show.php?id=' . $voto->pelicula_id ?>">
                                    <?= htmlspecialchars($voto->pelicula->titulo) ?>
                                </a>
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Puntuación: <?= (int) $voto->puntuacion ?> / 10
                            </h6>
                            <p class="card-text"><?= nl2br(htmlspecialchars($voto->critica)) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="<?= HOME ?>" class="btn btn-secondary mt-4">Volver a inicio</a>
</div>
