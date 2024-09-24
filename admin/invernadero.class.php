<?php
include('../sistema.class.php');

class Invernadero extends Sistema{
    //INSERTAR A LA BASE DE DATOS
    function create($data){
        $result = [];
        $this->conexion();
        $sql = "INSERT INTO invernadero (invernadero,latitud,longitud,area,fecha_creacion) 
        VALUES (:invernadero,:longitud,:latitud,:area,:fecha_creacion);";
        $insertar = $this -> conn -> prepare($sql);
        //bindParam para evitar las inyecciones de SQL
        $insertar -> bindParam(':invernadero',$data['invernadero'],PDO::PARAM_STR);
        $insertar->bindParam(':longitud', $data['longitud'], PDO::PARAM_STR);
        $insertar->bindParam(':latitud', $data['latitud'], PDO::PARAM_STR);
        $insertar->bindParam(':area', $data['area'], PDO::PARAM_INT);
        $insertar->bindParam(':fecha_creacion', $data['fecha_creacion'], PDO::PARAM_STR);
        $insertar->execute();
        $result =$insertar->rowCount();
        return $result;
    }

    function update ($id,$data){
        $result = [];
        return $result;
    }

    function delete ($id){
        $result = [];
        $this->conexion();
        $sql = "DELETE FROM invernadero WHERE id_invernadero=:id_invernadero";
        $eliminar = $this->conn->prepare($sql);
        $eliminar->bindParam(':id_invernadero',$id,PDO::PARAM_INT);
        $eliminar->execute();
        $result=$eliminar->rowcount();
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