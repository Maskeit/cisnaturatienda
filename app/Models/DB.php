<?php
namespace Models;

class DB {
    public $db_host;
    public $db_name;
    private $db_user;
    private $db_passwd;
    private $db_port;

    public $conex;

    //Variables de control para las consultas

    public $s = " * ";
    public $c = "";
    public $j = "";
    public $w = " 1 ";
    public $o = "";
    public $l = "";

    public $r; //Resultado de la consulta

    public function __construct($dbh = "localhost",
                                $dbn = "cisnaturatienda",
                                $dbu = "root",
                                $dbp = "root", 
                                $dbport = 8889){
        $this->db_host = $dbh;
        $this->db_name = $dbn;
        $this->db_user = $dbu;
        $this->db_passwd = $dbp;
        $this->db_port = $dbport;
    }
    public function db_connect(){
        $this->conex = new \mysqli($this->db_host,
                                    $this->db_user,
                                    $this->db_passwd,
                                    $this->db_name,
                                    $this->db_port);
        $this->conex->set_charset("utf8");
        if($this->conex->connect_error){
            echo "Falló la conexión a la base de datos";
        }else{
            return $this->conex;
        }
    }

    public function select($cc = []){
        if(count($cc) > 0){
            $this->s = implode(",",$cc);
        }
        return $this;
    }

    public function count($c = "*"){
        $this->c = ",count(" . $c .") as tt ";
        return $this;
    }
    public function countRows($field = "*") {
        $sql = "SELECT COUNT(" . $field . ") AS count FROM " . str_replace("Models\\", "", get_class($this)) . " WHERE " . $this->w;
        $result = $this->table->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        } else {
            return 0; // O maneja el error como prefieras
        }
    }
    
    public function join($join = "", $on = ""){
        if($join != "" && $on != ""){
            $this->j = ' join ' . $join . ' on ' . $on;
        }
        return $this;
    }

    //Tradicional Where
    public function where($ww = []){
        $this->w = "";
        if(count($ww) > 0){
            foreach($ww as $wheres){
                $this->w .= $wheres[0] . " like '" . $wheres[1] . "' " . ' and ';
            }
        }
        $this->w .= ' 1 ';
        return $this;
    }

    //condicional Where
    public function whereLike($ww = []) {
        $this->w = "";
        if (count($ww) > 0) {
            foreach ($ww as $wheres) {
                $field = $wheres[0];
                $operator = $wheres[1];
                $value = $wheres[2];
                
                $this->w .= $field . ' ' . $operator . ' ' . $value . ' AND ';
            }
        }
        $this->w .= '1';
        return $this;
    }
    
    public function orderBy($ob = []){
        $this->o = "";
        if(count($ob) > 0){
            foreach($ob as $orderBy){
                $this->o .= $orderBy[0] . ' ' . $orderBy[1] .  ',';
            }
            $this->o = ' order by ' . trim($this->o,',');
        }
        return $this;
    }
    public function inRandomOrder(){
        $this->o = ' order by rand()';
        return $this;
    }


    public function limit($l = ""){
        $this->l = "";
        if($l != ""){
            $this->l = ' limit ' . $l; 
        }
        return $this;
    }

    public function get(){
        $sql = "select " . $this->s .
                    $this->c .
                    " from " . str_replace("Models\\","",get_class($this)) . 
                    ($this->j != "" ? " a " . $this->j : "" ) .
                    " where " . $this->w . 
                    $this->o . 
                    $this->l;
        $this->r = $this->table->query($sql);
        $result = [];
        while( $f = $this->r->fetch_assoc()){
            $result[] = $f;
        }
        return json_encode($result);
    }

    public function create(){
        $sql = 'insert into '. str_replace("Models\\","",get_class($this)) .
                    ' (' . implode("," , $this->campos ) .') values (' . 
                    trim(str_replace("&","?,",str_pad("",count($this->campos),"&")),",") . ');';
        $stmt = $this->table->prepare($sql);
        $stmt->bind_param(str_pad("",count($this->campos),"s"),...$this->valores);
        return $stmt->execute();
    }

    public function insert($campo, $value){
        $sql = 'insert into '. str_replace("Models\\","",get_class($this)) . 
        ' (' . $campo .') values (?)';
        $stmt = $this->table->prepare($sql);
        $stmt->bind_param('s', $value);
        return $stmt->execute();
    }

    // public function update($sets){
    //     foreach($sets as $s){
    //         $set[] = $s[0] . "=" . $s[1];
    //     }
    //     $sql = 'update ' . str_replace("Models\\", "", get_class($this)) . 
    //             ' set ' . implode(",",$set) . ' where ' .$this->w;
    //     $result = $this->table->query($sql);
    //     return $result;
    // }

    public function update($sets) {
        $set = [];
        foreach ($sets as $s) {
            $set[] = $s[0] . "='" . $s[1] . "'";
        }
        $sql = 'update ' . str_replace("Models\\", "", get_class($this)) . 
                ' set ' . implode(",", $set) . ' where ' . $this->w;
        $result = $this->table->query($sql);
        return $result;
    }

    //metodo para actualizar sobre todo numeros
    public function updateNumbers($sets) {
        $set = [];
        foreach ($sets as $s) {
            $value = is_numeric($s[1]) ? $s[1] : "'" . $s[1] . "'";
            $set[] = $s[0] . "=" . $value;
        }
        $sql = 'UPDATE ' . str_replace("Models\\", "", get_class($this)) . 
                ' SET ' . implode(",", $set) . 
                ' WHERE ' . $this->w;
        return $this->table->query($sql);
    }
    
     
    public function delete($id){
        $sql = 'delete from ' . str_replace("Models\\","",get_class($this)) . ' where id = ?;';
        $stmt = $this->table->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function deleteMore($conditions){
        // Asumiendo que $conditions es un array de condiciones ([[nombre_campo, valor]])
        $sql = 'DELETE FROM ' . str_replace("Models\\","",get_class($this)) . ' WHERE ';
        
        $whereConditions = [];
        $bindTypes = "";
        $bindValues = [];
    
        foreach ($conditions as $condition) {
            $whereConditions[] = $condition[0] . ' = ?';
            $bindTypes .= 's'; // Usamos 's' para strings
            $bindValues[] = $condition[1];
        }
    
        $sql .= implode(' AND ', $whereConditions);
        
        $stmt = $this->table->prepare($sql);
    
        if (!empty($bindValues)) {
            $stmt->bind_param($bindTypes, ...$bindValues);
        }
    
        return $stmt->execute();
    }
     
}