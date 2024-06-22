$(document).ready(() => {
    var url = V_Global + "app/services/routes/create.route.php";
    create_product = {
        routes: {
            //rutas de funciones del home
            crear: url + "?_create",            
        },      
            view: function (route) {
            location.replace(this.routes[route]);
        },

        cp : $("#create-product"),
        loadContent: function(){
          var self = this;
          let html = "<h2>cargando</h2>";
          this.cp.html(html);
            html = `
            <h3 class="title-card">Sube tu Producto</h3>
            <form action="" id="form-product" method="POST" enctype="multipart/form-data">
                <div class="card shadow">
                    <div class="card-body">
                        <select class="form-select" name="type" aria-label="Default select example" required>
                            <option selected disabled>Selecciona un tipo de producto</option>
                            <option value="tintura">Tintura</option>
                            <option value="cds">Dioxido De Cloro</option>
                            <option value="curso">Curso/taller</option>
                            <option value="otro">Otro</option>
                        </select>
                        <div class="mb-3 mt-2">
                            <label for="product_name" class="form-label">Nombre del Producto</label>
                            <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Ejemplo: Tintura" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción del Producto</label>
                            <textarea name="description" id="description" class="form-control" cols="20" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="thumb" class="form-label">Sube una imagen para mostrar tu producto</label>
                            <input class="form-control" name="thumb" type="file" id="thumb" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio del producto</label>
                            <input type="text" name="price" class="form-control price-form" placeholder="$" aria-label="price" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Guardar<i class="bi bi-download"></i></button>
                    </div>
                </div>
            </form>
            `;
            self.cp.html(html);
        },

        createPost: function(){
            var form = document.getElementById('form-product'); // Asegúrate de que este es el ID correcto de tu formulario
            if (!form) {
                console.error('El formulario no fue encontrado en la página.');
                return;
            }
        
            form.addEventListener('submit', function (e) {
                e.preventDefault();
        
                var formData = new FormData(form);
                formData.append('_create', '1'); // Asegúrate que el servidor reconozca esta solicitud como una creación
        
                $.ajax({
                    url: url + "?_create", // Asegúrate que esta es la URL correcta
                    type: 'POST',
                    data: formData,
                    processData: false, // Importante: no procesar los datos
                    contentType: false, // Importante: no establecer un tipo de contenido
                    headers: {
                        Authorization: system.http.send.authorization(),
                    },
                    success: function (response) {
                        console.log("Respuesta del servidor: ", response);
                        // Aquí puedes manejar la respuesta del servidor
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la petición AJAX: ", xhr.responseText);
                    }
                });
            });

        },
    };
    create_product.loadContent();
    create_product.createPost();
});