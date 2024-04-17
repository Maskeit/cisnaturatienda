<?php

    namespace Controllers;

    use Models\carrito;
    use Models\product_order;
    use Models\products;
    require_once("../app/Controllers/auth/LoginController.php");
    use Controllers\auth\LoginController as LoginController;
class CarritoController {

    private $userId;
    public $productId;

    public function __construct(){

        $ua = new LoginController();
        $ua->sessionValidate();
        $this->userId = $ua->id;
    }

    /**
     * empiezan los metodos para
     * agregar productos al carrito
     */
    public function buscarProductoEnCarrito($pid, $uid) {
        $carrito = new carrito();
        $result = $carrito->where([['productId', $pid],['userId', $uid]])
                          ->get();
        if ($result === "[]") {
            return null;
        } else {
            return $result;
        }                          
    }
    
    public function agregarProducto($pid, $uid, $tt) {
        // Verificar si el producto ya está en el carrito del usuario
        $cantidad = $this->cantProductos($uid);
        $productoExistente = $this->buscarProductoEnCarrito($pid, $uid);
        $carrito = new carrito();
        if (empty($productoExistente))  {
            $carrito->valores = [$uid, $pid, $tt];        
            $result = $carrito->create();
        } else if(!empty($productoExistente)) {
            $result = $carrito->where([['userId', $uid], ['productId', $pid]])
                              ->update([['cantidad', 'cantidad + 1']]);
            $result = true;
        }
        return $result;
    }

    //subtotal del carrito actualiza
    public function incSubtotal($uid, $pid, $num) {
        $carrito = new carrito();
        $conexion = $carrito->db_connect();
    
        if ($conexion == null) {
            echo "Hubo un error al conectar a la base de datos <br>";
            return false;
        }
    
        $sql = "UPDATE carrito SET cantidad = cantidad + $num WHERE userId = $uid AND productId = $pid";
        $result = mysqli_query($conexion, $sql);
    
        // Verificar si la consulta se ejecutó correctamente
        if ($result) {
            // Devuelve true si la actualización fue exitosa
            mysqli_close($conexion);
            return true;
        } else {
            // En caso de error, muestra el mensaje y devuelve false
            echo "Hubo un error al actualizar el campo 'cantidad' en la tabla 'carrito' <br>";
            mysqli_close($conexion);
            return false;
        }
    }
    
    
    
    public function decSubtotal($uid, $pid,$num) {
        $carrito = new carrito();
        $conexion = $carrito->db_connect();
    
        if ($conexion == null) {
            echo "Hubo un error al conectar a la base de datos <br>";
            return false;
        }
    
        $sql = "UPDATE carrito SET cantidad = cantidad - $num WHERE userId = $uid AND productId = $pid";
        $result = mysqli_query($conexion, $sql);
    
        // Verificar si la consulta se ejecutó correctamente
        if ($result) {
            // Devuelve true si la actualización fue exitosa
            mysqli_close($conexion);
            return true;
        } else {
            // En caso de error, muestra el mensaje y devuelve false
            echo "Hubo un error al actualizar el campo 'cantidad' en la tabla 'carrito' <br>";
            mysqli_close($conexion);
            return false;
        }
    }

    //Metodo para contar cuantos productos tiene un usuario en su carrito
    public function cantProductos($uid){
        $carrito = new carrito();
        $result = $carrito->count() // tt
                          ->whereLike([
                              ['userId', '=', $uid],
                              ['cantidad', '>', 0]
                          ])
                          ->get();
        
        return $result;
    }

    //alternativa funcional
    public function allCar($uid=""){
        $carrito = new carrito();    
        $conexion = $carrito->db_connect();
        if($conexion == null){
            echo "Hubo un error al conectar a la base de datos <br>";
        } else {
            $sql = "SELECT b.id, a.product_name, a.thumb, a.price, a.active, b.productId, b.cantidad
                    FROM products a
                    INNER JOIN carrito b ON b.productId = a.id WHERE b.userId = $uid";
            
            $resultado = mysqli_query($conexion, $sql);
            
            // Procesar los datos y retornarlos en un formato adecuado
            $filas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            
            // Liberar el resultado y cerrar la conexión
            mysqli_free_result($resultado);
            mysqli_close($conexion);
            
            return json_encode($filas);
        }
    }

    public function deleteProductCar($pci){
        $carrito = new carrito();
        $result = $carrito->delete($pci);
        return $result;
    }

    //buscamos en la tabla si ya habia una orden existente previamente
    public function buscarOrdenExistente($uid){
        $order = new product_order();
        $result = $order->where([['userId',$uid]])
                        ->get();
            if ($result === "[]") {
                return null;
            } else {
                return $result;
            } 
    }

    //despues de verificar si hay o no una orden existente creamos la orden o la actualizamos
    public function temporaryOrder($datos){
        $order = new product_order();
        $uid = $datos['userId'];
        $productos = $datos['productsData'];
        $subtotal = $datos['subtotal'];
        $envio = $datos['envio'];
        $total = $datos['total'];

        $orderExists = $this->buscarOrdenExistente($uid);    
        if(empty($orderExists)){
            $order->valores = [
                $datos['userId'],
                json_encode($datos['productsData']),
                $datos['subtotal'],
                $datos['envio'],
                $datos['total'],
                $datos['status'],
            ];
            $order->create();            
        }else if(!empty($orderExists)){
            $query = $order->where([['userId',$uid]])
                            ->update([
                                      ['productsData', json_encode($productos)], // Convertir a JSON
                                      ['subtotal',$subtotal],
                                      ['envio',$envio],
                                      ['total',$total]
                            ]);
            if($query){        
                $result = $order->select(['id'])
                ->get();
            }                                   
                                    
            return $result;
        }
    }


    public function getOrder($orderId){
        $order = new product_order();
        $result = $order->where([['id',$orderId]])->get();
        return $result;
    }

}