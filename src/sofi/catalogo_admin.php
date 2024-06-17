<?php

namespace views;

include "../components/layout/main_admin.php";
head();
css('catalogo');
?>

<main class="pageCar">
    <div class="section-principal">
        <section class="content">
            <aside class="navegacion">
                <form class="barra-busqueda" id="form-buscador">
                    <input class="form-control" id="search-input" type="search" placeholder="Buscar producto" aria-label="Buscar producto">
                    <button id="btn-buscar" class="btn-search" type="submit"> <i class="bi bi-search searchIcon"></i></button>
                </form>
            </aside>
            <section id="posts" class="productos">
                <!-- content -->
            </section>
        </section>
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
</main>


<?php scripts('catalogo_admin'); ?>
<?php
foot();
