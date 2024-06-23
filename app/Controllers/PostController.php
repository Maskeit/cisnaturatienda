<?php

    namespace Controllers;

    use Models\user;
    use Models\products;
    use Models\product_order;
    use Controllers\auth\LoginController as LoginController;

    $uploadDirectory = __DIR__ . '/cisnaturatienda/app/pimg/';

class PostController {

    private $uploadDirectory;

    public function __construct(){
        $ua = new LoginController();
    }



    /********************** Métodos para el manejo de los productos ***************** */
    
    public function createProduct($datos){
        $product = new products();
        $check = @getimagesize($_FILES['thumb']['tmp_name']);
        if ($check !== false) {
            $carpeta_destino = __DIR__ . '/../../app/pimg/';
            if (!is_dir($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }
            $archivo_subido = $carpeta_destino . $_FILES['thumb']['name'];
            move_uploaded_file($_FILES['thumb']['tmp_name'], $archivo_subido);

            $product->valores = [$datos['type'],
                                 $datos['product_name'], 
                                 $datos['description'], 
                                 $_FILES['thumb']['name'], 
                                 $datos['price']];
            $product->create();
        } else {
            echo "Error al subir el archivo";
        }
    }
    

    public function updateProduct($datos){
        $product = new products();
        $pid = $datos['id'];
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
            $targetFilePath = $this->uploadDirectory . $newImageName;
        
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
        return $result;
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
        $product = new products();
        //Si quiero que tenga un orden descendiente o ascendiente usar 'DESC' o 'ASC'
        //orderBy([['created_at','ASC']])
        //inRandomOrder()
        $result = $product->orderBy([['created_at','ASC']])
                          ->get();  
        return $result;
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