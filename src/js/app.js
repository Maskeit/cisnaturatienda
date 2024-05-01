$(document).ready(() =>{
var url = V_Global + "app/services/routes/catalogo.route.php";

  const toaster = document.getElementById("toaster");

  //Este es el formulario
  const formularioBuscador = $("#form-buscador");
  formularioBuscador.on("submit", function (event) {
    event.preventDefault(); // Evita que el formulario se envíe automáticamente
    app.buscar(); // llama el metodo buscar de app
  });
  //Este es el input
  const buscarPalabra = $("#buscar-palabra");
  let timeoutId;
  buscarPalabra.on("input", function () {
    clearTimeout(timeoutId); // Reinicia el temporizador cada vez que se ingresa una letra

    // Configura un temporizador para ejecutar la búsqueda después de 500 milisegundos (medio segundo)
    timeoutId = setTimeout(function () {
      app.palabraClave = buscarPalabra.val();
      // Realiza la búsqueda y actualiza la vista de productos
    }, 500);
  });

  const app = {
    routes: {
      carrito: V_Global + "src/views/carrito.php",
      catalogo: V_Global + "src/views/catalogo.php",

      address: url, // a donde enviamos los datos del domicilio para guardarlos
      traerProductos: url + "?_tp=", //traer los productos
      singleproduct: url, //pedir el producto seleccionado

      //botones de compra y add
      addproduct: url,
      vercant: url,

    },
    view: function (route) {
      location.replace(this.routes[route]);
    },
    currentType: "",
    palabraClave: "",

    ad: $("#aviso"),
    fp: $("#filter-products"),
    fpAlt: $("#filter-products-alt"),
    pc: $("#product-card"),
    pagC: $("#pagination-container"),    
    padd: $("#toastContainer"),
    btnCart: $("#toggleBtnCart"),
    noResultsMessage: $("#no-results-message"),

    loader: $("#products-loader"),
    //Filtro de productos
    listProducts: function (toggle) {
      let html = `<h4>Filter Product disabled</h4>`;
      this.fp.html("");
      this.currentType = toggle;
      const all = toggle === "todo" ? true : false;
      const tta = toggle === "tintura" ? true : false;
      const tcds = toggle === "cds" ? true : false;
      const tcrs = toggle === "curso" ? true : false;
      const totr = toggle === "otro" ? true : false;
      const pack = toggle === "paquetes" ? true : false;

      html = `
          <ul class="ul-filter">
              <li class="lgi ${all ? "active" : ""}" onclick="app.productView('todo')">Todos los productos </li>
              <li class="lgi ${tta ? "active" : ""}" onclick="app.productView('tintura')">Tinturas </li>
              <li class="lgi ${tcds ? "active" : ""}" onclick="app.productView('cds')">Dioxido de cloro</li>
              <li class="lgi ${tcrs ? "active" : ""}" onclick="app.productView('curso')">Cursos</li>
              <li class="lgi ${pack ? "active" : ""}" onclick="app.productView('paquetes')">Paquetes</li>
              <li class="lgi ${totr ? "active" : ""}" onclick="app.productView('otro')">Productos Naturales</li>
          </ul>

          `;
      this.fp.html(html);
    },
    //listProducts Alternativo
    listProductsAlt: function (toggle) {
      let html = `<h4>Filter Product disabled</h4>`;
      this.fpAlt.html("");
      this.currentType = toggle;
      const all = toggle === "todo" ? "selected" : "";
      const tta = toggle === "tintura" ? "selected" : "";
      const tcds = toggle === "cds" ? "selected" : "";
      const tcrs = toggle === "curso" ? "selected" : "";
      const totr = toggle === "otro" ? "selected" : "";
      const pack = toggle === "paquetes" ? "selected" : "";
      html = `
              <div class="input-group">
                  <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                      <option value="todo">Todos los productos...</option>
                      <option value="tintura" ${tta}>Tinturas</option>
                      <option value="cds" ${tcds}>Dioxido de cloro</option>
                      <option value="curso" ${tcrs}>Cursos</option>
                      <option value="paquetes" ${pack}>Paquetes</option>
                      <option value="otro" ${totr}>Productos naturales</option>
                  </select>
              </div>`;
      this.fpAlt.html(html);

      // Manejar cambios en el select para actualizar la vista
      $("#inputGroupSelect04").on("change", function () {
        const selectedOption = $(this).val();
        app.productView(selectedOption);
      });
    },
    //Metodo para buscar Productos o filtrar la busqueda
    buscar: function () {
      this.palabraClave = buscarPalabra.val();
      this.productView();
    },

    hideLoader: function (loaderContainer) {
      loaderContainer.style.display = "none";
    },
    productos: [],
    //Se muestran todos los productos al catalogo
    productView: async function (tipo = "todo") {
      const self = this;
      this.ad.html("");
      const loaderContainer = system.showLoader();
      let foundProducts = false;
      let advice = `
          <div class="alert-session" role="alert">
              <button type="button" onclick="app.view('inisession')" class="sessionAlertButton nav-link  btn btn-link">Inicia Sesión</button> para que puedas comprar y agregar productos
          </div>
          `;
      // if (this.user.sv == false) {
      //   this.ad.html(advice);
      // }
      let html =  "<p class='p-message'>Cargando Productos...</p>";
      this.pc.html(html);
      try {
        $.ajax({
          type: "GET",
          url: this.routes.traerProductos + tipo,
          dataType: "json",
          headers: {
            Authorization: system.http.send.authorization(),
          },
          success: function (products){
            //console.log(products);
            if (products.length > 0) {
              app.productos = products;
              loaderContainer.style.display = "none";
              let html = ""; // Cambiado a let para que se pueda modificar dentro del bucle
              let hasResults = false; // Variable para controlar si se han encontrado productos
          
              for (let product of products) {
                  if (self.palabraClave === "" || // Filtrado por palabra clave
                      product.product_name.toLowerCase().includes(self.palabraClave.toLowerCase()) ||
                      product.description.toLowerCase().includes(self.palabraClave.toLowerCase())) {
                      // Si el producto está activo se mostrará
                      html += ` 
                          <div class="product-card" data-product-id="${product.id}" >
                              <div class="product-image">
                                  <img src="/cisnatura/app/pimg/${product.thumb}" alt="Product Image">
                                  <div class="card-overlay">
                                      <span class="ovtext">
                                          Ver detalles <i class="bi bi-eye-fill eyeColor"></i>
                                      </span>
                                  </div>
                              </div>
                              <div class="product-info placeholder-glow">
                                  <span class="product-name ">${product.product_name}</span>
                                  <span class="product-price">MX $${product.price}</span>
                                  <div class="gap-2 btnAddBuy ">
                                      <button id="product-${product.id}-button" type="button" class="boton-agregar w-100 my-2">
                                          <i class="bi bi-plus-circle-fill"></i>  Añadir al carrito
                                      </button>
                                  </div>
                              </div>
                          </div>
                      `;
                      hasResults = true; // Se ha encontrado al menos un producto
                  }
              }
          
              if (hasResults) {
                  // Se encontraron productos que coinciden con la búsqueda
                  self.pc.html(html);
                  self.noResultsMessage.hide();

                  $('.product-card').on('click', function() {
                    const productId = $(this).data('product-id');
                    app.singleProduct(productId);
                  });

                  $('.boton-agregar').on('click', function(e) {
                    e.stopPropagation();
                    const productId = $(this).closest('.product-card').data('product-id');
                    app.agregarProducto(productId, 1);
                  });
              } else {
                  // No se encontraron productos que coincidan con la búsqueda
                  self.pc.html(`<div><p class='p-message'>No hay resultados para <strong>${self.palabraClave}</strong></p><div>`);
                  self.noResultsMessage.show();
              }
          
              app.listProducts((self.currentType = tipo)); // el tipo de producto que se muestra al dar click
              app.listProductsAlt((self.currentType = tipo));
            } else if (products.length == 0) {
              let html = "<p class='p-message' >No hay productos para mostrar hoy</p>";
              self.pc.html(html);
            }
          }
        });

      } catch (error) {
          console.log(error);
      } finally {
          system.hideLoader(loaderContainer);
      }
    },
    agregarProducto: async function (pid, cantidad) {
      try {
        // Construye el cuerpo de la petición POST
        const body = new URLSearchParams();
        body.append('pid', pid);
        body.append('cantidad', cantidad);
        body.append('_ap', '1'); // Este podría ser tu indicador en el servidor para añadir al carrito
    
        const resp = await fetch(this.routes.addproduct, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            Authorization: system.http.send.authorization(),
          },
          body: body
        });
    
        const response = await resp.json();
        if (response.r === "success") {
          console.log("Producto agregado al carrito:", response);
        } else {
          console.error("Error agregando producto:", response);
        }
      } catch (error) {
        console.error("Error en la petición para agregar producto:", error);
      }
    },
    

    
    //Modal donde se muestra la descripcion del producto
    singleProduct: function (productId) {
      console.log(productId);
      // Encuentra el producto específico por ID
      const product = this.productos.find(p => p.id == productId);
      if (product) {
        let html = `
          <h5>${product.product_name}  MX $${product.price}</h5>
          <img src="/cisnatura/app/pimg/${product.thumb}" class="card-img-top" alt="...">
          <p>${product.description}</p>                    
          <div class="gap-2 btnAddBuy">
            <button id="product-${product.id}-button" type="button" class="boton-agregar w-100 my-2" 
              onclick="app.agregarProducto(${product.id}, 1, 1); $('#productModal').modal('hide');">
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
    // agregarProducto: async function (pid, uid, tt) {
    //   const resp = await fetch(
    //     this.routes.addproduct + "&pid=" + pid + "&uid=" + uid + "&tt=" + tt
    //   );
    //   const data = await resp.json();
    //   try {
    //     if (data.r === "success") {
    //       this.verCant(uid);
    //       // Obtener el botón y cambiar el color a success y quitar el outline
    //       const botonCerrarNotifiacion =
    //         document.getElementById("cerrarNotificacion");
    //       botonCerrarNotifiacion.addEventListener("click", () => {
    //         toaster.classList.add("d-none");
    //       });
    //       toaster.classList.remove("d-none");
    //       const addButton = document.getElementById(`product-${pid}-button`);
    //       if (addButton) {
    //         //mostrar el toaster
    //         toaster.classList.add("activo");
    //         // Guardar el ícono original y el texto original
    //         const originalIcon = addButton.querySelector("i").className;
    //         const originalText = addButton.textContent;
    //         addButton.classList.remove("boton-agregar");
    //         addButton.classList.add("boton-activo");
    //         addButton.innerHTML = '<i class="bi bi-bag-plus-fill"></i> Añadido!';
    //         setTimeout(() => {
    //           //Ocultar el toast despues de 5 segundos
    //           toaster.classList.remove("activo"); //toaster
    //         }, 6000);
    //         // Restaurar el botón después de 2 segundos
    //         setTimeout(() => {
    //           addButton.classList.remove("boton-activo");
    //           addButton.classList.add("boton-agregar");
    //           addButton.innerHTML = `<i class="${originalIcon}"></i> ${originalText}`;
    //         }, 2000); // 2000 milisegundos = 2 segundos
    //       }

    //       // Agregar la clase de animación
    //       const badge = document.querySelector(".badge");
    //       if (badge) {
    //         badge.classList.add("animate");
    //         setTimeout(() => {
    //           badge.classList.remove("animate");
    //         }, 1000); // Remover la clase después de 500ms (0.5s)
    //       }
    //     } else {
    //       alert("No se pudo agregar el producto");
    //       toaster.innerHTML = "No se pudo agregar";
    //     }
    //   } catch (error) {
    //     console.error(error);
    //   }
    // },
    // //Metodo para mostrar la cantidad de productos en el carrito
    // verCant: async function (uid) {
    //   this.btnCart.html("");

    //   try {
    //     const response = await fetch(this.routes.vercant + "?_np=" + uid);
    //     const data = await response.text();

    //     const cantidad = JSON.parse(data);
    //     const num = cantidad[0].tt === "0" ? "" : cantidad[0].tt;
    //     if (num) {
    //       let btnHtml = "";
    //       btnHtml = `
    //                   <button class="btnCarrito" onclick="app.view('carrito')">
    //                           Carrito <i class="bi bi-cart-fill"></i>  <span class="badge bg-danger animate">${num}</span>
    //                   </button>
    //                   <button class="btnCarritoAlt" onclick="app.view('carrito')">
    //                       <i class="bi bi-cart-fill"></i>  <span class="badge bg-danger animate">${num}</span>
    //                   </button>
    //                 `;
    //       this.btnCart.html(btnHtml);
    //       // Agrega la clase "animate" al span para la animación
    //     }
    //   } catch (error) {
    //     console.error(error);
    //   }
    // },
  };
  window.app = app;
  app.productView();
});