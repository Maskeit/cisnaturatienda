<?php
namespace views;
include "../components/layout/main.php";
head();
css('contacto');
?>

<main class="page">

    <section class="letters">
        <span class="cisnatura">CISnatura</span>
        <span class="descripcion">Fábrica de Remedios Herbolarios</span>
        <span class="descripcion">Contáctanos</span>
    </section>    
    <section class="help">
        <div>
            <span class="desc-titulo">Domicilio.</span>
            <span class="desc-location">C. Condor 103, Paraíso Salagua, 28650 Manzanillo, Colima</span>
            <span class="desc-titulo">Horario de atención.</span>
            <span class="desc-horario">Lunes a Viernes de 10:00 a 14:00 y de 16:00 a 19:00</span>
        </div>
        <div><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.868756820198!2d-104.33186!3d19.113412699999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8424d66211d28407%3A0xa13dfff562522d08!2sCondor%20103%2C%20Para%C3%ADso%20Salagua%2C%2028650%20Manzanillo%2C%20Col.!5e0!3m2!1ses-419!2smx!4v1691793773820!5m2!1ses-419!2smx" width="80%" height="350" 
        class="maps shadow" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
        <div>
            <span class="desc-titulo">Teléfono.</span>
            <span class="desc-horario">+52 314 122 1212</span>
        </div>
        <div>
            <span class="desc-titulo">Correo Electrónico</span>
            <span class="desc-horario">cisnatura@gmail.com</span>
        </div>
        
    </section>
</main>
<?php scripts();?>


<?php
    foot();
?>