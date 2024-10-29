<?php
require_once('../sistema.class.php');

class Usuario extends Sistema{
    //INSERTAR A LA BASE DE DATOS
    function create($data){
        $result = [];
        $this->conexion();
        $rol = $data['rol'];
        $data = $data['data'];
        //iniciar una transaccion
        $this->conn->beginTransaction();
        try {
            $sql = "INSERT INTO usuario (correo, contraseña) VALUES (:correo,:contrasena);";
            $insertar = $this->conn->prepare($sql);
            $contraEncrip = md5($data['contrasena']);
            //bindParam para evitar las inyecciones de SQL
            $insertar->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
            $insertar->bindParam(':contrasena', $contraEncrip, PDO::PARAM_STR);
            $insertar->execute();
            //conseguir el id con el correo del usuario creado 
            $sql="SELECT id_usuario from usuario where correo=:correo;";
            $consulta = $this->conn->prepare($sql);
            $consulta->bindParam(':correo',$data['correo'],PDO::PARAM_STR);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            $id_usuario = isset($datos['id_usuario'])? $datos['id_usuario']: null;
            if(!is_null($id_usuario)){
                foreach($rol as $r => $k){
                    $sql = "INSERT into usuario_rol(id_usuario,id_rol) values (:id_usuario,:id_rol)";
                    $insertar_rol=$this->conn->prepare($sql);
                    $insertar_rol->bindParam(':id_usuario',$id_usuario,PDO::PARAM_INT);
                    $insertar_rol->bindParam(':id_rol', $r, PDO::PARAM_INT);
                    $insertar_rol->execute();
                }
                $this->conn->commit(); //terminar la transaccion pero se ejecuta todo sale OK 
                $result = $insertar->rowCount();
            }
            
            return $result;
        } catch (Exception $e) {
            $this->conn->rollback(); //no se ejecuta la transaccion  da ERRROR en la consulta 
        }

    }

    function update($id, $data){
        $result = [];
        $this->conexion();
        $rol=$data['rol'];
        //iniciar una transaccion
        $data=$data['data'];
        $this->conn->beginTransaction();
        try {
            $sql = "UPDATE usuario SET correo=:correo,contraseña=:contrasena where id_usuario=:id_usuario;";
            $modificar = $this->conn->prepare($sql);
            $contraEncrip = md5($data['contrasena']);
            $modificar->bindParam(':id_usuario', $id, PDO::PARAM_INT);
            $modificar->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
            $modificar->bindParam(':contrasena', $contraEncrip, PDO::PARAM_STR);
            $modificar->execute();
            $result = $modificar->rowCount();
            $sql="DELETE from usuario_rol where id_usuario =:id_usuario";
            $borrarRol=$this->conn->prepare($sql);
            $borrarRol->bindParam(':id_usuario',$id,PDO::PARAM_INT);
            $borrarRol->execute();
            if (!is_null($id)) {
                foreach ($rol as $r => $k) {
                    $sql = "INSERT into usuario_rol(id_usuario,id_rol) values (:id_usuario,:id_rol)";
                    $insertar_rol = $this->conn->prepare($sql);
                    $insertar_rol->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                    $insertar_rol->bindParam(':id_rol', $r, PDO::PARAM_INT);
                    $insertar_rol->execute();
                }
                $this->conn->commit(); //terminar la transaccion pero se ejecuta todo sale OK 
                $result = $insertar_rol->rowCount();
            }
            $this->conn->commit();
            return $result;
        } catch (Exception $e) {
            return false;
        }
        
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

    function readAllRoles($id){
        $this->conexion();
        $result = [];
        $sql= "SELECT DISTINCT r.id_rol 
                from usuario u
                inner join usuario_rol ur on u.id_usuario=ur.id_usuario
                inner join rol r on r.id_rol=ur.id_rol
                where u.id_usuario=:id_usuario;";
        $readRoles=$this->conn->prepare($sql);
        $readRoles->bindParam(':id_usuario',$id,PDO::PARAM_INT);
        $readRoles->execute();
        $roles =[];
        $roles = $readRoles->fetchAll(PDO::FETCH_ASSOC);
        $data=[];
        foreach($roles as $rol){
            array_push($data,$rol['id_rol']);
        }

        return $data;
    }
}
