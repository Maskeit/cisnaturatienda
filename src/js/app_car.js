var app_car;
$(document).ready(() => {
  var url = V_Global + "app/services/routes/carrito.route.php";
  app_car = {
    routes: {
      pagar: "/cisnatura/resources/views/payments/direccion.php",
      traerCarrito: url + "?_tc", //traer productos seleccionados al carrito del usuario

      //botones del card para eliminar o actualzar la orden
      deleteCarProduct: url,
    },
    view: function (route) {
      location.replace(this.routes[route]);
    },
    pe: $("#pedido"), //el contenedor donde esta la lista de productos que seleccionamos
    lp: $("#pago"), //listo para pagar

    //Muestra el contenido del carrito
    contentCar: function () {
      const self = this;
      const loaderContainer = system.showLoader();
      let foundCarProducts = false;

      let html = "<h4 class='lead text-muted d-flex justify-content-center'>Todo está tranquilo por aquí<a href='./catalogo.php' class='mx-3' style='text-decoration: none;'><i class='bi bi-plus-square'></i></a></h4>";      
      self.pe.html(html);
      try {
        $.ajax({
            type: "GET",
            url: this.routes.traerCarrito,
            headers: {
                Authorization: system.http.send.authorization(),
            },
            dataType: "json", //importante no olvidar
            success: function (productos) {
                //console.log(productos.response);
              if (productos.response.length > 0) {
                    loaderContainer.style.display = "none";
                    let html = "";
                    foundCarProducts = true;
                    const productosFiltrados = productos.response.filter(
                        (producto) => producto.active === "1" && producto.cantidad !== "0"
                    );
                    html = "";
                    const subtotales = [];
                    const envio = 200;
                    const longitud = productosFiltrados.length;
                    if(longitud > 0){            
                      for (let product of productosFiltrados) {
                          const decLimit = product.cantidad > 1 ? "" : "d-none";
                          const subtotal = parseInt(product.cantidad) * parseFloat(product.price);
                          subtotales.push(subtotal);
                          html += `
                          <div class="card" data-product-id="${product.id}">
                              <div class="product-header">
                                  <p class="product-name">${product.product_name}</p>
                              </div>
                              <div class="card-body-product">
                                  <img src="/cisnaturatienda/app/pimg/${product.thumb}">
                                  <div>
                                      <img src="/cisnaturatienda/app/pimg/${product.thumb}" class="img-r">
                                      <p class="product-name">${product.product_name}</p>
                                  </div>
                                  <button onclick="app_car.delProduct(${product.id})" class="btnTrash"><i class="bi bi-trash"></i></button>
                                  <div class="d-flex justify-content">
                                      <a href="javascript:void(0);" class="${decLimit}" onclick="app_car.decrementar(${product.productId},1)"><i class="bi bi-dash-square"></i></a>
                                      <p class="quantity">${parseInt(product.cantidad)}</p>
                                      <a href="javascript:void(0);" onclick="app_car.incrementar(${product.productId},1)"><i class="bi bi-plus-square"></i></a>
                                  </div>
                                  <p>
                                      <span class="subtotal" id="subtotal-${product.id}" data-price="${product.price}">$${subtotal}</span>
                                  </p>
                              </div>
                          </div>
                          `;
                      }
                    }
                    const subtotal = subtotales.reduce((acc, curr) => acc + curr, 0);
                    self.pe.html(html);
                    self.procederPago(longitud, subtotal, envio, productos);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en la petición AJAX:", xhr.responseText);
            }
        });
    } catch (error) {
        console.error("Error al cargar los productos del carrito:", error);
    } finally{
      system.hideLoader(loaderContainer);
    }
    },
    //Elimina producto del carrito
    delProduct: async function (pid) {
      try{
        const body = new URLSearchParams();
        body.append("pid",pid);
        body.append("_dpc","1");

        const response = await fetch(this.routes.deleteCarProduct,{
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            Authorization: system.http.send.authorization(),
          },
          body: body,
        });
        const resp = await response.json();
        const metodo = resp.response;
        if(metodo == 'Ok') {
          this.contentCar();
        }

        console.log(metodo);
      } catch(error){
        console.error(error);
      }
    },
    //Aumenta la cantidad del producto
    incrementar: function (pid, uid, num) {
      fetch(this.url + "?_incP=" + pid + "&uid=" + uid + "&num=" + num) // Cambia pid por _incP
        .then((resp) => resp.json())
        .then((data) => {
          if (data.r === "success") {
            this.contentCar(uid); //actualiza la cant de prod añadidos
          } else {
            alert("No se pudo actualizar el INC");
          }
        })
        .catch((err) => console.error(err));
    },
    //Decrementa la cantidad del producto
    decrementar: function (pid, uid, num) {
      fetch(this.url + "?_decP=" + pid + "&uid=" + uid + "&num=" + num)
        .then((resp) => resp.json())
        .then((data) => {
          if (data.r === "success") {
            this.contentCar(uid); //actualiza la cant de prod añadidos
          } else {
            alert("No se pudo actualizar el DEC");
          }
        })
        .catch((err) => console.error(err));
    },
    //Resumen de lo que se va pagar
    procederPago: function (longitud, subtotal, envio, productos) {
      //cuantos productos hay en el carrito, si hay mas de cero se muestra el boton
      this.lp.html("");
      //console.log(longitud);
      const total = subtotal + envio;

      const products = productos;
      if (longitud > 0) {
        let html = `
            <div class="card">
                <div class="card-body">
                    <p>Listo para pagar</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item payItem">Subtotal: $${subtotal}.00</li>
                        <li class="list-group-item payItem">+ Envio: $${envio}.00</li>
                        <li class="list-group-item payItemtotal">Total: MX $${total}.00</li>                        
                    </ul>
                    <form id="payForm" action="">
                    <input type="hidden" id="subtotal" name="subtotal" value="${subtotal}" required>
                    <input type="hidden" id="total" name="total" value="${total}" required>
                    <input type="hidden" id="envio" name="envio" value="${envio}" required>
                    <input type="hidden" id="status" name="status" value="incomplete" required>
                        <div class="card-footer gap-2 d-grid">
                            <button type="submit" class="btnContinuar">
                                Continuar <i class="bi bi-caret-right-fill"></i>
                            </button>                
                        </div>
                    </form>
                </div>
            </div>
            `;
        this.lp.html(html);
        //tomamos los datos del formulario escondido en el boton
        //de 'Continuar' para poder enviarlos al servidor a una tabla auxiliar
        $(function () {
          const pf = $("#payForm");
          pf.on("submit", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const productsIds = products.map((producto) => producto.productId);
            const productQuant = products.map((producto) => producto.cantidad);
            // Crear un objeto con propiedades separadas para los IDs y cantidades
            const productsData = {
              productsIds: productsIds,
              productQuantities: productQuant,
            };
            // Convertir el objeto a JSON
            const productsJson = JSON.stringify(productsData);
            console.log(productsJson);
            // const productsJson = JSON.stringify({ productsIds: productsIds });
            // console.log(productsJson);

            const data = new FormData();
            data.append("subtotal", $("#subtotal").val());
            data.append("productsData", productsJson);
            data.append("envio", $("#envio").val());
            data.append("total", $("#total").val());
            data.append("status", $("#status").val());
            data.append("_order", "");
            fetch("/cisnatura/app/app.php", {
              method: "POST",
              body: data,
            })
              .then((resp) => resp.json())
              .then((respdos) => {
                console.log(respdos);

                const parsedResponse = JSON.parse(respdos.r);

                if (
                  Array.isArray(parsedResponse) &&
                  parsedResponse.length > 0
                ) {
                  const tempId = parsedResponse[0].id;
                  console.log(tempId);
                  document.cookie = `cart=${tempId}`;
                  const exists = document.cookie
                    .split(";")
                    .some(function (item) {
                      return item.trim().indexOf("cart=") == 0;
                    });

                  let cartValue = null;
                  if (exists) {
                    const cartCookie = document.cookie
                      .split("; ")
                      .find((cookie) => cookie.startsWith("cart="));
                    if (cartCookie) {
                      cartValue = cartCookie.split("=")[1];
                    }
                  }
                  // La variable cartValue se tiene que hashear para mandarla sin que se muestre al cliente
                  const urltempid =
                    "/cisnatura/resources/views/payments/direccion.php?_temp=" +
                    cartValue;
                  location.href = urltempid;
                } else {
                  console.error(
                    "La respuesta no tiene la estructura esperada."
                  );
                }
              })
              .catch((err) => console.error(err));
          });
        });
      } else {
        let html = `
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-center">
                        <p>Tu carrito está vacío. Agrega productos antes de proceder al pago.</p>
                    </div>
                </div>
            </div>
            `;
        this.lp.html(html);
      }
    },
  };
  window.app = app_car;
  app.contentCar();
});