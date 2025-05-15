<div class="profile-container">
    <?php if (session()->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo session()->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->hasFlash('error')): ?>
        <div class="alert alert-error">
            <?php echo session()->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="profile-header">
        <div class="profile-avatar">
            <?php echo substr($usuario->nombre, 0, 1); ?>
        </div>
        <div class="profile-title">
            <h1><?php echo htmlspecialchars($usuario->nombre); ?></h1>
            <div class="user-role <?php echo $usuario->role === 'admin' ? 'role-admin' : 'role-user'; ?>">
                <?php echo ucfirst($usuario->role); ?>
            </div>
        </div>
    </div>

    <div class="profile-section">
        <h2>Información Personal</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Correo electrónico:</span>
                <span class="info-value"><?php echo htmlspecialchars($usuario->email); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Creaste tu cuenta el:</span>
                <span class="info-value"><?php echo date('d/m/Y', strtotime($usuario->fecha_creacion)); ?></span>
            </div>
        </div>
        <div class="action-buttons">
            <a href="<?php echo BASE_URL . '/usuarios/edit.php'; ?>" class="btn btn-primary">Editar Perfil</a>
            <a href="<?php echo BASE_URL . '/auth/logout.php'; ?>" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>

    <div class="profile-section">
        <h2>Mis Valoraciones</h2>
        
        <?php if (empty($valoraciones)): ?>
            <p>Aún no has realizado ninguna valoración.</p>
        <?php else: ?>
            <div class="valoraciones-container">
                <?php foreach ($valoraciones as $valoracion): ?>
                    <div class="valoracion-card">
                        <div class="valoracion-fecha"><?php echo date('d/m/Y', strtotime($valoracion->fecha_valoracion)); ?></div>
                        <div class="valoracion-estrellas">
                            <?php for ($i = 0; $i < $valoracion->num_valoracion; $i++): ?>
                                ⭐
                            <?php endfor; ?>
                        </div>
                        <p class="valoracion-comentario"><?php echo htmlspecialchars($valoracion->comentario); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
