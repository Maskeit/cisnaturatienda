import { typeEmailLog , typePassLog } from "./Validator.js";
$(document).ready(() => {
//Loader de carga
const showLoader = () => {
    const loaderContainer = document.createElement("div");
    loaderContainer.classList.add("loader-container"); //loader-container
    const loader = document.createElement("div");
    loader.classList.add("loader"); //loader
    loaderContainer.appendChild(loader);
    loaderContainer.style.display = "block"; // Muestra el cargador
    return loaderContainer;
};
const hideLoader = (loaderContainer) => {
loaderContainer.style.display = "none";
};
$("#login-button").on("click", function() {
    login.sendLoginForm();
});
  const login = {
    lf: $("#login-form"),

    routes: {
      approute: V_Global + "app/services/signin.php",
    },
  
    sendLoginForm: async function () {
      const loaderContainer = showLoader();
      try {
          const data = new FormData();
          const email = $("#email").val();
          const pwdField = $("#passwd").val();
          let eNotEmpty = typeEmailLog(email);
          let pNotEmpty = typePassLog(pwdField);

          if(eNotEmpty != false && 
             pNotEmpty != false
            ) {
              data.append("email", email);
              data.append("passwd", btoa(pwdField));
              data.append("_login", "");
          }else{
            return alert('Complete todos los campos por favor');
          }
          const response = await fetch(this.routes.approute, {
            method: "POST",
            body: data,
          });
        
          const resp = await response.json();  // Ahora obtenemos el JSON sin importar el estado de la respuesta
          hideLoader(loaderContainer);  // Ocultamos el cargador independientemente del resultado

          // Comprobamos que la respuesta fue OK y el token está presente
          if (response.ok && resp.SSK && resp.SSID && resp.APISS__NME) { 
            // Aquí establecemos las cookies solo si la autenticación fue exitosa
            $.cookie('SSID', resp.SSID, {expires: 7, path: '/', domain: V_Domain});
            $.cookie('SSK', resp.SSK, {expires: 7, path: '/', domain: V_Domain});
            $.cookie('APISS__NME', resp.APISS__NME, {expires: 7, path: '/', domain: V_Domain});
            // Redirigir al usuario al home o donde corresponda
            window.location.href = V_Global + 'src/views/home.php'; // Asegúrate de reemplazar esto con la URL correcta
            } else if(resp.error && resp.error === "Failed auth") {
              // Si la respuesta del servidor indica fallo en la autenticación, manejar aquí el error
              $("#error").text("Sus datos de inicio de sesión son incorrectos").removeClass("d-none").effect("shake");
            }   else {
              // Manejar cualquier otro tipo de error no específicamente de autenticación fallida
              $("#error").text("Ocurrió un error inesperado, por favor intente nuevamente").removeClass("d-none").effect("shake");
            }

      } catch (error) {
        console.error(error);
      } finally {
        hideLoader(loaderContainer);  // Asegúrate de ocultar el cargador también aquí por si hay una excepción
    }
    },
  };
});
