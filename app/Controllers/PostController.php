<?php

    namespace Controllers;

    use Models\user;
    use Models\products;
    use Models\product_order;
    use Controllers\auth\LoginController as LoginController;


class PostController {

    public function __construct(){
        $ua = new LoginController();
    }

/**
 * Method to create a new product in the system.
 *
 * @param array $datos An associative array containing the product data.
 * @return bool Returns true if the product is created and image uploaded successfully, false otherwise.
 */
    /********************** Métodos para el manejo de los productos ***************** */
    public function createProduct($datos) {
        $response = [
			'success' => false,
			'message' => 'Error inicial'
		];
        if(!isset($datos['type'], $datos['product_name'], 
        $datos['description'], $datos['price']) ){
			$response['message'] = 'campos faltantes';
			return $response;
        }
        $product = new products();
        
        $check = @getimagesize($_FILES['thumb']['tmp_name']);
        if ($check === false) {
			$response['message'] = 'Archivo no valido';
			return $response;
        }

        $type = $datos['type'];
        $product_name = $datos['product_name']; 
        $description = $datos['description']; 
        $thumb = $_FILES['thumb']['name']; 
        $price = $datos['price'];

        $product->valores = [
            $type,
            $product_name, 
            $description, 
            $thumb, 
            $price ];

        $result = $product->create();

        if(!$result){
			$response['message'] = 'Internal server error';
			return $response;
        }
        // La imagen solo se guarda si el producto fue creado exitosamente """"
        $carpeta_destino = __DIR__ . '/../../app/pimg/';
        if (!is_dir($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        $archivo_subido = $carpeta_destino . $_FILES['thumb']['name'];
        if (!move_uploaded_file($_FILES['thumb']['tmp_name'], $archivo_subido)) {
			$response['message'] = 'Error al subir el archivo';
			return $response;
        }

        // si no hay errores retornamos un true
        $response['success'] = true;
        $response['message'] = 'Producto subido correctamente';
        return $response;
    }

    public function updateProduct($datos){
        $response = [
			'success' => false,
			'message' => 'Error inicial'
		];
        $product = new products();
        $pid = $datos['id'];
        //print_r($pid);
        $updateData = [];

        if (isset($datos['type'])) {
            $updateData[] = ['type', "'" . $datos['type'] . "'"];
        }
    
        if (isset($datos['product_name'])) {
            $updateData[] = ['product_name', "'" . $datos['product_name'] . "'"];
        }
    
        if (isset($datos['description'])) {
            $updateData[] = ['description', "'" . $datos['description'] . "'"];
        }
    
        if (isset($_FILES['thumb']['name']) && !empty($_FILES['thumb']['name'])) {
            // Ruta absoluta al directorio donde se almacenan las imágenes
            $newImageName = $_FILES['thumb']['name'];
            $targetFilePath = __DIR__ . '/../../app/pimg/' . $newImageName;
        
            // Mueve la imagen cargada al directorio de imágenes
            if (move_uploaded_file($_FILES['thumb']['tmp_name'], $targetFilePath)) {
                // Actualiza el campo 'thumb' en la base de datos con el nuevo nombre de la imagen.
                $updateData[] = ['thumb', "'" . $newImageName . "'"];
            } else {
                // Error al mover la imagen.
                echo "Error al cargar la imagen.";
            }
        }
        
        if (isset($datos['price'])) {
            $updateData[] = ['price', "'" . $datos['price'] . "'"];
        }
        // Realiza la actualización en la base de datos solo para los campos proporcionados.
        $result = $product->where([['id', $pid]])->update($updateData);
        
        if(!$result){
            $response['success'] = false;
            $response['message'] = "Error en el servidor";            
        }
        $response['success'] = true;
        $response['message'] = "actualizado";

        return $response;
    }
    
    public function deleteProduct($pid){
        $product = new products();
        $result = $product->delete($pid);                         
        return $result;
    }

    //cambiar status de la publicacion
    public function toggleProdActive($pid){
        $product = new products();
        $result = $product->where([['id',$pid]])
                          ->update([['active','not active']]);
        return $result;
    }
    

    //trae todos los productos al catalogo de administracion
    public function getProductsToAdmin(){
        $response = [
			'success' => false,
			'message' => 'Error inicial',
            'data' => null
		];
        $product = new products();
        //Si quiero que tenga un orden descendiente o ascendiente usar 'DESC' o 'ASC'
        //orderBy([['created_at','ASC']])
        //inRandomOrder()
        $result = $product->orderBy([['created_at','DESC']])
                          ->get();
                                  // si no hay errores retornamos un true
        $response['success'] = true;
        $response['message'] = 'Productos encontrados';
        $response['data'] = $result;
        return $response;
    }

    //trae los productos al catalogo del cliente
    public function getProductsToClient() {
        $product = new products();
        $result = $product->where([['active','1']])
                          ->orderBy([['created_at','ASC']])
                          ->get();

        return $result;
    }
    

    //trae todos los productos al catalogo
    public function getProductsToHome($limit=""){
        $product = new products();
        $result = $product->where([['active','1']])
                            ->inRandomOrder()
                            ->limit($limit)                         
                            ->get();
        return $result;
    }

    //Trae la info del producto seleccionado
    public function getProduct($pid){
        $product = new products();
        $result = $product->where([['id',$pid]])
                          ->get();
        return $result;
    }

    public function getMyOrders(){
        $order = new product_order();
        $result = $order->select()->get();
        return $result;
    }
}