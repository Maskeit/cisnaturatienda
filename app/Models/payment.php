<?php

namespace Models;

use Models\DB;

class payment extends DB {
    public $table;  
    function __construct(){
        parent::__construct();
        $this->table = $this->db_connect();
    }

    protected $campos = ['userId', 'customer_name', 'customer_email', 'item_desc',
                         'subtotal', 'envio', 'paid_amount','payment_status','address_id'];

    public $valores = [];

}