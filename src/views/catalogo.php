<?php

namespace views;

include "../components/layout/main.php";
head();
css('catalogo');
?>
<main class="pageCar">
    <div class="section-principal">
        <section class="content">
            <aside class="navegacion">
                <form class="barra-busqueda" id="form-buscador">
                    <input class="form-control" id="buscar-palabra" type="search" placeholder="Buscar producto" aria-label="Buscar producto">
                    <button id="btn-buscar" class="btn-search" type="submit"> <i class="bi bi-search searchIcon"></i></button>
                </form>

                <div id="filter-products" class="filter-list">
                    <!-- clasificacion de productos -->
                </div>
                <div id="filter-products-alt" class="filter-list-alt">
                    <!-- clasificacion de productos alternativa -->
                </div>

                <div id="viewCart">
                    <!-- Boton del carrito aparece aquí -->
                </div>
            </aside>
            <section id="product-card" class="productos">
                <!-- Productos listados aquí -->
                <h2 id="noResultsMessage" class="text-center" style="display: none;">No se encontraron resultados.</h2>
            </section>
        </section>
        <div id="toaster" class="toaster d-none">
            <div class="toast-head">
                <p>Se añadió al carrito! <i class="bi bi-bag-check-fill"></i></p>
                <button type="button" class="btn-close" id="cerrarNotificacion"></button>
            </div>
            <button onclick="app.view('carrito')" class="toastBtn">Ir al carrito</button>
        </div>
        <!-- Modal de Producto -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="productModalBody">
                        <!-- Detalles del producto aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php scripts('app'); ?>

<?php
foot();
