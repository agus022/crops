<?php
require_once('../sistema.class.php');
$app = new Sistema;
$accion = (isset($_GET['accion'])) ? $_GET['accion'] : null; //if ternario 

switch ($accion) {
    case 'login':
        $correo=$_POST['data']['correo'];
        $contrasena = $_POST['data']['contrasena'];

        if($app->login($correo,$contrasena)){
            echo('BIENVENIDO AL SISTEMA');
            echo('<pre>');
            print_r($_SESSION);
        }else{
            echo('ACCESO NEGADO');
        }
        die();
        break;
    case 'logout':
        $app->logOut();
        
        break;
    default:
        include('views/login/index.php');
        break;
}









?>
