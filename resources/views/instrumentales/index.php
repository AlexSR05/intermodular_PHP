    <div class="hero">
      <p class="hero-p">
        <span style="color: #ff826b">Explora</span>,
        <span style="color: #63aae4">obten</span> y
        <span style="color: #7afa7a">comparte</span> las mejores instrumentales
        del momento.
      </p>
    </div>
    <div class="instrumentales">
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
            <a href="<?php echo BASE_URL . '/instrumentales/instrumentales_index.php'?>" class="btn-link">Ver más</a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <div class="container-div">
      <div class="container">
        <section id="inicio" class="section">
          <h2>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bullseye" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
              <path d="M8 13A5 5 0 1 1 8 3a5 5 0 0 1 0 10m0 1A6 6 0 1 0 8 2a6 6 0 0 0 0 12"/>
              <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8"/>
              <path d="M9.5 8a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
            </svg>
            Inicio
          </h2>
          <div class="inicio-about-us">
            <div>
              <h3>Bienvenido a <b style="text-decoration: underline; font-family: 'Chewy', serif">LoopLab</b>.</h3>
              <p>En nuestra página, podrás encontrar una gran diversidad de instrumentales de diferentes géneros musicales a precios asequibles.</p>
            </div>
            <div>
              <h3><b style="text-decoration: underline; font-family: 'Chewy', serif">¿Quienes somos?</b></h3>
              <p>Somos un conjunto de productores musicales situados en el área de la Marina Baixa que quieren impulsar la carrera de productores, músicos y artistas locales.</p>
            </div>
          </div>
        </section>
        <section class="section">
          <p id="text-artistas"><b><i>Estos son algunos de los artistas del momento que han utilizado nuestra página:</i></b></p>
          <div>
            <video autoplay loop muted id="video" preload="auto" height="500" width="100%" style="position: relative;">
              <source src="<?php echo BASE_URL . '/media/video_intermodular.mp4'?>">
            </video>
          </div>
        </section>
      </div>
      <section id="valoraciones" class="section">
        <h2>
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
          </svg>
          Valoraciones
        </h2>
        <form action="valoraciones.php" method="post">
          <p><b>¡Nos encantaría saber tu opinión acerca de nuestra página!</b></p>
          <label for="comentario">Escribe tu valoración:</label><br><br>
          <textarea id="comentario" name="comentario" rows="4" required></textarea><br><br><br>
          <label for="puntuacion">Puntuación:</label><br><br>
          <select id="puntuacion" name="puntuacion" required>
            <option value="1">⭐</option>
            <option value="2">⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
          </select><br><br><br>
          <button type="submit">Enviar Valoración</button>
        </form>
      </section>
      <section id="colaboraciones" class="section">
        <h2>
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
          </svg>
          Colaboraciones
        </h2>
        <p>¡Conecta con otros productores y colabora en la creación de nuevas instrumentales!</p>
        <p><b><i>Próximamente...</i></b></p>
      </section>
    </div>
