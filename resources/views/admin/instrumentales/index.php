<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="admin-title">Gestión de Instrumentales</h1>
            <p class="admin-subtitle">Administra las instrumentales disponibles en la plataforma.</p>
        </div>
    </div>

    <?php if (session()->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo session()->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?php echo session()->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Instrumentales</h5>
                    <a href="<?= BASE_URL ?>/admin/instrumentales/create.php" class="btn btn-sm btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Nueva Instrumental
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Título</th>
                                    <th>BPM</th>
                                    <th>Productor</th>
                                    <th>Género</th>
                                    <th>Precio</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($instrumentales)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No hay instrumentales disponibles</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($instrumentales as $instrumental): ?>
                                        <tr>
                                            <td>
                                                <img src="<?= BASE_URL . '/' . $instrumental->imagen ?>" alt="<?= htmlspecialchars($instrumental->titulo) ?>" class="admin-thumbnail">
                                            </td>
                                            <td><?= htmlspecialchars($instrumental->titulo) ?></td>
                                            <td><?= $instrumental->bpm ?></td>
                                            <td>
                                                <?php 
                                                    $productor = $instrumental->productor();
                                                    echo $productor ? htmlspecialchars($productor->nombre) : 'Sin productor';
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    $genero = $instrumental->genero();
                                                    echo $genero ? htmlspecialchars($genero->nombre) : 'Sin género';
                                                ?>
                                            </td>
                                            <td><?= number_format($instrumental->precio, 2) ?> €</td>
                                            <td><?= $instrumental->fecha_creacion ? date('d/m/Y', strtotime($instrumental->fecha_creacion)) : 'N/A' ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= BASE_URL ?>/admin/instrumentales/edit.php?id=<?= $instrumental->id ?>" class="btn btn-sm btn-outline-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                                        </svg>
                                                    </a>
                                                    <a href="<?= BASE_URL ?>/admin/instrumentales/delete.php?id=<?= $instrumental->id ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta instrumental?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>