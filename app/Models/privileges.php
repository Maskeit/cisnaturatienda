<?php

namespace Models;

use Models\DB;

class privileges extends DB {
    public $table;
    function __construct(){
        parent::__construct();
        $this->table = $this->db_connect();
    }

    protected $campos = ['route','access',"user_type"];

    public $valores = [];

}