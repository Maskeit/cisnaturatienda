<?php

namespace Models;

use Models\DB;

class api extends DB {
    public $table;  
    function __construct(){
        parent::__construct();
        $this->table = $this->db_connect();
    }

    protected $campos = ['name', 'value', 'date'];

    public $valores = [];

}