const app_profile = {
  url: "/cisnatura/app/app.php",

  address: $('#direcciones'),
  hc: $('#history-cards'), //historial-body

  // Método para mostrar datos del perfil, ajustar controlador para seleccionar más campos
  personalData: function (uid) {
    let htmlAddress = "";
    this.address.html(htmlAddress);

    fetch(this.url + "?_fadd=" + uid)
      .then(resp => resp.json())
      .then(addresp => {
        const direcciones = addresp;
        const longitud = direcciones.length;

        if (longitud > 0) {
          // Comienza la construcción de la tarjeta card-data
          htmlAddress = `
            <div class="card-data-add"  data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
              </div>
              <div class="personal-data">
                <span>Direcciones</span>
                <span>Direcciones guardadas en tu cuenta.</span>
                <div class="collapse" id="collapseExample">`;

          // Itera sobre las direcciones y construye el contenido del colapso
          direcciones.forEach(direccion => {
            htmlAddress += `
              <div class="card card-body mb-2">
                <span>${direccion.fullName}</span>
                <span>${direccion.colonia}</span>
                <span>${direccion.calle}</span>
                <span>${direccion.ciudad}</span>
                <span>${direccion.estado}</span>
                <span>${direccion.postalcode}</span>
                <span>${direccion.telefono}</span>
              </div>`;          
          });
        }

        this.address.html(htmlAddress);
      })
      .catch(err => console.error(err));
  },
};

// historyCards : function(uid){
//   let html = "";
//   this.hc.html(html);
// },