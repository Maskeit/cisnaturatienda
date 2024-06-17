var catalogo_admin;
$(document).ready(() => {
  var url = V_Global + "app/services/routes/ad.route.php";
catalogo_admin = {
    routes: {
      //rutas de funciones del home
      posts: url + "?_posts",
      dp: url + "?_dp",
      editP : url,
    },

    view: function (route) {
      location.replace(this.routes[route]);
    },

    postsContent: $("#posts"),
    allProducts: [],

    initData: function () {
      var self = this;
      var catalogoContent = localStorage.getItem("catalogoContent");
      var lastUpdate = localStorage.getItem("lastUpdate");
      var currentTime = new Date().getTime();
      var updateInterval = 3600000;
      if (
        catalogoContent &&
        lastUpdate &&
        currentTime - lastUpdate < updateInterval
      ) {
        system.http.send.authorization();
        catalogoContent = JSON.parse(catalogoContent);
        self.allProducts = catalogoContent;
        self.displayPosts(catalogoContent);
      } else {
        this.loadPosts();
      }
    },
    loadPosts: function () {
      var self = this;
      $.ajax({
        type: "GET",
        url: this.routes.posts,
        dataType: "json",
        headers: {
          Authorization: system.http.send.authorization(),
        },
        success: function (response) {
          console.log("se tiene que hacer la peticiion");
          self.allProducts = response;
          localStorage.setItem(
            "catalogoContent",
            JSON.stringify(self.allProducts)
          );
          localStorage.setItem("lastUpdate", new Date().getTime());
          self.displayPosts(self.allProducts);
        },
        error: function (error) {
          console.error("Error: " + error);
        },
      });
    },
    displayPosts: function (productos) {
      //console.log("llegaron los productos ", productos);
      var html = "<p>Cargando productos</p>";
      if (productos.length > 0) {
        html = productos.map(product => `
                <div class="product-card" data-product-id="${product.id}" >
                    <div class="product-image">
                        <img src="/cisnaturatienda/app/pimg/${product.thumb}" alt="Product Image">
                        <div class="card-overlay">
                            <span class="ovtext">
                                Ver detalles <i class="bi bi-eye-fill eyeColor"></i>
                            </span>
                        </div>
                    </div>
                    <div class="product-info placeholder-glow">
                        <span class="product-name ">${product.product_name}</span>
                        <span class="product-price">MX $${product.price}</span>
                    </div>
                </div>
            `
          ).join("");
        this.postsContent.html(html);
        $(".product-card").on("click", function () {
          const productId = parseInt($(this).data("product-id"), 10);
          //console.log(productId);
          catalogo_admin.singleProduct(productId);
        });
      } else {
        html = "<p>No se encontraron productos</p>";
        this.postsContent.html(html);
      }
    },
    //descriipcion del producto
    singleProduct: function (productId) {
      self = this;
      console.log("Llego el producto", productId);
      // Encuentra el producto específico por ID desde el array allProducts
      const product = this.allProducts.find((p) => p.id == productId);
      if (product) {
        let html = `
        <form id="editProduct" action="" enctype="multipart/form-data">
            <div class="card-body">
                <input type="hidden" id="id" name="id" value="${product.id}">
                <label>Tipo de producto</label>
                <select id="typeProduct" class="form-select" name="type" aria-label="Default select example">
                    <option selected>${product.type}</option>
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
        </form> `;
        document.getElementById("productModalBody").innerHTML = html;
        $("#productModal").modal("show"); // Muestra el modal

        //peticion para editar producto
        $(function() {
            const ep = $("#editProduct");
            ep.on("submit", function (e) {
                e.preventDefault();
                e.stopPropagation();
                const data = new FormData();
                data.append("type", $("#typeProduct").val());
                data.append("product_name", $("#product_name").val());
                data.append("description", $("#description").val());
                data.append("price", $("#price").val());
                data.append("id", $("#id").val());
                data.append("_editproduct", "");
                // Obtén el archivo seleccionado en el campo de imagen (si se seleccionó uno)
                const thumbInput = document.getElementById("thumb");
                if (thumbInput.files.length > 0) {
                data.append("thumb", thumbInput.files[0]);
                }

                $.ajax({
                    type: "POST",
                    url: self.routes.editP,
                    processData: false,  // importante para el envío de FormData
                    contentType: false,  // importante para el envío de FormData
                    data: data,
                    headers: {
                        Authorization: system.http.send.authorization(),
                    },
                    success: function (response) {
                        console.log("Update state: ", response);
                        if(response.response == false){
                            alert(response);   
                            return;
                        }
                        self.allProducts = response;
                        //localStorage.setItem("catalogoContent", JSON.stringify(self.allProducts));
                        //localStorage.setItem("lastUpdate", new Date().getTime());
                        self.displayPosts(self.allProducts);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error updating product: ", xhr.responseText);
                    }
                });            
            });
        })
      } else {
        alert("Producto no encontrado");
      }
    },


    deleteProduct: function(pid){
        console.log(pid);
        $.ajax({
            type: "POST",
            url: this.routes.dp,
            dataType: "json",
            headers: {
                Authorization: system.http.send.authorization(),
            },
            data: {
                id: pid
            },
            success: function (response) {
                self.allProducts = response;
                localStorage.setItem(
                    "catalogoContent",
                    JSON.stringify(self.allProducts)
                );
                localStorage.setItem("lastUpdate", new Date().getTime());
                self.displayPosts(self.allProducts);
            },
            error: function (error) {
                console.error("Error: " + error);
            },
        });
    }
  };

  catalogo_admin.initData();
});
