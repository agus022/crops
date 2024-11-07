<?php
    require_once('../sistema.class.php');
    $app = new Sistema;
    $accion = (isset($_GET['accion'])) ? $_GET['accion'] : null; //if ternario 

    switch ($accion) {
        case 'login':
            $correo=$_POST['data']['correo'];
            $contrasena = $_POST['data']['contrasena'];

            if($app->logIn($correo,$contrasena)){
                $mensaje= "BIENVENIDO AL SISTEMA";
                $tipo="success";
                $app->checkRol('Administrador');
                require_once('views/headeradministrador.php');
                $app->alerta($tipo,$mensaje);
                //plantillas de bienvenida 
            }else{
                $mensaje = "Correo o contraseña incorrectos <a href='login.php'>[Intentar de nuevo]</a>";
                $tipo = "danger";
                require_once('views/header.php');
                $app->alerta($tipo, $mensaje);
                
            }
            
            break;
        case 'logout':
            $app->logOut();

            break;
        default:
            include('views/login/index.php');
            break;
    }
    require_once('views/footer.php');
?>