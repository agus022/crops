<?php
include ("invernadero.class.php");
$app = new Invernadero;
// $app -> conexion();
// print_r($app);
// $result = $app -> readAll();
// print_r($result);
$accion = (isset($_GET['accion']))?$_GET['accion']:null; //if ternario 
switch ($accion){
    case 'create':
        break;
    case 'update':
        break;
    case 'delete':
        break;
    default:
        $invernaderos=$app -> readAll();
        include('views/invernadero/index.php');
}

?>