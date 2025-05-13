<section class="section">
  <h3>LoopLab</h3>
  <h2>Registro de Usuario</h2>
  <form action="<?php echo BASE_URL . '/auth/register/store.php'?>" method="POST">
    <br>
    <label for="nombre">Nombre Completo: <span style="color: red">*</span></label>
    <input type="text" id="nombre" name="nombre" required>
    <br><br>
    
    <label for="correo">Correo Electrónico: <span style="color: red">*</span></label>
    <input type="email" id="correo" name="email" required>
    <br><br>
    
    <label for="contraseña">Contraseña: <span style="color: red">*</span></label>
    <input type="password" id="contraseña" name="password" required>
    <br><br>
    
    <button type="submit">Registrarse</button>
    <p class="option-register">¿Ya estás registrado? <a href="<?php print BASE_URL . '/auth/login/index.php'?>" id="login">Inicia Sesión aquí</a></p>
  </form>
</section>
