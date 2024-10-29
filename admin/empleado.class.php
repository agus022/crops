<?php
require_once('../sistema.class.php');

class Empleado extends Sistema{
    //INSERTAR A LA BASE DE DATOS
    function create($data)
    {
        $result = [];
        $this->conexion();
        $sql = "INSERT INTO empleado (primer_apellido,segundo_apellido,nombre,rfc,id_usuario) 
        VALUES (:primer_apellido,:segundo_apellido,:nombre,:rfc,:id_usuario);";
        $insertar = $this->conn->prepare($sql);
        //bindParam para evitar las inyecciones de SQL
        $insertar->bindParam(':primer_apellido', $data['primer_apellido'], PDO::PARAM_STR);
        $insertar->bindParam(':segundo_apellido', $data['segundo_apellido'], PDO::PARAM_STR);
        $insertar->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $insertar->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
        $insertar->bindParam(':id_usuario', $data['id_usuario'], PDO::PARAM_INT);
        $insertar->execute();
        $result = $insertar->rowCount();
        return $result;
    }

    function update($id, $data)
    {
        $result = [];
        $this->conexion();
        $sql = "UPDATE empleado SET primer_apellido=:primer_apellido,segundo_apellido=:segundo_apellido,nombre=:nombre,rfc=:rfc,id_usuario=:id_usuario
        where id_empleado=:id_empleado;";
        $modificar = $this->conn->prepare($sql);
        $modificar->bindParam(':id_empleado', $id, PDO::PARAM_INT);
        $modificar->bindParam(':primer_apellido', $data['primer_apellido'], PDO::PARAM_STR);
        $modificar->bindParam(':segundo_apellido', $data['segundo_apellido'], PDO::PARAM_STR);
        $modificar->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $modificar->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
        $modificar->bindParam(':id_usuario', $data['id_usuario'], PDO::PARAM_INT);
        $modificar->execute();
        $result = $modificar->rowCount();
        return $result;
    }

    function delete($id)
    {
        $result = [];
        $this->conexion();
        $sql = "DELETE FROM empleado WHERE id_empleado=:id_empleado;";
        $eliminar = $this->conn->prepare($sql);
        $eliminar->bindParam(':id_empleado', $id, PDO::PARAM_INT);
        $eliminar->execute();
        $result = $eliminar->rowcount();
        return $result;
    }

    function readOne($id)
    {
        $result = [];
        $this->conexion();
        $sql = 'SELECT * from empleado where id_empleado = :id_empleado;';
        $update = $this->conn->prepare($sql);
        $update->bindParam(':id_empleado', $id, PDO::PARAM_INT);
        $update->execute();
        $result = $update->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll()
    {
        $this->conexion();
        $result = [];
        $consulta = 'SELECT e.*, u.correo FROM empleado e JOIN usuario u ON e.id_usuario = u.id_usuario;';
        $sql = $this->conn->prepare($consulta);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
