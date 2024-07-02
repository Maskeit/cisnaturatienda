var catalogo_admin;
$(document).ready(() => {
  var url = V_Global + "app/services/routes/ad.route.php";
  $('#search-input').on('input', function() {
    const keyword = $(this).val();
    catalogo_admin.searchProducts(keyword);
  });
  catalogo_admin = {
    routes: {
      //rutas de funciones del home
      posts: url + "?_posts",
      dp: url + "?_dp",
      editP : url + "?_editproduct",
    },

    view: function (route) {
      location.replace(this.routes[route]);
    },
    
    postsContent: $("#posts"),
    allProducts: [],
    
    // metodo para buscar productos 
    searchProducts: function(keyword) {
      const searchResults = this.allProducts.filter(product =>
          product.product_name.toLowerCase().includes(keyword.toLowerCase()) ||
          product.description.toLowerCase().includes(keyword.toLowerCase())
      );
      this.displayPosts(searchResults);
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
    //hace la peticion para traer los productos
    // hace la peticion para traer los productos
    loadPosts: function () {
      var self = this;
      try {
        $.ajax({
          type: "GET",
          url: this.routes.posts,
          dataType: "json",
          headers: {
            Authorization: system.http.send.authorization(),
          },
          success: function (response) {
            if (!response) {
              console.error("No response from the server");
              system.clearCookiesAndRedirect();
              return;
            }
            if (!Array.isArray(response)) {
              console.error("Data is not an array:", response);
              system.clearCookiesAndRedirect();
              return;
            }
            self.allProducts = response;
            self.displayPosts(self.allProducts);
          },
          error: function (error) {
            console.error("Error: " + error);
          },
        });
      } catch (err) {
        console.error("Error: " + err);
        system.clearCookiesAndRedirect();
      }
    },
    //muestra los productos en el catalogo despues de cargarlos
    displayPosts: function (productos) {
      var html = "<p>Cargando productos</p>";
      if (Array.isArray(productos) && productos.length > 0) {
        html = productos.map(product => `
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
                    <div class="wcf-left"><span class="price">${product.active == 1 ? "Habilitado" : "Deshabilitado"}</span></div>
                    <div class="wcf-right">
                      <span class="">stock: 12</span>
                    </div>
                  </div>
              </div>
            </div>
            `
        ).join("");
        this.postsContent.html(html);
        $(".wsk-cp-product").on("click", function () {
          const productId = parseInt($(this).data("product-id"), 10);
          //console.log(productId);
          catalogo_admin.singleProduct(productId);
        });
      } else {
        html = "<p>No se encontraron productos</p>";
        this.postsContent.html(html);
      }
    },

    //descriipcion del producto y form para editar el producto
    singleProduct: async function (productId) {
      self = this;
      // Encuentra el producto específico por ID desde el array allProducts
      const product = this.allProducts.find((p) => p.id == productId);
      if (product) {
        let html = `
        <form action="" id="form-product" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <input type="hidden" id="id" name="id" value="${product.id}">
                <label>Tipo de producto</label>
                <select id="typeProduct" class="form-select" name="type" aria-label="Default select example">
                    <option selected class="bg-primary">${product.type}</option>
                    <option value="tintura">Tintura</option>
                    <option value="cds">Dioxido De Cloro</option>
                    <option value="curso">Curso/taller</option>
                    <option value="otro">Otro</option>
                </select>
        
                <!-- Campo editable: Nombre del Producto -->
                <div class="mb-3 mt-2">
                    <label for="product_name" class="form-label">Nombre del Producto</label>
                    <input id="product_name" type="text" name="product_name" class="form-control" value="${product.product_name}">
                </div>
        
                <!-- Campo editable: Descripción del Producto -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción completa del Producto</label>
                    <textarea name="description" id="description" class="form-control" cols="10" rows="5">${product.description}</textarea>
                </div>
        
                <!-- Campo editable: Imagen del Producto -->
                <div class="mb-3">
                    <label for="thumb" class="form-label">Actualizar imagen del producto</label>
                    <input id="thumb" class="form-control" name="thumb" type="file">
                </div>
        
                <!-- Campo editable: Precio del Producto -->
                <div class="mb-3">
                    <label for="price" class="form-label">Precio del producto</label>
                    <input id="price" type="text" name="price" class="form-control" value="${product.price}" aria-label="price">
                </div>
            </div>
        
            <div class="card-footer">
                <button class="btn btn-secondary" type="button" onclick="catalogo_admin.deleteProduct(${product.id})">Eliminar producto <i class="bi bi-trash"></i></button>
                <button class="btn btn-primary" type="submit">Guardar Cambios <i class="bi bi-download"></i></button>
                <a href="#" class="btn btn-link active" onclick="catalogo_admin.toggleProductActive(${product.id})">
                    <i class="bi bi-toggle toggleBtn"></i>
                </a>
            </div>
        </form> 
        `;
        document.getElementById("productModalBody").innerHTML = html;
        ClassicEditor.create(document.querySelector('#description')).catch(error => {
            console.error(error);
        });
        $("#productModal").modal("show"); // Muestra el modal

        var form = document.getElementById('form-product');
        form.onsubmit = async function(e) {
            e.preventDefault();
            var formData = new FormData(form);
            formData.append('_editproduct', '1');
            try {
                const response = await fetch(self.routes.editP, {
                    method: "POST",
                    headers: {
                      Authorization: system.http.send.authorization(),
                    },
                    body: formData,
                });
                const data = await response.json();
                $("#productModal").modal("hide"); // Cerrar el modal
                if (!data.response) {
                  $("#toaster-c p").text("Hubo un error, inténtelo de nuevo más tarde.");
                  $("#toaster-c").removeClass("d-none").addClass("activo").css("background", "var(--ciserror)");
                } else {
                    $("#toaster-c p").text("Se ha actualizado el producto correctamente!");
                    $("#toaster-c").removeClass("d-none").addClass("activo").css("background", "var(--cisgreen-400)");
                    self.loadPosts();
                }
                setTimeout(() => {
                    $("#toaster-c").addClass("d-none").removeClass("activo");
                }, 4000);
            } catch (error) {
                console.error("Error en la petición: ", error);
            }
        };
        $("#cerrarNotificacion").on("click", function() {
            $("#toaster-c").addClass("d-none").removeClass("activo");
        });
      } else {
          alert("Producto no encontrado");
          console.error("Not found");
      }
    },
    //eliminar producto de la base de datos
    deleteProduct: async function(pid) {

      if (!confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        return;
      }      
      try {
          var self = this;
          const body = new URLSearchParams();
          body.append("pid", pid);
          body.append("_dp", "1");
  
          const response = await fetch(this.routes.dp, {
              method: "POST",
              headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
                  Authorization: system.http.send.authorization(),
              },
              body: body,
          });
  
          const data = await response.json(); // Asegúrate de que el servidor devuelve una respuesta JSON
          if (data.response === true) {
              console.log("Producto eliminado correctamente");
              // Recargar o actualizar la lista de productos
              self.loadPosts();
          } else {
              console.error("No se pudo eliminar el producto:", data.response);
          }
      } catch (error) {
          console.error("Error: " + error);
      }
    },
  
  };

  catalogo_admin.loadPosts();
  catalogo_admin.initSearch();
});
