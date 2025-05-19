<header>
    <h1>LoopLab</h1>
    <br><br>
    <nav class="main-nav">
        <a href="<?php echo BASE_URL . '/instrumentales/index.php' ?>">Volver al inicio</a>
        <a href="<?php echo BASE_URL . '/contacts/index.php' ?>">Contacto</a>
        <?php if (App\Core\Auth::check()): ?>
            <div class="user-dropdown">
                <a href="<?php echo BASE_URL . '/auth/logout.php' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5.5 0 0 0-1 0z" />
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                    </svg>
                    Cerrar sesión
                </a>
            </div>
            </div>
        <?php else: ?>
            <a href="<?php echo BASE_URL . '/auth/login/index.php' ?>" class="login-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                </svg>
                Iniciar sesión
            </a>
        <?php endif; ?>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownToggle = document.getElementById('userDropdownToggle');
        const dropdownContent = document.getElementById('userDropdownContent');

        if (dropdownToggle && dropdownContent) {
            // Mostrar/ocultar menú al hacer clic
            dropdownToggle.addner('click', function(e) {
                e.preventDefault();
                dropdownContent.classList.toggle('show');
            });

            // Cerrar el menú si se hace clic fuera de él
            document.addEventListener('click', function(e) {
                if (!dropdownToggle.contains(e.target) && !dropdownContent.contains(e.target)) {
                    dropdownContent.classList.remove('show');
                }
            });
        }
    });
</script>