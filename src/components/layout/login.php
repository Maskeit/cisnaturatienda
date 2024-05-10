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
        <div id="loader"></div>

    <?php
}
function scripts($script = ""){
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
    ?>
    </body>

    </html>