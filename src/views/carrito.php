<?php
namespace views;
include "../components/layout/main.php";
head();
css('carrito');
?>
<main class="pageCar" id="cart-loader">
    <section class="container">
        <div class="progress mb-3">
            <div class="progress-bar bg-success" role="progressbar" aria-label="Basic example" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <nav class="container breadcrum-con" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/cisnaturatienda/src/views/catalogo.php">Volver</a></li>
            <li class="breadcrumb-item active" aria-current="page">comprar</li>
          </ol>
        </nav>
        <div class="row">
            <div class="col-md-8">
                <div class="content">
                    <div class="card-title"><p>Productos del carrito</p></div>
                    <hr>
                    <div class="cart-items" id="pedido">
                        <!-- Aquí se generarán dinámicamente los elementos del carrito -->
                    </div>
                </div>

            </div>

            <div class="col-md-4 mb-3 w-20">
                <div id="pago" class="payCar">
                    <!-- Listo para pagar -->
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
scripts('app_car');
foot();
?>
