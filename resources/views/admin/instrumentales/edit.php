<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="admin-title">Editar Instrumental</h1>
            <p class="admin-subtitle">Modifica la información del instrumental.</p>
        </div>
    </div>

    <?php if (session()->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?php echo session()->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card admin-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información del Instrumental</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/admin/instrumentales/update.php?id=<?= $instrumental->id ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($instrumental->titulo) ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="bpm" class="form-label">BPM</label>
                                <input type="number" class="form-control" id="bpm" name="bpm" min="0" max="300" value="<?= $instrumental->bpm ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="precio" class="form-label">Precio (€) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" value="<?= $instrumental->precio ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_productor" class="form-label">Productor <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_productor" name="id_productor" required>
                                    <option value="">Seleccionar productor</option>
                                    <?php foreach ($productores as $productor): ?>
                                        <option value="<?= $productor->id ?>" <?= $instrumental->id_productor == $productor->id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($productor->nombre) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_genero" class="form-label">Género <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_genero" name="genero" required>
                                    <option value="">Seleccionar género</option>
                                    <?php foreach ($generos as $genero): ?>
                                        <option value="<?= $genero->id ?>" <?= $instrumental->id_genero == $genero->id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($genero->nombre) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="imagen" class="form-label">Imagen de Portada</label>
                                <?php if ($instrumental->imagen): ?>
                                    <div class="mb-2">
                                        <img src="<?= BASE_URL . '/' . $instrumental->imagen ?>" alt="<?= htmlspecialchars($instrumental->titulo) ?>" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                                <div class="form-text">Deja en blanco para mantener la imagen actual. Formatos recomendados: JPG, PNG. Tamaño máximo: 2MB.</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="audio" class="form-label">Archivo de Audio</label>
                                <?php if ($instrumental->audio): ?>
                                    <div class="mb-2">
                                        <audio controls class="w-100">
                                            <source src="<?= BASE_URL . '/' . $instrumental->audio ?>" type="audio/mpeg">
                                            Tu navegador no soporta la reproducción de audio.
                                        </audio>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="audio" name="audio" accept="audio/*">
                                <div class="form-text">Deja en blanco para mantener el audio actual. Formatos recomendados: MP3, WAV. Tamaño máximo: 10MB.</div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= BASE_URL ?>/admin/instrumentales.php" class="btn btn-outline-secondary">
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
                                Actualizar Instrumental
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>