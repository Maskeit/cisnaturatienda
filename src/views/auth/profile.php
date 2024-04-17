<?php
namespace views;
require "../../../app/autoloader.php";
include "../layouts/main.php";
use Controllers\auth\LoginController as LoginController;
// $ua = new LoginController;
// $sessionData = $ua->sessionValidate();
// if (!$sessionData) {
//     // No se ha iniciado sesión, redirigir a la página de inicio de sesión
//     header("Location: /cisnatura/resources/views/auth/login.php");
//     exit;
// }
head($ua);
?>
<link rel="stylesheet" href="/cisnatura/resources/css/profile.css">

<!-- crear modelo, controlador y la vista de este perfil -->
<main>
    <!-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/cisnatura/resources/vies/home.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Perfil</li>
    </ol>
    </nav> -->
    <div class="container">
        <div class="col-md">
            <h2 class="title-perfil">Perfil de usuario</h2>
            <div class="card-group-info">        
                <div class="card-data">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                    </div>
                    <div class="personal-data">
                        <span>Nombre elegido</span>
                        <span><?="nombre"?></span>
                    </div>
                </div>
                <div class="card-data">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
                        <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
                        <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
                        </svg>
                    </div>
                    <div class="personal-data">
                        <span>Correo</span>
                        <span><?="Email"?></span>
                    </div>
                </div>
                <div id="direcciones"></div>
            </div>            
        </div>
        <div class="col-md">
            <div class="card-historial">
                <h2 class="title-historial">Historial de compras</h2>
                <div id="history-cards"><!-- se genera con javascript -->
                    <div class="card-pedido">
                        <div class="card-pedido-content">
                            <img src="/cisnatura/app/pimg/OPUNTIA.jpeg" alt="">
                            <div class="body-card-pedido">
                                <span>Pedido realizado el dia 24 de agosto de 2023</span>
                                <span>Productos cisnatura por $860</span>
                                <small>ID del pedido:123141412124</small>
                            </div>
                            <small class="view-details">Ver detalles</small>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

</main>
<?php scripts('app_profile') ?>
<script>
    // $(function(){
    //     app_profile.personalData(<?=$ua->id?>);
    //     //app_profile.historyCards(<?=$ua->id?>);
    // })
</script>
<?php foot(); ?>