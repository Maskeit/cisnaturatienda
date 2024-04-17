<?php

namespace Models;

use Models\DB;

class product_order extends DB {
    public $table;  
    function __construct(){
        parent::__construct();
        $this->table = $this->db_connect();
    }

    protected $campos = ['userId','productsData', 'subtotal','envio','total','order_status'];
    //recordar que productsData es de tipo TEXT ya que almacena objetos jSON

    public $valores = [];

}