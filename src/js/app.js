$(document).ready(() => {
  var url = V_Global + "app/services/routes/catalogo.route.php";
  $('#search-input').on('input', function() {
    const keyword = $(this).val();
    app.searchProducts(keyword);
  });
  const app = {
    allProducts : [],
    routes: {
      carrito: V_Global + "src/views/carrito.php",
      catalogo: V_Global + "src/views/catalogo.php",
      address: url, // a donde enviamos los datos del domicilio para guardarlos
      traerProductos: url + "?_tp", //traer los productos
      singleproduct: url, //pedir el producto seleccionado

      //botones de compra y add
      addproduct: url + "?_ap",
      vercant: url,
    },
    view: function (route) {
      location.replace(this.routes[route]);
    },

    fp: $("#filter-products"),
    fpAlt: $("#filter-products-alt"),
    pc: $("#product-card"),
    pagC: $("#pagination-container"),
    padd: $("#toastContainer"),
    btnCart: $("#viewCart"),
    noResultsMessage: $("#no-results-message"),
    noProductsFound: $("#no-products"),
    btnBuscar: $("#btn-buscar"),

    //Filtro de productos
    listProducts: function () {
      const categories = [
          { name: "Todos los productos", type: "todo" },
          { name: "Tinturas", type: "tintura" },
          { name: "Dióxido de cloro", type: "cds" },
          { name: "Cursos", type: "curso" },
          { name: "Paquetes", type: "paquetes" },
          { name: "Productos Naturales", type: "otro" }
      ];
      let html = categories.map(cat => `
          <li class="lgi ${this.currentType === cat.type ? "active" : ""}" data-type="${cat.type}">
              ${cat.name}
          </li>
      `).join("");
      html = `<ul class="ul-filter">${html}</ul>`;
      this.fp.html(html);

      // Evento para filtrar productos por categoría
      $(".lgi").on("click", function() {
          const type = $(this).data("type");
          app.currentType = type;
          app.filterProductsByType(type);
          $(".lgi").removeClass("active"); // Remueve la clase active de todos
          $(this).addClass("active"); // Añade la clase active solo al que fue clickeado
      });
    },
    listProductsAlt: function () {
    const categories = [
        { name: "Todos los productos", type: "todo" },
        { name: "Tinturas", type: "tintura" },
        { name: "Dióxido de cloro", type: "cds" },
        { name: "Cursos", type: "curso" },
        { name: "Paquetes", type: "paquetes" },
        { name: "Productos Naturales", type: "otro" }
    ];

    let html = `
        <div class="input-group">
            <select class="form-select" id="productFilterSelect" aria-label="Selecciona una categoría">
                ${categories.map(cat => `<option value="${cat.type}" ${this.currentType === cat.type ? "selected" : ""}>${cat.name}</option>`).join("")}
            </select>
        </div>
    `;
    this.fpAlt.html(html);

    // Evento para cambiar la vista de productos basada en la selección del usuario
    $("#productFilterSelect").on("change", function() {
        const selectedType = $(this).val();
        app.filterProductsByType(selectedType);
    });
    },
    loadProducts : function (){
      const self = this;
      $.ajax({
        type:"GET",
        url: this.routes.traerProductos,
        dataType: "json",
        headers: {
          Authorization: system.http.send.authorization(),
        },
        success: function(response){
          self.allProducts = response; // Asegúrate de que esto está asignando datos
          self.displayProducts(response); // Llama a mostrar productos alt 0
        },
        error: function(error){
          console.error("Error: " + error);
        }
      });
    },
    filterProductsByType : function(type){
      // Filtra los productos según la categoría seleccionada o todo "que miedo "
      if (type === "todo") {
        this.displayProducts(this.allProducts);
        return;
      }
      const filteredProducts = this.allProducts.filter(product => product.type === type);
      filteredProducts.length > 0 ? this.displayProducts(filteredProducts) : this.displayProducts([]);
    },
    // metodo para buscar productos 
    searchProducts: function(keyword) {
        const searchResults = this.allProducts.filter(product =>
            product.product_name.toLowerCase().includes(keyword.toLowerCase()) ||
            product.description.toLowerCase().includes(keyword.toLowerCase())
        );
        this.displayProducts(searchResults);
    },
    // Inicializa los eventos del formulario de búsqueda
    initSearch: function() {
      const self = this; // Referencia a la instancia de app para uso en callbacks

      $('#form-buscador').on('submit', function(event) {
          event.preventDefault(); // Detiene la recarga de la página
          const keyword = $('#search-input').val().trim();
          if (keyword) {
              self.searchProducts(keyword);
          }
      });

      $('#search-input').on('input', function() {
          const keyword = $(this).val().trim();
          if (keyword) {
              self.searchProducts(keyword);
          }
      });
    },
    displayProducts: function(allProducts){
      if(allProducts.length > 0){
      const html = allProducts.map(product => `
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
      `).join("");
        this.pc.html(html);
        // Evento para ver detalles del producto
        $(".wsk-cp-product").on("click", function () {
          const productId = parseInt($(this).data("product-id"), 10);
          app.singleProduct(productId);
        });
        // Evento para agregar al carrito, deteniendo la propagación para no activar el evento del product card
        $(".buy-btn").on("click", function(e) {
          e.stopPropagation(); // Detiene la propagación del evento para no disparar el click del card
          const productId = $(this).closest('.wsk-cp-product').data("product-id");
          app.agregarProducto(productId, 1);
        });        
      } else{
        html = `<p>No se encontraron resultados.</p>`;
        this.pc.html(html); // sobre escribir el contenedor de productos
      }
    },
    //Metodo para mostrar la cantidad de productos en el carrito
    verCant: function () {
      var self = this;
      self.btnCart.html("");
      try {
        $.ajax({
          type: "GET",
          url: this.routes.vercant + "?_np",
          dataType: "json",
          headers: {
            Authorization: system.http.send.authorization(),
          },
          success: function (response) {
            const num = response;
            if (num > 0) {
              let btnHtml = `
                <button class="cart-btn" onclick="app.view('carrito')">
                  Carrito <i class="bi bi-cart-fill"></i> <span class="badge bg-danger animate">${num}</span>
                </button>
                <button class="cart-btn-alt" onclick="app.view('carrito')">
                  <i class="bi bi-cart-fill"></i> <span class="badge bg-danger animate">${num}</span>
                </button>
              `;
              self.btnCart.html(btnHtml);
            }
          },
          error: function (xhr, status, error) {
            alert("Error al obtener la cantidad del carrito:", error);
          },
        });
      } catch (error) {
        console.error("Error en la configuración de AJAX:", error);
      }
    },
    //metodo para agregar productos al carrito del usuario
    agregarProducto: async function (pid, cantidad) {
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
          app.verCant();
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
    //Modal donde se muestra la descripcion del producto
    singleProduct: function(productId) {
      // Encuentra el producto específico por ID desde el array allProducts
      const product = this.allProducts.find(p => p.id == productId);
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
          alert("Producto no encontrado");
      }
    },
  };
  window.app = app;
  app.loadProducts();
  app.verCant();
  app.initSearch();
  app.listProducts();
  app.listProductsAlt();
});