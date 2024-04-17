<?php

namespace Models;

use Models\DB;

class sessions extends DB {
    public $table;
    function __construct(){
        parent::__construct();
        $this->table = $this->db_connect();
    }

    protected $campos = ['user','json',"date"];

    public $valores = [];

}