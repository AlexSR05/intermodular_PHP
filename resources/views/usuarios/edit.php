<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <?php echo substr($usuario->nombre, 0, 1); ?>
        </div>
        <div class="profile-title">
            <h1>Editar Perfil</h1>
        </div>
    </div>

    <?php if (session()->hasFlash('error')): ?>
        <div class="alert alert-error">
            <?php echo session()->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="profile-section">
        <form action="<?php echo BASE_URL . '/usuarios/update.php'; ?>" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario->nombre); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($usuario->email); ?>" disabled>
                <small>El correo electrónico no se puede cambiar.</small>
            </div>

            <div class="form-group">
                <label for="password">Nueva contraseña <i>(dejar en blanco para mantener la actual)</i></label>
                <input type="password" id="password" name="password" class="form-control">
                <small style="color: red;">Mínimo 6 caracteres.</small>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="<?php echo BASE_URL . '/usuarios/profile.php'; ?>" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>
