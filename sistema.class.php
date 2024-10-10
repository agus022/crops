<?php
require_once ("config.class.php");
class Sistema{
    var $conn;
    function conexion (){
        $this-> conn = new PDO(SGBD.':host='.DBHOST.'; dbname='.DBNAME.'; port='.DBPORT,DBUSER,DBPASS);
    }

    function alerta($tipo, $mensaje){
        include ('views/alert.php');
    }

    function getRol($correo){
        $this->conexion();
        $data=[];
        if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
            $sql="select r.rol from usuario u
                  inner join usuario_rol ur on u.id_usuario=ur.id_usuario
                  inner join rol r on r.id_rol=ur.id_rol 
                  where u.correo=:correo";
            $roles = $this->conn->prepare($sql);
            $roles->bindParam(':correo',$correo, PDO::PARAM_STR);
            $roles->execute();
            $data = $roles->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    function getPrivilegio($correo){
        $this->conexion();
        $data=[];
        if (filter_var($correo, FILTER_VALIDATE_EMAIL)){
            $sql= "select p.permiso from usuario u
                    inner join usuario_rol ur on u.id_usuario=ur.id_usuario
                    inner join rol r on r.id_rol=ur.id_rol
                    inner join rol_permiso rp on rp.id_rol=r.id_rol
                    inner join permiso p on p.id_permiso=rp.id_permiso
                    where u.correo=:correo";
            $privilegio = $this->conn->prepare($sql);
            $privilegio->bindParam(':correo', $correo, PDO::PARAM_STR);
            $privilegio->execute();
            $data = $privilegio->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
}

?>