$(document).ready(() => {
    var url = V_Global + "app/services/routes/mainAdmin.route.php";
    const main = {
      routes: {
        //rutas del navbar
        closeSession: url + "?_closeSession",
        AP_name: url + "?_aname",
      },
      view: function (route) {
        location.replace(this.routes[route]);
      },
  
      action: $("#close-profile"),
  
      closeSession: function () {
        $.ajax({
          type: "POST",
          url: this.routes.closeSession,
          data: { _closeSession: "1" },
          dataType: "json",
          headers: {
            Authorization: system.http.send.authorization(),
          },
          success: function (response) {
            if(!response.response) {
              console.log(response.response)
              return;
            }
            system.clearCookiesAndRedirect();
          },
          error: function (error) {
            console.log("System Error: ",error);
          },
        });
      },
  
      closeSession2: function () {
        system.clearCookiesAndRedirect();
      },
  
      initData: function () {
        var self = this;
        // Intenta cargar el nombre desde localStorage primero
        var userInfo = localStorage.getItem("userInfo");
        if (userInfo) {
          userInfo = JSON.parse(userInfo);
          var now = new Date();
          // Verifica si los datos son recientes, por ejemplo, menos de un día de antigüedad
          if (now.getTime() - userInfo.timestamp < 86400000) {
            self.updateNavbar(userInfo.name);
            return; // Salir si los datos aún son válidos
          }
        }
        // Realiza la petición para actualizar los datos        
        $.ajax({
          type: "POST",
          url: this.routes.AP_name,
          data: { _aname: "fetchData" },
          dataType: "json",
          headers: {
            Authorization: system.http.send.authorization(),
          },
          success: function (response) {
            var name = response.response;            
            var now = new Date();
            // Guarda el nombre y la marca de tiempo en localStorage
            localStorage.setItem("userInfo", JSON.stringify({name: name, timestamp: now.getTime()}));
            self.updateNavbar(name); // Actualiza la barra de navegación con el nuevo nombre
          },
          error: function (error) {
            console.log("La petición no fue exitosa", error);
          },
        });
      },
      
      // Método para actualizar la barra de navegación
      updateNavbar: function (name) {
        var html = `
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              ${name}
          </a>
          <ul class="dropdown-menu w-50 mx-left">
              <li>
                  <button type="button" class="dropdown-item btn btn-danger" onclick="main.closeSession2()">Cerrar sesión</button>
              </li>
          </ul>
        </li>
        `;
        this.action.html(html);
      }
      
    };
    window.main = main;
    main.initData();
  });
  