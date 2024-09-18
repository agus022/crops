<?php
include('../sistema.class.php');

class Invernadero extends Sistema{

    function create($data){
        $result = [];
        return $result;
    }

    function update ($id,$data){
        $result = [];
        return $result;
    }

    function delete ($id){
        $result = [];
        return $result;
    }

    function readOne($id){
        $result = [];
        return $result;        
    }

    function readAll (){
        $this-> conexion();
        $result = [];
        $consulta = 'select * from invernadero where 1=1';
        $sql = $this->conn->prepare($consulta);
        $sql ->execute();
        $result = $sql ->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>