<?php
namespace views;
include "../components/layout/main.php";
head();
css('home');
?>
<div class="pagina-cisnatura" id="loader">

    <section class="banner">
        <div class="grid-banner">
            <article>
                <h1>Tienda CISnatura</h1>
                <p>Fábrica de productos herbolarios y ClO2</p>
                <a href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <button type="button" onclick="app_home.view('catalogo')">¡Ver productos!</button>
                </a>
            </article>

            <img id="interactive-image" src="/cisnaturatienda/public/info/8.webp" alt="Gotero Presentacion">
        </div>
        <div class="redes">
            <a href="https://acortar.link/K9IKSS"  target="_blank"><img class="" src="/cisnaturatienda/public/icons/instagram.png"></a>
            <a href="https://www.facebook.com/cisnaturasofiageovana"  target="_blank"><img class="" src="/cisnaturatienda/public/icons/facebook.png"></a>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center mt-4 mb-3">
            <div class="col-md-6 text-center align-items-center">
                <div class="image-container">
                    <img src="/cisnaturatienda/public/res/sofia1.webp" alt="Sofia Gevoana" class="img-thumbnail rounded">
                </div>
                <h2 class="fw-normal">Sofia Geovana</h2>
                <p>Terapeuta en medicina complementaria y alternativas de salud.</p>
                <p><a class="btnContacto" href="/cisnaturatienda/src/views/contacto.php">Ver Contacto &raquo;</a></p>
            </div>
            <div class="col-md-6 rounded-3" id="informacion">
                <h1 class="pTitle">Nuestra Misión</h1>
                <p class="parrafo">
                En nuestra fábrica, nos enorgullecemos de crear productos de alta calidad con ingredientes naturales cuidadosamente 
                seleccionados. Nos especializamos en tinturas y productos naturistas para la salud, 
                    <span id="parrafoCompleto" class="hidden">
                    utilizando exclusivamente plantas naturales y elementos puros como la sal y el agua de mar para garantizar 
                    la máxima eficacia. Nuestro compromiso con la naturaleza guía todo nuestro proceso de fabricación, 
                    y estamos dedicados a ofrecer soluciones naturales respetuosas con el medio ambiente.
                    </span>
                    <span id="verMas" class="ver-mas">Leer más...</span>
                </p>
            </div>

        </div>
        <div class="link-catalogo">
            <h2><a href="catalogo.php" data-type="#" data-id="#" target="_blank" rel="#" >Ir a comprar <i class="bi bi-bag-heart-fill"></i></a></h2>    
            <div class="container-fluid">
                <div class="productos" id="product-tintura">
                    <!-- aquí van los productos -->
                </div>
            </div>
            <div class="toaster" id="toaster">
                <div class="toast-head">
                    <p>Se añadió al carrito!  <i class="bi bi-bag-check-fill"></i></p>
                    <button type="button" class="btn-close" id="cerrarNotificacion"></button>
                </div>
                <button onclick="app_home.view('carrito')" class="toastBtn">Ir al carrito</button>
            </div>      
        </div>
        <section>
        <h2 class="wp-block-heading mt-5" style="color: #6c757d;">Desde dentro de la naturaleza</h2>
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        <strong>COMO TOMAR AGUA CORRECTAMENTE</strong>
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            <strong>Beber agua es esencial para mantenernos hidratados</strong>
                            y asegurar un buen funcionamiento de nuestro cuerpo. La recomendación 
                            de beber agua de la siguiente manera, basada en el cálculo de la cantidad de 
                            mililitros que se deben tomar cada hora desde las 7 am hasta las 7 pm, 
                            tiene como objetivo proporcionar una guía personalizada para mantener una hidratación adecuada durante el día.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        <strong>ALIMENTACION FUNCIONAL</strong>
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                            <strong>Alimentos altamente alcalinos</strong> Una dieta alcalina puede ofrecer varios beneficios para la salud, como:
                                    Mejorar la salud ósea: Se ha sugerido que una dieta alcalina puede ayudar a preservar la densidad ósea y reducir el riesgo de osteoporosis.
                                    Reducir la inflamación: Alimentos alcalinos, como frutas y verduras, son ricos en antioxidantes y compuestos antiinflamatorios que pueden disminuir la inflamación en el cuerpo.
                                    Promover la salud cardiovascular: Una alimentación alcalina se basa en alimentos naturales y saludables, lo que puede contribuir a una mejor salud cardiovascular.
                                    Ayudar en el control del peso: Una dieta alcalina suele incluir alimentos bajos en calorías y altos en nutrientes, lo que puede favorecer el control del peso.
                                    Mejorar la digestión: Muchos alimentos alcalinos son ricos en fibra, lo que favorece una buena digestión y salud intestinal.
                                    Sin embargo, es importante tener en cuenta que el pH del cuerpo está regulado por sistemas biológicos complejos, y la influencia directa de la dieta alcalina en el pH
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        <strong>LIMPIEZAS ORGANICAS</strong>
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">
                            <strong>Debemos consumir una alimentación alcalina</strong> porque ayuda a mantener un equilibrio saludable en nuestro cuerpo. Una dieta alcalina se caracteriza por incluir alimentos que ayudan a mantener un nivel adecuado de pH en el organismo, promoviendo un ambiente menos ácido.
                                Se cree que una dieta alcalina puede ofrecer varios beneficios para la salud, como:
                                Mejorar la salud ósea: Se ha sugerido que una dieta alcalina puede ayudar a preservar la densidad ósea y reducir el riesgo de osteoporosis.
                                Reducir la inflamación: Alimentos alcalinos, como frutas y verduras, son ricos en antioxidantes y compuestos antiinflamatorios que pueden disminuir la inflamación en el cuerpo.
                                Promover la salud cardiovascular: Una alimentación alcalina se basa en alimentos naturales y saludables, lo que puede contribuir a una mejor salud cardiovascular.
                                Ayudar en el control del peso: Una dieta alcalina suele incluir alimentos bajos en calorías y altos en nutrientes, lo que puede favorecer el control del peso.
                                Mejorar la digestión: Muchos alimentos alcalinos son ricos en fibra, lo que favorece una buena digestión y salud intestinal.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <section>
            <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center my-0">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Aquí puedes agregar la imagen con bordes redondeados -->
                        <!-- carousel -->
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="/cisnaturatienda/public/res/plc1.webp" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="/cisnaturatienda/public/res/plc2.webp" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="/cisnaturatienda/public/res/plc3.webp" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <!-- <img src="/cisnatura/resources/img/pagina2.jpg" alt="" class="img-fluid rounded"> -->
                    </div>
                    <div class="col-md-6">
                        <h1 class="display-4 fw-normal">Aprende más</h1>
                        <p class="lead fw-normal">Visita la pagina principal <a href="https://www.cisnatura.com/"><strong> www.cisnatura.com</strong></a> y mantente informado acerca de los mejores remedios herbolarios.</p>
                        <a class="btn btn-outline-primary" href="https://www.cisnatura.com/">Ver página principal</a>
                    </div>
    
                </div>
            </div>
        </section>
        <!-- Modal del producto -->
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
    </div>
</div>    


<?php scripts('app_home');?>

<?php
    foot();