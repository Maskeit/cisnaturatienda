<?php

namespace views;

include "./components/layout/main_admin.php";
head();
css('newproduct');
?>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<!-- Agregar alerta o algo para notificar que se agrego con exito -->
<section class="container pt-2 mt-5">
    <div id="create-product" class="row justify-content-center mt-4 mb-3">
        <!-- aqui va el contenido del formulario -->
    </div>
    <div id="toaster" class="toaster d-none">
        <div class="toast-head">
            <p>Se ha subido el producto correctamente! <i class="bi bi-bag-check-fill"></i></p>
            <button type="button" class="btn-close" id="cerrarNotificacion"></button>
        </div>
    </div>

</section>
<?php scripts('create_product'); ?>
<?php
foot();