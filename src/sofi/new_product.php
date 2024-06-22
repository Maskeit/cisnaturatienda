<?php

namespace views;

include "../components/layout/main_admin.php";
head();
css('newproduct');
?>
<!-- Agregar alerta o algo para notificar que se agrego con exito -->
<section class="container pt-2 mt-5">
    <div id="create-product" class="row justify-content-center mt-4 mb-3">
        <!-- aqui va el contenido del formulario -->
    </div>
</section>
<?php scripts('create_product'); ?>
<?php
foot();
