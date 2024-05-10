
const app_car = {
    url: "/cisnatura/app/app.php",    
    routes :{
        pagar : "/cisnatura/resources/views/payments/direccion.php",
    },
    view : function(route){
        location.replace(this.routes[route]);
    },
    user: {
        sv: false,
        id: "",
        tipo: "",
    },
    pe: $('#pedido'),//el contenedor donde esta la lista de productos que seleccionamos
    lp: $('#pago'), //listo para pagar

    loader : $('#cart-loader'),
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
    //Muestra el contenido del carrito
    contentCar: async function(uid) {
        const idUser = uid;
        //console.log(idUser);
        let html = "<h4 class='lead text-muted d-flex justify-content-center'>Todo está tranquilo por aquí<a href='./catalogo.php' class='mx-3' style='text-decoration: none;'><i class='bi bi-plus-square'></i></a></h4>";
        this.pe.html("");

        loaderContainer = this.showLoader();
        try {
            const resp = await fetch(this.url + "?_vcar=" + idUser);
            const caresp = await resp.json();
            if(resp.ok){loaderContainer.style.display = "none";}
            const productos = caresp.filter(producto => producto.active === "1" && producto.cantidad !=="0");               
            const longitud = productos.length;
            const activeProducts = productos.map(producto => producto.active);
            const positiveProducts = productos.map(producto => producto.cantidad);
            console.log(positiveProducts);
            //console.log(activeProducts);
            if (longitud > 0) {                
                html = "";
                const subtotales = [];
                const envio = 200;
                
                for (let product of productos) { 
                        //console.log(product.productId);                       
                        //condicion para verificar si la cantidad agregada es mayor a 1
                        const decLimit = product.cantidad > 1 ? "" : "d-none";
                        const subtotal = parseInt(product.cantidad)*parseFloat(product.price);
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
                                    <a href="javascript:void(0);" onclick="app_car.delProduct(${product.id},${idUser})" class="btnTrash"><i class="bi bi-trash"></i></a>
                                    <div class="d-flex justify-content">
                                        <a href="javascript:void(0);" class="${decLimit}" onclick="app_car.decrementar(${product.productId},${idUser},1)"><i class="bi bi-dash-square"></i></a>
                                            <p class="quantity">${parseInt(product.cantidad)}</p>
                                        <a href="javascript:void(0);" onclick="app_car.incrementar(${product.productId},${idUser},1)"><i class="bi bi-plus-square"></i></a>
                                    </div>
                                    <p>
                                        <span class="subtotal" id="subtotal-${product.id}" data-price="${product.price}">$${subtotal}</span>
                                    </p>
                            </div>
                        </div>                        
                        `;                        
                }
                const subtotal = subtotales.reduce((acc , curr)=>acc + curr, 0);
                this.procederPago(idUser,longitud, subtotal, envio, productos);
            }
            this.pe.html(html);

        } catch (error) {
            console.error(error);
        }finally{
            this.hideLoader(loaderContainer);
        }
    },
    //Elimina producto del carrito
    delProduct: function(pci, uid) {
        //alert("Llego el producto " + pci);
        fetch(this.url + "?_pci=" + pci)
            .then(resp => resp.json())
            .then(data => {
                if (data.r === "success") {
                    this.contentCar(uid); // Actualizar la lista de citas después de eliminar
                    this.procederPago();
                } else {
                    alert("No se pudo borrar");
                }
            }).catch(err => console.error(err));
    },
    //Aumenta la cantidad del producto
    incrementar: function(pid, uid, num) {
        fetch(this.url + "?_incP=" + pid + "&uid=" + uid + "&num=" + num) // Cambia pid por _incP
        .then(resp => resp.json())
        .then(data => {
            if (data.r === "success") {
                this.contentCar(uid); //actualiza la cant de prod añadidos
            } else {
                alert("No se pudo actualizar el INC");
            }
        }).catch(err => console.error(err));
    },
    //Decrementa la cantidad del producto    
    decrementar: function(pid,uid, num){
        fetch(this.url + "?_decP=" + pid + "&uid="+uid+ "&num=" + num)
        .then(resp => resp.json())
        .then(data => {
            if (data.r === "success") {
                this.contentCar(uid); //actualiza la cant de prod añadidos
            } else {
                alert("No se pudo actualizar el DEC");
            }
        }).catch(err => console.error(err));
    },
    //Resumen de lo que se va pagar
    procederPago: function(uid,longitud, subtotal, envio ,productos) {//cuantos productos hay en el carrito, si hay mas de cero se muestra el boton
    this.lp.html("");
    //console.log(longitud);
    const total = subtotal+envio;
    
    const products = productos;
        if (longitud > 0 ) {
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
                    <input type="hidden" id="userId" name="userId" value="${uid}" required>                    
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
            $(function(){
                const pf = $('#payForm');
                pf.on("submit",function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const productsIds = products.map(producto => producto.productId);
                    const productQuant = products.map(producto => producto.cantidad);
                        // Crear un objeto con propiedades separadas para los IDs y cantidades
                        const productsData = {
                            productsIds: productsIds,
                            productQuantities: productQuant
                        };
                    // Convertir el objeto a JSON
                    const productsJson = JSON.stringify(productsData);
                    console.log(productsJson);
                    // const productsJson = JSON.stringify({ productsIds: productsIds });
                    // console.log(productsJson);

                    const data = new FormData();
                    data.append("userId",$("#userId").val());
                    data.append("subtotal",$("#subtotal").val());
                    data.append("productsData", productsJson);
                    data.append("envio",$("#envio").val());
                    data.append("total",$("#total").val());
                    data.append("status",$("#status").val());
                    data.append("_order","");
                    fetch("/cisnatura/app/app.php",{
                        method: "POST",
                        body: data                    
                    }).then(resp => resp.json())
                      .then(respdos => {
                        console.log(respdos);

                        const parsedResponse = JSON.parse(respdos.r);

                        if (Array.isArray(parsedResponse) && parsedResponse.length > 0) {
                            const tempId = parsedResponse[0].id;
                            console.log(tempId);
                            document.cookie = `cart=${tempId}`;
                            const exists = document.cookie.split(';').some(function (item) {
                                return item.trim().indexOf('cart=') == 0;
                            });
                
                            let cartValue = null;
                            if (exists) {
                                const cartCookie = document.cookie.split('; ')
                                    .find(cookie => cookie.startsWith('cart='));
                                if (cartCookie) {
                                    cartValue = cartCookie.split('=')[1];
                                }
                            }
                            // La variable cartValue se tiene que hashear para mandarla sin que se muestre al cliente
                            const urltempid = "/cisnatura/resources/views/payments/direccion.php?_temp=" + cartValue;
                            location.href = urltempid;
                        } else {
                            console.error("La respuesta no tiene la estructura esperada.");
                        }                      
                    }).catch(err => console.error(err));
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