<br><br><br>
<section class="section">
    <div class="flex-titulo-buscador">
        <div>
            <h2>Instrumentales Disponibles</h2>
            <p class="instrumental-desc">Explora nuestra colección de instrumentales organizadas por géneros y encuentra la ideal para tu nuevo Single, Álbum o EP.</p>
        </div>

        <div class="searcher">
            <form method="GET" action="<?= BASE_URL . '/instrumentales/instrumentales_index.php'; ?>">
            <input type="text" name="search" placeholder="Buscar instrumental por nombre, género..." id="input-searcher" required>
            <button type="submit" class="search-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
            </form>
        </div>
    </div>
    <br><br>
    
    <div id="notification-container" class="notification-container">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->get('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->get('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
    
    <div id="instrumentales">
    <?php if (count($instrumentales)): ?>
        <?php foreach($instrumentales as $instrumental) : ?>
          <div class="instrumental">
            <img src="<?= '../' . htmlspecialchars($instrumental->imagen); ?>" alt="Imagen de la instrumental no encontrada." class="instrumental-img">
            <ul class="details">
              <li><strong>Título:</strong> <br><i><?= $instrumental->titulo; ?></i></li>
              <li><strong>BPM:</strong> <br><i><?= $instrumental->bpm; ?></i></li>
              <?php $genero = $instrumental->genero;
              ?>
              <li><strong>Género:</strong> <br><i><?= $genero?->nombre ?? 'Sin género'; ?></i></li>
            </ul>
            <p class="creator-date">
              <?php $productor = $instrumental->productor(); ?>
              <strong>Made By:</strong> <i><?= $productor?->nombre ?? 'Sin productor'; ?></i><br>    
              <i><?= $instrumental->fecha_creacion; ?></i>
            </p>
            <audio controls class="custom-audio" oncontextmenu="return false;">
              <source src="<?= '../' . $instrumental->audio;?>" type="audio/mp3">
              No se ha podido cargar o tu navegador no soporta el elemento de audio.
            </audio>
            <div class="precio-carrito">
              <p><b>Precio:</b> <?= number_format($instrumental->precio, 2, '.', '');?> €</p>
            </div>
            <form action="<?= BASE_URL . '/carrito/add.php'; ?>" method="POST" class="add-to-cart-form">
                <input type="hidden" name="articulo_id" value="<?= $instrumental->id ?>">
                <input type="hidden" name="cantidad" value="1">
                <input type="hidden" name="return_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                <button type="submit" class="button-48" 
                    data-id="<?= $instrumental->id ?>" 
                    data-title="<?= htmlspecialchars($instrumental->titulo) ?>" 
                    data-price="<?= $instrumental->precio ?>" 
                    data-bpm="<?= $instrumental->bpm ?>" 
                    data-image="<?= htmlspecialchars($instrumental->imagen) ?>">
                    Añadir al carrito
                </button>
            </form>
          </div>
        <?php endforeach; ?>
        <?php else: ?>
            <h3 style='font-size: 14px;'> No se han encontrado instrumentales relativas a tu búsqueda.</h3>
        <?php endif; ?>
    </div>
    <br>
</section>
</body>
</html>
