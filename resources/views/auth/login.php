<section class="section">
    <h3>LoopLab</h3>
    <h2>Inicia Sesión</h2>
    
    <?php if (session()->hasFlash('error')): ?>
        <div class="alert alert-error">
            <?php echo session()->getFlash('error'); ?>
        </div>
    <?php endif; ?>
    
    <?php if (session()->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo session()->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    
    <form action="<?php print BASE_URL . '/auth/login/login.php'?>" method="POST">
      <br>
      <label for="correo">Correo Electrónico: <span style="color: red">*</span></label>
      <input type="email" id="correo" name="email" required>
      <br><br>
      <div class="forgot-your-password-div">
        <label for="contraseña">Contraseña: <span style="color: red">*</span></label>
        <a class="forgot-your-password" href="<?php print BASE_URL . '/contacts/index.php'?>">¿Has olvidado tu contraseña?</a>
      </div>
      <input type="password" id="contraseña" name="password" required>
      <br><br>
      <button type="submit">Iniciar Sesión</button>
      <p class="option-register">¿No tienes una cuenta? <a href="<?php print BASE_URL . '/auth/register/index.php'?>" id="login">Regístrate aquí</a></p>
      <br>
      <hr>
      <div class="social-login">
        <button onclick="window.location.href='google_auth.php'">
          <img src="<?php print BASE_URL . '/media/google_logo.png'?>" alt="Google"> Iniciar sesión con Google
        </button>
      </div>
    </form>
  </section>
