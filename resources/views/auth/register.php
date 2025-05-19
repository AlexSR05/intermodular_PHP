<div class="bg-light py-3 py-md-5">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
        <div class="bg-white p-4 p-md-5 rounded shadow-sm">
          <div class="row">
            <div class="col-12 text-center mb-5">
              <h3 class="fs-3 fw-bold mb-0" style="font-family: 'Rubik Spray Paint', serif; color: var(--brand-color);">LoopLab</h3>
              <h2 class="fs-4 fw-normal mt-2">Registro de Usuario</h2>
              
              <?php if (session()->hasFlash('error')): ?>
                <div class="alert alert-danger mt-3">
                  <?php echo session()->getFlash('error'); ?>
                </div>
              <?php endif; ?>
              
              <?php if (session()->hasFlash('success')): ?>
                <div class="alert alert-success mt-3">
                  <?php echo session()->getFlash('success'); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
          
          <form action="<?php echo BASE_URL . '/auth/register/store.php'?>" method="POST">
            <div class="row gy-3 gy-md-4 overflow-hidden">
              <div class="col-12">
                <label for="nombre" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Tu nombre completo" required>
              </div>
              <div class="col-12">
                <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="nombre@ejemplo.com" required>
              </div>
              <div class="col-12">
                <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password" id="password" required>
              </div>
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" name="terms" id="terms" required>
                  <label class="form-check-label text-secondary" for="terms">
                    Acepto los <a href="#" class="link-primary text-decoration-none">términos y condiciones</a>
                  </label>
                </div>
              </div>
              <div class="col-12">
                <div class="d-grid">
                  <button class="btn btn-lg btn-primary" type="submit">Registrarse</button>
                </div>
              </div>
            </div>
          </form>
          
          <div class="row">
            <div class="col-12">
              <hr class="mt-5 mb-4 border-secondary-subtle">
              <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center">
                <a href="<?php echo BASE_URL . '/auth/login/index.php'?>" class="link-secondary text-decoration-none">¿Ya tienes una cuenta? Inicia sesión aquí</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
