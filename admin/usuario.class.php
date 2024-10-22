<?php
require_once('../sistema.class.php');

class Usuario extends Sistema{
    //INSERTAR A LA BASE DE DATOS
    function create($data){
        $result = [];
        $this->conexion();
        $data = $data['data'];
        //iniciar una transaccion
        $this->conn->beginTransaction();
        $sql = "INSERT INTO usuario (correo, contraseña) 
        VALUES (:correo,:contrasena);";
        $insertar = $this->conn->prepare($sql);
        $contraEncrip= md5($data['contrasena']);
        //bindParam para evitar las inyecciones de SQL
        $insertar->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
        $insertar->bindParam(':contrasena', $contraEncrip, PDO::PARAM_STR);
        $insertar->execute();
        $this->conn->commit(); //terminar la transaccion
        $result = $insertar->rowCount();
        return $result;
    }

    function update($id, $data){
        $result = [];
        $this->conexion();
        $sql = "UPDATE usuario SET correo=:correo,contraseña=:contrasena where id_usuario=:id_usuario;";
        $modificar = $this->conn->prepare($sql);
        $contraEncrip = md5($data['contrasena']);
        $modificar->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $modificar->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
        $modificar->bindParam(':contrasena', $contraEncrip, PDO::PARAM_STR);
        $modificar->execute();
        $result = $modificar->rowCount();
        return $result;
    }

    function delete($id){
        $result = [];
        $this->conexion();
        $sql = "DELETE FROM usuario WHERE id_usuario=:id_usuario;";
        $eliminar = $this->conn->prepare($sql);
        $eliminar->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $eliminar->execute();
        $result = $eliminar->rowcount();
        return $result;
    }

    function readOne($id){
        $result = [];
        $this->conexion();
        $sql = 'SELECT * from usuario where id_usuario = :id_usuario;';
        $update = $this->conn->prepare($sql);
        $update->bindParam(':id_usuario', $id, PDO::PARAM_INT);
        $update->execute();
        $result = $update->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function readAll(){
        $this->conexion();
        $result = [];
        $consulta = 'select * from usuario;';
        $sql = $this->conn->prepare($consulta);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
