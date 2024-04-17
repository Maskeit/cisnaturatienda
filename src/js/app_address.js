const app_address = {
    url: "/cisnatura/app/app.php",
    user: {
        sv: false,
        id: "",
        tipo: "",
    },

    addExs : $("#addExs"),
    btnconf :$("#btnConfirm"),
    addSelect : $("#address"),

  loader: $("#address-loader"),
  //Loader de carga
  showLoader: function () {
    const loaderContainer = document.createElement("div");
    loaderContainer.classList.add("loader-container"); //loader-container
    const loader = document.createElement("div");
    loader.classList.add("loader"); //loader
    loaderContainer.appendChild(loader);
    this.loader.append(loaderContainer);
    loaderContainer.style.display = "block";
    return loaderContainer;
  },
  hideLoader: function (loaderContainer) {
    loaderContainer.style.display = "none";
  },
  findAddress: async function (uid) {
    let cartValue = null;
    const cookieExists = document.cookie.split(';').some(
      function(item){          
        return item.trim().indexOf('cart=') == 0;
      });

    if(cookieExists){
      const cartCookie = document.cookie
        .split('; ')
        .find(cookie=> cookie.startsWith('cart='));
        if(cartCookie){
          cartValue = cartCookie.split('=')[1];
        }
        console.log('valor de cookie: ', cartValue);
    }else{
      //console.log("No se encontro la cookie");
      const urlBack = "/cisnatura/resources/views/carrito.php";
      location.href = urlBack
    }
    const tempOrder = new URLSearchParams(window.location.search).get("_temp");
    console.log("Este es el id: "+tempOrder);
    const addressDiv = document.getElementById('addExs');
      const userId = uid;
      let html = "";
      this.addExs.html(html);
      const loaderContainer = this.showLoader(); // Mostrar el loader
      try {
        const resp = await fetch(this.url + "?_fadd=" + userId); //find address by userId
        const addresp = await resp.json();
        if(resp.ok){loaderContainer.style.display = "none";}
        const direcciones = addresp;
        const longitud = direcciones.length;
        if (longitud > 0) {
          html += `<ul class="list-group mb-3">`;
          let i = 0;
          for (let direccion of direcciones) {;
            html += `
              <li class="list-group-item">
              <div class="row">
                <div class="col-8">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="direccion" id="direccion-${i}" value="${direccion.id}" ${""}>                    
                    <label class="form-check-label" for="direccion-${i}">
                      <div class="card-body">
                        <span> ${direccion.fullName}</span><br>
                        <span> ${direccion.telefono}</span><br>
                        <span> ${direccion.colonia}</span><br>
                        <span> ${direccion.calle}</span><br>
                        <span> ${direccion.ciudad}</span><br>
                        <span> ${direccion.estado}</span><br>
                        <span> ${direccion.postalcode}</span>                          
                      </div>                     
                    </label>                  
                  </div>
                </div>
                <div class="col">
                  <a href="#" onclick="app_address.deleteAddres(${direccion.id},${userId})"><i class="bi bi-trash"></i> Eliminar</a>
                </div>
              </div>
              </li>
            `;
            i++;
          }
          html += `</ul>`;
          const btntoggle = longitud > "0" ? "block" : "none"
          let button = `<button id="btnContinuar" type="button" class="btnContinuar d-${btntoggle}">Continuar al pago</button>`;
          this.btnconf.html(button);
          // Agregar evento click al botón "Continuar"
          $("#btnContinuar").on("click", function() {
            // Obtener el valor del radio button seleccionado
                                          //$('input[name="direccion"]').prop('checked', false);
                                          //$('input[name="direccion"]:checked').val();
            const direccionSeleccionada = $('input[name="direccion"]:checked').val();
            const alertError = document.getElementById('alert-address');
            // Redirigir a mercado_pago.php con el valor seleccionado como parámetro
            if (direccionSeleccionada) {
              alertError.classList.add('d-none');
              //location.href = `/cisnatura/resources/views/payments/stripe.php?addressId=${direccionSeleccionada}&_orderId=${cartValue}`;
              location.href = `/cisnatura/resources/views/payments/process.php?addressId=${direccionSeleccionada}&_orderId=${cartValue}`;
            } else {
              alertError.classList.remove('d-none');                
            }
          });
        }          
        this.addExs.html(html);
      //addressDiv.innerHTML = `Total a pagar: $${total}`;
      } catch (error) {
        console.error(error);
      }finally{
        this.hideLoader(loaderContainer);
      }

  },


  deleteAddres(aid,uid){ //addres id
    confirm("Desea eliminar esta dirección?")
    if(confirm){
      fetch(this.url + "?_aid="+aid)
        .then(resp => resp.json())
        .then(aidres => {
          if(aidres.r == "success"){
            this.findAddress(uid);
          }else{
            alert("No se pudo eliminar la direccion intentelo de nuevo");
          }
        }).catch(err=>console.error(err));
    }
  }

}