<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="admin-title">Editar Usuario</h1>
            <p class="admin-subtitle">Modifica la información del usuario.</p>
        </div>
    </div>

    <?php if (session()->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?php echo session()->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo session()->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 mx-auto">
            <div class="card admin-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información del Usuario</h5>
                </div>
                <div class="card-body">
                    <!-- Debug info (solo visible si DEBUG está activado) -->
                    <?php if (defined('DEBUG') && DEBUG): ?>
                        <div class="alert alert-info">
                            <strong>Debug Info:</strong><br>
                            Usuario ID: <?= $usuario->id ?><br>
                            Nombre actual: <?= htmlspecialchars($usuario->nombre) ?><br>
                            Email actual: <?= htmlspecialchars($usuario->email) ?><br>
                            Role actual: <?= htmlspecialchars($usuario->role) ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= BASE_URL ?>/admin/usuarios/update.php" method="POST">
                        <input type="hidden" name="id" value="<?= $usuario->id ?>">
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario->nombre) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario->email) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Rol</label>
                            <select class="form-select" id="role" name="role">
                                <option value="user" <?= $usuario->role === 'user' ? 'selected' : '' ?>>Usuario</option>
                                <option value="admin" <?= $usuario->role === 'admin' ? 'selected' : '' ?>>Administrador</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-text">Deja en blanco para mantener la contraseña actual.</div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= BASE_URL ?>/admin/usuarios.php" class="btn btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                                </svg>
                                Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle me-1" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                </svg>
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Debug: Verificar que los campos tienen valores al enviar el formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const nombreInput = document.getElementById('nombre');
    const emailInput = document.getElementById('email');
    
    form.addEventListener('submit', function(e) {
        console.log('Enviando formulario...');
        console.log('Nombre:', nombreInput.value);
        console.log('Email:', emailInput.value);
        
        if (!nombreInput.value.trim()) {
            alert('El nombre no puede estar vacío');
            e.preventDefault();
            return false;
        }
        
        if (!emailInput.value.trim()) {
            alert('El email no puede estar vacío');
            e.preventDefault();
            return false;
        }
    });
});
</script>
