$(document).ready(() =>{
    const home = {
        init: function (){
            try {                
                Authorization: system.http.send.authorization();
                document.write("Hola se ha cargado el script")
            } catch (error) {
                system.clearCookiesAndRedirect();
            }
        }
    };
    home.init();
});