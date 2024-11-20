<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


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
            $roles2=[];
            foreach($data as $rol){
                array_push($roles2,$rol['rol']);
            }
            $data = $roles2;
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
            $permisos= [];
            foreach ($data as $permiso) {
                array_push($permisos, $permiso['permiso']);
            }
            $data=$permisos;
        }
        return $data;
    }

    function logIn($correo,$contrasena){
        $contrasena=md5($contrasena);//ENCRIPTAR CONTASENA PARA EVITAR INYECCIONES DE SQL 
        $acceso=false;
        if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
            $this->conexion();
            $consulta="SELECT * FROM usuario WHERE correo=:correo and contraseña=:contrasena";
            $sql =$this->conn->prepare($consulta);
            $sql->bindParam(':correo',$correo,PDO::PARAM_STR);
            $sql->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            if(isset($result[0])){
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
        $mensaje="SE CERRO SESION, GRACIAS POR USAR EL SISTEMA CROPS :) [<a href='login.php'>presione aqui para volver a entrar</a>]";
        $tipo="info";
        require_once('views/header.php');
        require_once('views/headeralert.php');
        $this->alerta($tipo, $mensaje);
        require('views/footer.php');
    }


    function checkRol($rol){
        if(isset($_SESSION['roles'])){
            $roles=$_SESSION['roles'];
            if(!in_array($rol,$roles)){  
                $mensaje="ERROR! Usted no tiene el rol adecuado";
                $tipo="danger";
                require_once('views/headeralert.php');
                $this->alerta($tipo,$mensaje);
                die();
            }
        }else{
            $mensaje = "Se requiere iniciar sesion [<a href='login.php'>Iniciar Sesion aqui</a>]";
            $tipo = "warning";
            require_once('views/headeralert.php');
            $this->alerta($tipo, $mensaje);
            die();
        }
    }

    function sendMail($destinario,$asunto,$mensaje){

        require 'vendor/autoload.php';
        $mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = '20031296@itcelaya.edu.mx';
        $mail->Password = 'yhcfilmbfqtksplb';
        $mail->setFrom('20031296@itcelaya.edu.mx', 'AGUSTIN');
        $mail->addAddress($destinario, 'Sistema - CROPS');

        //Set the subject line
        $mail->Subject = $asunto;
        $mail->msgHTML($mensaje);

        //Replace the plain text body with one created manually
        $mail->AltBody = 'HOLAAAA MUNDO DESDE UN CORREO ELECTRONICO ';

        //Attach an image file
        $mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }

    }

}

?>