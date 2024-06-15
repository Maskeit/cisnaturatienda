import { validateEmail, validateName, validatePass } from "./Validator.js";
$(document).ready(() => {
  const url = V_Global + "app/services/routes/register.route.php"; 
  const register = {
    rf: $("#register-form"),

    sendRegisterForm: async function () {
      const loaderContainer = system.showLoader();

      const name = $("#name").val();
      const email = $("#email").val();
      const pwdField = $("#passwd").val();
      const pwdField2 = $("#passwd2").val();
      let nombreValidado = validateName(name); //Este es u nombre formateado para ingresarlo sin errores a la bd
      let emailValidado = validateEmail(email);
      let passwordValidado = validatePass(pwdField, pwdField2);

      if (nombreValidado === "error" || !emailValidado || !passwordValidado) {
        console.error("Validation failed");
        system.hideLoader(loaderContainer);
        return; // Detiene la ejecución si la validación falla
      }
      const data = new FormData(this.rf[0]); // Usamos el formulario directamente para crear FormData
      data.append("name", nombreValidado);
      data.append("email", email);
      data.append("passwd", pwdField);
      data.append("_register", "");
      try {
        const response = await fetch(url, {
          method: "POST",
          body: data,
        });

        if (response.ok) {
          const resp = await response.json();
          if (resp.r === false) {
              $("#account-exists").removeClass("d-none").addClass("d-block"); // Mostrar mensaje de error
              system.hideLoader(loaderContainer);
          } else if (resp.r === true) {
              $("#account-exists").addClass("d-none").removeClass("d-block"); // Ocultar mensaje de error
              location.href = "/cisnaturatienda/src/views/auth/login.php"; // Redireccionar
          }
      } else {
          throw new Error("Network response was not ok");
      }
      
      } catch (error) {
        console.error(error);
      } finally{
        system.hideLoader(loaderContainer);
      }
    },
  };
  // Evento para manejar el clic del botón de registro
  $("#register-button").on("click", function () {
    register.sendRegisterForm();
  });
});
