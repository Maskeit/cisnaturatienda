$(document).ready(() => {
var url = V_Global + "app/services/routes/home.route.php";
  const app_home = {
    routes: {
      catalogo: V_Global + "src/views/catalogo.php",
      carrito: V_Global + "src/views/carrito.php",
      //rutas de funciones del home
      lastpostT: url + "?_lp",
      //botones de compra y add
      addproduct: url + "?_ap",
      vercant: url,
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
                        <div class="product-card" data-product-id="${product.id}" onclick="">
                            <div class="product-image">
                                <img src="/cisnaturatienda/app/pimg/${product.thumb}" alt="Product Image">
                                <div class="card-overlay">
                                    <span class="ovtext">
                                        Ver detalles <i class="bi bi-eye-fill eyeColor"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="product-info">
                                <span class="product-name">${product.product_name}</span>
                                <span class="product-price">MX $${product.price}</span>
                                <div class="gap-2 btnAddBuy d-block">
                                <button id="product-${product.id}-button" type="button" class="boton-agregar d-block w-100 my-2" 
                                    onclick="event.stopPropagation(); app_home.agregarProducto(${product.id}, 1)">
                                    <i class="bi bi-plus-circle-fill"></i>  Añadir al carrito
                                </button>
                                </div>
                            </div>
                        </div>
                    `;
                  }
                }).join("");
              $("#product-tintura").append(html);
              // Después de agregar los productos al DOM
            $('.product-card').on('click', function() {
              const productId = $(this).data('product-id');
              app_home.singleProduct(productId);
            });

            } else {
              console.log("joder si hay cookies, pero no contenido porque no existe el archivo");
              $("#product-tintura").append("<h4>Aún no hay productos</h4>");
            }
          }
        });
      } catch (err) {
        console.error(err);
      } finally {
        system.hideLoader(loaderContainer); // Ocultar el loader después de que se completa la solicitud
      }
    },
    //Modal donde se muestra la descripcion del producto
    singleProduct: function (productId) {
      // Encuentra el producto específico por ID
      const product = this.productos.find(p => p.id == productId);
      if (product) {
        let html = `
          <h5>${product.product_name}  MX $${product.price}</h5>
          <img src="/cisnaturatienda/app/pimg/${product.thumb}" class="card-img-top" alt="...">
          <p>${product.description}</p>                    
          <div class="gap-2 btnAddBuy">
            <button id="product-${product.id}-button" type="button" class="boton-agregar w-100 my-2" 
              onclick="app_home.agregarProducto(${product.id}, 1); $('#productModal').modal('hide');">
              <i class="bi bi-plus-circle-fill"></i>  Añadir al carrito
            </button>
          </div>
        `;
        document.getElementById("productModalBody").innerHTML = html;
        $("#productModal").modal("show"); // Muestra el modal
      } else {
        console.error('Producto no encontrado');
      }
    },
    //metodo para agregar un producto al carrito
    agregarProducto: async function (pid, tt) {
      try {
        $.ajax({
          type: "GET",
          url:this.routes.addproduct + "&pid=" + pid + "&tt=" + tt,
          dataType: "json",
          headers: {
            Authorization: system.http.send.authorization(),
          },
          success: function (result){
            console.log(result);
          },
        })

        const data = await resp.json();
        if (data.r === "success") {
          // Obtener el botón y cambiar el color a success y quitar el outline
          const botonCerrarNotifiacion =
            document.getElementById("cerrarNotificacion");
          botonCerrarNotifiacion.addEventListener("click", () => {
            toaster.classList.add("d-none");
          });
          toaster.classList.remove("d-none");
          const addButton = document.getElementById(`product-${pid}-button`);
          if (addButton) {
            //mostrar el toaster
            toaster.classList.add("activo");
            // Guardar el ícono original y el texto original
            const originalIcon = addButton.querySelector("i").className;
            const originalText = addButton.textContent;
            addButton.classList.remove("boton-agregar");
            addButton.classList.add("boton-activo");
            addButton.innerHTML =
              '<i class="bi bi-bag-plus-fill"></i> Añadido!';
            setTimeout(() => {
              //Ocultar el toast despues de 5 segundos
              toaster.classList.remove("activo"); //toaster
            }, 6000);
            // Restaurar el botón después de 2 segundos
            setTimeout(() => {
              addButton.classList.remove("boton-activo");
              addButton.classList.add("boton-agregar");
              addButton.innerHTML = `<i class="${originalIcon}"></i> ${originalText}`;
            }, 2000); // 2000 milisegundos = 2 segundos
          }

          // Agregar la clase de animación
          const badge = document.querySelector(".badge");
          if (badge) {
            badge.classList.add("animate");
            setTimeout(() => {
              badge.classList.remove("animate");
            }, 1000); // Remover la clase después de 500ms (0.5s)
          }
        } else {
          alert("No se pudo agregar el producto");
          toaster.innerHTML = "No se pudo agregar";
        }
      } catch (error) {
        console.error(error);
      }
    },
  };

  document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM completamente cargado...")
    system.verMasBtn("verMas", "parrafoCompleto");
  });
  app_home.lastPost();
});
