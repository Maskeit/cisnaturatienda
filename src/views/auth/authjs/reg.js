import {validateEmail, validateName, validatePass }from "./Validator.js";
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

$("#register-button").on("click", function() {
  register.sendRegisterForm();
});

 const register = {
  rf: $("#register-form"),

  routes: {
    approute: V_Global + "app/app.php",
  },

  sendRegisterForm: async function () {
    const loaderContainer = showLoader();
    try {
        const data = new FormData();
        const name = $("#name").val();
        const email = $("#email").val();
        const pwdField = $("#passwd").val();
        const pwdField2 = $("#passwd2").val();        
        let nombreValidado = validateName(name); //Este es u nombre formateado para ingresarlo sin errores a la bd
        let emailValidado = validateEmail(email);
        let passwordValidado = validatePass(pwdField, pwdField2);

      if (
          nombreValidado != "error" &&
          emailValidado != false &&
          passwordValidado != false
        ) {
          data.append("name", nombreValidado);
          data.append("email", email);
          data.append("passwd", pwdField);          
        }

        data.append("_register", "");
        const response = await fetch(this.routes.approute, {
          method: "POST",
          body: data,
        });

        if (response.ok) {
          const resp = await response.json();
          if (resp.r === true) {
            hideLoader(loaderContainer);
            location.href = "/cisnatura/resources/views/auth/login.php";
          } 
        } else {          
          throw new Error("Network response was not ok");
        }
    } catch (error) {
      console.error(error);
    }
  },
}
});
