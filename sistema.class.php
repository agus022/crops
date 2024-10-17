<?php
session_start();//se crea la super global session
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
            $rol=[];
            foreach($data as $rol){
                array_push($rol,$rol['rol']);
            }
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
            $permiso= [];
            foreach ($data as $permiso) {
                array_push($permiso, $permiso['permiso']);
            }
        }
        return $data;
    }

    function logIn($correo,$contrasena){
        $contrasena=md5($contrasena);//ENCRIPTAR CONTASENA PARA EVITAR INYECCIONES DE SQL 
        $acceso=false;
        if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
            $this->conexion();
            $sql="SELECT * FROM usuario WHERE correo=:correo and contraseña=:contrasena";
            $user =$this->conn->prepare($sql);
            $user->bindParam(':correo',$correo,PDO::PARAM_STR);
            $user->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            $user->execute();
            $resultado = $user->fetchAll(PDO::FETCH_ASSOC);
            if(isset($resultado[0])){
                $acceso=true;
                $_SESSION['validado'] = $acceso;
                $_SESSION['correo'] = $correo;
                $roles=$this->getRol($correo);
                $privilegios=$this->getPrivilegio($correo);
                $_SESSION['roles'] = $roles;
                $_SESSION['privilegios'] = $privilegios;
                return $acceso;
            }

        }
        $_SESSION['validado'] = false;
        return $acceso;
    }

    function logOut(){
        unset($_SESSION);
        session_destroy();
    }


    function checkRol($rol){
        $roles=$_SESSION['roles'];
        if(!in_array($rol,$roles)){  
            echo('NO TIENES EL ROL');
            die();
        }
    }

}

?>