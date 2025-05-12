<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>intermodular</title>
    <?php if(request()->routeIs('/instrumentales/index.php'))  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/index_style.css'; ?>">
    <?php elseif(request()->routeIs('/instrumentales/instrumentales_index.php'))  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/instrumentales_index.css'; ?>">
    <?php elseif(request()->routeIs('/contact.php'))  : ?>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/css/contact.css'; ?>">
    <?php endif; ?>
    
    <link rel="icon" href="<?php echo BASE_URL . '/media/LogoPagina.png'?>" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Rubik+Spray+Paint&display=swap"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Chewy&family=Rubik+Spray+Paint&display=swap"
      rel="stylesheet"
    />
    
</head>
<body>
    <?php
      if(request()->routeIs('/instrumentales/index.php'))
      {
        include(__DIR__ . '/partials/headers/index_header.php');
      } 
      elseif(request()->routeIs('/instrumentales/instrumentales_index.php'))
      {
        include(__DIR__ . '/partials/headers/instrumentales_header.php');
      }
      elseif(request()->routeIs('/contact.php'))
      {
        include(__DIR__ . '/partials/headers/contact_header.php');
      }?>

    <main class="flex-grow-1 mt-2 mb-2">
        <!-- Variable: $content -->
        <?= $content ?>
    </main>
    
    <?php include(__DIR__ . '/partials/footer.php')?>

</body>
</html>