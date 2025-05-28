<div class="admin-dashboard">
    <div class="container-fluid py-5">
        <!-- Encabezado y estadísticas -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="admin-title">Panel de Control - Admin</h1>
                <p class="admin-subtitle">Bienvenido, <?= htmlspecialchars(App\Core\Auth::user()['nombre']) ?>.</p>
            </div>
        </div>
        
        <!-- Tarjetas de estadísticas -->
        <div class="row g-4 mb-5">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card admin-stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">Instrumentales</h5>
                            <div class="admin-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-music-note-beamed" viewBox="0 0 16 16">
                                    <path d="M6 13c0 1.105-1.12 2-2.5 2S1 14.105 1 13c0-1.104 1.12-2 2.5-2s2.5.896 2.5 2m9-2c0 1.105-1.12 2-2.5 2s-2.5-.895-2.5-2 1.12-2 2.5-2 2.5.895 2.5 2"/>
                                    <path fill-rule="evenodd" d="M14 11V2h1v9zM6 3v10H5V3z"/>
                                    <path d="M5 2.905a1 1 0 0 1 .9-.995l8-.8a1 1 0 0 1 1.1.995V3L5 4z"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="admin-stat-value"><?= $totalInstrumentales ?></h2>
                        <p class="admin-stat-label">Total de instrumentales</p>
                        <a href="<?= BASE_URL ?>/admin/instrumentales.php" class="btn btn-sm btn-primary mt-3">Gestionar</a>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card admin-stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">Usuarios</h5>
                            <div class="admin-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="admin-stat-value"><?= $totalUsuarios ?></h2>
                        <p class="admin-stat-label">Usuarios registrados</p>
                        <a href="<?= BASE_URL ?>/usuarios/index.php" class="btn btn-sm btn-primary mt-3">Gestionar</a>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card admin-stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">Valoraciones</h5>
                            <div class="admin-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="admin-stat-value"><?= $totalValoraciones ?></h2>
                        <p class="admin-stat-label">Valoraciones recibidas</p>
                        <a href="<?= BASE_URL ?>/instrumentales/index.php#valoraciones" class="btn btn-sm btn-primary mt-3">Gestionar</a>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card admin-stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title mb-0">Productores</h5>
                            <div class="admin-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                                    <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                                    <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <h2 class="admin-stat-value"><?= $totalProductores ?></h2>
                        <p class="admin-stat-label">Productores registrados</p>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Acciones rápidas -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card admin-card">
                    <div class="card-body">
                        <h5 class="card-title">Acciones rápidas</h5>
                        <div class="row g-3 mt-3">
                            <div class="col-12 col-md-6 col-lg-6">
                                <a href="<?= BASE_URL ?>/admin/instrumentales/create.php" class="btn btn-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                    Nuevo Instrumental
                                </a>
                            </div>
                            <br><br>
                            <div class="col-12 col-md-6 col-lg-6">
                                <a href="<?= BASE_URL ?>/auth/register/index.php" class="btn btn-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus me-2" viewBox="0 0 16 16">
                                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                                    </svg>
                                    Nuevo Usuario
                                </a>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Secciones principales -->
        <div class="row">
            <!-- Instrumentales recientes -->
            <div class="col-12 col-xl-6 mb-4">
                <div class="card admin-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Instrumentales recientes</h5>
                        <a href="<?= BASE_URL ?>/admin/instrumentales.php" class="btn btn-sm btn-outline-primary">Ver todos</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Título</th>
                                        <th>Productor</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($instrumentalesRecientes)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-3">No hay instrumentales disponibles</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($instrumentalesRecientes as $instrumental): ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= BASE_URL . '/' . $instrumental->imagen ?>" alt="<?= htmlspecialchars($instrumental->titulo) ?>" class="admin-thumbnail">
                                                </td>
                                                <td><?= htmlspecialchars($instrumental->titulo) ?></td>
                                                <td>
                                                    <?php 
                                                        $productor = $instrumental->productor();
                                                        echo $productor ? htmlspecialchars($productor->nombre) : 'Sin productor';
                                                    ?>
                                                </td>
                                                <td><?= number_format($instrumental->precio, 2) ?> €</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Usuarios recientes -->
            <div class="col-12 col-xl-6 mb-4">
                <div class="card admin-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Usuarios recientes</h5>
                        <a href="<?= BASE_URL ?>/usuarios/index.php" class="btn btn-sm btn-outline-primary">Ver todos</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th>Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($usuariosRecientes)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4">No hay usuarios disponibles</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($usuariosRecientes as $usuario): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($usuario->nombre) ?></td>
                                                <td><?= htmlspecialchars($usuario->email) ?></td>
                                                <td>
                                                    <span class="badge <?= $usuario->role === 'admin' ? 'bg-danger' : 'bg-primary' ?>">
                                                        <?= $usuario->role === 'admin' ? 'Administrador' : 'Usuario' ?>
                                                    </span>
                                                </td>
                                                <td><?= $usuario->fecha_creacion ? date('d/m/Y', strtotime($usuario->fecha_creacion)) : 'N/A' ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="<?= BASE_URL ?>/admin/usuarios/edit.php?id=<?= $usuario->id ?>" class="btn btn-sm btn-outline-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
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
            
            <!-- Valoraciones recientes -->
            <div class="col-12 col-xl-6 mb-4">
                <div class="card admin-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Valoraciones recientes</h5>
                        <a href="<?= BASE_URL ?>/instrumentales/index.php#valoraciones" class="btn btn-sm btn-outline-primary">Ver todas</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Comentario</th>
                                        <th>Puntuación</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($valoracionesRecientes)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-3">No hay valoraciones disponibles</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($valoracionesRecientes as $valoracion): ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                        $usuario = $valoracion->usuario();
                                                        echo $usuario ? htmlspecialchars($usuario->nombre) : 'Usuario anónimo';
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="comment-preview">
                                                        <?= htmlspecialchars(substr($valoracion->comentario, 0, 50)) ?>
                                                        <?= strlen($valoracion->comentario) > 50 ? '...' : '' ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="rating">
                                                        <?php for ($i = 0; $i < $valoracion->num_valoracion; $i++): ?>
                                                            <span class="star">⭐</span>
                                                        <?php endfor; ?>
                                                    </div>
                                                </td>
                                                <td><?= $valoracion->fecha_valoracion ? date('d/m/Y', strtotime($valoracion->fecha_valoracion)) : 'N/A' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Productores -->
            <div class="col-12 col-xl-6 mb-4">
                <div class="card admin-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Productores</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Instrumentales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($productores)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-3">No hay productores disponibles</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($productores as $productor): ?>
                                            <tr>
                                                <td><?= $productor->id ?></td>
                                                <td><?= htmlspecialchars($productor->nombre) ?></td>
                                                <td>
                                                    <?php 
                                                        echo isset($productorInstrumentales[$productor->id]) ? $productorInstrumentales[$productor->id] : 0;
                                                    ?>
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
        
        <!-- Gráficos y estadísticas -->
        <div class="row">
            <div class="col-12 col-xl-8 mb-4">
                <div class="card admin-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Estadísticas de instrumentales por género</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="genresChart" style="color: black;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-xl-4 mb-4">
                <div class="card admin-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Distribución de valoraciones</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="ratingsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>

