<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'LoopLab' ?></title>
    
    <!-- CSS Específicos por página -->
    <?php if(request()->routeIs('/instrumentales/index.php'))  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/index_style.css'; ?>">
    <?php elseif(request()->routeIs('/instrumentales/instrumentales_index.php'))  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/instrumentales_index.css'; ?>">
    <?php elseif(request()->routeIs('/contacts/index.php'))  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/contact.css'; ?>">
    <?php elseif(request()->routeIs('/auth/login/index.php') || request()->routeIs('/auth/register/index.php'))  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/auth.css'; ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <?php elseif(strpos(request()->url(), '/admin/') !== false)  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/admin.css'; ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
    
    <!-- CSS adicionales pasados como variables -->
    <?php if (isset($styles) && is_array($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" href="<?php echo BASE_URL . $style; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- CSS específico para el perfil -->
    <?php if(request()->routeIs('/usuarios/profile.php') || request()->routeIs('/usuarios/edit.php'))  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/profile.css'; ?>">
    <?php endif; ?>
    
    <link rel="icon" href="<?php echo BASE_URL . '/media/LogoPagina.png'?>" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Spray+Paint&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Chewy&family=Rubik+Spray+Paint&display=swap" rel="stylesheet" />
</head>
<body>
    <?php
      //Headers
      if(strpos(request()->url(), '/admin/') !== false) {
        include(__DIR__ . '/partials/headers/admin_header.php');
      }
      elseif(request()->routeIs('/instrumentales/index.php')) {
        include(__DIR__ . '/partials/headers/index_header.php');
      }
      elseif(request()->routeIs('/instrumentales/instrumentales_index.php')) {
        include(__DIR__ . '/partials/headers/instrumentales_header.php');
      }
      elseif(request()->routeIs('/contacts/index.php')) {
        include(__DIR__ . '/partials/headers/contact_header.php');
      }
      elseif(request()->routeIs('/usuarios/profile.php') || request()->routeIs('/usuarios/edit.php')) {
        include(__DIR__ . '/partials/headers/profile_header.php');
      }
      elseif(request()->routeIs('/auth/login/index.php') || request()->routeIs('/auth/register/index.php')) {
        // No incluir header para páginas de login/registro
      }
    ?>

    <main class="flex-grow-1 mt-2 mb-2">
        <!-- Variable: $content -->
        <?= $content ?>
    </main>
    
    <?php 
      if (
        request()->routeIs('/auth/login/index.php') ||
        request()->routeIs('/auth/register/index.php') ||
        strpos(request()->url(), '/admin/') !== false
      ) {
        // No incluir footer para páginas de login/registro y admin
      } else {
        include(__DIR__ . '/partials/footers/footer.php');
      }
    ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
