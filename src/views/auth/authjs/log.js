import { typeEmailLog, typePassLog } from "./Validator.js";

$(document).ready(() => {
  const url = V_Global + "app/services/signin.php";
    $("#login-button").on("click", function() {
        login.sendLoginForm();
    });

    const login = {
        lf: $("#login-form"),

        sendLoginForm: async function() {
            const loaderContainer = system.showLoader();
            try {
                const email = $("#email").val();
                const pwdField = $("#passwd").val();
                let eNotEmpty = typeEmailLog(email);
                let pNotEmpty = typePassLog(pwdField);

                if (!eNotEmpty || !pNotEmpty) {
                    system.hideLoader(loaderContainer);
                    return alert('Complete todos los campos por favor');
                }

                //const data = new FormData(this.lf[0]); // Utiliza directamente el formulario

                const data = new FormData();
                data.append("email", email);
                data.append("passwd", btoa(pwdField));
                data.append("_login", "");

                const response = await fetch(url, {
                    method: "POST",
                    body: data,
                });

                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }

                const resp = await response.json();

                if (resp.SSK && resp.SSID && resp.APISS__NME) {
                    $.cookie('SSID', resp.SSID, {expires: 1, path: '/', domain: V_Domain});
                    $.cookie('SSK', resp.SSK, {expires: 1, path: '/', domain: V_Domain});
                    $.cookie('APISS__NME', resp.APISS__NME, {expires: 1, path: '/', domain: V_Domain});
                    localStorage.clear();
                    window.location.href = V_Global + 'src/views/home.php';
                } else if (resp.error && resp.error === "Failed auth") {
                    $("#error").text("Sus datos de inicio de sesión son incorrectos").removeClass("d-none").effect("shake");
                } else {
                    $("#error").text("Ocurrió un error inesperado, por favor intente nuevamente").removeClass("d-none").effect("shake");
                }
            } catch (error) {
                console.error("Error en la petición: ", error);
                $("#error").text("Error de conexión").removeClass("d-none").effect("shake");
            } finally {
                system.hideLoader(loaderContainer);
            }
        },
    };
});
