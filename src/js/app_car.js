var app_car;
$(document).ready(() => {
  var url = V_Global + "app/services/routes/carrito.route.php";
  app_car = {
    routes: {
      pagar: "/cisnatura/resources/views/payments/direccion.php",
      traerCarrito: url + "?_tc", //traer productos seleccionados al carrito del usuario
      actualizarCarrito:url,
      //botones del card para eliminar o actualzar la orden
      deleteCarProduct: url,
    },
    view: function (route) {
      location.replace(this.routes[route]);
    },
    pe: $("#pedido"), //el contenedor donde esta la lista de productos que seleccionamos
    lp: $("#pago"), //listo para pagar

    allProducts : [],
    // carga de productos
    // Asegurándose de pasar los productos correctos a displayCar después de cargarlos
    loadProducts: function () {
      const self = this;
      $.ajax({
        type: "GET",
        url: this.routes.traerCarrito,
        dataType: "json",
        headers: {
          Authorization: system.http.send.authorization(),
        },
        success: function (response) {
          self.allProducts = response.response;
          self.displayCar(response.response);
        },
        error: function(error){
          console.error("Error: " + error);
        }
      });
    },
    
    displayCar: function (products) {
      let html = "";
      let subtotales = [];
      let envio = 200;
    
      html = products.map(product => {
        const decLimit = product.cantidad > 1 ? "" : "d-none";
        const subtotal = parseInt(product.cantidad) * parseFloat(product.price);
        subtotales.push(subtotal);
        return `
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
              <button  class="btnUpdt" onclick="app_car.delProduct(${product.id})"><i class="bi bi-trash"></i></button>
              <div class="d-flex justify-content">
                <button class="btnUpdt ${decLimit}" onclick="app_car.decrementar(${product.id})"><i class="bi bi-dash-square"></i></button>
                <p class="quantity">${parseInt(product.cantidad)}</p>
                <button class="btnUpdt" onclick="app_car.incrementar(${product.id})"><i class="bi bi-plus-square"></i></button>
              </div>
              <p>
                <span class="subtotal" id="subtotal-${product.id}" data-price="${product.price}">$${subtotal}</span>
              </p>
            </div>
          </div>
        `;
      }).join('');
    
      let totalSubtotal = subtotales.reduce((acc, curr) => acc + curr, 0);
      this.pe.html(html);
      this.procederPago(products.length, totalSubtotal, envio);
    },
    

    //Elimina producto del carrito
    delProduct: async function (pid) {
      try {
        const body = new URLSearchParams();
        body.append("pid", pid);
        body.append("_dpc", "1");
    
        const response = await fetch(this.routes.deleteCarProduct, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            Authorization: system.http.send.authorization(),
          },
          body: body,
        });
        const resp = await response.json();
        if (resp.response === "Ok") {
          this.loadProducts();
        }
      } catch (error) {
        console.error("Error al eliminar producto:", error);
      }
    },
    incrementar: function (productId) {
      productId = parseInt(productId, 10);  // Asegurarse que productId es un número    
      let carrito = JSON.parse(localStorage.getItem("carrito") || "[]");    
      const productIndex = carrito.findIndex(product => parseInt(product.id, 10) === productId);    
      if (productIndex !== -1) {
        // Convertir cantidad a número antes de incrementar
        carrito[productIndex].cantidad = parseInt(carrito[productIndex].cantidad, 10) + 1;
        localStorage.setItem("carrito", JSON.stringify(carrito));
        this.displayCar(carrito); // Actualiza la vista del carrito
        this.actualizarCarritoServer(productId, carrito[productIndex].cantidad);
      } else {
        console.error("Producto no encontrado en el carrito:", productId);
      }
    },

    decrementar: function (productId) {
      productId = parseInt(productId, 10);  // Asegurarse que productId es un número
      let carrito = JSON.parse(localStorage.getItem("carrito") || "[]");
      const productIndex = carrito.findIndex(product => parseInt(product.id, 10) === productId);    
      if (productIndex !== -1) {
        // Convertir cantidad a número antes de incrementar
        carrito[productIndex].cantidad = parseInt(carrito[productIndex].cantidad, 10) - 1;
        localStorage.setItem("carrito", JSON.stringify(carrito));
        this.displayCar(carrito); // Actualiza la vista del carrito
        this.actualizarCarritoServer(productId, carrito[productIndex].cantidad);
      } else {
        console.error("Producto no encontrado en el carrito:", productId);
      }
    },
    
    actualizarCarritoServer: function (productId, nuevaCantidad) {
      const body = new URLSearchParams();
      body.append("pid", productId);
      body.append("cantidad", nuevaCantidad);
      body.append("_update", "1");
      fetch(this.routes.actualizarCarrito, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
          Authorization: system.http.send.authorization(),
        },
        body: body,
      })
      .then(response => response.json())
      .catch(error => {
        console.error("Error al actualizar el carrito:", error);
      });
    },

    //Resumen de lo que se va pagar
    procederPago: function (longitud, subtotal, envio) {
      //cuantos productos hay en el carrito, si hay mas de cero se muestra el boton
      this.lp.html("");
      const total = subtotal + envio;
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
        location.href = V_Global + '/src/views/catalogo.php';
      }
    },
  };
  window.app = app_car;
  app.loadProducts();
});