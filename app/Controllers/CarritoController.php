<?php

namespace Controllers;

use Models\carrito;
use Models\product_order;
use Models\products;

class CarritoController
{

    public $productId;

    public function __construct()
    {
    }

    /**
     * empiezan los metodos para
     * agregar productos al carrito
     */
    public function buscarProductoEnCarrito($pid, $uid)
    {
        $carrito = new carrito();
        $result = $carrito->where([['productId', $pid], ['userId', $uid]])
            ->get();
        $decodedResult = json_decode($result, true); // Decodificar el JSON en un array asociativo
        if (empty($decodedResult)) {
            return null;
        } else {
            return $decodedResult;
        }
    }


    public function agregarProducto($pid, $uid, $tt)
    {
        $carrito = new carrito();
        $productoExistente = $this->buscarProductoEnCarrito($pid, $uid);

        if (is_null($productoExistente)) {
            // Si no existe el producto en el carrito, se crea una nueva entrada
            $carrito->valores = [$uid, $pid, $tt];
            return $carrito->create();
        } else {
            // Si el producto ya existe, incrementa la cantidad
            $cantidadActual = $productoExistente[0]['cantidad']; // Asumiendo que `cantidad` es parte de los datos retornados
            $nuevaCantidad = $cantidadActual + $tt;
            return $carrito->where([['userId', $uid], ['productId', $pid]])
                ->updateNumbers([['cantidad', $nuevaCantidad]]);
        }
    }

    // update field 'cantidad' in colum 'carrito
    public function updateProductQuantity($pid, $userId, $cantidad){
        $carrito = new carrito();
        $updateData = [];
        $updateData[] = ['cantidad' , $cantidad];
        $result = $carrito->where([['id', $pid],['userId', $userId]])->update($updateData);
        return $result;
    }

    //Metodo para contar cuantos productos tiene un usuario en su carrito
    public function cantProductos($uid)
    {
        $carrito = new carrito();
        $carrito->whereLike([['userId', '=', $uid], ['cantidad', '>', 0]]);
        $cantidad = $carrito->countRows('userId');
        return $cantidad;
    }

    //alternativa funcional
    public function allCar($uid = "")
    {
        $carrito = new carrito();
        $conexion = $carrito->db_connect();
        if ($conexion == null) {
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

            return $filas;
        }
    }

    //Metodo para eliminar el product de la lista
    public function deleteProductCar($pci)
    {
        $carrito = new carrito();
        $result = $carrito->delete($pci);
        return $result;
    }

    //buscamos en la tabla si ya habia una orden existente previamente
    public function buscarOrdenExistente($uid)
    {
        $order = new product_order();
        $result = $order->where([['userId', $uid]])
            ->get();
        if ($result === "[]") {
            return null;
        } else {
            return $result;
        }
    }

    //despues de verificar si hay o no una orden existente creamos la orden o la actualizamos
    public function temporaryOrder($datos)
    {
        $order = new product_order();
        $uid = $datos['userId'];
        $productos = $datos['productsData'];
        $subtotal = $datos['subtotal'];
        $envio = $datos['envio'];
        $total = $datos['total'];

        $orderExists = $this->buscarOrdenExistente($uid);
        if (empty($orderExists)) {
            $order->valores = [
                $datos['userId'],
                json_encode($datos['productsData']),
                $datos['subtotal'],
                $datos['envio'],
                $datos['total'],
                $datos['status'],
            ];
            $order->create();
        } else if (!empty($orderExists)) {
            $query = $order->where([['userId', $uid]])
                ->update([
                    ['productsData', json_encode($productos)], // Convertir a JSON
                    ['subtotal', $subtotal],
                    ['envio', $envio],
                    ['total', $total]
                ]);
            if ($query) {
                $result = $order->select(['id'])
                    ->get();
            }

            return $result;
        }
    }
    //metodo para obtener la orden
    public function getOrder($orderId)
    {
        $order = new product_order();
        $result = $order->where([['id', $orderId]])->get();
        return $result;
    }
}
