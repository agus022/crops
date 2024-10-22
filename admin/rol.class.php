<?php
require_once('../sistema.class.php');

class Rol extends Sistema{
    //INSERTAR A LA BASE DE DATOS
    function create($data){
        $result = [];
        $this->conexion();
        $sql = "INSERT INTO rol (rol) VALUES (:rol);";
        $insertar = $this->conn->prepare($sql);
        //bindParam para evitar las inyecciones de SQL
        $insertar->bindParam(':seccion', $data['seccion'], PDO::PARAM_STR);
        $insertar->bindParam(':area', $data['area'], PDO::PARAM_INT);
        $insertar->bindParam(':id_invernadero', $data['id_invernadero'], PDO::PARAM_INT);
        $insertar->execute();
        $result = $insertar->rowCount();
        return $result;
    }

    function update($id, $data){
        $result = [];
        $this->conexion();
        $sql = "UPDATE seccion SET seccion=:seccion,area=:area,id_invernadero=:id_invernadero 
        where id_seccion=:id_seccion;";
        $modificar = $this->conn->prepare($sql);
        $modificar->bindParam(':id_seccion', $id, PDO::PARAM_INT);
        $modificar->bindParam(':seccion', $data['seccion'], PDO::PARAM_STR);
        $modificar->bindParam(':area', $data['area'], PDO::PARAM_INT);
        $modificar->bindParam(':id_invernadero', $data['id_invernadero'], PDO::PARAM_INT);
        $modificar->execute();
        $result = $modificar->rowCount();
        return $result;
    }

    function delete($id)
    {
        $result = [];
        $this->conexion();
        $sql = "DELETE FROM seccion WHERE id_seccion=:id_seccion;";
        $eliminar = $this->conn->prepare($sql);
        $eliminar->bindParam(':id_seccion', $id, PDO::PARAM_INT);
        $eliminar->execute();
        $result = $eliminar->rowcount();
        return $result;
    }

    function readOne($id)
    {
        $result = [];
        $this->conexion();
        $sql = 'SELECT * from seccion where id_seccion = :id_seccion;';
        $update = $this->conn->prepare($sql);
        $update->bindParam(':id_seccion', $id, PDO::PARAM_INT);
        $update->execute();
        $result = $update->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll()
    {
        $this->conexion();
        $result = [];
        $consulta = 'select s.*,i.invernadero from seccion s join invernadero i on s.id_invernadero=i.id_invernadero;';
        $sql = $this->conn->prepare($consulta);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
