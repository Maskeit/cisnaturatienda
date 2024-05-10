<?php
function head()
{
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Credits
        Pagina desarrollada por Miguel Agustin Alejandre Arreola 
        -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/cisnaturatienda/src/css/bootstrap.css">
        <link rel="stylesheet" href="/cisnaturatienda/src/css/main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="icon" href="/cisnaturatienda/public/icons/logoCisnatura.png" type="image/x-icon">
        <?php
        function css($css = '')
        {
            if ($css != '') {
                echo '<link rel="stylesheet" href="/cisnaturatienda/src/css/' . $css . '.css">';
            }
        }
        ?>
        <title>CISnatura Tienda</title>
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-K9VQ3DBB');
        </script>
        <!-- End Google Tag Manager -->
    </head>

    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K9VQ3DBB" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
        <!-- navbar navbar-expand-lg navbar-light bg-white bg-gradient mb-3 shadow sticky-top -->
        <div id="app" class="container-main">
            <div class="page-content">
                <header>
                    <nav class="navbar navbar-expand-md fixed-top bg-light shadow" data-bs-theme="light">
                        <div class="container-fluid">

                            <div class="d-flex justify-content-center">
                                <a class="navbar-brand ml-3 mt-2 d-lg-none" href="/cisnatura/index.php">
                                    <img src="/cisnatura/resources/img/logoCisnatura.png" alt="Logo" height="50">
                                </a>
                                <a class="navbar-brand d-none d-lg-block navbar-logo" href="/cisnatura/index.php">
                                    <img src="/cisnatura/resources/img/logoCisnatura.png" height="60" alt="Logo">
                                </a>
                            </div>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse nav-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-0 mb-lg-0 justify-content-center">
                                    <li class="nav-item">
                                        <a class="nav-link mx-1 my-1 button-navbar" href="/cisnaturatienda/src/views/home.php">Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-1 my-1 button-navbar" href="/cisnaturatienda/src/views/catalogo.php">Catálogo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-1 my-1 button-navbar" href="/cisnaturatienda/src/views/contacto.php">Contacto</a>
                                    </li>
                                </ul>
                                <ul class="navbar-nav ml-auto mb-2 d-flex align-items-center">
                                    <!-- btn -->
                                    <!-- btn -->
                                    <?php ?>
                                        <li class="nav-item mx-1">                                    
                                            <a class="button-register nav-link  btn btn-link" href="/cisnaturatienda/src/views/auth/register.php">Registrarse</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="button-session nav-link btn btn-link" href="/cisnaturatienda/src/views/auth/login.php">Iniciar Sesión</a>
                                        </li>
                                    <?php ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?= 'Nombre' ?>
                                        </a>
                                        <ul class="dropdown-menu w-50 mx-left">
                                            <li>
                                                <button type="button" class="dropdown-item btn btn-primary" onclick="main.view('profile')">Mi Cuenta</button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item btn btn-danger" onclick="main.view('endsession')">Cerrar sesión</button>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php ?>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </header>
            </div>
        </div>


    <?php
}
function scripts($script = "")
{
    ?>
        </div>
        <script src="/cisnaturatienda/src/libraries/jquery.js"></script>
        <script src="/cisnaturatienda/src/libraries/jquery-ui.min.js"></script>
        <script src="/cisnaturatienda/src/libraries/popper.js"></script>
        <script src="/cisnaturatienda/src/libraries/bootstrap.js"></script>
        <script src="/cisnaturatienda/src/libraries/cookies/src/jquery.cookie.js"></script>
        <script src="/cisnaturatienda/src/libraries/push.min.js"></script>
        <script src="/cisnaturatienda/src/components/system.component.js"></script>
        <script src="/cisnaturatienda/src/js/main.js"></script>
        <?php
        if ($script != '') {
            echo '<script src="/cisnaturatienda/src/js/' . $script . '.js"></script>';
        }
    }
    function foot()
    {
        ?>
        <!-- Footer de la pagina -->
        <div class="footer-contain">
            <div class="container">
                <footer class="footer-elements">
                    <ul>
                        <li class="nav-item"><a href="/cisnaturatienda/src/views/home.php" class="nav-link px-2 text-body-secondary">Inicio</a></li>
                        <li class="nav-item"><a href="/cisnaturatienda/src/views/catalogo.php" class="nav-link px-2 text-body-secondary">Catálogo</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Ubicación</a></li>
                        <li class="nav-item"><a href="/cisnaturatienda/src/views/legal/cookies-policy.php" class="nav-link px-2 text-body-secondary">Cookies</a></li>
                        <li class="nav-item"><a href="/cisnaturatienda/src/views/legal/" class="nav-link px-2 text-body-secondary" target="_blank">Aviso de privacidad</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Preguntas</a></li>
                        <li class="nav-item"><a class="text-body-secondary" href="https://acortar.link/K9IKSS" target="_blank"><svg class="bi" width="24" height="24"><i class="bi bi-instagram"></i></svg></a></li>
                        <li class="nav-item"><a class="text-body-secondary" href="https://www.facebook.com/cisnaturasofiageovana" target="_blank"><svg class="bi" width="24" height="24"><i class="bi bi-facebook"></i></svg></a></li>
                    </ul>
                    <p class="text-center text-body-secondary">&copy; 2024 CISnatura, Inc</p>
                </footer>
            </div>
        </div>
    </body>

    </html>


<?php }
