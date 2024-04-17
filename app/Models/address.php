<?php

namespace Models;

use Models\DB;

class address extends DB {
    public $table;
    function __construct(){
        parent::__construct();
        $this->table = $this->db_connect();
    }

    protected $campos = ['userId','fullName','telefono','colonia','calle','estado','ciudad','postalcode'];

    public $valores = [];

}

//agregar campo "referencia"