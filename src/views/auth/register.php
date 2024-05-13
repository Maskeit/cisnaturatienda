<?php

namespace views;

include "../../components/layout/login.php";
head();
css('register');
?>
<main class="pageCar">
    <section class="banner">
        <img class="banner_login" src="/cisnaturatienda/public/img/fondo_log.webp" alt="banner">
    </section>
    <section class="card-container">
        <img class="form-image" src="/cisnaturatienda/public/icons/iconoSession.png" alt="register icon">
        <div class="card mt-3 shadow">
            <div class="card-body">
                <h1>Registro</h1>
                <form action="" id="register-form">
                    <div class="form-group mb-3 ">
                        <label for="name">¿Cómo te llamas?</label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Nombre" maxlength="40" required>
                        <small class="form-text text-danger d-none" id="name-invalid">No caracteres especiales.</small>
                    </div>
                    <div class="form-group mb-3 ">
                        <label for="email">Correo electronico</label>
                        <input type="email" id="email" class="form-control" name="email" placeholder="ejemplo@gmail.com" maxlength="60" required>
                        <small class="form-text text-danger d-none" id="email-exists">Este correo ya esta asociado a una cuenta o hubo un error.</small>
                        <small class="form-text text-danger d-none" id="email-invalid">Correo no válido.</small>
                    </div>
                    <div class="form-group mb-3 ">
                        <label for="passwd">Contraseña <small class="text-muted">Mínimo 8 caracteres</small> </label>
                        <input type="password" class="form-control" id="passwd" name="passwd" maxlength="60" required>
                    </div>
                    <div class="form-group mb-3 ">
                        <label for="passwd2">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="passwd2" name="passwd2" maxlength="60" required>
                        <span class="form-text text-danger d-none" id="pwd-invalid">Contrasena no valida</span>
                        <span class="form-text text-danger d-none" id="pwd-invalid2">Las contraseñas tienen que ser iguales.</span>
                        <span class="form-text text-danger d-none" id="pwd-invalid3">
                            La contaseña debe contener al menos una letra mayúscula, un numero y un caracter especial
                        </span>
                    </div>
                    <div class="d-grid gap-2 my-2">
                        <span id="account-exists" class="d-none text-danger">
                            Este correo ya está siendo utilizado o hubo un error.
                        </span>
                        <button class="btn-form" type="button" id="register-button">
                            Registrar <i class="bi bi-box-arrow-in-right"></i>
                        </button>
                        <a href="./login.php" class="btn btn-link floant-end">
                            ¿Ya tienes una cuenta? Inicia aquí
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
<script src="./authjs/reg.js" type="module"></script>