<!-- Scripts para los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const genresData = {
        labels: <?= json_encode(array_column($generosStats, 'nombre')) ?>,
        datasets: [{
            label: 'Instrumentales por género',
            data: <?= json_encode(array_column($generosStats, 'count')) ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(199, 199, 199, 0.7)',
                'rgba(83, 102, 255, 0.7)',
                'rgba(40, 159, 64, 0.7)',
                'rgba(210, 199, 199, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(199, 199, 199, 1)',
                'rgba(83, 102, 255, 1)',
                'rgba(40, 159, 64, 1)',
                'rgba(210, 199, 199, 1)'
            ],
            borderWidth: 1
        }]
    };

    const ratingsData = {
        labels: ['5 estrellas', '4 estrellas', '3 estrellas', '2 estrellas', '1 estrella'],
        datasets: [{
            label: 'Número de valoraciones',
            data: <?= json_encode($valoracionesStats) ?>,
            backgroundColor: [
                'rgba(75, 192, 192, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configuración para el gráfico de géneros
    const genresConfig = {
        type: 'bar',
        data: genresData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'black'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: 'black'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'black'
                    }
                }
            }
        }
    };

    // Configuración para el gráfico de valoraciones
    const ratingsConfig = {
        type: 'doughnut',
        data: ratingsData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: 'black'
                    }
                }
            }
        }
    };

    // Crear los gráficos
    const genresChart = new Chart(
        document.getElementById('genresChart'),
        genresConfig
    );

    const ratingsChart = new Chart(
        document.getElementById('ratingsChart'),
        ratingsConfig
    );
});
</script>
