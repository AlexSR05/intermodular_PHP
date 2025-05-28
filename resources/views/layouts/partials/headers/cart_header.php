<header>
  <a href="<?php echo BASE_URL . '/instrumentales/index.php' ?>"><h1>LoopLab</h1></a>
  <br><br>
  <nav class="main-nav">
    <a href="<?php echo BASE_URL . '/instrumentales/instrumentales_index.php' ?>">Explorar Más Instrumentales</a>
    <a href="<?php echo BASE_URL . '/contacts/index.php' ?>">Contacto</a>
    <?php if (App\Core\Auth::check()): ?>
      <div class="user-dropdown">
        <a href="#" class="user-dropdown-toggle" id="userDropdownToggle">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
          </svg>
          <?php echo App\Core\Auth::user()['nombre']; ?>
        </a>
      </div>
    <?php else: ?>
      <a href="<?php echo BASE_URL . '/auth/login/index.php' ?>" class="login-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
        </svg>
        Iniciar sesión
      </a>
    <?php endif; ?>
  </nav>
</header>
