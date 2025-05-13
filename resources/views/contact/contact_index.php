<section id="registro" class="section">
      <h2>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="18"
          height="18"
          fill="currentColor"
          class="bi bi-person-circle"
          viewBox="0 0 16 16"
        >
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
          <path
            fill-rule="evenodd"
            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"
          />
        </svg>
        Contáctanos aquí.
      </h2>
    <form action="<?php echo BASE_URL . '/contacts/store.php'?>" method="post">
      <label for="correo">Tu correo electrónico <span style="color: red">*</span></label><br /><br />
      <input type="email" id="correo" name="email" required /><br /><br />

      <label for="nombre">Tu nombre <span style="color: red">*</span></label><br /><br />
      <input type="text" id="nombre" name="nombre" required /><br /><br />

      <label for="mensaje">Tu mensaje <span style="color: red">*</span></label><br /><br />
      <textarea id="mensaje" name="mensaje" required style="resize: none; width: 400px; height: 120px;"></textarea><br /><br />

      <button type="submit">Enviar Información de Contacto</button>
    </form>
</section>