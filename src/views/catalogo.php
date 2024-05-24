<?php
namespace views;
include "../components/layout/main.php";
head();
css('catalogo');
?>
<main class="pageCar">
    <div class="section-principal">
        <!-- <h2 class="wp-block-heading mt-2" style="text-decoration: none;">
            Cátalogo Cisnatura
        </h2> -->
            <div id="aviso" class="aviso"></div>
            <section class="content">
                <div class="search-filter">
                    <form class="barra-busqueda" id="form-buscador">
                        <input class="form-control" id="buscar-palabra" type="search" placeholder="Buscar producto" aria-label="Search">
                        <button id="btn-buscar" class="btn-search" type="submit"> <i class="bi bi-search searchIcon"></i></button>
                    </form> 
                    <!-- onclick="app.buscar()" -->
                    <section>
                        <!-- <small class="alert-info">Filtra por Categorías.</small> -->
                        <div id="filter-products" class="filter-list">
                            <!-- clasificacion de productos -->
                        </div>
                        <div id="filter-products-alt" class="filter-list-alt mb-4">
                            <!-- clasificacion de productos -->
                        </div>

                        <div id="viewCart">
                            <!-- Aqui se espera que aparezca el boton cuando ya haya una cantidad -->
                        </div>
                    </section>
                </div>
                <section id="products-loader">                        
                    <div id="product-card" class="productos">
                        <!-- Aquí van los productos -->                                             
                        <!-- No resultados -->
                        <h2 id="noResultsMessage" class="text-center" style="display: none;">No se encontraron resultados.</h2>
    
                        <!-- <button class="btnCarrito" onclick="app.view('carrito')">
                            Carrito<span id="addproduct" class="addproduct"></span>
                        </button> -->
                    </div>
                </section>
                <div class="toaster" id="toaster">
                    <div class="toast-head">
                        <p>Se añadió al carrito!  <i class="bi bi-bag-check-fill"></i></p>
                        <button type="button" class="btn-close" id="cerrarNotificacion"></button>
                    </div>
                    <button onclick="app.view('carrito')" class="toastBtn">Ir al carrito</button>
                </div>
            </section>
            <!-- Modal -->
            <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="productModalBody">
                            <!-- Aquí se mostrarán los datos del producto -->
                        </div>
                    </div>
                </div>
            </div>
            <!--delete Modal-->
                    <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body" id="deleteProductModalBody">
                            <!-- Aquí se mostrarán los datos del producto -->
                        </div>
                    </div>
                </div>
            </div>
    </div>
</main>


<?php scripts('app');?>

<?php
    foot();