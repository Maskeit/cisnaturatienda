<?php

namespace Models;

use Models\DB;

class binnacle extends DB {
    public $table;
    function __construct(){
        parent::__construct();
        $this->table = $this->db_connect();
    }

    protected $campos = ['module','message','type','_from','date'];

    public $valores = [];

}