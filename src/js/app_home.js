$(document).ready(() => {
  var url = V_Global + "app/services/routes/home.route.php";
  const app_home = {
    routes: {
      carrito: V_Global + "src/views/carrito.php",
      catalogo: V_Global + "src/views/catalogo.php",
      //rutas de funciones del home
      lastpostT: url + "?_lp",
      //botones de compra y add
      addproduct: url + "?_ap",
    },

    view: function (route) {
      location.replace(this.routes[route]);
    },

    lpt: $("#product-tintura"), // id del contenedor de los 4 productos

    productos: [], //aqui se almacenaran los productos de mientras

    lastPost: async function () {
      this.lpt.html("");
      const loaderContainer = system.showLoader(); // Mostrar el loader

      try {
        $.ajax({
          type: "GET",
          url: this.routes.lastpostT,
          dataType: "json",
          headers: {
            Authorization: system.http.send.authorization(),
          },
          success: function (result) {
            const longitud = result.length;
            if (longitud > 0) {
              app_home.productos = result;

              const html = result
                .map((product) => {
                  if (product.active === "1") {
                    return `
                    <div class="wsk-cp-product" data-product-id="${product.id}">
                      <div class="wsk-cp-img">
                          <img src="/cisnaturatienda/app/pimg/${product.thumb}" alt="Product Image">
                      </div>
                      <div class="wsk-cp-text">
                          <div class="title-product">
                            <h3>${product.product_name}</h3>
                          </div>
                          <div class="description-prod">
                            <p>${product.description}</p>
                          </div>
                          <div class="card-footer">
                            <div class="wcf-left"><span class="price">$${product.price} MX</span></div>
                            <div class="wcf-right">
                              <button id="product-${product.id}-button" type="button" class="buy-btn">
                                <i class="bi bi-bag-plus"></i>
                              </button>
                            </div>
                          </div>
                      </div>
                    </div>
                    `;
                  }
                })
                .join("");
              $("#product-tintura").append(html);

              // Después de agregar los productos al DOM
              $(".wsk-cp-product").on("click", function () {
                const productId = $(this).data("product-id");
                app_home.singleProduct(productId);
              });

              $(".buy-btn").on("click", function (e) {
                e.stopPropagation();
                const productId = $(this)
                  .closest(".wsk-cp-product")
                  .data("product-id");
                app_home.agregarProducto(productId, 1);
              });

            } else {
              console.log(
                "joder si hay cookies, pero no contenido porque no existe el archivo"
              );
              system.clearCookiesAndRedirect();
              $("#product-tintura").append("<h4>Aún no hay productos</h4>");
            }
          },
        });
      } catch (err) {
        //console.error(err);
        system.clearCookiesAndRedirect();
      } finally {
        system.hideLoader(loaderContainer); // Ocultar el loader después de que se completa la solicitud
      }
    },
    //Modal donde se muestra la descripcion del producto
    singleProduct: function (productId) {
      // Encuentra el producto específico por ID
      const product = this.productos.find((p) => p.id == productId);
      if (product) {
        let html = `
          <img src="/cisnaturatienda/app/pimg/${product.thumb}" class="card-img-top" alt="product ${product.product_name}">
            <h3>${product.product_name}</h3>
          <p>${product.description}</p>
            <div class="card-footer">
              <div class="wcf-left"><span class="price">$${product.price} MX</span></div>
              <div class="wcf-right">
                <button class="buy-btn" id="product-${product.id}-button" type="button"
                  onclick="app_home.agregarProducto(${product.id}); $('#productModal').modal('hide');">
                  <i class="bi bi-bag-plus"></i>
                </button>
              </div>
            </div>
        `;
        document.getElementById("productModalBody").innerHTML = html;
        $("#productModal").modal("show"); // Muestra el modal
      } else {
        console.error("Producto no encontrado");
      }
    },
    //metodo para agregar un producto al carrito
    //metodo para agregar productos al carrito del usuario
    agregarProducto: async function (pid) {
      try {
        // Construye el cuerpo de la petición POST
        const body = new URLSearchParams();
        body.append("pid", pid);
        body.append("cantidad", "1");
        body.append("_ap", "1");

        const response = await fetch(this.routes.addproduct, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            Authorization: system.http.send.authorization(),
          },
          body: body,
        });

        const resp = await response.json();
        if (resp.response == 1) {
          $("#toaster").removeClass("d-none").addClass("d-block"); // Muestra el toast
          // Usa setTimeout para ocultar el toast después de 4 segundos
          setTimeout(() => {
            $("#toaster").addClass("d-none").removeClass("d-block"); // Oculta el toast
          }, 4000);
        } else {
          alert("no se puedo agregar el producto al carrito");
        }
      } catch (error) {
        alert(error);
      }
    },
  };

  window.app_home = app_home;
  app_home.lastPost();
});
