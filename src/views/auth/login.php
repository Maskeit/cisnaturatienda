<?php

namespace views;

include "../../components/layout/login.php";
head();
css('register');
?>
<main class="pageCar">
  <section class="banner">
    <img class="banner_login" src="/cisnaturatienda/public/img/fondo_log.png" alt="banner">
  </section>
  <section class="card-container">
    <img class="form-image" src="/cisnaturatienda/public/icons/iconoSession.png" alt="login icon">
    <div class="card mt-3 shadow">
      <div class="card-body">
        <h1>Inicia Sesión</h1>
        <form action="" id="login-form">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" class="form-control" name="email" placeholder="Correo Electronico" required>
          </div>
          <div class="form-group">
            <label for="passwd">Contraseña</label>
            <input type="password" class="form-control" id="passwd" name="passwd" required>
          </div>
          <div class="d-grid gap-2 my-2">
            <small class="form-text text-danger d-none" id="error">
              Sus datos de inicio de sesión son incorrecctos
              <a href="#">Olvidé mi Contraseña</a>
            </small>
            <button class="btn-form" type="button" id="login-button">
              Iniciar sesión <i class="bi bi-box-arrow-in-right"></i>
            </button>
            <a href="./register.php" class="btn btn-link floant-end">
              ¿No tienes una cuenta? Registrate aquí
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
scripts();
?>
<script src="./authjs/log.js" type="module"></script>